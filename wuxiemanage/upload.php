<?php

function reSizeImg($imgSrc, $resize_width, $resize_height, $isCut = false) {
    //图片的类型
    $type = substr(strrchr($imgSrc, "."), 1);
    //初始化图象
    if ($type == "jpg") {
        $im = imagecreatefromjpeg($imgSrc);
    }
    if ($type == "gif") {
        $im = imagecreatefromgif($imgSrc);
    }
    if ($type == "png") {
        $im = imagecreatefrompng($imgSrc);
    }
    //目标图象地址
    $full_length = strlen($imgSrc);
    $type_length = strlen($type);
    $name_length = $full_length - $type_length;
    $name = substr($imgSrc, 0, $name_length - 1);
    $dstimg = $name . "_resize." . $type;

    $width = imagesx($im);
    $height = imagesy($im);

    //生成图象
    //改变后的图象的比例
    $resize_ratio = ($resize_width) / ($resize_height);
    //实际图象的比例
    $ratio = ($width) / ($height);
    if (($isCut) == 1) { //裁图
        if ($ratio >= $resize_ratio) { //高度优先
            $newimg = imagecreatetruecolor($resize_width, $resize_height);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, (($height) * $resize_ratio), $height);
            ImageJpeg($newimg, $dstimg);
        }
        if ($ratio < $resize_ratio) { //宽度优先
            $newimg = imagecreatetruecolor($resize_width, $resize_height);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, $width, (($width) / $resize_ratio));
            ImageJpeg($newimg, $dstimg);
        }
    } else { //不裁图
        if ($ratio >= $resize_ratio) {
            $newimg = imagecreatetruecolor($resize_width, ($resize_width) / $ratio);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, $resize_width, ($resize_width) / $ratio, $width, $height);
            ImageJpeg($newimg, $dstimg);
        }
        if ($ratio < $resize_ratio) {
            $newimg = imagecreatetruecolor(($resize_height) * $ratio, $resize_height);
            imagecopyresampled($newimg, $im, 0, 0, 0, 0, ($resize_height) * $ratio, $resize_height, $width, $height);
            ImageJpeg($newimg, $dstimg);
        }
    }
    ImageDestroy($im);
}

$id = $_GET['id'];
if ($_FILES["file"]["error"] > 0) {
    echo "Error Code: " . $_FILES["file"]["error"] . "<br />";
}
else {
    $filename = basename($_FILES["file"]["name"]);
    $actualname = $filename;
    $extpos = strrpos($_FILES["file"]["name"],'.');
    $ext = substr($filename,$extpos+1);
    $modifiedFilename = $id . '.' . $ext;

    move_uploaded_file($_FILES["file"]["tmp_name"], __DIR__. '/files/' . $modifiedFilename);

    echo "上传成功";

    reSizeImg( "./files/$id.jpg", 512, 512 );

    echo '
    <script>
    alert("上传成功，请返回并刷新页面");
    history.go(-1); 
    </script>
    ';
}
?>
