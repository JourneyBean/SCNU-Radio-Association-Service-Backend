<?php

// 列表与表格。显示完整内容

$db_host = 'localhost';
$db_name = 'wuxie2';
$db_user = 'wuxie2';
$db_pwd = 'wuxie2019db2';

$webpage_head = 
'
<html>
<head>
    <meta charset="utf-8">
    <title>档案集合</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://scnuradio-association.cn/wuxie2/web/src/wuxie_logo.png">
    <link rel="stylesheet" href="//scnuradio-association.cn/wuxie2/static/bootstrap_4_3_1/css/bootstrap.min.css">
    <script src="//scnuradio-association.cn/wuxie2/static/bootstrap_4_3_1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<br>
    <p><i>内部资料，严禁泄露</i></p>
    <h1>无协招新报名档案集合</h1>
    <hr>
    <p>提供所有线上报名完整档案</p>
    <h2>模板</h2>

    <hr>
    <h3><center>2019年华南师范大学无线电协会干事招新在线报名档案（模板）</center></h3>
    <p>序号：0 唯一ID：0</p>
    <table class="table table-bordered table-hover">
        <tr>
            <th>姓名</th>
            <td>（姓名）</td>
            <th>性别</th>
            <td>（性别）</td>
            <th>电话</th>
            <td>（电话）</td>
        </tr>
        <tr>
            <th>第一志愿</th>
            <td></td>
            <th>第二志愿</th>
            <td></td>
            <th>服从调剂</th>
            <td></td>
        </tr>
        <tr>
            <th>学院</th>
            <td></td>
            <th>班级</th>
            <td></td>
            <td colspan="2" rowspan="2">(照片)</td>
        </tr>
        <tr>
            <th>宿舍楼</th>
            <td></td>
            <th>宿舍号</th>
            <td colspan="3"></td>
        </tr>
        <tr>
            <th>特长</th>
            <td colspan="5"></td>
        </tr>
        <tr>
            <th>介绍</th>
            <td colspan="5"></td>
        </tr>
        <tr>
            <th>认识</th>
            <td colspan="5"></td>
        </tr>
        <tr>
            <th>备注</th>
            <td colspan="5">&nbsp;</td>
        </tr>
    </table>
    <br>
    <h2 style="page-break-after:always;">数据</h2>
';

echo $webpage_head;

$dbconn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
if ($dbconn->errno) {
    echo "Error: could not connect to database.";
    exit;
} else {
    $query =
           'SELECT 
                id, 
                name, 
                gender, 
                first_choice, 
                second_choice, 
                obey, 
                phone, 
                college, 
                class, 
                dorm_building, 
                dorm_room, 
                hobby, 
                introduction, 
                other
            FROM signup';
    $stmt = $dbconn->prepare($query);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result(
        $id, 
        $name, 
        $gender, 
        $first_choice, 
        $second_choice, 
        $obey, 
        $phone, 
        $college, 
        $class, 
        $dorm_building, 
        $dorm_room, 
        $hobby, 
        $introduction, 
        $other
    );

    $count = 0;
    while ($stmt->fetch()) {
        $count++;
        echo "
    <hr>
    <h3 id=\"$id\"><center>2019年华南师范大学无线电协会干事招新在线报名档案</center></h3>
    <p>序号：$count 唯一ID：$id</p>
    <table class=\"table table-bordered table-hover\">
        <tr>
            <th>姓名</th>
            <td>$name</td>
            <th>性别</th>
            <td>$gender</td>
            <th>电话</th>
            <td>$phone</td>
        </tr>
        <tr>
            <th>第一志愿</th>
            <td>$first_choice</td>
            <th>第二志愿</th>
            <td>$second_choice</td>
            <th>服从调剂</th>
            <td>$obey</td>
        </tr>
        <tr>
            <th>学院</th>
            <td>$college</td>
            <th>班级</th>
            <td colspan=\"3\">$class</td>
            <!--<td colspan=\"2\" rowspan=\"2\">
                <img src=\"files/".$id."_resize.jpg\" width=\"256\">
            </td>-->
        </tr>
        <tr>
            <th>宿舍楼</th>
            <td>$dorm_building</td>
            <th>宿舍号</th>
            <td colspan=\"3\">$dorm_room</td>
        </tr>
        <tr>
            <th>特长</th>
            <td colspan=\"5\">$hobby</td>
        </tr>
        <tr>
            <th>自我介绍</th>
            <td colspan=\"5\">$introduction</td>
        </tr>
        <tr>
            <th>认识展望建议</th>
            <td colspan=\"5\">$other</td>
        </tr>
        <tr>
            <th>备注</th>
            <td colspan=\"5\">&nbsp;<br><br></td>
        </tr>
    </table>
    <p  style=\"page-break-after:always;\">
        <a href=\"https://scnuradio-association.cn/wuxiemanage/files/$id.pdf\">下载pdf</a>&nbsp;&nbsp;
        <a href=\"https://scnuradio-association.cn/wuxiemanage/files/$id.docx\">下载docx</a>&nbsp;&nbsp;
        <a href=\"https://scnuradio-association.cn/wuxiemanage/photo.php?id=$id\" target=\"_blank\">查看照片</a>
    </p>
        ";
    }
    $stmt->close();
}
$dbconn->close();

echo '
    <hr>
    <p>End of page.</p>
    <p>(C)2019 华师无协 版权所有</p>
</div>
</body>
</html>
';

?>