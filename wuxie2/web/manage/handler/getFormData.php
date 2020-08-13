<?php
// get form data php program
// Afferent parameters:
// request: what form data is - recruit? fix? member? match?
// session: current session
// php?session=123&request=fix

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

require __DIR__.'/../../../settings.php';
require __DIR__.'/../libraries.php';

$session = $_POST['session'];
$table = $_POST['table'];

$table_head_arr = array();
$table_body_arr = array();
$table_rows = 0;

$return_arr = array(  'status'=>'', 'code'=>'', 'table_rows'=>$table_rows, 'table_head'=>$table_head_arr, 'table_body'=>$table_body_arr );

if (check_user_session($session)['status'] == 'success') {
    // if session valids
    // then check param table
    if ($table != 'signup' || $table != 'comp' || $table != 'fix' || $table != 'member') {
        // param table invalid
        $return_arr['status'] = 'failed';
        $return_arr['code'] = 'table_param_error';
    } else {
        // param checked
        $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
        if ($dbconn->errno) {
            // db connect error
            $return_arr['status'] = 'error';
            $return_arr['code'] = 'db_connect_error';
        } else {
            // db successfully connected
            // get all data
            $query = 'SELECT `COLUMN_NAME` FROM `information_schema`.`COLUMNS` WHERE `TABLE_NAME` = ?';
            $stmt = $dbconn->prepare($query);
            $stmt->bind_param('s', $table);
            $stmt->execute();
            $stmt->store_result();
            $table_rows = $stmt->num_rows;
            if ($table_rows != 0) {
                // successfully executed
                $stmt->bind_result($column_name);
                while ($stmt->fetch()) {
                    array_push($table_head_arr, $column_name);
                }
                $stmt->close();

                $query = 'SELECT * FROM ?';
                $stmt = $dbconn->prepare($query);
                $stmt->bind_param('s', $table);
                $stmt->execute();
                $stmt->store_result();

            } else {
                // error
                $return_arr['status'] = 'error';
                $return_arr['code'] = 'db_data_lost';
            }
        }
    }
} else {
    $return_arr['status'] = 'failed';
    $return_arr['code'] = 'session_invalid';
}

?>
