<?php
require '../settings.php';

$data_raw = file_get_contents("php://input");
$data_arr = json_decode($data_raw, true);

$return_arr = array( 'status'=>'', 'code'=>'', 'msg'=>'','debug'=>$data_raw );

$key = $data_arr['key'];

$in_item = $data_arr['item'];
$in_name = $data_arr['name'];
$in_phone = $data_arr['phone'];
$in_grade = $data_arr['grade'];
$in_college = $data_arr['college'];
$in_dorm_building = $data_arr['dorm_building'];
$in_dorm_room = $data_arr['dorm_room'];
$in_description = $data_arr['description'];
$in_notes = $data_arr['notes'];

if ($key != $secure_key) {
    $return_arr['status'] = 'failed';
    $return_arr['code'] = 'auth_error';
    $return_arr['msg'] = '认证失败，请联系管理员';
    exit( json_encode( $return_arr ) );
}

if ($in_item=='' || $in_name=='' || $in_phone=='' || $in_grade=='' || $in_college=='' || $in_dorm_building=='' || $in_dorm_room=='' || $in_description=='') {
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

$query = 'INSERT INTO fix (item, name, phone, grade, college, dorm_building, dorm_room, description, notes) VALUES (?,?,?,?,?,?,?,?,?)';
$stmt = $dbconn->prepare($query);
$stmt->bind_param('sssssssss', $in_item, $in_name, $in_phone, $in_grade, $in_college, $in_dorm_building, $in_dorm_room, $in_description, $in_notes);
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
echo json_encode($return_arr);
?>
