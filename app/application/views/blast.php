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
    <link href="<?= _assets() ?>/plugins/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/css/main.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/css/custom.css" rel="stylesheet">
    <style>
        .form-off {
            display: none;
        }

        .form-on {
            display: block;
        }
    </style>
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
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab_input" type="button" role="tab" aria-controls="home" aria-selected="true">Input</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab_datatable" type="button" role="tab" aria-controls="profile" aria-selected="false">Reports</button>
                                    </li>
                                </ul>
                                <br>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tab_input" role="tabpanel" aria-labelledby="home-tab">
                                        <form action="" method="post" class="loadingbtn">
                                            <label class="form-label">Type</label>
                                            <select name="type" id="type-message" class="form-select">
                                                <option value="0">- Select message type -</option>
                                                <option value="1">Text Message</option>
                                                <option value="2">Text & Media Message</option>
                                                <option value="3">Quick Reply Button Message</option>
                                                <option value="4">Url & Call Button Message</option>
                                                
                                            </select>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12 col-xl-6">
                                                    <label>Device</label>
                                                    <select name="device" class="js-states form-control">
                                                        <?php foreach ($device->result() as $d) : ?>
                                                            <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-xl-6">
                                                    <div class="">
                                                        <label for="">Receiver</label>
                                                        <div id="input_tujuan">
                                                            <select class="js-states form-control" name="listnumber[]" id="listnumber" tabindex="-1" style="display: none; width: 100%" multiple="multiple" required>
                                                                <optgroup label="By Label">
                                                                    <?php foreach ($label->result() as $l) : ?>
                                                                        <option value="<?= $l->label ?>"><?= "$l->label" ?></option>
                                                                    <?php endforeach ?>
                                                                </optgroup>
                                                                <optgroup label="Nomor">
                                                                    <?php foreach ($nomor->result() as $n) : ?>
                                                                        <option value="<?= $n->nomor ?>"><?= "$n->nomor ($n->nama)" ?></option>
                                                                    <?php endforeach ?>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="allcheck" type="checkbox" name="all_number">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Send to all numbers (in contacts data).
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-off mb-2" id="form-message">
                                                        <label for="">Message</label>
                                                        <textarea name="pesan" class="form-control" rows="7" placeholder="Ex : Hai {name}
