<?php

// 传入参数方式：POST
// 传入参数类型：formdata
// 传入参数列表：
//   1）session：session=session
//   2）操作类型：mode=delete/edit
//   3）要操作的id：id=id
//   4）其他具体参数
// 暂时只实现删除功能

require __DIR__.'/../../../settings.php';
require __DIR__.'/../libraries.php';


$session = $_POST['session'];

$mode = $_POST['mode'];
$id = $_POST['id'];

$return_arr = array('status'=>'', 'code'=>'');

if (check_user_session($session)['status'] == 'success') {
    // if session valids
    if ($mode == 'delete') {
        $dbconn = new mysqli($db_host, $db_name, $db_pwd, $db_name);
        if ($dbconn->errno) {
            // db connect failed
            $return_arr['status'] = 'failed';
            $return_arr['code'] = 'db_connect_error';
        } else {
            // db connected
            $query = 'DELETE FROM `signup` WHERE id=?';
            $stmt = $dbconn->prepare($query);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            if ($stmt->affected_rows) {
                // affected, success
                $return_arr['status'] = 'success';
                $return_arr['code'] = 'success';
            } else {
                $return_arr['status'] = 'failed';
                $return_arr['code'] = 'write_db_error';
            }
            $stmt->close();
        }
        $dbconn->close();
    }
} else {
    // if session not valids
    $return_arr['status'] = 'failed';
    $return_arr['code'] = 'session_invalid';
}

echo json_encode($return_arr);

?>
