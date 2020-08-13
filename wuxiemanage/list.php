<?php

// 列表，显示序号、唯一ID、姓名、性别、电话、第一志愿、第二志愿、调剂。

$db_host = 'localhost';
$db_name = 'wuxie2';
$db_user = 'wuxie2';
$db_pwd = 'wuxie2019db2';


$webpage_head = 
'
<html>
<head>
    <meta charset="utf-8">
    <title>报名简明列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://scnuradio-association.cn/wuxie2/web/src/wuxie_logo.png">
    <link rel="stylesheet" href="//scnuradio-association.cn/wuxie2/static/bootstrap_4_3_1/css/bootstrap.min.css">
    <script src="//scnuradio-association.cn/wuxie2/static/bootstrap_4_3_1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <br>
    <p><i>内部资料，严禁泄露</i></p>
    <h1>无协招新报名简明列表</h1>
    <hr>
    <p>提供线上报名档案基本信息</p>
    <h2>数据列表</h2>
    <br>
    <table class="table table-bordered table-hover">
        <tr>
            <th>序号</th>
            <th>唯一ID</th>
            <th>姓名</th>
            <th>姓别</th>
            <th>电话</th>
            <th>第一志愿</th>
            <th>第二志愿</th>
            <th>班级</th>
            <th>详情</th>
        </tr>
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
    
    <tr>
        <td>$count</td>
        <td>$id</td>
        <td>$name</td>
        <td>$gender</td>
        <td>$phone</td>
        <td>$first_choice</td>
        <td>$second_choice</td>
        <td>$class</td>
        <td><a href=\"https://scnuradio-association.cn/wuxiemanage/archives.php#$id\" target=\"_blank\">查看档案</a></td>
    </tr>
        ";
    }
    $stmt->close();
}
$dbconn->close();

echo '
    </table>
    <p>(C)2019 华师无协 版权所有</p>
</div>
</body>
</html>
';

?>