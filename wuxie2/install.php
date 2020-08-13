<?php

require './settings.php';

echo '[INFO] Starting to connect to database.'.'<br>';
$dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($dbconn->connect_errno) {
    echo '[ERR] Failed to connect to database.'.'<br>';
    echo $dbconn->connect_error;
    exit();
}
echo '[OK] Connected to database.'.'<br>';

$query = "CREATE TABLE signup (
    id              INT             NOT NULL    AUTO_INCREMENT,
    name            VARCHAR(100)    NOT NULL,
    gender          VARCHAR(100)    NOT NULL,
    first_choice    VARCHAR(100)    NOT NULL,
    second_choice   VARCHAR(100)    NOT NULL,
    obey            VARCHAR(100)    NOT NULL,
    phone           VARCHAR(100)    NOT NULL,
    college         VARCHAR(100)    NOT NULL,
    class           VARCHAR(100)    NOT NULL,
    dorm_building   VARCHAR(100)    NOT NULL,
    dorm_room       VARCHAR(100)    NOT NULL,
    hobby           VARCHAR(1000)   NOT NULL,
    introduction    VARCHAR(1000)   NOT NULL,
    other           VARCHAR(1000)   NOT NULL,
    PRIMARY KEY (id)
  );";
if ($dbconn->query($query)===TRUE) {
    echo '[OK] Successfully created table signup'.'<br>';
} else {
    echo '[ERR] Failed to create table signup'.'<br>';
    echo $dbconn->error.'<br>';
}

$query = "CREATE TABLE comp (
    id              INT             NOT NULL    AUTO_INCREMENT,
    team_name       VARCHAR(100)    NOT NULL,
    first_name      VARCHAR(100)    NOT NULL,
    first_id        VARCHAR(100)    NOT NULL,
    first_college   VARCHAR(100)    NOT NULL,
    first_class     VARCHAR(100)    NOT NULL,
    first_dorm_building VARCHAR(100) NOT NULL,
    first_dorm_room VARCHAR(100)    NOT NULL,
    first_phone     VARCHAR(100)    NOT NULL,
    second_name     VARCHAR(100),
    second_id       VARCHAR(100),
    second_college  VARCHAR(100),
    second_class    VARCHAR(100),
    second_phone    VARCHAR(100),
    third_name      VARCHAR(100),
    third_id        VARCHAR(100),
    third_college   VARCHAR(100),
    third_class     VARCHAR(100),
    third_phone     VARCHAR(100),
    PRIMARY KEY (id)
  );";
if ($dbconn->query($query)===TRUE) {
    echo '[OK] Successfully created table comp'.'<br>';
} else {
    echo '[ERR] Failed to create table comp'.'<br>';
    echo $dbconn->error.'<br>';
}

$query = "CREATE TABLE member (
    id              INT            NOT NULL    AUTO_INCREMENT,
    name            VARCHAR(100)    NOT NULL,
    gender          VARCHAR(100)    NOT NULL,
    phone           VARCHAR(100)    NOT NULL,
    college         VARCHAR(100)    NOT NULL,
    class           VARCHAR(100)    NOT NULL,
    dorm_building   VARCHAR(100)    NOT NULL,
    dorm_room       VARCHAR(100)    NOT NULL,
    PRIMARY KEY (id)
  );";
if ($dbconn->query($query)===TRUE) {
    echo '[OK] Successfully created table member'.'<br>';
} else {
    echo '[ERR] Failed to create table member'.'<br>';
    echo $dbconn->error.'<br>';
}

$query = "CREATE TABLE fix (
    id              INT            NOT NULL    AUTO_INCREMENT,
    item            VARCHAR(100)    NOT NULL,
    name            VARCHAR(100)    NOT NULL,
    phone           VARCHAR(100)    NOT NULL,
    grade           VARCHAR(100)    NOT NULL,
    college         VARCHAR(100)    NOT NULL,
    dorm_building   VARCHAR(100)    NOT NULL,
    dorm_room       VARCHAR(100)    NOT NULL,
    description     VARCHAR(1000)   NOT NULL,
    notes           VARCHAR(1000),
    PRIMARY KEY (id)
  );";
if ($dbconn->query($query)===TRUE) {
    echo '[OK] Successfully created table fix'.'<br>';
} else {
    echo '[ERR] Failed to create table fix'.'<br>';
    echo $dbconn->error.'<br>';
}

$query = "CREATE TABLE users (
    `uid`               INT             NOT NULL    AUTO_INCREMENT,
    `username`          VARCHAR(100)    NOT NULL,
    `password`          VARCHAR(100)    NOT NULL,
    `scope`             VARCHAR(1000),
    PRIMARY KEY (uid)
  );";
if ($dbconn->query($query)===TRUE) {
    echo '[OK] Successfully created table users'.'<br>';
} else {
    echo '[ERR] Failed to create table users'.'<br>';
    echo $dbconn->error.'<br>';
}

$query = 'INSERT INTO users (uid, username, password, scope) VALUES (?, ?, ?, ?)';
$stmt = $dbconn->prepare($query);
$s1 = '1';
$s2 = $admin_username;
$s3 = $admin_password;
$s4 = 'admin';
$stmt->bind_param('isss', $s1, $s2, $s3, $s4);
$stmt->execute();
if ($stmt->affected_rows == '1') {
    echo '[OK] Successfully added superuser named '.$admin_username.' password '.$admin_password.'<br>';
} else {
    echo '[ERR] Failed to add superuser admin into table users';
}
$stmt->close();

$query = "CREATE TABLE user_session (
    `uid`               INT             NOT NULL,
    `session`           VARCHAR(100)    NOT NULL,
    `expr_time`         VARCHAR(100)    NOT NULL
  );";
if ($dbconn->query($query)===TRUE) {
    echo '[OK] Successfully created table user_session'.'<br>';
} else {
    echo '[ERR] Failed to create table user_session'.'<br>';
    echo $dbconn->error.'<br>';
}


$dbconn->close();

?>
