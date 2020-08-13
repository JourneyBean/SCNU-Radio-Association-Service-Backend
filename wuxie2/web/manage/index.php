<?php
require './../../settings.php';
require './libraries.php';

$page_name = $_GET['page'];
$session = $_COOKIE['manage_session'];

if ($page_name == 'login' || $page_name == 'error') {
    put_html($page_name);
    exit();
}

if ($page_name == '') {
    echo '<meta http-equiv="refresh" content="0;URL=https://scnuradio-association.cn/wuxie2/web/manage/?page=index">';
}

$return = check_user_session($session);

if ($return['status'] == 'success') {
    put_html($page_name);
} else {
    if ($return['code'] == 'session_timeout') {
        setcookie('login_msg', 'session_timeout');
    } else {
        setcookie('login_msg', 'not_logged_in');
    }
    setcookie('page_before_login', $page_name);
    put_html('login');
}


?>
