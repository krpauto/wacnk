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
                        <form action="<?= base_url('contacts/del') ?>" method="post">
                            <div class="card widget widget-action-list">
                                <div class="card-body text-center">
                                    <button class="btn btn-danger m-1" type="submit"><i class=" material-icons">delete</i>Delete</button>
                                    <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal" data-bs-target="#generates"><i class="material-icons">contacts</i>Generate Contacts</button>
                                    <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal" data-bs-target="#importexcel"><i class="material-icons">file_upload</i>Import xlsx</button>
                                    <a href="<?= base_url('excel/export') ?>" class="btn btn-warning m-1"><i class="material-icons">download</i>Export xlsx</a>
                                    <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal" data-bs-target="#add"><i class="material-icons">add</i>Add</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>Contacts Number</h5>
                                            <table id="datatable1" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><input class="form-check-input" onchange="checkAll(this)" name="chk[]" type="checkbox"></th>
                                                        <th>Name</th>
                                                        <th>Number</th>
                                                        <th>Label</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($nomor->result() as $d) : ?>
                                                        <tr>
                                                            <td><input class="form-check-input" name="id[]" value="<?= $d->id ?>" type="checkbox"></td>
                                                            <td><?= $d->nama ?></td>
                                                            <td><?= $d->nomor ?></td>
                                                            <td><small class="btn btn-primary btn-style-light btn-sm"><i class="material-icons">label</i> <?= $d->label ?></small></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label">Name</label>
                        <input type="text" name="nama" class="form-control" required>
                        <label class="form-label">Number</label>
                        <input type="number" name="nomor" class="form-control" required placeholder="62xxxx">
						<p class="text-small text-danger">*Use Country Code ( without + )</p>
                        <label class="form-label">Label</label>
                        <input type="text" name="label" list="lab" class="form-control" autocomplete="off">
                        <datalist id="lab">
                            <?php foreach ($label->result() as $r) : ?>
                                <option value="<?= $r->label ?>"><?= $r->label ?></option>
                            <?php endforeach ?>
                        </datalist>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelled</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importexcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import xlsx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url("excel/import") ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="formFile" class="form-label">File Excel <small style="font-size: 9px;">(.xlsx)</small></label>
                            <input class="form-control" type="file" name="file" id="formFile" required />
                        </div>
                        <div class="text-center">
                            <a class="btn btn-primary btn-sm me-1" data-bs-toggle="collapse" href="#advance" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Advance
                            </a>
                        </div>
                        <div class="collapse" id="advance">
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Start From line</label>
                                <input type="text" name="a" class="form-control" id="basicInput" value="2" required />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Column Name to</label>
                                <input type="text" name="b" class="form-control" id="basicInput" value="1" required />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Column Number to</label>
                                <input type="text" name="c" class="form-control" id="basicInput" value="2" required />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Column Label to</label>
                                <input type="text" name="d" class="form-control" id="basicInput" value="3" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelled</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="generates" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Nomor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url("getcontacts") ?>" method="post">
                    <div class="modal-body">
                        <label class="form-label">Device</label>
                        <select name="device" class="form-select" required>
                            <?php foreach ($device->result() as $d) : ?>
                                <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelled</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
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
    <script src="<?= _assets() ?>/plugins/datatables/datatables.min.js"></script>
    <script src="<?= _assets() ?>/js/main.min.js"></script>
    <script src="<?= _assets() ?>/js/custom.js"></script>
    <script src="<?= _assets() ?>/js/pages/dashboard.js"></script>
    <script>
        $('#datatable1').DataTable({
            responsive: true
        });

        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
    </script>
</body>

</html>