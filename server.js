const { default: chikaConnect, useSingleFileAuthState, DisconnectReason, fetchLatestBaileysVersion, generateForwardMessageContent, prepareWAMessageMedia, generateWAMessageFromContent, generateMessageID, downloadContentFromMessage, makeInMemoryStore, jidDecode, proto } = require("@adiwajshing/baileys")
const pino = require('pino')
const { Boom } = require('@hapi/boom')
const fs = require('fs')
const chalk = require('chalk')
require('dotenv/config')
const express = require('express')
const socket = require("socket.io");
const { toDataURL } = require('qrcode')
const mysql = require('mysql');
require('dotenv').config();
const request = require('request');
const { smsg } = require('./app_node/lib/myf')

const app = express()
const host = process.env.HOST
const port = parseInt(process.env.PORT)
app.use(express.urlencoded({ extended: true }))
app.use(express.json())
const ser = app.listen(port, host, () => {
    console.log(`Server is listening on http://${host}:${port}`)
})
const io = socket(ser);

const db = mysql.createConnection({
    host: process.env.DB_HOSTNAME,
    user: process.env.DB_USERNAME,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE
});

db.connect((err) => {
    if (err) throw err;
    console.log('Mysql Connected...');
});

const sessionMap = new Map()

async function startDEVICE(idevice) {
    const store = makeInMemoryStore({ logger: pino().child({ level: 'silent', stream: 'store' }) })
    const { state, saveState } = useSingleFileAuthState(`./app_node/session/device-${idevice}.json`)
    const chika = chikaConnect({
        logger: pino({ level: 'silent' }),
        printQRInTerminal: true,
        browser: ['CNKWA', 'Chrome', '1.0.0'],
        auth: state
    })
    store.bind(chika.ev)
    chika.decodeJid = (jid) => {
        if (!jid) return jid
        if (/:\d+@/gi.test(jid)) {
            let decode = jidDecode(jid) || {}
            return decode.user && decode.server && decode.user + '@' + decode.server || jid
        } else return jid
    }
    chika.ev.on('messages.upsert', async chatUpdate => {
        try {
            mek = chatUpdate.messages[0]
            if (!mek.message) return
            // mek.message = (Object.keys(mek.message)[0] === 'ephemeralMessage') ? mek.message.ephemeralMessage.message : mek.message
            if (mek.key && mek.key.remoteJid === 'status@broadcast') return
            if (mek.key.id.startsWith('BAE5') && mek.key.id.length === 16) return
            m = smsg(chika, mek, store)
            require("./app_node/lib/handler")(chika, chatUpdate, db, m)
        } catch (err) {
            console.log(err)
        }
    })
    chika.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update
        if (connection === 'open') {
            sessionMap.set(idevice, { chika, store })
            io.emit('message', {
                id: idevice,
                text: 'Whatsapp is ready!'
            });
            io.emit('authenticated', {
                id: idevice,
                data: chika.user
            })
        }
        if (connection === 'close') {
            sessionMap.delete(parseInt(idevice))
            const logoutsessi = () => {
                chika.logout();
                if (fs.existsSync(`./app_node/session/device-${idevice}.json`)) {
                    fs.unlinkSync(`./app_node/session/device-${idevice}.json`);
                }
            }
            let reason = new Boom(lastDisconnect?.error)?.output.statusCode
            if (reason === DisconnectReason.badSession) { console.log(`Bad Session File, Please Delete Session and Scan Again`); logoutsessi(); }
            else if (reason === DisconnectReason.connectionClosed) { console.log("Connection closed, reconnecting...."); startDEVICE(idevice); }
            else if (reason === DisconnectReason.connectionLost) { console.log("Connection Lost from Server, reconnecting..."); startDEVICE(idevice); }
            else if (reason === DisconnectReason.connectionReplaced) { console.log("Connection Replaced, Another New Session Opened, Please Close Current Session First"); logoutsessi(); }
            else if (reason === DisconnectReason.loggedOut) { console.log(`Device Logged Out, Please Scan Again And Run.`); logoutsessi(); }
            else if (reason === DisconnectReason.restartRequired) { console.log("Restart Required, Restarting..."); startDEVICE(idevice) }
            else if (reason === DisconnectReason.timedOut) { console.log("Connection TimedOut, Reconnecting..."); startDEVICE(idevice); }
            else chika.end(`Unknown DisconnectReason: ${reason}|${connection}`)
        }
        if (update.qr) {
            const url = await toDataURL(qr)
            try {
                io.emit('qr', {
                    id: idevice,
                    src: url
                });
                io.emit('message', {
                    id: idevice,
                    text: 'QR Code received, scan please!'
                });
            } catch {
                io.emit('message', {
                    id: idevice,
                    text: 'QR Error, please refresh page!'
                });
                logoutDEVICE(parseInt(idevice))
            }
        }
        console.log('Connected...', update)
    })
    chika.ev.on('creds.update', saveState)
    chika.ev.on('contacts.upsert', async (m) => {
        console.log(m)
        request({
            url: process.env.BASE_WEB + '/app/api/callback',
            method: "POST",
            json: {
                "id": idevice,
                "data": m
            }
        })
    })

    return chika
}

const logoutDEVICE = (idevice) => {
    const chi = sessionMap.get(parseInt(idevice))
    chi.chika.logout();
    if (fs.existsSync(`./app_node/session/device-${idevice}.json`)) {
        fs.unlinkSync(`./app_node/session/device-${idevice}.json`);
    }
    sessionMap.delete(parseInt(idevice))
}

io.on('connection', function (socket) {
    socket.on('create-session', function (data) {
        if (sessionMap.has(parseInt(data.id))) {
            console.log('get session: ' + data.id);
            const conn = sessionMap.get(parseInt(data.id)).chika
            io.emit('message', {
                id: data.id,
                text: 'Whatsapp is ready!'
            });
            io.emit('authenticated', {
                id: data.id,
                data: conn.user
            })
        } else {
            console.log('Create session: ' + data.id);
            startDEVICE(parseInt(data.id));
        }
    });
    socket.on('logout', async function (data) {
        if (fs.existsSync(`./app_node/session/device-${data.id}.json`)) {
            socket.emit('isdelete', {
                id: data.id,
                text: '<h2 class="text-center text-info mt-4">Logout Success, Lets Scan Again<h2>'
            })
            logoutDEVICE(parseInt(data.id))
        } else {
            socket.emit('isdelete', {
                id: data.id,
                text: '<h2 class="text-center text-danger mt-4">You are have not Login yet!<h2>'
            })
        }
    })
});

require('./app_node/routes/web')(app, sessionMap, startDEVICE)
require('./app_node/lib/cron')(db, sessionMap, fs, startDEVICE)

let file = require.resolve(__filename)
fs.watchFile(file, () => {
    fs.unwatchFile(file)
    console.log(chalk.redBright(`Update ${__filename}`))
    delete require.cache[file]
    require(file)
})
