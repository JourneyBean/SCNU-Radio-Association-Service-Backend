<?php
    date_default_timezone_set('Asia/Shanghai');
?>

<html>
    <head>
        <meta charset="UTF-8" />
        <title>无协作业提交</title>
    </head>
    <body>
        <h1>无协干事作业提交系统（Beta）</h1>
        <hr/>
        <p>说明：请提交作业文件的压缩包，压缩包文件名不做要求，系统会自动根据所填信息重命名提交文件。提交作业时，请填写好相关信息。如非必要请勿更改事件标识。</p>
        <b>注意：提交文件不能大于64MB</b>


        <form action="upload.php" method="post"  enctype="multipart/form-data">

        <label for:"datetag">时间标识：</label>
        <input type="text" name="datetag" id="datetag" value="<?php echo date("YmdHis"); ?>" />
        <br/>

        <label for:"departmenttag">部门：</label>
        <input type="text" name="departmenttag" id="departmenttag" value="" />
        <br/>

        <label for:"nametag">姓名：</label>
        <input type="text" name="nametag" id="nametag" value="" />
        <br/>

        <label for:"commenttag">作业名称：</label>
        <input type="text" name="commenttag" id="commenttag" value="" />
        <br/>

        <label for="file">选择文件：</label>
        <input type="file" name="file" id="file" />
        <br />

        <input type="submit" name="submit" value="提交" />

        </form>
    </body>
</html>
