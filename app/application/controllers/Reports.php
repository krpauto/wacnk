<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            redirect(base_url('login'));
        }
        date_default_timezone_set('Asia/Jakarta');
    }

    public function single()
    {
        $data['title'] = 'Report Single Message';
        $iduser = $this->session->userdata('id_login');
        $data['request'] = $this->db->query("SELECT reports.*, device.pemilik, device.nomor FROM device INNER JOIN reports ON device.nomor = reports.device WHERE pemilik=$iduser and type='single' ORDER BY id DESC");
        view('report_single', $data);
    }

    public function single_del()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $this->db->query("DELETE FROM reports WHERE id IN(" . implode(",", $id) . ")");
            $this->session->set_flashdata('success', 'Successfully delete.');
            redirect(base_url('report/single'));
        } else {
            $this->session->set_flashdata('error', 'checklist that you want to delete.');
            redirect(base_url('report/single'));
        }
    }

    public function received()
    {
        $data['title'] = 'Report Received Message';
        $iduser = $this->session->userdata('id_login');
        $data['request'] = $this->db->query("SELECT reports.*, device.pemilik, device.nomor FROM device INNER JOIN reports ON device.nomor = reports.device WHERE pemilik=$iduser and type='received' ORDER BY id DESC");
        view('report_received', $data);
    }

    public function received_del()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $this->db->query("DELETE FROM reports WHERE id IN(" . implode(",", $id) . ")");
            $this->session->set_flashdata('success', 'Successfully delete.');
            redirect(base_url('report/received'));
        } else {
            $this->session->set_flashdata('error', 'checklist that you want to delete.');
            redirect(base_url('report/received'));
        }
    }

    public function api()
    {
        $data['title'] = 'Report Api Message';
        $iduser = $this->session->userdata('id_login');
        $data['request'] = $this->db->query("SELECT reports.*, device.pemilik, device.nomor FROM device INNER JOIN reports ON device.nomor = reports.device WHERE pemilik=$iduser and type='api' ORDER BY id DESC");
        view('report_api', $data);
    }

    public function api_del()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $this->db->query("DELETE FROM reports WHERE id IN(" . implode(",", $id) . ")");
            $this->session->set_flashdata('success', 'Successfully delete.');
            redirect(base_url('report/api'));
        } else {
            $this->session->set_flashdata('error', 'checklist that you want to delete.');
            redirect(base_url('report/api'));
        }
    }
}
