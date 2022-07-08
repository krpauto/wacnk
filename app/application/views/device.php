<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNKWA  <?= $title ?></title>
    <link rel="icon" href="http://weddingcnk.com/zcnk.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?= _assets() ?>/css/main.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/css/custom.css" rel="stylesheet">
</head>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">

        <?php require_once(VIEWPATH . '/include_head.php') ?>

        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                                <li class="nav-item dropdown hidden-on-mobile">
                                    <a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons">add</i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="addDropdownLink">
                                        <li><a class="dropdown-item" href="#">Broadcast</a></li>
                                        <li><a class="dropdown-item" href="#">WA Blast</a></li>
                                        <li><a class="dropdown-item" href="#">Auto Responder</a></li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">

                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="page-description p-0">
                                    <h4><?= $title ?></h4>
                                </div>
                            </div>
                        </div>
                        <?= _alert() ?>
                        <div class="alert alert-info">Scan this QR using whatsapp multi device.</div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget widget-stats-large">
                                    <div class="row">
                                        <div class="col-xl-8">
                                            <div class="widget-stats-large-chart-container">
                                                <div class="card-header" id="logoutbutton">
                                                    <button onclick="logoutqr()" class="btn btn-danger scanbutton"><i class="material-icons">logout</i>Logout</button>
                                                </div>
                                                <div class="card-body">
                                                    <div id="apex-earnings"></div>
                                                    <div class="imageee text-center" id="area-image-<?= $row->nomor ?>">
                                                        <img src="http://gatewayku.my.id/z/cnkwaiting.png" height="200px" alt="">
                                                    </div>
                                                    <div class="text-center" id="statusss-<?= $row->nomor ?>">
                                                        <button class="btn btn-primary" type="button" disabled>
                                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                            Waiting for response from server
                                                        </button>
														
		
		
		<li class="list-group-item text-danger">
			<video autoplay="" autoload=""muted="" loop="" width="78%" height="244">
			  <source src="http://gatewayku.my.id/z/cnkscan.mp4" type="video/mp4">
			</video>
		</li>
	
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="widget-stats-large-info-container">
                                                <div class="card-header">
                                                    <h5 class="card-title">Account</h5>
                                                </div>
												
                                                <div class="card-body account">
                                                    <ul class="list-group account list-group-flush">
                                                        <li class="list-group-item">Name : <span id="anama-<?= $row->nomor ?>"></span></li>
                                                        <li class="list-group-item">Number : <span id="anomor-<?= $row->nomor ?>"><?= $row->nomor ?></span></li>
                                                        <li class="list-group-item">Device : <span id="adevice-<?= $row->nomor ?>"></span></li>
                                                    </ul>
                                                    <div class="text-center mt-4">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#webhooks" class="btn btn-primary mb-1"><i class="material-icons">code</i>Settings</button>
                                                        <a href="<?= base_url('device/delete/') . $row->nomor ?>" onclick="logoutqr()" class="btn btn-danger mb-1"><i class="material-icons">delete_outline</i>Remove</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Logs: </h6>
                                        <span id="logs">

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="webhooks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label">Webhook Url</label>
                        <input type="text" name="webhook" class="form-control" value="<?= $row->link_webhook ?>" autocomplete="off">
                        <br>
                        <label class="form-label">Delivery / minute</label>
                        <input type="number" name="chunk" class="form-control" value="<?= $row->chunk ?>" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelled</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <script src="<?= _assets() ?>/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= _assets() ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="<?= _assets() ?>/plugins/pace/pace.min.js"></script>
    <script src="<?= _assets() ?>/js/main.min.js"></script>
    <script src="<?= _assets() ?>/js/custom.js"></script>
    <script src="<?= base_url() ?>../node_modules/socket.io/client-dist/socket.io.js"></script>
    <script>
        var nomorbase = <?= $row->nomor ?>

        <?php if ($settings->install_in == 1) { ?>
            var socket = io();
        <?php } else { ?>
            var socket = io('<?= $settings->base_node ?>', {
                transports: ['websocket',
                    'polling',
                    'flashsocket'
                ]
            });
        <?php } ?>

        socket.emit('create-session', {
            id: nomorbase
        });

        socket.on('message', function(msg) {
            $('#logs').append(`+ ` + msg.text + ` <hr class="p-0 m-0">`);
        })

        socket.on('qr', function(src) {
            $(`#area-image-${src.id}`).html(`<img src="` + src.src + `" alt="cardimg" id="qrcode" height="300px">`);
            
            
            
            $(`#statusss-${src.id}`).html(`<button class="btn btn-warning" type="button" disabled><i class="material-icons">qr_code_scanner</i>SCAN QR.</button><li class="list-group-item text-danger">
			<video autoplay="" autoload=""muted="" loop="" width="78%" height="244">
			  <source src="http://gatewayku.my.id/z/cnkscan.mp4" type="video/mp4">
			</video>
		</li>`);
        });

        // ketika terhubung
        socket.on('authenticated', function(src) {
            const nomors = src.data.id;
            $(`#anama-${src.id}`).html(src.data.name)
            $(`#anomor-${src.id}`).html(src.id)
            $(`#adevice-${src.id}`).html('Unknown')
            // $("#logoutbutton").html('')
            $(`#area-image-${src.id}`).html(`<img src="http://gatewayku.my.id/z/cnkwaiting2.png" alt="cardimg" id="qrcode" height="120px" style="max-height: 100%">`);
            $(`#statusss-${src.id}`).html(`<button disabled class="btn btn-success"><i class="material-icons">done</i>Connected.</button>`);
        });

        /// function ini untuk logouot
        function logoutqr() {
            socket.emit('logout', {
                id: nomorbase
            });
            $(`#statusss-${src.id}`).html(`Device Logout.<br><a href="" class="btn btn-danger"><i class="material-icons">restart_alt</i>QR SCAN REPEAT.</a>`);
        }

        socket.on('isdelete', function(src) {
            $(`#statusss-${src.id}`).html(`Device Logout.<br><a href="" class="btn btn-danger"><i class="material-icons">restart_alt</i>QR SCAN REPEAT.</a>`);
            $(`#area-image-${src.id}`).html(src.text);
        });
        socket.on('close', function(src) {
            console.log(src);
            $(`#statusss-${src.id}`).html(`<button disabled class="btn btn-danger"><i class="material-icons">error_outline</i>` + src.text + `</button>`);
        })
    </script>

</body>

</html>