<?php
// SCRIPT BY VELIXS.COM 
// BELI SOURCE CODE INI KE VELIXS.COM UNTUK MENDAPAKAN UPDATE GRATIS

function base_node()
{
    $ci = &get_instance();
    $row = $ci->db->get_where('settings', ['id' => 1])->row();
    return $row->base_node;
}

function is_login($notcokie = true)
{
    $ci = &get_instance();
    if ($ci->session->userdata('status_login')) {
        return true;
    } else {
        if ($notcokie == true) {
            if (isset($_COOKIE['walix_id']) && isset($_COOKIE['walix_token'])) {
                $id_users = $_COOKIE['walix_id'];
                $password = $_COOKIE['walix_token'];
                $query = $ci->db->get_where("account", array('id' => $id_users));
                if ($query->num_rows() == 1) {
                    $row = $query->row();
                    if ($password == hash('ripemd160', $row->password)) {
                        $ci->session->set_userdata(array('status_login' => true, 'id_login' => $row->id));
                        return true;
                    } else {
                        unset($_COOKIE['walix_id']);
                        unset($_COOKIE['walix_token']);
                        setcookie('walix_id', NULL, -1, '/');
                        setcookie('walix_token', NULL, -1, '/');
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

function view($view, $data = [])
{
    $ci = &get_instance();
    $data['user'] = $ci->db->get_where('account', ['id' => $ci->session->userdata('id_login')])->row();
    if ($data['user']->status == 'expired') {
        $ci->session->set_flashdata('error', 'Your account has expired.');
        redirect(base_url('logout'));
    } else if ($data['user']->status == 'inactive') {
        $ci->session->set_flashdata('error', 'Your account has not been activated.');
        redirect(base_url('logout'));
    }
    $ci->load->view($view, $data);
}

function _assets($url = '')
{
    if ($url) {
        return base_url("assets/$url");
    } else {
        return base_url("assets");
    }
}

function _alert()
{
    $ci = &get_instance();
    if ($ci->session->flashdata('success')) {
        return '<div class="alert alert-success alert-style-light" role="alert">' . $ci->session->flashdata('success') . '</div>';
    } else if ($ci->session->flashdata('error')) {
        return '<div class="alert alert-danger alert-style-light" role="alert">' . $ci->session->flashdata('error') . '</div>';
    }
}

function _POST($par)
{
    $ci = &get_instance();
    $par = $ci->input->post($par);
    $par = htmlspecialchars($par);
    $par = str_replace("'", "", $par);
    return $par;
}

function _GET($par)
{
    $ci = &get_instance();
    $par = $ci->input->get($par);
    $par = htmlspecialchars($par);
    $par = str_replace("'", "", $par);
    return $par;
}

function _uploadMedia($reqired = false)
{
    if ($reqired == false) {
        return '                        <span class="d-flex justify-content-center mt-3 text-center" id="live_preview">
    <button onclick="mediamodal()" type="button" class="btn btn-primary">Upload Media</button>
    </span>
    <input type="hidden" id="inputmedia" name="media">';
    } else {
        return '                        <span class="d-flex justify-content-center mt-3 text-center" id="live_preview">
    <button onclick="mediamodal()" type="button" class="btn btn-primary">Upload Media</button>
    </span>
    <div class="text-center">
        <small>Required to be filled in.</small>
    </div>
    <input type="hidden" id="inputmedia" name="media" required>';
    }
}

function _storage()
{
    return base_url("storage/");
}

function uploadimg($par = [])
{
    $ci = &get_instance();
    $config['upload_path'] = "$par[path]";
    $config['allowed_types'] = 'jpg|png|jpeg|pdf';
    $config['encrypt_name'] = TRUE;
    $ci->load->library('upload', $config);
    $ci->upload->initialize($config);

    if (!empty($_FILES["$par[name]"]['name'])) {
        if ($ci->upload->do_upload("$par[name]")) {
            $img = $ci->upload->data();
            if ($par['compress'] == true) {
                //Compress Image
                $config['image_library'] = 'gd2';
                $config['source_image'] = "$par[path]" . $img['file_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = FALSE;
                $config['width'] = $par['width'];
                $config['height'] = $par['height'];
                $config['new_image'] = "$par[path]" . $img['file_name'];
                $ci->load->library('image_lib', $config);
                $ci->image_lib->resize();
            }

            $image = $img['file_name'];
            return array('result' => 'success', 'nama_file' => $image, 'error' => '');
        } else {
            return array('result' => 'error', 'file' => '', 'error' => $ci->upload->display_errors());
        }
    } else {
        return array('result' => 'noimg');
    }
}

function SendBlast($sender)
{
    $url = base_node() . "/blast";  // jika instal di local
    $data = [
        "sender" => $sender,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_URL, $url);
    //  curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function sendMSG($number, $msg, $sender)
{
    $url = base_node() . "/send-message";  // jika instal di local
    // $url = url_wa() . 'send-message';
    $data = [
        "sender" => $sender,
        "number" => $number,
        "message" => $msg
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_URL, $url);
    //  curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function SendBC($sender, $message, $filetype = '', $filename = '', $urll = '')
{
    $url = base_node() . "/send-broadcast";
    //$url = url_wa() . 'send-media';
    $data = [
        'sender' => $sender,
        'message' => $message,
        'url' => $urll,
        'filename' => $filename,
        'filetype' => $filetype,
    ];
    //var_dump($data); die;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function sendBTN($number, $sender, $msg, $footer, $btn1, $btn2)
{
    $url = base_node() . "/send-button";
    $data = [
        "sender" => $sender,
        "number" => $number,
        "message" => $msg,
        "footer" => $footer,
        "btn1" => $btn1,
        "btn2" => $btn2
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_URL, $url);
    //  curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function sendMedia($number, $message, $sender, $filetype, $filename, $urll)
{
    $url = base_node() . "/send-media";
    $data = [
        'sender' => $sender,
        'number' => $number,
        'caption' => $message,
        'url' => $urll,
        'filename' => $filename,
        'filetype' => $filetype,
    ];
    //var_dump($data); die;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}
