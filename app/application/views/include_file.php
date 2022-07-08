<script>
    function mediamodal() {
        $("#modalmedia").modal('show')
        $("#getmedia").html('<div class="text-center" style="margin-top: 15%"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        $("#getmedia").load('<?= base_url("file/get") ?>');
    }

    function getmedia(media) {
        var ext = media.search(".pdf");
        if (ext != -1) {
            var mm = '<?= _storage() ?>/pdf.png';
        } else {
            var mm = media;
        }
        document.getElementById('inputmedia').value = media;

        $("#live_preview").html(`<a href="javascript:void(0)"><img class="card-img" style="width: 20%;" src="` + mm + `" onclick="mediamodal()"/></a>`);
    }

    function uploadmedia() {
        $("#getmedia").html('<div class="alert alert-primary alert-style-light text-center" role="alert"><div class="spinner-grow" style="height: 20px; width: 20px;" role="status"><span class="visually-hidden">Loading...</span></div>Uploading Media..</div>');
        const fileupload = $('#fileupload').prop('files')[0];
        let formData = new FormData();
        formData.append('fileupload', fileupload);

        $.ajax({
            type: 'POST',
            url: "<?= base_url('file/upload') ?>",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(msg) {
                if (msg != 'berhasil') {
                    alert(msg)
                }
                $("#getmedia").load('<?= base_url("file/get") ?>');
            },
            error: function() {
                $("#getmedia").load('<?= base_url("file/get") ?>');
                alert("Data Gagal Diupload");
            }
        });
    }

    function lihat_gambar(media) {
        var ext = media.search(".pdf");
        if (ext != -1) {
            var mm = '<?= _storage() ?>pdf.png';
        } else {
            var mm = media.replace('@', '<?= _storage() ?>');
        }
        $("#lihatm").modal('show')
        $("#preview_lihat").html(`<div class="alert alert-primary alert-style-light text-center" role="alert"><div class="spinner-grow" style="height: 20px; width: 20px;" role="status"><span class="visually-hidden">Loading...</span></div>Loading..</div>`);
        $("#preview_lihat").html(`<a href="${media}" target="_blank"><img class="card-img" style="width: 50%;" src="` + mm + `"/></a>`);
    }

    $(".loadingbtn").submit(function() {
        $(".btnkirim").html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Sending...</button>')
    })
</script>
<div class="modal fade" id="modalmedia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Media Manager</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="getmedia">

            </div>
            <div class="modal-footer justify-content-center" id="footerupload">
                <label for="fileupload" id="inpu" class="btn btn-primary">
                    <input id="fileupload" onchange="uploadmedia()" type="file" name="fileupload" style="display: none;">
                    Upload Media
                </label>
            </div>
        </div>
    </div>
</div>