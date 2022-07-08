const { phoneNumberFormatter } = require('../lib/formatter');
const fs = require('fs')

module.exports = function (app, sessionMap, startDEVICE) {

    const device = (sender) => {
        return conn = sessionMap.get(parseInt(sender)).chika
        // if (sessionMap.has(parseInt(sender))) {
        // } else {
        //     return
        // }
    }

    // app.get('/', function (req, res) {
    //     // const chi = sessionMap.get(6285731618404)
    //     // console.log(chi.store.contacts.all())

    //     // console.log(chi)
    //     // chi.chika.sendMessage('6281331703371@s.whatsapp.net', { text: 'teasdasdasdadsdst' })
    //     // chi.chika.sendMessage('6281331703371@s.whatsapp.net', { image: { url: 'http://localhost/walix/app/storage/bff68d6422082a4b83e134a431bf5064.jpg' }, caption: '⭔ Media Url' })
    // })

    app.post('/send-message', async (req, res) => {
        const sender = req.body.sender;
        if (device(sender)) {
            const conn = device(sender)
            if (req.body.number.length > 15) {
                var number = req.body.number;
            } else {
                var number = phoneNumberFormatter(req.body.number);
            }
            const message = req.body.message;
            conn.sendMessage(number, { text: `${message}` }).then(response => {
                res.status(200).json({
                    status: true,
                    response: response
                });
            }).catch(err => {
                res.status(500).json({
                    status: false,
                    response: err
                });
            });
        } else {
            res.status(500).json({
                status: false,
                response: 'Please scan the QR before use this API'
            });
        }

    });

    app.post('/send-media', async (req, res) => {
        const sender = req.body.sender;
        if (device(sender)) {
            const conn = device(sender)
            const url = req.body.url;
            const filetype = req.body.filetype;
            const filename = req.body.filename;
            const caption = req.body.caption;
            if (req.body.number.length > 18) {
                var number = req.body.number;
            } else {
                var number = phoneNumberFormatter(req.body.number);
            }

            if (filetype == 'jpg' || filetype == 'png' || filetype == 'jpeg') {
                conn.sendMessage(number, { image: { url: `${url}` }, caption: `${caption}` }).then(response => {
                    res.status(200).json({
                        status: true,
                        response: response
                    });
                }).catch(err => {
                    res.status(500).json({
                        status: false,
                        response: err
                    });
                });
            } else if (filetype == 'pdf') {
                conn.sendMessage(number, { document: { url: `${url}` }, mimetype: 'application/pdf', fileName: `${filename}` }).then(response => {
                    return res.status(200).json({
                        status: true,
                        response: response
                    });
                }).catch(err => {
                    return res.status(500).json({
                        status: false,
                        response: err
                    });
                });
            } else {
                res.status(500).json({
                    status: false,
                    response: 'Filetype tidak dikenal'
                });
            }
        } else {
            res.writeHead(401, {
                'Content-Type': 'application/json'
            });
            res.end(JSON.stringify({
                status: false,
                message: 'Please scan the QR before use the API 2'
            }));
        }
    });

    app.post('/send-button', async (req, res) => {
        const sender = req.body.sender;
        if (device(sender)) {
            const conn = device(sender);
            const message = req.body.message;
            const footer = req.body.footer;
            const btn1 = req.body.btn1;
            const btn2 = req.body.btn2;
            if (req.body.number.length > 15) {
                var number = req.body.number;
            } else {
                var number = phoneNumberFormatter(req.body.number);
            }

            const buttons = [
                { buttonId: `${btn1}`, buttonText: { displayText: `${btn1}` }, type: 1 },
                { buttonId: `${btn2}`, buttonText: { displayText: `${btn2}` }, type: 1 }
            ]

            const buttonMessage = {
                text: `${message}`,
                footer: `${footer}`,
                buttons: buttons,
                headerType: 1
            }
            conn.sendMessage(number, buttonMessage).then(response => {
                res.status(200).json({
                    status: true,
                    response: response
                });
            }).catch(err => {
                res.status(500).json({
                    status: false,
                    response: err
                });
            });
        } else {
            res.writeHead(401, {
                'Content-Type': 'application/json'
            });
            res.end(JSON.stringify({
                status: false,
                message: 'Please scan the QR before use the API 2'
            }));
        }
    });

};