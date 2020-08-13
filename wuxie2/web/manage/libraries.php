<?php

function put_html($page_name) {
    $page_path = __DIR__.'/web-content/'.$page_name.'.html';
    $page_content = file_get_contents($page_path);
    echo $page_content;
}

// read a cookie and directly passes its value
function check_user_session($session) {
    require  __DIR__.'/../../settings.php';
    date_default_timezone_set('Asia/Shanghai');

    $current_time = date('YmdHis');
    $return_arr = array('status'=>'', 'code'=>'');

    // echo 'session = '.$session.'<br>';

    // if session cookie's value is null
    if ($session == '') {
        $return_arr['status'] = 'failed';
        $return_arr['code'] = 'null_session';
    } else {
        // if session value is not null
        // then validate
        // echo 'Entered BP1 <br>';
        $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
        if ($dbconn->errno) {
            $return_arr['status'] = 'error';
            $return_arr['code'] = 'db_connection_failure';
            // !!!!!!!!!! will be edited in future !!!!!!!!
            // !!!!! known issue: clean the outdated session in db
        } else {
            // db succesfully connected
            // echo 'Entered BP2 <br>';
            $query = 'SELECT expr_time FROM user_session WHERE session = ?';
            $stmt = $dbconn->prepare($query);
            $stmt->bind_param('s', $session);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($expr_time);

            // echo '$stmt->num_rows = '.$stmt->num_rows.'<br>';
            if ($stmt->num_rows != 1) {
                // given session not found, maybe it is cleared.
                $return_arr['status'] = 'failed';
                $return_arr['code'] = 'session_not_found';
            } else {
                // found given session, then check expr time
                $stmt->fetch();
                $stmt->free_result();
                $stmt->close();

                if ($current_time > $expr_time) {
                    // session timeout
                    $return_arr['status'] = 'failed';
                    $return_arr['code'] = 'session_timeout';
                } else {
                    // session works
                    // then add 30 min of time to this session
                    // !!!!!!!!!!!!!! will be modified in future !!!!!!!!
                    $new_expr_time = date('YmdHis', strtotime('+30 minutes'));
                    $query = 'UPDATE user_session SET expr_time = ? WHERE session = ?';
                    $stmt = $dbconn->prepare($query);
                    $stmt->bind_param('ss', $new_expr_time, $session);
                    $stmt->execute();
                    $stmt->close();
                    
                    $return_arr['status'] = 'success';
                    $return_arr['code'] = 'success';
                }
            }
        }
        $dbconn->close();
    }

    return $return_arr;
}

// function get_uid($username, $password) {
//     require './../../settings.php';

//     $return_arr = array('status'=>'', 'code'=>'');

//     $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
//     if ($dbconn->errno) {
//         $return_arr['status'] = 'error';
//         $return_arr['code'] = 'db_connection_failure';
//     } else {
//         $query = 'SELECT uid, password FROM users WHERE username = ?';
//         $stmt = $dbconn->prepare($query);
//         $stmt->bind_param('s', $username);
//         $stmt->execute();
//         $stmt->store_result();
//         $stmt->bind_result($uid, $got_password);

//         if ($stmt->num_rows != 1) {
//             // username not found
//             $return_arr['status'] = 'failed';
//             $return_arr['code'] = 'username_not_found';
//         } else {
//             $stmt->fetch();
//             $stmt->free_result();
//             $stmt->close();

//             if ($password == $got_password) {
//                 $return_arr['status'] = 'success';
//                 $return_arr['code'] = $uid;
//             } else {
//                 $return_arr['status'] = 'failed';
//                 $return_arr['code'] = 'wrong_password';
//             }
//         }
//     }
//     $dbconn->close();

//     return $return_arr;
// }

function new_session($username, $password) {
    // ini_set('display_errors', 999);
    require __DIR__.'/../../settings.php';
    date_default_timezone_set('Asia/Shanghai');

    $return_arr = array('status'=>'', 'code'=>'', 'uid'=>'', 'session'=>'');

    if ($username=='' || $password=='') {
        $return_arr['status'] = 'failed';
        $return_arr['code'] = 'null_username';
    } else {
        // if username and password not null
        // then validate

        $dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

        if ($dbconn->errno) {
            $return_arr['status'] = 'error';
            $return_arr['code'] = 'db_connect_error';
        } else {
            $query = 'SELECT uid, password FROM users WHERE username = ?';
            $stmt = $dbconn->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($uid, $correct_password);

            if ($stmt->num_rows != 1) {
                $stmt->close();
                $return_arr['status'] = 'failed';
                $return_arr['code'] = 'username_not_found';
            } else {
                $stmt->fetch();
                $stmt->free_result();
                $stmt->close();

                if ($password == $correct_password) {
                    // password vailds
                    // then generate new session,
                    //      insert into db,
                    //      return session and uid
                    $session = md5(uniqid(microtime(true),true));
                    $expr_time = date('YmdHis', strtotime('+30 minutes'));
                    
                    $query = 'INSERT INTO user_session (uid, session, expr_time) VALUES (?, ?, ?)';
                    $stmt = $dbconn->prepare($query);
                    $stmt->bind_param('iss', $uid, $session, $expr_time);
                    $stmt->execute();
                    if ($stmt->affected_rows == '1') {
                        // success
                        $return_arr['status'] = 'success';
                        $return_arr['code'] = 'success';
                        $return_arr['session'] = $session;
                        $return_arr['uid'] = $uid;
                    } else {
                        // sth went wrong
                        $return_arr['status'] = 'error';
                        $return_arr['code'] = 'db_write_error';
                    }
                    $stmt->close();
                } else {
                    $return_arr['status'] = 'failed';
                    $return_arr['code'] = 'password_incorrect';
                }
            }

        }

        $dbconn->close();
    }

    return $return_arr;
}

?>
