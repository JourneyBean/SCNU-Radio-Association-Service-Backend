<?php
require __DIR__.'/../../../settings.php';

$dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);

if ($dbconn->errno) {
    echo 'failed to connect to database<br>';
    exit( $dbconn->error );
}

$query = 'SELECT * FROM ?';
if ($stmt = $dbconn->prepare($query)) {
    $table = 'comp';
    $stmt->bind_param('s', $table);
    $stmt->execute();

    $meta = $stmt->result_metadata();
    while ($field = $meta->fetch_field()) {
        $params[] = &$row[$field->name];
    }
    call_user_func_array(array($stmt, 'bind_result'), $params);
    while ($stmt->fetch()) { 
        foreach($row as $key => $val) 
        { 
            $c[$key] = $val; 
        } 
        $result[] = $c; 
    } 
    
    $stmt->close(); 
}
$dbconn->close();

print_r($result);

?>