note : {name} write the name according to the recipient.
When you send a pdf file the message input will be used for the pdf file name." required></textarea>
                                                    </div>
                                                    <span class="form-off" id="form-footer">
                                                        <label class="form-label">Footer</label>
                                                        <input type="text" class="form-control" name="footer" placeholder="footer" autocomplete="off">
                                                    </span>
                                                    <div class="form-off" id="form-media">
                                                        <label for="">Link media ( JPG,JPEG,PDF )</label>
                                                        <div class="input-group">
                                                            <input type="text" id="inputmedia" name="media" class="form-control" placeholder="Link media">
                                                            <span onclick="mediamodal()" class="btn btn-primary"><span class="material-icons pt-1">file_upload</span></span>
                                                        </div>
                                                        <small>Leave it blank if you want to send a message only.</small>
                                                    </div>
                                                    <span class="form-off" id="form-button-reply">
                                                        <div class="row">
                                                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                                <label class="form-label">Button 1</label>
                                                                <input type="text" class="form-control" name="btn1" placeholder="ex: Menu" autocomplete="off">
                                                            </div>
                                                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                                <label class="form-label">Button 2</label>
                                                                <input type="text" class="form-control" name="btn2" placeholder="ex: menu" autocomplete="off">
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">Button 3</label>
                                                                <input type="text" class="form-control" name="btn3" placeholder="ex: menu" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </span>
                                                    <span class="form-off" id="form-button-urlcall">
                                                        <div class="row">
                                                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                                <label class="form-label">Web Url Button Text</label>
                                                                <input type="text" class="form-control" name="btnurl" placeholder="ex: VELIXS WEB" autocomplete="off">
                                                            </div>
                                                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                                <label class="form-label">Web Url</label>
                                                                <input type="text" class="form-control" name="btnurl_val" placeholder="ex: https://velixs.com" autocomplete="off">
                                                            </div>
                                                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                                <label class="form-label">Call Button Text</label>
                                                                <input type="text" class="form-control" name="btncall" placeholder="ex: CALL ME" autocomplete="off">
                                                            </div>
                                                            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                                                                <label class="form-label">Calling Number</label>
                                                                <input type="text" class="form-control" name="btncall_val" placeholder="ex: 628XXXXXXX" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">send</i>Send</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="tab-pane fade" id="tab_datatable" role="tabpanel" aria-labelledby="profile-tab">
                                        <form action="<?= base_url("blast/del") ?>" method="post">
                                            <button type="submit" class="btn btn-danger m-1"><i class="material-icons">delete</i>Delete</button>
                                            <div class="table-responsive">
                                                <table id="datatable1" class="display" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th><input class="form-check-input" onchange="checkAll(this)" name="chk[]" type="checkbox"></th>
                                                            <th>Device</th>
                                                            <th>Receiver</th>
                                                            <th>Type</th>
                                                            <th>Message</th>
                                                            <th>Footer</th>
                                                            <th>Button1</th>
                                                            <th>Button2</th>
                                                            <th>Button3</th>
                                                            <th>Media</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($blast->result() as $b) : ?>
                                                            <tr>
                                                                <td><input class="form-check-input checkdel" name="id[]" value="<?= $b->id ?>" type="checkbox"></td>
                                                                <td><?= $b->sender ?></td>
                                                                <td><?= $b->tujuan ?></td>
                                                                <td><?= $b->type ?></td>
                                                                <td><?= $b->pesan ?></td>
                                                                <td><?= $b->footer ?></td>
                                                                <td><?= $b->btn1 ?></td>
                                                                <td><?= $b->btn2 ?></td>
                                                                <td><?= $b->btn3 ?></td>
                                                                <td><?= ($b->media == '') ? '<button class="btn btn-dark btn-sm" disabled>None</button>' : '<button type="button" class="btn btn-primary btn-sm" onclick="lihat_gambar(`' . $b->media . '`)">Lihat</button>' ?></td>
                                                                <td>
                                                                    <?php
                                                                    if ($b->status == 'pending') {
                                                                        echo '<span class="badge badge-style-light rounded-pill badge-warning">Pending</span>';
                                                                    } else if ($b->status == 'terkirim') {
                                                                        echo '<span class="badge badge-style-light rounded-pill badge-success">Sent</span>';
                                                                    } else if ($b->status == 'gagal') {
                                                                        echo '<span class="badge badge-style-light rounded-pill badge-danger">Fail</span>';
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
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
    <!-- Modal -->
    <div class="modal fade" id="lihatm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="preview_lihat">

                </div>
            </div>
        </div>
    </div>
    <!-- Javascripts -->
    <script src="<?= _assets() ?>/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= _assets() ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="<?= _assets() ?>/plugins/pace/pace.min.js"></script>
    <script src="<?= _assets() ?>/plugins/datatables/datatables.min.js?v=1"></script>
    <script src="<?= _assets() ?>/plugins/select2/js/select2.full.min.js"></script>
    <script src="<?= _assets() ?>/js/main.min.js"></script>
    <script src="<?= _assets() ?>/js/custom.js"></script>
    <script>
        $('select').select2();
        $('#datatable1').DataTable({
            responsive: true
        });

        $("#allcheck").change(function() {
            if (this.checked == true) {
                $("#listnumber").val('')
                $("#input_tujuan").hide()
                $("#listnumber").attr('required', false)
            } else {
                $("#listnumber").attr('required', true)
                $("#input_tujuan").show()
            }
        })

        function checkAll(ele) {
            var checkboxes = document.getElementsByClassName('checkdel');
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

        $('#type-message').change(function() {
            $(".form-on").removeClass('form-on');
            var tye = this.value;

            switch (tye) {
                case '0':
                    break
                case '1':
                    $("#form-device").addClass('form-on');
                    $("#form-message").addClass('form-on');
                    break
                case '2':
                    $("#form-device").addClass('form-on');
                    $("#form-device").addClass('form-on');
                    $("#form-message").addClass('form-on');
                    $("#form-media").addClass('form-on');
                    break
                case '3':
                    $("#form-device").addClass('form-on');
                    $("#form-device").addClass('form-on');
                    $("#form-message").addClass('form-on');
                    $("#form-button-reply").addClass('form-on');
                    $("#form-footer").addClass('form-on');
                    break
                case '4':
                    $("#form-device").addClass('form-on');
                    $("#form-device").addClass('form-on');
                    $("#form-message").addClass('form-on');
                    $("#form-button-urlcall").addClass('form-on');
                    $("#form-footer").addClass('form-on');
                    break
                case '5':
                    alert('Coming Soon')
                    break
            }
        })
    </script>
    <?php require_once('include_file.php') ?>
</body>

</html>