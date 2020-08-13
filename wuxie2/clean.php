<?php
    require './settings.php';
    printf("Starting to clear all tables...<br/>");

    $mysqli = new mysqli($db_host, $db_user, $db_pwd, $db_name);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s \n <br/>", mysqli_connect_error());
        exit();
    }

    $query = "show tables";
    $table_names = array();
    if ($result = $mysqli->query($query)) {
        while ($row = $result->fetch_assoc()) {
            array_push($table_names, $row["Tables_in_wuxie2"]);
        }
    }
    $result->free();

    printf("Deleting tables <br/>");

    for ($i=0; $i<count($table_names); $i++) {
        $query = "DROP TABLE ".$table_names[$i];
        if ($mysqli->query($query) === TRUE) {
            printf("Deleted Table %s <br/>", $table_names[$i]);
        } else {
            printf("Unable to delete %s <br/>",$table_names[$i]);
        }
    }

    $mysqli -> close();

    echo 'Clear up OK, please wait for 3 seconds to go to installation page<br/>';
    echo '<head><meta http-equiv="refresh" content="3;URL=https://scnuradio-association.cn/wuxie2/install.php"/></head>';
?>
