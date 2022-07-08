<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dashboards extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      redirect(base_url('login'));
    }
    date_default_timezone_set('Asia/Jakarta');
  }

  //device and home

  public function index()
  {
    if ($this->input->post()) {
      $nomor = _POST('nomor');
      $webhook = _POST('webhook');
      $users = $this->db->get_where('account', ['id' => $this->session->userdata('id_login')])->row();
      if ($this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')])->num_rows() >= $users->limit_device) {
        $this->session->set_flashdata('error', 'You have exceeded the device limit.');
        redirect(base_url('home'));
      }
      if ($this->db->get_where('device', ['nomor' => $nomor])->num_rows() == 0) {
        $this->db->insert('device', [
          'pemilik' => $this->session->userdata('id_login'),
          'nomor' => $nomor,
          'link_webhook' => $webhook,
          'chunk' => 100
        ]);
        $this->session->set_flashdata('success', 'The device has been successfully added.');
        redirect(base_url('home'));
      } else {
        $this->session->set_flashdata('error', 'Number already registered.');
        redirect(base_url('home'));
      }
    } else {
      $data = [
        'title' => 'Home',
        'device' => $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')]),
        'contacts' => $this->db->get_where('nomor', ['make_by' => $this->session->userdata('id_login')])->num_rows(),
        'pending' => $this->db->get_where('pesan', ['status' => 'MENUNGGU JADWAL', 'make_by' => $this->session->userdata('id_login')])->num_rows(),
        'gagal' => $this->db->get_where('pesan', ['status' => 'GAGAL', 'make_by' => $this->session->userdata('id_login')])->num_rows(),
        'terkirim' => $this->db->get_where('pesan', ['status' => 'TERKIRIM', 'make_by' => $this->session->userdata('id_login')])->num_rows()
      ];
      view("home", $data);
    }
  }

  public function device()
  {
    $nomor = htmlspecialchars(str_replace("'", "", $this->uri->segment(2)));
    if ($this->input->post()) {
      $webhook = _POST('webhook');
      $chunk = _POST('chunk');
      $this->db->update('device', ['link_webhook' => $webhook, 'chunk' => $chunk], ['nomor' => $nomor]);
      $this->session->set_flashdata('success', 'Successfully update device.');
      redirect(base_url('device/') . $nomor);
    } else {
      $query = $this->db->get_where('device', ['nomor' => $nomor]);
      if ($query->num_rows() != 1) {
        $this->session->set_flashdata('error', 'Device tidak ada.');
        redirect(base_url('home'));
      }
      $data = [
        'title' => 'Device',
        'row' => $query->row(),
        'settings' => $this->db->get_where('settings', ['id' => 1])->row()
      ];
      view('device', $data);
    }
  }

  public function device_delete()
  {
    $nomor = htmlspecialchars(str_replace("'", "", $this->uri->segment(3)));
    $this->db->delete('device', ['nomor' => $nomor]);
    $this->session->set_flashdata('success', 'Device has been deleted successfully.');
    redirect(base_url());
  }

  // auto responder
  public function autoresponder()
  {
    if ($this->input->post()) {
      if ($this->input->post('type') == '1') {
        $datainsert = [
          'type' => 'Text',
          'keyword' => _POST('keyword'),
          'response' => _POST('message'),
          'nomor' => _POST('device'),
          'make_by' => $this->session->userdata('id_login')
        ];
        $this->db->insert('autoreply', $datainsert);
      } else if ($this->input->post('type') == '2') {
        $datainsert = [
          'type' => 'Text & Media',
          'keyword' => _POST('keyword'),
          'response' => _POST('message'),
          'nomor' => _POST('device'),
          'media' => _POST('media'),
          'make_by' => $this->session->userdata('id_login')
        ];
        $this->db->insert('autoreply', $datainsert);
      } else if ($this->input->post('type') == '3') {
        $datainsert = [
          'type' => 'Quick Reply Button',
          'keyword' => _POST('keyword'),
          'response' => _POST('message'),
          'footer' => _POST('footer'),
          'btn1' => _POST('btn1'),
          'btnid1' => _POST('btn1'),
          'btn2' => _POST('btn2'),
          'btnid2' => _POST('btn2'),
          'btn3' => _POST('btn3'),
          'btnid3' => _POST('btn3'),
          'nomor' => _POST('device'),
          'make_by' => $this->session->userdata('id_login')
        ];
        $this->db->insert('autoreply', $datainsert);
      } else if ($this->input->post('type') == '4') {
        $datainsert = [
          'type' => 'Url & Call Button',
          'keyword' => _POST('keyword'),
          'response' => _POST('message'),
          'footer' => _POST('footer'),
          'btn1' => _POST('btnurl'),
          'btnid1' => _POST('btnurl_val'),
          'btn2' => _POST('btncall'),
          'btnid2' => _POST('btncall_val'),
          'nomor' => _POST('device'),
          'make_by' => $this->session->userdata('id_login')
        ];
        $this->db->insert('autoreply', $datainsert);
      }
      $this->session->set_flashdata('success', 'Successfully added Auto Reply.');
      redirect(base_url('autoresponder'));
    } else {
      $data = [
        'title' => 'Auto Reply',
        'respon' => $this->db->get_where('autoreply', ['make_by' => $this->session->userdata('id_login')]),
        'device' =>  $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')])
      ];
      view('autoresponder', $data);
    }
  }

  public function autoresponder_del()
  {
    $id = htmlspecialchars(str_replace("'", "", $this->uri->segment(3)));
    $this->db->delete('autoreply', ['id' => $id]);
    $this->session->set_flashdata('success', 'Autoreply deleted successfully.');
    redirect(base_url('autoresponder'));
  }
  public function autoresponder_view()
  {
    $id = htmlspecialchars(str_replace("'", "", $this->uri->segment(3)));
    $data['title'] = 'Auto Reply View';
    $data['row'] = $this->db->get_where('autoreply', ['id' => $id])->row();
    view('autoresponder_view', $data);
  }

  // contacts number 
  public function contacts()
  {
    if ($this->input->post()) {
      $nama = _POST('nama');
      $nomor = _POST('nomor');
      $label = _POST('label');
      if ($this->db->get_where('nomor', ['nomor' => $nomor])->num_rows() == 0) {
        $this->db->insert('nomor', [
          'nama' => $nama,
          'nomor' => $nomor,
          'label' => $label,
          'make_by' => $this->session->userdata('id_login')
        ]);
        $this->session->set_flashdata('success', 'Successfully added Number.');
        redirect(base_url('contacts'));
      } else {
        $this->session->set_flashdata('error', 'Number already exists.');
        redirect(base_url('contacts'));
      }
    } else {
      $data = [
        'title' => 'Contacts',
        'nomor' => $this->db->get_where('nomor', ['make_by' => $this->session->userdata('id_login')]),
        'device' =>  $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')]),
        'label' => $this->db->query('SELECT * FROM nomor WHERE label!="" GROUP BY label ORDER BY id DESC')
      ];
      view('contacts', $data);
    }
  }

  public function get_contacts()
  {
    if ($this->input->post()) {
      $device = _POST('device');
      $by = $this->session->userdata('id_login');
      $all_contacts = $this->db->get_where('all_contacts', ['sender' => $device]);
      foreach ($all_contacts->result() as $c) {
        $a = $this->db->get_where('nomor', ['nomor' => $c->number, 'make_by' => $by]);
        if ($a->num_rows() == 0) {
          $this->db->insert('nomor', [
            'nama' => $c->name,
            'nomor' => $c->number,
            'label' => '',
            'make_by' => $by
          ]);
        }
      }
      $this->session->set_flashdata('success', 'Successfully retrieved contacts.');
      redirect(base_url('contacts'));
    }
  }

  public function contacts_del()
  {
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $this->db->query("DELETE FROM nomor WHERE id IN(" . implode(",", $id) . ")");
      $this->session->set_flashdata('success', 'Successfully Delete the number in the checklist.');
      redirect(base_url('contacts'));
    } else {
      $this->session->set_flashdata('error', 'checklist that you want to delete.');
      redirect(base_url('contacts'));
    }
  }

  // wa blast
  public function blast()
  {
    if ($this->input->post()) {
      $device = _POST('device');
      $pesan = _POST('pesan');
      $media = _POST('media');
      if ($this->input->post('all_number')) {
        $arr = [];
        foreach ($this->db->get_where('nomor', ['make_by' => $this->session->userdata('id_login')])->result() as $nomor) {
          array_push($arr, $nomor->nomor);
        }
        $target = $arr;
      } else {
        $target = $this->input->post('listnumber');
      }
      foreach ($target as $t) {
        $label = $this->db->get_where('nomor', ['label' => $t, 'make_by' => $this->session->userdata('id_login')]);
        if ($label->num_rows() != 0) {
          $nolabel = $label->result();
          foreach ($nolabel as $nl) {
            if ($this->input->post('type') == '1') {
              $datainsert = [
                'type' => 'Text',
                'sender' => $device,
                'tujuan' => $nl->nomor,
                'pesan' => str_replace("{name}", $nl->nama, $pesan),
                'make_by' => $this->session->userdata('id_login')
              ];
              $cek =  $this->db->get_where('blast', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('blast', $datainsert);
              }
            } else if ($this->input->post('type') == '2') {
              $datainsert = [
                'type' => 'Text & Media',
                'sender' => $device,
                'tujuan' => $nl->nomor,
                'media' => $media,
                'pesan' => str_replace("{name}", $nl->nama, $pesan),
                'make_by' => $this->session->userdata('id_login')
              ];
              $cek =  $this->db->get_where('blast', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('blast', $datainsert);
              }
            } else if ($this->input->post('type') == '3') {
              $datainsert = [
                'type' => 'Quick Reply Button',
                'sender' => $device,
                'tujuan' => $nl->nomor,
                'footer' => _POST('footer'),
                'btn1' => _POST('btn1'),
                'btnid1' => _POST('btn1'),
                'btn2' => _POST('btn2'),
                'btnid2' => _POST('btn2'),
                'btn3' => _POST('btn3'),
                'btnid3' => _POST('btn3'),
                'pesan' => str_replace("{name}", $nl->nama, $pesan),
                'make_by' => $this->session->userdata('id_login')
              ];
              $cek =  $this->db->get_where('blast', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('blast', $datainsert);
              }
            } else if ($this->input->post('type') == '4') {
              $datainsert = [
                'type' => 'Url & Call Button',
                'sender' => $device,
                'tujuan' => $nl->nomor,
                'footer' => _POST('footer'),
                'btn1' => _POST('btnurl'),
                'btnid1' => _POST('btnurl_val'),
                'btn2' => _POST('btncall'),
                'btnid2' => _POST('btncall_val'),
                'pesan' => str_replace("{name}", $nl->nama, $pesan),
                'make_by' => $this->session->userdata('id_login')
              ];
              $cek =  $this->db->get_where('blast', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('blast', $datainsert);
              }
            }
          }
        } else {
          $row = $this->db->get_where('nomor', ['nomor' => $t, 'make_by' => $this->session->userdata('id_login')])->row();
          if ($this->input->post('type') == '1') {
            $datainsert = [
              'type' => 'Text',
              'sender' => $device,
              'tujuan' => $t,
              'pesan' => str_replace("{name}", $row->nama, $pesan),
              'make_by' => $this->session->userdata('id_login')
            ];
            $cek =  $this->db->get_where('blast', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('blast', $datainsert);
            }
          } else if ($this->input->post('type') == '2') {
            $datainsert = [
              'type' => 'Text & Media',
              'sender' => $device,
              'tujuan' => $t,
              'pesan' => str_replace("{name}", $row->nama, $pesan),
              'media' => $media,
              'make_by' => $this->session->userdata('id_login')
            ];
            $cek =  $this->db->get_where('blast', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('blast', $datainsert);
            }
          } else if ($this->input->post('type') == '3') {
            $datainsert = [
              'type' => 'Quick Reply Button',
              'sender' => $device,
              'tujuan' => $t,
              'pesan' => str_replace("{name}", $row->nama, $pesan),
              'footer' => _POST('footer'),
              'btn1' => _POST('btn1'),
              'btnid1' => _POST('btn1'),
              'btn2' => _POST('btn2'),
              'btnid2' => _POST('btn2'),
              'btn3' => _POST('btn3'),
              'btnid3' => _POST('btn3'),
              'make_by' => $this->session->userdata('id_login')
            ];
            $cek =  $this->db->get_where('blast', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('blast', $datainsert);
            }
          } else if ($this->input->post('type') == '4') {
            $datainsert = [
              'type' => 'Url & Call Button',
              'sender' => $device,
              'tujuan' => $t,
              'pesan' => str_replace("{name}", $row->nama, $pesan),
              'footer' => _POST('footer'),
              'btn1' => _POST('btnurl'),
              'btnid1' => _POST('btnurl_val'),
              'btn2' => _POST('btncall'),
              'btnid2' => _POST('btncall_val'),
              'make_by' => $this->session->userdata('id_login')
            ];
            $cek =  $this->db->get_where('blast', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('blast', $datainsert);
            }
          }
        }
      }
      $res = ['status' => true];
      if ($res['status'] == true) {
        $this->session->set_flashdata('success', 'Send message successfully, message status can be seen in the table below this page.');
        redirect(base_url('blast'));
      } else {
        $this->session->set_flashdata('error', 'Scan the QR first.');
        redirect(base_url('blast'));
      }
    } else {
      $id_login = $this->session->userdata('id_login');
      $data = [
        'title' => 'Blast',
        'device' =>  $this->db->get_where('device', ['pemilik' => $id_login]),
        'nomor' => $this->db->get_where('nomor', ['make_by' => $id_login]),
        'blast' => $this->db->query("SELECT * FROM blast WHERE make_by='$id_login' ORDER BY id DESC"),
        'label' => $this->db->query('SELECT * FROM nomor WHERE label!="" GROUP BY label ORDER BY id DESC')
      ];
      view('blast', $data);
    }
  }

  public function blast_del()
  {
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $this->db->query("DELETE FROM blast WHERE id IN(" . implode(",", $id) . ")");
      $this->session->set_flashdata('success', 'Successfully Delete the blast in the checklist.');
      redirect(base_url('blast'));
    } else {
      $this->session->set_flashdata('error', 'checklist that you want to delete.');
      redirect(base_url('blast'));
    }
  }

  public function schedule()
  {
    $id_login = $this->session->userdata('id_login');
    if ($this->input->post()) {
      $pesan = _POST("pesan");
      $sender = _POST("device");
      $jadwal = date("Y-m-d H:i:s", strtotime(_POST("tgl") . " " . _POST("jam")));
      if ($this->input->post('media') == '') {
        $media = null;
      } else {
        $media = $this->input->post('media');
      }

      if ($this->input->post('all_number')) {
        foreach ($this->db->get_where('nomor', ['make_by' => $this->session->userdata('id_login')])->result() as $nomor) {
          if ($this->input->post('type') == '1') {
            $datainsert = [
              'type' => 'Text',
              'sender' => $sender,
              'nomor' => $nomor->nomor,
              'pesan' => str_replace('{name}', $nomor->nama, $pesan),
              'jadwal' => $jadwal,
              'make_by' => $id_login,
            ];
            $cek =  $this->db->get_where('pesan', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('pesan', $datainsert);
            }
          } else if ($this->input->post('type') == '2') {
            $datainsert = [
              'type' => 'Text & Media',
              'sender' => $sender,
              'nomor' => $nomor->nomor,
              'pesan' => str_replace('{name}', $nomor->nama, $pesan),
              'jadwal' => $jadwal,
              'make_by' => $id_login,
              'media' => $media
            ];
            $cek =  $this->db->get_where('pesan', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('pesan', $datainsert);
            }
          } else if ($this->input->post('type') == '3') {
            $datainsert = [
              'type' => 'Quick Reply Button',
              'sender' => $sender,
              'nomor' => $nomor->nomor,
              'pesan' => str_replace('{name}', $nomor->nama, $pesan),
              'jadwal' => $jadwal,
              'make_by' => $id_login,
              'footer' => _POST('footer'),
              'btn1' => _POST('btn1'),
              'btnid1' => _POST('btn1'),
              'btn2' => _POST('btn2'),
              'btnid2' => _POST('btn2'),
              'btn3' => _POST('btn3'),
              'btnid3' => _POST('btn3')
            ];
            $cek =  $this->db->get_where('pesan', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('pesan', $datainsert);
            }
          } else if ($this->input->post('type') == '4') {
            $datainsert = [
              'type' => 'Url & Call Button',
              'sender' => $sender,
              'nomor' => $nomor->nomor,
              'pesan' => str_replace('{name}', $nomor->nama, $pesan),
              'jadwal' => $jadwal,
              'make_by' => $id_login,
              'footer' => _POST('footer'),
              'btn1' => _POST('btnurl'),
              'btnid1' => _POST('btnurl_val'),
              'btn2' => _POST('btncall'),
              'btnid2' => _POST('btncall_val')
            ];
            $cek =  $this->db->get_where('pesan', $datainsert);
            if ($cek->num_rows() == 0) {
              $this->db->insert('pesan', $datainsert);
            }
          }
        }
      } else {
        $target = $this->input->post('target');
        foreach ($target as $t) {
          $label = $this->db->get_where('nomor', ['label' => $t, 'make_by' => $this->session->userdata('id_login')]);
          if ($label->num_rows() != 0) {
            $nolabel = $label->result();
            foreach ($nolabel as $nl) {
              if ($this->input->post('type') == '1') {
                $datainsert = [
                  'type' => 'Text',
                  'sender' => $sender,
                  'nomor' => $nl->nomor,
                  'pesan' => str_replace('{name}', $nl->nama, $pesan),
                  'jadwal' => $jadwal,
                  'make_by' => $id_login
                ];
                $cek =  $this->db->get_where('pesan', $datainsert);
                if ($cek->num_rows() == 0) {
                  $this->db->insert('pesan', $datainsert);
                }
              } else if ($this->input->post('type') == '2') {
                $datainsert = [
                  'type' => 'Text & Media',
                  'sender' => $sender,
                  'nomor' => $nl->nomor,
                  'pesan' => str_replace('{name}', $nl->nama, $pesan),
                  'jadwal' => $jadwal,
                  'make_by' => $id_login,
                  'media' => $media
                ];
                $cek =  $this->db->get_where('pesan', $datainsert);
                if ($cek->num_rows() == 0) {
                  $this->db->insert('pesan', $datainsert);
                }
              } else if ($this->input->post('type') == '3') {
                $datainsert = [
                  'type' => 'Quick Reply Button',
                  'sender' => $sender,
                  'nomor' => $nl->nomor,
                  'pesan' => str_replace('{name}', $nl->nama, $pesan),
                  'jadwal' => $jadwal,
                  'make_by' => $id_login,
                  'footer' => _POST('footer'),
                  'btn1' => _POST('btn1'),
                  'btnid1' => _POST('btn1'),
                  'btn2' => _POST('btn2'),
                  'btnid2' => _POST('btn2'),
                  'btn3' => _POST('btn3'),
                  'btnid3' => _POST('btn3')
                ];
                $cek =  $this->db->get_where('pesan', $datainsert);
                if ($cek->num_rows() == 0) {
                  $this->db->insert('pesan', $datainsert);
                }
              } else if ($this->input->post('type') == '4') {
                $datainsert = [
                  'type' => 'Url & Call Button',
                  'sender' => $sender,
                  'nomor' => $nl->nomor,
                  'pesan' => str_replace('{name}', $nl->nama, $pesan),
                  'jadwal' => $jadwal,
                  'make_by' => $id_login,
                  'footer' => _POST('footer'),
                  'btn1' => _POST('btnurl'),
                  'btnid1' => _POST('btnurl_val'),
                  'btn2' => _POST('btncall'),
                  'btnid2' => _POST('btncall_val')
                ];
                $cek =  $this->db->get_where('pesan', $datainsert);
                if ($cek->num_rows() == 0) {
                  $this->db->insert('pesan', $datainsert);
                }
              }
            }
          } else {
            $row = $this->db->get_where('nomor', ['nomor' => $t, 'make_by' => $this->session->userdata('id_login')])->row();
            if ($this->input->post('type') == '1') {
              $datainsert = [
                'type' => 'Text',
                'sender' => $sender,
                'nomor' => $t,
                'pesan' => str_replace('{name}', $row->nama, $pesan),
                'jadwal' => $jadwal,
                'make_by' => $id_login,
              ];
              $cek =  $this->db->get_where('pesan', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('pesan', $datainsert);
              }
            } else if ($this->input->post('type') == '2') {
              $datainsert = [
                'type' => 'Text & Media',
                'sender' => $sender,
                'nomor' => $t,
                'pesan' => str_replace('{name}', $row->nama, $pesan),
                'jadwal' => $jadwal,
                'make_by' => $id_login,
                'media' => $media
              ];
              $cek =  $this->db->get_where('pesan', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('pesan', $datainsert);
              }
            } else if ($this->input->post('type') == '3') {
              $datainsert = [
                'type' => 'Quick Reply Button',
                'sender' => $sender,
                'nomor' => $t,
                'pesan' => str_replace('{name}', $row->nama, $pesan),
                'jadwal' => $jadwal,
                'make_by' => $id_login,
                'footer' => _POST('footer'),
                'btn1' => _POST('btn1'),
                'btnid1' => _POST('btn1'),
                'btn2' => _POST('btn2'),
                'btnid2' => _POST('btn2'),
                'btn3' => _POST('btn3'),
                'btnid3' => _POST('btn3')
              ];
              $cek =  $this->db->get_where('pesan', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('pesan', $datainsert);
              }
            } else if ($this->input->post('type') == '4') {
              $datainsert = [
                'type' => 'Url & Call Button',
                'sender' => $sender,
                'nomor' => $t,
                'pesan' => str_replace('{name}', $row->nama, $pesan),
                'jadwal' => $jadwal,
                'make_by' => $id_login,
                'footer' => _POST('footer'),
                'btn1' => _POST('btnurl'),
                'btnid1' => _POST('btnurl_val'),
                'btn2' => _POST('btncall'),
                'btnid2' => _POST('btncall_val')
              ];
              $cek =  $this->db->get_where('pesan', $datainsert);
              if ($cek->num_rows() == 0) {
                $this->db->insert('pesan', $datainsert);
              }
            }
          }
        }
      }
      $this->session->set_flashdata('success', 'Successfully submit scheduled message.');
      redirect(base_url('schedule'));
    } else {
      $data = [
        'title' => 'Scheduled',
        'device' =>  $this->db->get_where('device', ['pemilik' => $id_login]),
        'nomor' => $this->db->get_where('nomor', ['make_by' => $id_login]),
        'pesan' => $this->db->get_where('pesan', ['make_by' => $id_login]),
        'label' => $this->db->query('SELECT * FROM nomor WHERE label!="" GROUP BY label ORDER BY id DESC')
      ];
      view("pesan_jadwal", $data);
    }
  }

  public function schedule_del()
  {
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $this->db->query("DELETE FROM pesan WHERE id IN(" . implode(",", $id) . ")");
      $this->session->set_flashdata('success', 'Successfully delete the schedule in the checklist.');
      redirect(base_url('schedule'));
    } else {
      $this->session->set_flashdata('error', 'checklist that you want to delete.');
      redirect(base_url('schedule'));
    }
  }


  public function send()
  {
    if ($this->input->post()) {
      $submitby = $this->input->post('submitby');
      if ($submitby == 'pesan-text') {
        $device = _POST('device');
        $nomor = _POST('nomor');
        $pesan = _POST('pesan');
        $res = sendMSG($nomor, $pesan, $device);
        if ($res['status'] == true) {
          $datainsert = [
            'device' => $device,
            'receiver' => $nomor,
            'message' => $pesan,
            'type' => 'single',
            'status' => 'Sent',
            'created_at' => date('Y-m-d H:i:s')
          ];
          $this->db->insert('reports', $datainsert);
          $this->session->set_flashdata('success', 'Text message sent.');
          redirect(base_url('send'));
        } else {
          $datainsert = [
            'device' => $device,
            'receiver' => $nomor,
            'message' => $pesan,
            'type' => 'single',
            'status' => 'Failed',
            'created_at' => date('Y-m-d H:i:s')
          ];
          $this->db->insert('reports', $datainsert);
          $this->session->set_flashdata('error', 'failed to send message.');
          redirect(base_url('send'));
        }
      } else if ($submitby == 'pesan-media') {
        $device = $this->input->post('device');
        $nomor = $this->input->post('nomor');
        $pesan = $this->input->post('pesan');
        $media = $this->input->post('media');
        $a = explode('/', $media);
        $filename = $a[count($a) - 1];
        $a2 = explode('.', $filename);
        $namefile = $a2[count($a2) - 2];
        $filetype = $a2[count($a2) - 1];
        $getstorage = $this->db->get_where('storage', ['namafile' => $filename])->row();
        $res = sendMedia($nomor, $pesan, $device, $filetype, explode('.', $getstorage->nama_original)[0], $media);
        if ($res['status'] == true) {
          $datainsert = [
            'device' => $device,
            'receiver' => $nomor,
            'message' => $pesan,
            'media' => $media,
            'type' => 'single',
            'status' => 'Sent',
            'created_at' => date('Y-m-d H:i:s')
          ];
          $this->db->insert('reports', $datainsert);
          $this->session->set_flashdata('success', 'Media message sent.');
          redirect(base_url('send'));
        } else {
          $datainsert = [
            'device' => $device,
            'receiver' => $nomor,
            'message' => $pesan,
            'media' => $media,
            'type' => 'single',
            'status' => 'Failed',
            'created_at' => date('Y-m-d H:i:s')
          ];
          $this->db->insert('reports', $datainsert);
          $this->session->set_flashdata('error', 'failed to send message.');
          redirect(base_url('send'));
        }
      } else if ($submitby == 'pesan-button') {
        $device = $this->input->post('device');
        $nomor = $this->input->post('nomor');
        $pesan = $this->input->post('pesan');
        $footer = $this->input->post('footer');
        $btn1 = $this->input->post('btn1');
        $btn2 = $this->input->post('btn2');
        $res = sendBTN($nomor, $device, $pesan, $footer, $btn1, $btn2);
        if ($res['status'] == true) {
          $datainsert = [
            'device' => $device,
            'receiver' => $nomor,
            'message' => $pesan,
            'footer' => $footer,
            'btn1' => $btn1,
            'btn2' => $btn2,
            'btnid1' => $btn1,
            'btnid2' => $btn2,
            'type' => 'single',
            'status' => 'Sent',
            'created_at' => date('Y-m-d H:i:s')
          ];
          $this->db->insert('reports', $datainsert);
          $this->session->set_flashdata('success', 'Text message sent.');
          redirect(base_url('send'));
        } else {
          $datainsert = [
            'device' => $device,
            'receiver' => $nomor,
            'message' => $pesan,
            'footer' => $footer,
            'btn1' => $btn1,
            'btn2' => $btn2,
            'btnid1' => $btn1,
            'btnid2' => $btn2,
            'type' => 'single',
            'status' => 'Failed',
            'created_at' => date('Y-m-d H:i:s')
          ];
          $this->db->insert('reports', $datainsert);
          $this->session->set_flashdata('error', 'failed to send message');
          redirect(base_url('send'));
        }
      }
    } else {
      $data = [
        'title' => 'Single Send',
        'device' =>  $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')])
      ];
      view('send', $data);
    }
  }

  public function api()
  {
    $data = [
      'title' => 'API'
    ];
    view('api', $data);
  }

  public function settings()
  {
    if ($this->input->post('account')) {
      $username = _POST('username');
      $password = $this->input->post('password');
      $api = $this->input->post('api');
      if ($password == '') {
        $pw = $this->input->post('old_password');
      } else {
        $pw = password_hash($password, PASSWORD_DEFAULT);
      }
      $this->db->update('account', [
        'username' => $username,
        'password' => $pw,
        'api_key' => $api
      ], ['id' => $this->session->userdata('id_login')]);
      $this->session->set_flashdata('success', 'The account has been updated.');
      redirect(base_url('settings'));
    } else {
      $data = [
        'title' => 'Settings',
        'settings' => $this->db->get_where('settings', ['id' => 1])->row()
      ];
      view('settings', $data);
    }
  }

  public function users()
  {
    $uw = $this->db->get_where('account', ['id' => $this->session->userdata('id_login')])->row();
    if ($uw->level == 2) {
      $this->session->set_flashdata('error', 'Only for admin level.');
      redirect(base_url());
    }
    if ($this->input->post()) {
      $username = _POST('username');
      if ($this->db->get_where('account', ['username' => $username])->num_rows() == 1) {
        $this->session->set_flashdata('error', 'Username already exist.');
        redirect(base_url('users'));
      }
      $password = _POST('password');
      $limitdevice = _POST('limitdevice');
      if ($this->input->post('lifetime') == 'on') {
        $expired = null;
      } else {
        $expired = $this->input->post('expired');
      }
      $level = $this->input->post('level');
      $this->db->insert('account', [
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'level' => $level,
        'status' => 'active',
        'expired' => $expired,
        'limit_device' => $limitdevice,
        'api_key' => md5(date('H:i'))
      ]);
      $this->session->set_flashdata('success', 'Account has been added.');
      redirect(base_url('users'));
    } else {
      $data = [
        'title' => 'Users',
        'users' => $this->db->get('account')
      ];
      view('users', $data);
    }
  }

  public function settings_post()
  {
    $uw = $this->db->get_where('account', ['id' => $this->session->userdata('id_login')])->row();
    if ($uw->level == 2) {
      $this->session->set_flashdata('error', 'Only for admin level.');
      redirect(base_url());
    }
    if ($this->input->post('globals')) {
      $this->db->update('settings', ['base_node' => $this->input->post('base_node'), 'install_in' => $this->input->post('install_in')], ['id' => 1]);
      $this->session->set_flashdata('success', 'Global settings have been updated.');
      redirect(base_url('settings'));
    }
  }

  public function users_edit()
  {
    $id = $this->uri->segment(3);
    if ($this->input->post()) {
      $username = _POST('username');
      if ($this->db->get_where('account', ['username' => $username, 'id!=' => $id])->num_rows() == 1) {
        $this->session->set_flashdata('error', 'Username already exist.');
        redirect(base_url('users'));
      }
      if (_POST('password') == '') {
        $password = _POST('old_password');
      } else {
        $password = password_hash(_POST('password'), PASSWORD_DEFAULT);
      }
      $limitdevice = _POST('limitdevice');
      if ($this->input->post('lifetime') == 'on') {
        $expired = null;
      } else {
        $expired = $this->input->post('expired');
      }
      $level = $this->input->post('level');
      $this->db->update('account', [
        'username' => $username,
        'password' => $password,
        'level' => $level,
        'status' =>  $this->input->post('status'),
        'expired' => $expired,
        'limit_device' => $limitdevice
      ], ['id' => $id]);
      $this->session->set_flashdata('success', 'Account has been added.');
      redirect(base_url('users'));
    } else {
      $data = [
        'title' => 'Users Edit',
        'users' => $this->db->get_where('account', ['id' => $id])->row()
      ];
      view('users_edit', $data);
    }
  }

  public function users_del()
  {
    $uw = $this->db->get_where('account', ['id' => $this->session->userdata('id_login')])->row();
    if ($uw->level == 2) {
      $this->session->set_flashdata('error', 'Only for admin level.');
      redirect(base_url());
    }
    $id = $this->uri->segment(3);
    $this->db->delete('account', ['id' => $id]);
    $this->session->set_flashdata('success', 'Account has been deleted.');
    redirect(base_url('users'));
  }
}
