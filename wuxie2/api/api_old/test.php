<?php
// $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
// // $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA'])?$GLOBALS['HTTP_RAW_POST_DATA']:0;
// echo '{ "data": "success-debug-info-'.'hhh'.'" }';

$in = file_get_contents("php://input");
$inn = json_decode($in, true);

$str1 = $inn['name'];
$str2 = file_get_contents("php://input");

$return_array = array( 'data'=>'success', 'debug'=>$str2 );

echo json_encode($return_array);

?>
