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
    <link href="<?= _assets() ?>/plugins/select2/css/select2.min.css" rel="stylesheet">
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
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#p-text" type="button" role="tab" aria-controls="" aria-selected=" true">Message Text</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#p-media" type="button" role="tab" aria-controls="" aria-selected="false">Message Media</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#p-tombol" type="button" role="tab" aria-controls="" aria-selected="false">Message Button</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="p-text" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <br>
                                        <form action="" method="post" class="loadingbtn">
                                            <input type="hidden" name="submitby" value="pesan-text">
                                            <div class="row">
                                                <div class="col-12 col-xl-6">
                                                    <label>Device</label>
                                                    <select class="js-states form-control" name="device" tabindex="-1" style="display: none; width: 100%">
                                                        <?php foreach ($device->result() as $d) : ?>
                                                            <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <div class="mt-3">
                                                        <label for="">To</label>
                                                        <input type="text" name="nomor" class="form-control" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-xl-6">
                                                    <div class="mt-4">
                                                        <textarea name="pesan" class="form-control" rows="10" placeholder="Message" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">send</i>Send</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="p-media" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <br>
                                        <form action="" method="post" class="loadingbtn">
                                            <input type="hidden" name="submitby" value="pesan-media">
                                            <label>Device</label>
                                            <select class="js-states form-control" name="device" tabindex="-1" style="display: none; width: 100%">
                                                <?php foreach ($device->result() as $d) : ?>
                                                    <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                                                <?php endforeach ?>
                                            </select>

                                            <div class="row">
                                                <div class="col-12 col-xl-6">
                                                    <div class="mt-3">
                                                        <label for="">To</label>
                                                        <input type="text" name="nomor" class="form-control" required autocomplete="off">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="">Link media ( JPG,JPEG,PDF )</label>
                                                        <div class="input-group">
                                                            <input type="text" id="inputmedia" name="media" class="form-control" placeholder="Link media">
                                                            <span onclick="mediamodal()" class="btn btn-primary"><span class="material-icons pt-1">file_upload</span></span>
                                                        </div>
                                                        <small>Empty if you just want to send a message.</small>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-xl-6">
                                                    <div class="mt-3">
                                                        <label for="">Message</label>
                                                        <textarea name="pesan" class="form-control" rows="10" placeholder="Message" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">send</i>Send</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="p-tombol" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <br>
                                        <form action="" method="post" class="loadingbtn">
                                            <input type="hidden" name="submitby" value="pesan-button">
                                            <div class="row">
                                                <div class="col-12 col-xl-6">
                                                    <label>Device</label>
                                                    <select class="js-states form-control" name="device" tabindex="-1" style="display: none; width: 100%">
                                                        <?php foreach ($device->result() as $d) : ?>
                                                            <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                    <div class="mt-3">
                                                        <label for="">To</label>
                                                        <input type="text" name="nomor" class="form-control" required autocomplete="off">
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="">Footer</label>
                                                        <input type="text" name="footer" class="form-control" required>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="">Button 1</label>
                                                        <input type="text" name="btn1" class="form-control" required>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="">Button 2</label>
                                                        <input type="text" name="btn2" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-xl-6">
                                                    <div class="mt-4">
                                                        <textarea name="pesan" class="form-control" rows="10" placeholder="Message" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">send</i>Send</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Javascripts -->
    <script src="<?= _assets() ?>/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= _assets() ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="<?= _assets() ?>/plugins/pace/pace.min.js"></script>
    <script src="<?= _assets() ?>/plugins/select2/js/select2.full.min.js"></script>
    <script src="<?= _assets() ?>/js/main.min.js"></script>
    <script src="<?= _assets() ?>/js/custom.js"></script>
    <script>
        $('select').select2();
    </script>
    <?php require_once('include_file.php') ?>
</body>

</html>