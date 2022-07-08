<?php
defined('BASEPATH') or exit('No direct script access allowed');

class File extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            redirect(base_url('login'));
        }
        date_default_timezone_set('Asia/Jakarta');
    }

    public function get_media()
    {
        $media = $this->db->query('SELECT * FROM storage ORDER BY id DESC')->result();
        echo '<div class="row">';
        foreach ($media as $m) {
            if (preg_match('/.pdf/', $m->namafile)) {
                $namafile = 'pdf.png';
            } else {
                $namafile = $m->namafile;
            }
            $bb = _storage() . "$m->namafile";
            echo '  <div class="col-6 col-xl-2 col-lg-3 col-md-4 col-sm-4">
            <a href="javascript:void(0)" style="text-decoration: none; color: black" data-bs-dismiss="modal" onclick="getmedia(' . "'$bb'" . ')">
            <div class="card">
                <img src="' . base_url('storage/') . $namafile . '" class="card-img-top" style="max-height: 8rem; min-height: 8rem; object-fit: cover;">
                <div class="card-body p-1 text-center">
                    <small style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $m->nama_original . '</small>
                </div>
            </div>
            </a>
            </div>';
        }
        echo '</div>';
    }

    public function upload()
    {
        $img = uploadimg([
            'path' => "./storage/",
            'name' => 'fileupload',
            'compress' => false
        ]);
        if ($img['result'] == 'success') {
            $this->db->insert('storage', [
                'namafile' => $img['nama_file'],
                'nama_original' => $_FILES['fileupload']['name']
            ]);
            echo 'berhasil';
        } else {
            echo 'Only File pdf,jpeg,jpg,png';
        }
    }
}
