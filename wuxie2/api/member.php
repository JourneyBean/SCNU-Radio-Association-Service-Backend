<?php
// ini_set('display_errors', '1');

function getRecordByPhone( $phone ) {
    require '../settings.php';

    $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
    if ($dbconn->connect_errno) {
        $return_arr['status'] = 'error';
        $return_arr['code'] = 'db_connect_error';
        $return_arr['msg'] = '数据库连接失败';
        exit( json_encode( $return_arr ) );
    }

    $query = "SELECT id FROM member WHERE phone=?";
    $stmt = $dbconn->prepare($query);
    $stmt->bind_param('s', $phone);
    $stmt->execute();
    $stmt->store_result();
    
    $record_num = $stmt->num_rows;
    if ($record_num == 0) {
        $return_num = -1;
    } else {
        $stmt->bind_result($id);
        $stmt->fetch();
        $return_num = $id;
    }

    $stmt->close();
    $dbconn->close();

    return $return_num;
}

function insertRecordById($id, $name, $gender, $phone, $college, $class, $dorm_building, $dorm_room) {
    require '../settings.php';

    $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
    if ($dbconn->connect_errno) {
        $return_arr['status'] = 'error';
        $return_arr['code'] = 'db_connect_error';
        $return_arr['msg'] = '数据库连接失败';
        exit( json_encode( $return_arr ) );
    }

    //$query = 'update member set name="Test222", gender="both",phone="12333333",college="wudian",class="baban",dorm_building="nan4",dorm_room="45558" where id=120';
    $query = "UPDATE member SET name=?, gender=?, phone=?, college=?, class=?, dorm_building=?, dorm_room=? WHERE id=?";
    $stmt = $dbconn->prepare($query);
    $stmt->bind_param('sssssssi', $name, $gender, $phone, $college, $class, $dorm_building, $dorm_room, $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->affected_rows != '1') {
        $return_arr['status'] = 'success';
        $return_arr['code'] = 'success';
        $return_arr['msg'] = '数据库写入失败（数据一致）。重复报名？如需修改数据，请修改后再提交。'.$stmt->error;
        exit( json_encode( $return_arr ) );
    }

    $stmt->close();
    $dbconn->close();

}

function newRecord($name, $gender, $phone, $college, $class, $dorm_building, $dorm_room) {
    require '../settings.php';

    $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
    if ($dbconn->connect_errno) {
        $return_arr['status'] = 'error';
        $return_arr['code'] = 'db_connect_error';
        $return_arr['msg'] = '数据库连接失败';
        exit( json_encode( $return_arr ) );
    }

    $query = 'INSERT INTO member (name, gender, phone, college, class, dorm_building, dorm_room) VALUES (?,?,?,?,?,?,?)';
    $stmt = $dbconn->prepare($query);
    $stmt->bind_param('sssssss', $name, $gender, $phone, $college, $class, $dorm_building, $dorm_room);
    $stmt->execute();
    if ($stmt->affected_rows != '1') {
        $return_arr['status'] = 'error';
        $return_arr['code'] = 'db_write_error';
        $return_arr['msg'] = '数据库写入失败：'.$stmt->error;
        exit( json_encode( $return_arr ) );
    }

    $stmt->close();
    $dbconn->close();

}


require '../settings.php';

$data_raw = file_get_contents("php://input");
$data_arr = json_decode($data_raw, true);

$return_arr = array( 'status'=>'', 'code'=>'', 'msg'=>'','debug'=>$data_raw );


// 通道开关
$isOpen = 1;

if ($isOpen == 1) {



    $key = $data_arr['key'];

    $name = $data_arr['name'];
    $gender = $data_arr['gender'];
    $phone = $data_arr['phone'];
    $college = $data_arr['college'];
    $class = $data_arr['class'];
    $dorm_building = $data_arr['dorm_building'];
    $dorm_room = $data_arr['dorm_room'];

    if ($key != $secure_key) {
        $return_arr['status'] = 'failed';
        $return_arr['code'] = 'auth_error';
        $return_arr['msg'] = '认证失败，请联系管理员';
        exit( json_encode( $return_arr ) );
    }

    if ($name=='' || $gender=='' || $phone=='' || $college=='' || $class=='' || $dorm_building=='' || $dorm_room=='') {
        $return_arr['status'] = 'failed';
        $return_arr['code'] = 'data_imcomplete';
        $return_arr['msg'] = '请填写所有信息';
        exit( json_encode( $return_arr ) );
    }

    $gotRecordId = getRecordByPhone($phone);
    if ( $gotRecordId != -1) {
        // Need update
        insertRecordById($gotRecordId, $name, $gender, $phone, $college, $class, $dorm_building, $dorm_room);
        $return_arr['status'] = 'success';
        $return_arr['code'] = 'success';
        $return_arr['msg'] = '数据更新成功';
    } else {
        newRecord($name, $gender, $phone, $college, $class, $dorm_building, $dorm_room);
        $return_arr['status'] = 'success';
        $return_arr['code'] = 'success';
        $return_arr['msg'] = '报名成功';
    }

    echo json_encode($return_arr);

} else {
    $return_arr['status'] = 'success';
    $return_arr['code'] = 'success';
    $return_arr['msg'] = '现在不是报名时间';
    echo json_encode($return_arr);
}



?>
