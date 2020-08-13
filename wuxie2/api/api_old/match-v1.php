<?php

require '../settings.php';

$data_raw = file_get_contents("php://input");
$data_arr = json_decode($data_raw, true);

$return_arr = array( 'status'=>'', 'code'=>'', 'msg'=>'','debug'=>$data_raw );

$key = $data_arr['key'];

$team_name = $data_arr['team_name'];
$first_name = $data_arr['first_name'];
$first_id = $data_arr['first_id'];
$first_college = $data_arr['first_college'];
$first_class = $data_arr['first_class'];
$first_dorm_building = $data_arr['first_dorm_building'];
$first_dorm_room = $data_arr['first_dorm_room'];
$first_phone = $data_arr['first_phone'];

$second_name = $data_arr['second_name'];
$second_id = $data_arr['second_id'];
$second_college = $data_arr['second_college'];
$second_class = $data_arr['second_class'];
$second_phone = $data_arr['second_phone'];

$third_name = $data_arr['third_name'];
$third_id = $data_arr['third_id'];
$third_college = $data_arr['third_college'];
$third_class = $data_arr['third_class'];
$third_phone = $data_arr['third_phone'];


if ($key != $secure_key) {
    $return_arr['status'] = 'failed';
    $return_arr['code'] = 'auth_error';
    $return_arr['msg'] = '认证失败，请联系管理员';
    exit( json_encode( $return_arr ) );
}

if ($team_name=='' || $first_name=='' || $first_id=='' || $first_college=='' || $first_class=='' || 
$first_dorm_building=='' || $first_dorm_room=='' || $first_phone=='' || false) {
    $return_arr['status'] = 'failed';
    $return_arr['code'] = 'data_imcomplete';
    $return_arr['msg'] = '请填写所有信息';
    exit( json_encode( $return_arr ) );
}

$dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($dbconn->connect_errno) {
    $return_arr['status'] = 'error';
    $return_arr['code'] = 'db_connect_error';
    $return_arr['msg'] = '数据库连接失败';
    exit( json_encode( $return_arr ) );
}

$query = 'INSERT INTO comp (team_name, first_name, first_id, first_college, first_class, first_dorm_building, first_dorm_room, first_phone, 
second_name, second_id, second_college, second_class, second_phone, 
third_name, third_id, third_college, third_class, third_phone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
$stmt = $dbconn->prepare($query);
$stmt->bind_param('ssssssssssssssssss', $team_name,$first_name,$first_id, $first_college, $first_class, $first_dorm_building, $first_dorm_room, $first_phone, 
$second_name, $second_id, $second_college, $second_class, $second_phone, 
$third_name, $third_id, $third_college, $third_class, $third_phone);
$stmt->execute();

if ($stmt->affected_rows != '1') {
    $return_arr['status'] = 'error';
    $return_arr['code'] = 'db_write_error';
    $return_arr['msg'] = '数据库写入失败：'.$stmt->error;
    exit( json_encode( $return_arr ) );
}

$return_arr['status'] = 'success';
$return_arr['code'] = 'success';
$return_arr['msg'] = '报名成功';
// $return_arr['msg'] = '现在不是报名时间';
echo json_encode($return_arr);
?>