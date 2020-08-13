<?php

$id = $_GET['id'];
$nextid = $id+1;
$previd = $id-1;

echo '
<html>
<head>
    <meta charset="utf-8">
    <title>照片查看</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <link rel="icon" href="https://scnuradio-association.cn/wuxie2/web/src/wuxie_logo.png">
    <link rel="stylesheet" href="//scnuradio-association.cn/wuxie2/static/bootstrap_4_3_1/css/bootstrap.min.css">
    <script src="//scnuradio-association.cn/wuxie2/static/bootstrap_4_3_1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <br>
    <p><i>内部资料，严禁泄露</i></p>
    <h1>照片查看</h1>
';

echo "
    <p>唯一ID：$id</p>
    <p>
        <form class=\"form-inline\" role=\"form\" action=\"upload.php?id=$id\" method=\"POST\" enctype=\"multipart/form-data\">
        <div class=\"form-group\">
        <label for=\"file\">上传照片：</label>
        <input type=\"file\" id=\"file\" name=\"file\">
        </div>
        <button type=\"submit\" class=\"btn btn-primary\">提交</button>
    </form>
        <a href=\"https://scnuradio-association.cn/wuxiemanage/photo.php?id=$previd\">上一个($previd)</a> &nbsp;&nbsp;&nbsp;&nbsp;
        <a href=\"https://scnuradio-association.cn/wuxiemanage/photo.php?id=$nextid\">下一个($nextid)</a>
    </p>
    <p>（点击图片可查看原图）</p>
    <p>
";

if (file_exists("./files/$id.jpg")) {
    echo "
        <a href=\"https://scnuradio-association.cn/wuxiemanage/files/$id.jpg\">
            <img src=\"https://scnuradio-association.cn/wuxiemanage/files/".$id."_resize.jpg\" height=\"512\">
        </a>
    ";
} else {
    echo "照片未上传或该唯一ID不存在";
}

echo "
    </p>
    </body>
    </html>
";

?>
