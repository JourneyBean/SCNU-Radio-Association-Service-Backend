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

    $query = "SELECT id FROM comp WHERE first_phone=?";
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

function insertRecordById($id, $team_name, $first_name, $first_id, $first_college, $first_class, $first_dorm_building, $first_dorm_room, $first_phone, 
$second_name, $second_id, $second_college, $second_class, $second_phone, 
$third_name, $third_id, $third_college, $third_class, $third_phone) {
    require '../settings.php';

    $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
    if ($dbconn->connect_errno) {
        $return_arr['status'] = 'error';
        $return_arr['code'] = 'db_connect_error';
        $return_arr['msg'] = '数据库连接失败';
        exit( json_encode( $return_arr ) );
    }

    //$query = 'update member set name="Test222", gender="both",phone="12333333",college="wudian",class="baban",dorm_building="nan4",dorm_room="45558" where id=120';
    $query = "UPDATE comp SET team_name=?, first_name=?, first_id=?, first_college=?, first_class=?, first_dorm_building=?, first_dorm_room=?,
     first_phone=?, 
    second_name=?, second_id=?, second_college=?, second_class=?, second_phone=?, 
    third_name=?, third_id=?, third_college=?, third_class=?, third_phone=? WHERE id=?";
    $stmt = $dbconn->prepare($query);
    $stmt->bind_param('ssssssssssssssssssi', $team_name, $first_name, $first_id, $first_college, $first_class, $first_dorm_building, $first_dorm_room, $first_phone, 
    $second_name, $second_id, $second_college, $second_class, $second_phone, 
    $third_name, $third_id, $third_college, $third_class, $third_phone, $id);
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

function newRecord($team_name, $first_name, $first_id, $first_college, $first_class, $first_dorm_building, $first_dorm_room, $first_phone, 
$second_name, $second_id, $second_college, $second_class, $second_phone, 
$third_name, $third_id, $third_college, $third_class, $third_phone) {
    require '../settings.php';

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
    $stmt->bind_param('ssssssssssssssssss', $team_name, $first_name, $first_id, $first_college, $first_class, $first_dorm_building, $first_dorm_room, $first_phone, 
    $second_name, $second_id, $second_college, $second_class, $second_phone, 
    $third_name, $third_id, $third_college, $third_class, $third_phone);
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
    $first_dorm_building=='' || $first_dorm_room=='' || $first_phone=='') {
        $return_arr['status'] = 'failed';
        $return_arr['code'] = 'data_imcomplete';
        $return_arr['msg'] = '请填写所有信息';
        exit( json_encode( $return_arr ) );
    }

    $gotRecordId = getRecordByPhone($first_phone);
    if ( $gotRecordId != -1) {
        // Need update
        insertRecordById($gotRecordId, $team_name, $first_name, $first_id, $first_college, $first_class, $first_dorm_building, $first_dorm_room, $first_phone, 
        $second_name, $second_id, $second_college, $second_class, $second_phone, 
        $third_name, $third_id, $third_college, $third_class, $third_phone);
        $return_arr['status'] = 'success';
        $return_arr['code'] = 'success';
        $return_arr['msg'] = '数据更新成功';
    } else {
        newRecord($team_name, $first_name, $first_id, $first_college, $first_class, $first_dorm_building, $first_dorm_room, $first_phone, 
        $second_name, $second_id, $second_college, $second_class, $second_phone, 
        $third_name, $third_id, $third_college, $third_class, $third_phone);
        $return_arr['status'] = 'success';
        $return_arr['code'] = 'success';
        $return_arr['msg'] = '报名成功';
    }

    echo json_encode($return_arr);

} else {
    $return_arr['status'] = 'success';
    $return_arr['code'] = 'success';
    $return_arr['msg'] = '报名截止了';
    echo json_encode($return_arr);
}



?>
