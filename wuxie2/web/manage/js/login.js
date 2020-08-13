function formToJsonString(formID) {
    var array = $('#' + formID).serializeArray();
    var obj = {};
    $(array).each(function () {
        obj[this.name] = this.value;
    });
    obj['key'] = 'wuxie2019apiManageKey2d4Yu';
    console.log(JSON.stringify(obj));
    return JSON.stringify(obj);
}

function login_info( level, text ) {
    $('#login-result').html('<div class="alert alert-'+level+'" role="alert" style="opacity: 0">'+text+'</div>');
    $("div").animate({opacity:'1'});
}


$(function() {
    if ($.cookie('login_msg') == 'session_timeout') {
        $('#msg').html('<h6 class="card-subtitle mb-2 text-danger">会话过期</h6>');
    } else if ($.cookie('login_msg') == 'not_logged_in') {
        $('#msg').html('<h6 class="card-subtitle mb-2 text-info">该资源需要登录才能访问</h6>');
    }


    $('#login-form-btn').click(function() {
        if (true) {
            $.ajax({
                type: 'POST',
                url: 'https://scnuradio-association.cn/wuxie2/web/manage/handler/login.php',
                data: formToJsonString('login-form'),
                async: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    // alert('sent');
                    // console.log(data);
                    if (data.status == 'success') {
                        $.cookie('manage_session', data.session);
                        window.location.href = 'https://scnuradio-association.cn/wuxie2/web/manage/?page='+$.cookie('page_before_login');
                    } else if (data.status == 'failed') {
                        if (data.code == 'null_username') {
                            login_info('warning','请填写完整');
                        } else if (data.code == 'username_not_found') {
                            login_info('danger','用户名或密码错误');
                        } else if (data.code == 'password_incorrect') {
                            login_info('danger','用户名或密码错误');
                        } else {
                            login_info('warning','出了些意外，请重试');
                        }
                    } else if (data.status == 'error') {
                        if (data.code == 'db_connect_error') {
                            login_info('dark','服务器数据库连接错误');
                        } else if (data.code == 'db_write_error'){
                            login_info('dark','服务器数据库写入错误');
                        } else {
                            login_info('dark','服务器错误，请联系管理员');
                        }
                    }
                },
                error: function() {
                    alert('err');
                }
            });
        }
    });
});