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
                                    <?php if ($user->level == 1) { ?>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Global</button>
                                        </li>
                                    <?php } ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= ($user->level == 1) ? "" : "active" ?>" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Account</button>
                                    </li>
                                </ul>
                                <br>
                                <div class="tab-content" id="pills-tabContent">
                                    <?php if ($user->level == 1) { ?>
                                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                            <form action="<?= base_url('settings/global') ?>" method="post" class="loadingbtn">
                                                <input type="hidden" name="globals" value="pesan-text">
                                                <div class="mt-3">
                                                    <label>BASE NODE</label>
                                                    <input type="text" class="form-control" value="<?= $settings->base_node ?>" name="base_node" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="">Install In</label>
                                                    <select class="form-select" name="install_in">
                                                        <option <?= ($settings->install_in == 2) ? 'selected' : '' ?> value="2">Local</option>
                                                        <option <?= ($settings->install_in == 1) ? 'selected' : '' ?> value="1">Hosting</option>
                                                    </select>
                                                </div>
                                                <div class="text-end btnkirim mt-3">
                                                    <button type="submit" class="btn btn-primary"><i class="material-icons">save</i>Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php } ?>
                                    <div class="tab-pane fade <?= ($user->level == 1) ? "" : "show active" ?>" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <form action="" method="post" class="loadingbtn">

                                            <input type="hidden" name="account" value="pesan-text">
                                            <div class="row">
                                                <div class="mt-3">
                                                    <label>Api Key</label>
                                                    <input type="text" class="form-control" value="<?= $user->api_key ?>" name="api" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" value="<?= $user->username ?>" name="username" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control" name="password">
                                                    <small>Leave it blank if you don't want to change the password.</small>
                                                </div>
                                            </div>
                                            <input type="hidden" name="old_password" value="<?= $user->password ?>">
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">save</i>Update</button>
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