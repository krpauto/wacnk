<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        error_reporting(0);
    }

    public function send_message()
    {
        if ($this->input->post()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $sender = $data['sender'];
            $nomor = $data['number'];
            $pesan = $data['message'];
            $key = $data['api_key'];
            header('Content-Type: application/json');
        } else {
            $sender = $this->input->get('sender');
            $nomor = $this->input->get('receiver');
            $pesan = $this->input->get('message');
            $key = $this->input->get('apikey');
            header('Content-Type: application/json');
        }

        if (!isset($nomor) && !isset($pesan) && !isset($sender) && !isset($key)) {
            $ret['status'] = false;
            $ret['msg'] = "Incorrect parameters!";
            echo json_encode($ret, true);
            exit;
        }

        $cek = $this->db->get_where('account', ['api_key' => $key]);
        if ($cek->num_rows() == 0) {
            $ret['status'] = false;
            $ret['msg'] = "Api Key is wrong/not found!";
            echo json_encode($ret, true);
            exit;
        }
        $id_users = $cek->row()->id;
        $cek2 = $this->db->get_where('device', ['nomor' => $sender, 'pemilik' => $id_users]);
        if ($cek2->num_rows() == 0) {
            $ret['status'] = false;
            $ret['msg'] = "Device not found!";
            echo json_encode($ret, true);
            exit;
        }
        $res = sendMSG($nomor, $pesan, $sender);
        if ($res['status'] == "true") {
            $datainsert = [
                'device' => $sender,
                'receiver' => $nomor,
                'message' => $pesan,
                'type' => 'api',
                'status' => 'Sent',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reports', $datainsert);
            $ret['status'] = true;
            $ret['msg'] = "Message sent successfully";
            echo json_encode($ret, true);
            exit;
        } else {
            $datainsert = [
                'device' => $sender,
                'receiver' => $nomor,
                'message' => $pesan,
                'type' => 'api',
                'status' => 'Failed',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reports', $datainsert);
            $ret['status'] = false;
            $ret['msg'] = 'Device not connected';
            echo json_encode($ret, true);
            exit;
        }
    }

    public function send_media()
    {
        if ($this->input->post()) {
            // Takes raw data from the request
            $data = json_decode(file_get_contents('php://input'), true);
            $sender = $data['sender'];
            $nomor = $data['number'];
            $caption = $data['message'];
            //$filetype = $data['filetype'];
            $key = $data['api_key'];
            $url = $data['url'];
            header('Content-Type: application/json');
        } else {
            $sender = $this->input->get('sender');
            $nomor = $this->input->get('receiver');
            $caption = $this->input->get('message');
            //$filetype = $data['filetype'];
            $key = $this->input->get('apikey');
            $url = $this->input->get('url');
            header('Content-Type: application/json');
        }

        if (!isset($nomor) ||  !isset($sender) || !isset($key)  || !isset($url)) {
            $ret['status'] = false;
            $ret['msg'] = "Parameter salah!";
            echo json_encode($ret, true);
            exit;
        }

        $a = explode('/', $url);
        $filename = $a[count($a) - 1];
        $a2 = explode('.', $filename);
        $namefile = $a2[count($a2) - 2];
        $ext = $a2[count($a2) - 1];

        if ($ext != 'jpg' && $ext != 'pdf' && $ext != 'png') {
            $ret['status'] = false;
            $ret['msg'] = "Only support jpg and pdf";
            echo json_encode($ret, true);
            exit;
        }

        $cek = $this->db->get_where('account', ['api_key' => $key]);
        if ($cek->num_rows() == 0) {
            $ret['status'] = false;
            $ret['msg'] = "Api Key is wrong/not found!";
            echo json_encode($ret, true);
            exit;
        }
        $id_users = $cek->row()->id;
        $cek2 = $this->db->get_where('device', ['nomor' => $sender, 'pemilik' => $id_users]);
        if ($cek2->num_rows() == 0) {
            $ret['status'] = false;
            $ret['msg'] = "Device not found!";
            echo json_encode($ret, true);
            exit;
        }
        $res = sendMedia($nomor, $caption, $sender, $ext, $namefile, $url);
        if ($res['status'] == "true") {
            $datainsert = [
                'device' => $sender,
                'receiver' => $nomor,
                'message' => $caption,
                'media' => $url,
                'type' => 'api',
                'status' => 'Sent',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reports', $datainsert);
            $ret['status'] = true;
            $ret['msg'] = "Message sent successfully";
            echo json_encode($ret, true);
            exit;
        } else {
            $datainsert = [
                'device' => $sender,
                'receiver' => $nomor,
                'message' => $caption,
                'media' => $url,
                'type' => 'api',
                'status' => 'Failed',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reports', $datainsert);
            $ret['status'] = false;
            $ret['msg'] = 'Device not connected';
            echo json_encode($ret, true);
            exit;
        }
    }

    public function send_button()
    {
        if ($this->input->post()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $sender = $data['sender'];
            $nomor = $data['number'];
            $pesan = $data['message'];
            $footer = $data['footer'];
            $button1 = $data['button1'];
            $button2 = $data['button2'];
            $key = $data['api_key'];
            header('Content-Type: application/json');
        } else {
            $sender = $this->input->get('sender');
            $nomor = $this->input->get('receiver');
            $pesan = $this->input->get('message');
            $footer = $this->input->get('footer');
            $button1 = $this->input->get('btn1');
            $button2 = $this->input->get('btn2');
            $key = $this->input->get('apikey');
            header('Content-Type: application/json');
        }

        if (!isset($nomor) && !isset($pesan) && !isset($sender) && !isset($key) && !isset($button1) && !isset($button2)) {
            $ret['status'] = false;
            $ret['msg'] = "Incorrect parameters!";
            echo json_encode($ret, true);
            exit;
        }

        $cek = $this->db->get_where('account', ['api_key' => $key]);
        if ($cek->num_rows() == 0) {
            $ret['status'] = false;
            $ret['msg'] = "Api Key is wrong/not found!";
            echo json_encode($ret, true);
            exit;
        }
        $id_users = $cek->row()->id;
        $cek2 = $this->db->get_where('device', ['nomor' => $sender, 'pemilik' => $id_users]);
        if ($cek2->num_rows() == 0) {
            $ret['status'] = false;
            $ret['msg'] = "Device not found!";
            echo json_encode($ret, true);
            exit;
        }
        $res = sendBTN($nomor, $sender, $pesan, $footer, $button1, $button2);
        if ($res['status'] == "true") {
            $datainsert = [
                'device' => $sender,
                'receiver' => $nomor,
                'message' => $pesan,
                'footer' => $footer,
                'btn1' => $button1,
                'btn2' => $button2,
                'btnid1' => $button1,
                'btnid2' => $button2,
                'type' => 'api',
                'status' => 'Sent',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reports', $datainsert);
            $ret['status'] = true;
            $ret['msg'] = "Message sent successfully";
            echo json_encode($ret, true);
            exit;
        } else {
            $datainsert = [
                'device' => $sender,
                'receiver' => $nomor,
                'message' => $pesan,
                'footer' => $footer,
                'btn1' => $button1,
                'btn2' => $button2,
                'btnid1' => $button1,
                'btnid2' => $button2,
                'type' => 'api',
                'status' => 'Failed',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('reports', $datainsert);
            $ret['status'] = false;
            $ret['msg'] = 'Device not connected';
            echo json_encode($ret, true);
            exit;
        }
    }

    public function callback()
    {
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $sender =  preg_replace("/\D/", "", $data['id']);
        foreach ($data['data'] as $d) {
            $number = str_replace("@s.whatsapp.net", "", $d['id']);
            $nama = $d['name'];
            $cek = $this->db->get_where('all_contacts', ['sender' => $sender, 'number' => $number]);
            if ($cek->num_rows() == 0) {
                $this->db->query("INSERT INTO all_contacts VALUES(null,'$sender','$number','$nama','Personal')");
            }
        }
    }
}
