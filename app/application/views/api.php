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
    <link href="<?= _assets() ?>/plugins/highlight/styles/github-gist.css" rel="stylesheet">
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
									<form action="" method="post" class="loadingbtn">

                                            <input type="hidden" name="account" value="pesan-text">
                                            <div class="row">
                                                <div class="mt-3">
                                                    <label>Api Key/Token</label>
                                                    <input type="text" class="form-control" value="<?= $user->api_key ?>" name="api" required>
                                                </div>
                                                
                                        </form>
                                </div>
                            </div>
                        </div>
                        <?= _alert() ?>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#p-text" type="button" role="tab" aria-controls="" aria-selected=" true">Message Text</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#p-media" type="button" role="tab" aria-controls="" aria-selected="false">Message Media</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#p-tombol" type="button" role="tab" aria-controls="" aria-selected="false">Message Button</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#webhooksss" type="button" role="tab" aria-controls="" aria-selected="false">Webhook</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="p-text" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <table class="table table-striped">
                                            <tr>
                                                <td>
                                                    <span class="text-warning">apikey</span>
                                                </td>
                                                <td>Your api key</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">sender</span>
                                                </td>
                                                <td>sender number (must have scanned qr)</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">receiver</span>
                                                </td>
                                                <td>message recipient</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">message</span>
                                                </td>
                                                <td>message content</td>
                                            </tr>
                                        </table>
                                        <br>
                                        <h4>GET</h4>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="html"><?= base_url('api/send-message') ?>?<span class="text-warning">apikey</span>=<?= $user->api_key ?>&<span class="text-warning">sender</span>=628xxxx&<span class="text-warning">receiver</span>=628xxxx&<span class="text-warning">message</span>=test</code></pre>
                                            </div>
                                        </div>
                                        <br>
                                        <h4>POST</h4>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">$data = [
    'api_key' => '<?= $user->api_key ?>',
    'sender'  => 'Sender number (make sure its scanned)',
    'number'  => 'Number of destination to send message',
    'message' => 'the message'
];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "<?= base_url('api/send-message') ?>",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($data))
);

$response = curl_exec($curl);

curl_close($curl);
echo $response;
                                                </code></pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="p-media" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <table class="table table-striped">
                                            <tr>
                                                <td>
                                                    <span class="text-warning">apikey</span>
                                                </td>
                                                <td>Your api key</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">sender</span>
                                                </td>
                                                <td>sender number (must have scanned qr)</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">receiver</span>
                                                </td>
                                                <td>message recipient</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">message</span>
                                                </td>
                                                <td>message content</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">url</span>
                                                </td>
                                                <td>Url Media Images</td>
                                            </tr>
                                        </table>
                                        <br>
                                        <h4>GET</h4>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="html"><?= base_url('api/send-media') ?>?<span class="text-warning">apikey</span>=<?= $user->api_key ?>&<span class="text-warning">sender</span>=628xxxx&<span class="text-warning">receiver</span>=628xxxx&<span class="text-warning">message</span>=test&url=https://i.ibb.co/HNdL38S/Untitled-1.png</code></pre>
                                            </div>
                                        </div>
                                        <br>
                                        <h4>POST</h4>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">$data = [
    'api_key' => '<?= $user->api_key ?>',
    'sender'  => 'sender number (make sure its scanned)',
    'number'  => 'Number of destination to send message',
    'message' => 'caption (fill in if you send a picture)',
    
    'url' => 'Link image/pdf'
];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "<?= base_url('api/send-media') ?>",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($data))
);

$response = curl_exec($curl);

curl_close($curl);
echo $response;
                                                </code></pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="p-tombol" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <table class="table table-striped">
                                            <tr>
                                                <td>
                                                    <span class="text-warning">apikey</span>
                                                </td>
                                                <td>Your api key</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">sender</span>
                                                </td>
                                                <td>sender number (must have scanned qr)</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">receiver</span>
                                                </td>
                                                <td>message recipient</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">message</span>
                                                </td>
                                                <td>message content</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">footer</span>
                                                </td>
                                                <td>footer text</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">btn1</span>
                                                </td>
                                                <td>button1</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="text-warning">btn2</span>
                                                </td>
                                                <td>button2</td>
                                            </tr>
                                        </table>
                                        <br>
                                        <h4>GET</h4>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="html"><?= base_url('api/send-button') ?>?<span class="text-warning">apikey</span>=<?= $user->api_key ?>&<span class="text-warning">sender</span>=628xxxx&<span class="text-warning">receiver</span>=628xxxx&<span class="text-warning">message</span>=test&<span class="text-warning">footer</span>=footer&<span class="text-warning">btn1</span>=button1&<span class="text-warning">btn2</span>=button2</code></pre>
                                            </div>
                                        </div>
                                        <br>
                                        <h4>POST</h4>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">$data = [
    'api_key' => '<?= $user->api_key ?>',
    'sender'  => 'sender number (make sure its scanned)',
    'number'  => 'Number of destination to send message',
    'message' => 'message',
    'footer' => 'message below the button',
    'button1' => 'first button name',
    'button2' => 'second button name',
];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "<?= base_url('api/send-button') ?>",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($data))
);

$response = curl_exec($curl);

curl_close($curl);
echo $response;
                                                </code></pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="webhooksss" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <br>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">header('content-type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('whatsapp.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);
$message = $data['message']; // it catches incoming message
$from = $data['from']; // it catches message sender number


if (strtolower($message) == 'hai') {
    $result = [
        'mode' => 'chat', // mode chat = normal chat
        'pesan' => 'Hai juga'
    ];
} else if (strtolower($message) == 'hallo') {
    $result = [
        'mode' => 'reply', // mode reply = reply pessan
        'pesan' => 'Halo juga'
    ];
} else if (strtolower($message) == 'gambar') {
    $result = [
        'mode' => 'picture', // type picture = send picture message
        'data' => [
            'caption' => '*webhook picture*',
            'url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZ2Ox4zgP799q86H56GbPMNWAdQQrfIWD-Mw&usqp=CAU'
        ]
    ];
}

print json_encode($result);
                                                </code></pre>
                                            </div>
                                        </div>
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
    <script src="<?= _assets() ?>/plugins/highlight/highlight.pack.js"></script>
    <script src="<?= _assets() ?>/js/main.min.js"></script>
    <script src="<?= _assets() ?>/js/custom.js"></script>
    <script>
        $('select').select2();
    </script>
    <?php require_once('include_file.php') ?>
</body>

</html>