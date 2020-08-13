<?php
require '../settings.php';

$data_raw = file_get_contents("php://input");
$data_arr = json_decode($data_raw, true);

$return_arr = array( 'status'=>'', 'code'=>'', 'msg'=>'','debug'=>$data_raw );

$key = $data_arr['key'];

$name = $data_arr['name'];
$gender = $data_arr['gender'];
$first_choice = $data_arr['first_choice'];
$second_choice = $data_arr['second_choice'];
$obey = $data_arr['obey'];
$phone = $data_arr['phone'];
$college = $data_arr['college'];
$class = $data_arr['class'];
$dorm_building = $data_arr['dorm_building'];
$dorm_room = $data_arr['dorm_room'];
$hobby = $data_arr['hobby'];
$introduction = $data_arr['introduction'];
$other = $data_arr['other'];

if ($key != $secure_key) {
    $return_arr['status'] = 'failed';
    $return_arr['code'] = 'auth_error';
    $return_arr['msg'] = '认证失败，请联系管理员';
    exit( json_encode( $return_arr ) );
}

if ($name=='' || $gender=='' || $first_choice=='' || $second_choice=='' || $obey=='' || 
$phone=='' || $college=='' || $class=='' || $dorm_building=='' || 
$dorm_room=='' || $hobby=='' || $introduction=='' || $other=='') {
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

$query = 'INSERT INTO signup (name, gender, first_choice, second_choice, obey, 
phone, college, class, dorm_building, 
dorm_room, hobby, introduction, other) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)';
$stmt = $dbconn->prepare($query);
$stmt->bind_param('sssssssssssss', 
$name, $gender, $first_choice, $second_choice, $obey, 
$phone, $college, $class, $dorm_building, 
$dorm_room, $hobby, $introduction, $other);
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
Error
