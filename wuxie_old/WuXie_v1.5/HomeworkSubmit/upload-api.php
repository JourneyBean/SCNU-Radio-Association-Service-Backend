<?php
	date_default_timezone_set('Asia/Shanghai');

  	$projectRootDir = $_SERVER['DOCUMENT_ROOT'];

  	$dateTag = date("YmdHis");
  	$departmentTag = $_POST["departmenttag"];
  	$nameTag = $_POST["nametag"];
  	$commentTag = $_POST["commenttag"];
	  $targetFileDir = $projectRootDir . '/WuXie_2/HomeworkSubmit/files';
	  
	$status = '';
	$err = '';
	$filetype = '';
	$filename1 = '';
	$filename2 = '';
	$filesize = '';

  	if (!file_exists($targetFileDir)) 
    	mkdir ($targetFileDir,0755,true);


	if($_FILES["file"]["size"] < 64000000)
	{
		if ($_FILES["file"]["error"] > 0)
 		{
			$status = 'fail';
			$err =  "错误代码 " . $_FILES["file"]["error"] ;
			echo '<meta http-equiv="refresh" content="0;URL=https://scnuradio-association.cn/WuXie_2/HomeworkSubmit/error.html" />';

  		}
  		else
 		{
			$status = 'success';
			$err = '0';
			$filetype = $_FILES["file"]["type"];
			$filename1 = $_FILES["file"]["name"];
			$filesize = $_FILES["file"]["size"];
   	 		//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

	  		$string = strrev($_FILES['file']['name']);
      		$array = explode('.',$string);
      		$ext = strrev($array[0]);
      		$modifiedFilename = $departmentTag . '-' . $nameTag . '-' . $commentTag . '-' . $dateTag . '.' . $ext;

      		move_uploaded_file($_FILES["file"]["tmp_name"], "$targetFileDir/" . $modifiedFilename);
		  
			//echo "Stored in: " . "$targetFileDir/" . $modifiedFilename;

			$filename2 = $modifiedFilename;

			//Delete This Line if de
			echo '<meta http-equiv="refresh" content="0;URL=https://scnuradio-association.cn/WuXie_2/HomeworkSubmit/success.html" />';
  		}

	}
	else
	{
		$status = 'fail';
		$err = '文件过大';
		echo '<meta http-equiv="refresh" content="0;URL=https://scnuradio-association.cn/WuXie_2/HomeworkSubmit/toobig.html" />';
	}

	echo '{ "status": "' . $status . '", "code": "' . $err . '", "filetype": "' . $filetype . '", "filename1": "' . 
		$filename1 . '", "filesize": "' . $filesize . '", "filename2": "' . $filename2 .'" }';
?>
