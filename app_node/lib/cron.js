const cron = require('node-cron');
const { phoneNumberFormatter } = require('./formatter');

module.exports = function (db, sessionMap, fs, startDEVICE) {
    cron.schedule('* * * * *', function () {
        console.log('cronjob berjalan')
        let sqlde = `SELECT device.*, account.id as id_account, account.username, account.expired,account.status FROM device INNER JOIN account ON device.pemilik = account.id`;
        db.query(sqlde, function (err, results) {
            results.forEach(async de => {
                var sekarang = new Date().getTime();
                const myDate = new Date(de.expired)
                const itstime = myDate.getTime()
                if (de.status != 'expired') {
                    if (de.expired != null) {
                        if (sekarang >= itstime) {
                            db.query("UPDATE `account` SET `status` = 'expired' WHERE `account`.`id` = " + de.id_account, function (err, result) {
                                if (err) throw err;
                                console.log(result.affectedRows + " expired user " + de.username);
                                if (sessionMap.has(parseInt(de.nomor))) {
                                    const chi = sessionMap.get(parseInt(de.nomor))
                                    chi.chika.logout();
                                    sessionMap.delete(parseInt(de.nomor))
                                }
                                if (fs.existsSync(`./app_node/session/device-${parseInt(de.nomor)}.json`)) {
                                    fs.unlinkSync(`./app_node/session/device-${parseInt(de.nomor)}.json`);
                                }
                            });
                        }
                    }
                }
                if (sessionMap.has(parseInt(de.nomor))) {
                    let sql = `SELECT * FROM pesan WHERE status='MENUNGGU JADWAL' OR status='GAGAL' AND sender = ${de.nomor} LIMIT ${de.chunk}`;
                    const velixs = sessionMap.get(parseInt(de.nomor)).chika
                    db.query(sql, function (err, result) {
                        result.forEach(async d => {
                            const yourDate = new Date(d.jadwal)
                            const waktu = yourDate.getTime()
                            if (sekarang >= waktu) {
                                if (d.nomor.length > 15) {
                                    var number = d.nomor;
                                } else {
                                    var number = phoneNumberFormatter(d.nomor);
                                }
                                console.log(`Mengirim Ke Nomer ${number}`)
                                switch (d.type) {
                                    case "Text":
                                        velixs.sendMessage(number, { text: d.pesan }).then(response => {
                                            db.query(`UPDATE pesan SET status = 'TERKIRIM' where id = ${d.id}`)
                                        }).catch(err => {
                                            db.query(`UPDATE pesan SET status = 'GAGAL' where id = ${d.id}`)
                                        });
                                        break
                                    case "Text & Media":
                                        let filename = d.media.split('/')[d.media.split('/').length - 1];
                                        let filetype = filename.split('.')[1]
                                        if (filetype == 'jpg' || filetype == 'png' || filetype == 'jpeg') {
                                            velixs.sendMessage(number, { image: { url: `${d.media}` }, caption: `${d.pesan}` }).then(response => {
                                                db.query(`UPDATE pesan SET status = 'TERKIRIM' where id = ${d.id}`)
                                            }).catch(err => {
                                                db.query(`UPDATE pesan SET status = 'GAGAL' where id = ${d.id}`)
                                            });
                                        } else if (filetype == 'pdf') {
                                            velixs.sendMessage(number, { document: { url: `${d.media}` }, mimetype: 'application/pdf', fileName: `${d.pesan}` }).then(response => {
                                                db.query(`UPDATE pesan SET status = 'TERKIRIM' where id = ${d.id}`)
                                            }).catch(err => {
                                                db.query(`UPDATE pesan SET status = 'GAGAL' where id = ${d.id}`)
                                            });
                                        } else {
                                            res.status(500).json({
                                                status: false,
                                                response: 'Filetype tidak dikenal'
                                            });
                                        }
                                        break
                                    case "Quick Reply Button":
                                        const buttons = [
                                            { buttonId: d.btn1, buttonText: { displayText: d.btn1 }, type: 1 },
                                            { buttonId: d.btn2, buttonText: { displayText: d.btn2 }, type: 1 },
                                            { buttonId: d.btn3, buttonText: { displayText: d.btn3 }, type: 1 }
                                        ]
                                        const buttonMessage = {
                                            text: d.pesan,
                                            footer: d.footer,
                                            buttons: buttons,
                                            headerType: 1
                                        }
                                        velixs.sendMessage(number, buttonMessage).then(response => {
                                            db.query(`UPDATE pesan SET status = 'TERKIRIM' where id = ${d.id}`)
                                        }).catch(err => {
                                            db.query(`UPDATE pesan SET status = 'GAGAL' where id = ${d.id}`)
                                        });
                                        break
                                    case "Url & Call Button":
                                        const templateButtons = [
                                            { index: 1, urlButton: { displayText: d.btn1, url: d.btnid1 } },
                                            { index: 2, callButton: { displayText: d.btn2, phoneNumber: d.btnid2 } }
                                        ]
                                        const templateMessage = {
                                            text: d.pesan,
                                            footer: d.footer,
                                            templateButtons: templateButtons
                                        }
                                        velixs.sendMessage(number, templateMessage).then(response => {
                                            db.query(`UPDATE pesan SET status = 'TERKIRIM' where id = ${d.id}`)
                                        }).catch(err => {
                                            db.query(`UPDATE pesan SET status = 'GAGAL' where id = ${d.id}`)
                                        });
                                        break
                                }
                            }
                        })

                    });
                    let sql2 = `SELECT * FROM blast WHERE sender = ${de.nomor} AND status != 'terkirim' LIMIT ${de.chunk}`;
                    db.query(sql2, function (err, resultss) {
                        resultss.forEach(async dw => {
                            if (dw.tujuan.length > 15) {
                                var number = dw.tujuan;
                            } else {
                                var number = phoneNumberFormatter(dw.tujuan);
                            }
                            console.log(`Mengirim Ke Nomer ${number}`)
                            switch (dw.type) {
                                case "Text":
                                    velixs.sendMessage(number, { text: dw.pesan }).then(response => {
                                        db.query(`UPDATE blast SET status = 'terkirim' where id = ${dw.id}`)
                                    }).catch(err => {
                                        db.query(`UPDATE blast SET status = 'gagal' where id = ${dw.id}`)
                                    });
                                    break
                                case "Text & Media":
                                    let filename = dw.media.split('/')[dw.media.split('/').length - 1];
                                    let filetype = filename.split('.')[1]
                                    if (filetype == 'jpg' || filetype == 'png' || filetype == 'jpeg') {
                                        velixs.sendMessage(number, { image: { url: `${dw.media}` }, caption: `${dw.pesan}` }).then(response => {
                                            db.query(`UPDATE blast SET status = 'terkirim' where id = ${dw.id}`)
                                        }).catch(err => {
                                            db.query(`UPDATE blast SET status = 'gagal' where id = ${dw.id}`)
                                        });
                                    } else if (filetype == 'pdf') {
                                        velixs.sendMessage(number, { document: { url: `${dw.media}` }, mimetype: 'application/pdf', fileName: `${dw.pesan}` }).then(response => {
                                            db.query(`UPDATE blast SET status = 'terkirim' where id = ${dw.id}`)
                                        }).catch(err => {
                                            db.query(`UPDATE blast SET status = 'gagal' where id = ${dw.id}`)
                                        });
                                    }
                                    break
                                case "Quick Reply Button":
                                    const buttons = [
                                        { buttonId: dw.btn1, buttonText: { displayText: dw.btn1 }, type: 1 },
                                        { buttonId: dw.btn2, buttonText: { displayText: dw.btn2 }, type: 1 },
                                        { buttonId: dw.btn3, buttonText: { displayText: dw.btn3 }, type: 1 }
                                    ]
                                    const buttonMessage = {
                                        text: dw.pesan,
                                        footer: dw.footer,
                                        buttons: buttons,
                                        headerType: 1
                                    }
                                    velixs.sendMessage(number, buttonMessage).then(response => {
                                        db.query(`UPDATE blast SET status = 'terkirim' where id = ${dw.id}`)
                                    }).catch(err => {
                                        db.query(`UPDATE blast SET status = 'gagal' where id = ${dw.id}`)
                                    });
                                    break
                                case "Url & Call Button":
                                    const templateButtons = [
                                        { index: 1, urlButton: { displayText: dw.btn1, url: dw.btnid1 } },
                                        { index: 2, callButton: { displayText: dw.btn2, phoneNumber: dw.btnid2 } }
                                    ]
                                    const templateMessage = {
                                        text: dw.pesan,
                                        footer: dw.footer,
                                        templateButtons: templateButtons
                                    }
                                    velixs.sendMessage(number, templateMessage).then(response => {
                                        db.query(`UPDATE blast SET status = 'terkirim' where id = ${dw.id}`)
                                    }).catch(err => {
                                        db.query(`UPDATE blast SET status = 'gagal' where id = ${dw.id}`)
                                    });
                                    break
                            }
                        })
                    });
                }
            })
        })

    });

    cron.schedule('* * * * *', function () {
        console.log('cronjob reconnect device')
        let sqlde = `SELECT *  FROM device`;
        db.query(sqlde, function (err, results) {
            results.forEach(async de => {
                if (fs.existsSync(`./app_node/session/device-${parseInt(de.nomor)}.json`)) {
                    if (!sessionMap.has(parseInt(de.nomor))) {
                        console.log(parseInt(de.nomor))
                        startDEVICE(parseInt(de.nomor))
                    }
                }
            })
        })
    });
};