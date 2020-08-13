<?php
require './../../../settings.php';
require './../libraries.php';

$data_raw = file_get_contents('php://input');
$data_arr = json_decode($data_raw, true);

$key = $data_arr['key'];

$username = $data_arr['username'];
$password = $data_arr['password'];

$return_arr = array('status'=>'', 'code'=>'', 'session'=>'');

if ($key != $manage_key) {
    // authkey invalid
    $return_arr['status'] = 'error';
    $return_arr['code'] = 'key_invalid';
} else {
    // authkey correct
    $get_arr = new_session($username, $password);
    $return_arr['status'] = $get_arr['status'];
    $return_arr['code'] = $get_arr['code'];
    $return_arr['session'] = $get_arr['session'];
}

echo json_encode($return_arr);
?>
