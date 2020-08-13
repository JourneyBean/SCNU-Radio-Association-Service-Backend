<?php
// get form data php program
// Afferent parameters:
// request: what form data is - recruit? fix? member? match?
// session: current session
// php?session=123

// return params:
// {
//     table-rows: 123
//     table-head: {
//         value: [value1, value2...]
//     }
//     table-body: {
//         [
//             {colume1: value1, column2: value2 ...},
//             {column1: value1, column2: value2 ...}
//         ]
//     }
// }
// ini_set('display_errors', 999);

require __DIR__.'/../../../settings.php';
require __DIR__.'/../libraries.php';

$session = $_POST['session'];

$table_head_arr = array();
$table_body_arr = array();
$table_rows = 0;
$debug_msg = array();

$return_arr = array(
    'status' => '', 
    'code' => '',
    'table_rows' => $table_rows, 
    'table_head' => $table_head_arr, 
    'table_body' => $table_body_arr,
    'debug_msg' => $debug_msg
);
$debug_msg['session'] = $session;

$user_session_check_result = check_user_session($session);
$debug_msg['session_check_result'] = $user_session_check_result;

if ($user_session_check_result['status'] == 'success') {
    // session valids
    // then connect to db
    $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
    if ($dbconn->errno) {
        // db connect error
        $return_arr['status'] = 'error';
        $return_arr['code'] = 'db_connect_error';
        $debug_msg['db_connection_status'] = 'db_connect_error';
    } else {
        // db connected
        $debug_msg['db_connection_status'] = 'db_connect_success';
        $table_name = 'fix';

        $query = 'SELECT `COLUMN_NAME` FROM `information_schema`.`COLUMNS` WHERE `TABLE_NAME` = ?';
        $stmt = $dbconn->prepare($query);
        $stmt->bind_param('s', $table_name);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($column_name);
        while ($stmt->fetch()) {
            array_push($table_head_arr, $column_name);
        }
        $stmt->close();
        $debug_msg['table_head_array'] = $table_head_arr;
        
        $query =
            'SELECT 
                id, 
                item, 
                name, 
                phone, 
                grade, 
                college, 
                dorm_building, 
                dorm_room, 
                description, 
                notes
            FROM fix';
        $stmt = $dbconn->prepare($query);
        $stmt->execute();
        $stmt->store_result();
        $table_rows = $stmt->num_rows;
        $stmt->bind_result(
            $id,
            $item,
            $name,
            $phone,
            $grade,
            $college,
            $dorm_building,
            $dorm_room,
            $description,
            $notes
        );
        while ($stmt->fetch()) {
            $table_row = array(
                'id' => $id,
                'item' => $item,
                'name' => $name,
                'phone' => $phone,
                'grade' => $grade,
                'college' => $college,
                'dorm_building' => $dorm_building,
                'dorm_room' => $dorm_room,
                'description' => $description,
                'notes' => $notes
            );
            array_push($table_body_arr, $table_row);
        }
        $stmt->close();
        $debug_msg['table_body_array'] = $table_body_arr;

        $return_arr['status'] = 'success';
        $return_arr['code'] = 'success';
        $return_arr['table_rows'] = $table_rows;
        $return_arr['table_head'] = $table_head_arr;
        $return_arr['table_body'] = $table_body_arr;
    }
} else {
    // session not valid
    $return_arr['status'] = 'failed';
    $return_arr['code'] = $user_session_check_result['code'];
}

// $return_arr['debug_msg'] = $debug_msg;
$return_arr['debug_msg'] = 'not_in_debug_mode';
echo json_encode($return_arr);

?>
