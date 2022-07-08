<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNKWA  <?= $title ?></title>
    <link rel="icon" href="https://weddingcnk.com/zcnk.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/datatables/datatables.min.css" rel="stylesheet">
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

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">

                                        <form method="post">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                        <label class="form-label">Username</label>
                                                        <input type="text" name="username" value="<?= $users->username ?>" class="form-control" required>
                                                    </div>
                                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                        <label class="form-label">Password</label>
                                                        <input type="text" name="password" class="form-control" autocomplete="off">
                                                        <input type="hidden" name="old_password" value="<?= $users->password ?>" class="form-control" autocomplete="off">
                                                        <small>Leave it blank if you don't want to change your password.</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                        <label class="form-label">Role</label>
                                                        <select name="level" class="form-select" aria-label="Default select example">
                                                            <option <?= ($users->level == 1) ? 'selected' : '' ?> value="1">ADMIN</option>
                                                            <option <?= ($users->level == 2) ? 'selected' : '' ?> value="2">CS</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                        <label class="form-label">Limit Device</label>
                                                        <input type="number" name="limitdevice" class="form-control" value="<?= $users->limit_device ?>" required min="1" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                
                                                <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="<?= _assets() ?>/plugins/datatables/datatables.min.js"></script>
    <script src="<?= _assets() ?>/js/main.min.js"></script>
    <script src="<?= _assets() ?>/js/custom.js"></script>
    <script src="<?= _assets() ?>/js/pages/dashboard.js"></script>
    <script>
        $('#datatable1').DataTable({
            responsive: true,
            "lengthChange": false,
            "paging": false,
            "searching": false
        });

        <?php if ($users->expired == null) { ?>
            $("#input_tujuan").hide()
            $("#expired").attr('required', false)
        <?php } ?>

        $("#lifetime").change(function() {
            if (this.checked == true) {
                $("#input_tujuan").hide()
                $("#expired").attr('required', false)
            } else {
                $("#expired").attr('required', true)
                $("#input_tujuan").show()
            }
        })
    </script>
</body>

</html>