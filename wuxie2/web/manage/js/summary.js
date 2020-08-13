function signup_delete_handler(that) {
    // $('#delete-confirm').modal('show');
    // $('#modal-confirm').click(function() {
    //     alert('ok');
    //     $('#delete-confirm').modal('hide');
    // });
    var result = confirm("即将删除该条数据，确认？");
    if (result == true) {
        row_uuid = $(that).attr('data-row-id');
        console.log(row_uuid);
        // var send_data = new FormData();
        // send_data.append('session', $.cookie('session'));
        // send_data.append('mode', 'delete');
        // send_data.append('id', row_uuid);
        $.ajax({
            type: "POST",
            url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/editSignupData.php",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {
                'session': $.cookie('manage_session'),
                'mode': 'delete',
                'id': row_uuid
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    table_data_handler('signup', $.cookie('manage_session'), $('#query-text').val());
                }
            }
        });
    } else {
        // do nothing
    }
    
}

function match_delete_handler(that) {
    // $('#delete-confirm').modal('show');
    // $('#modal-confirm').click(function() {
    //     alert('ok');
    //     $('#delete-confirm').modal('hide');
    // });
    var result = confirm("即将删除该条数据，确认？");
    if (result == true) {
        row_uuid = $(that).attr('data-row-id');
        console.log(row_uuid);
        // var send_data = new FormData();
        // send_data.append('session', $.cookie('session'));
        // send_data.append('mode', 'delete');
        // send_data.append('id', row_uuid);
        $.ajax({
            type: "POST",
            url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/editMatchData.php",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {
                'session': $.cookie('manage_session'),
                'mode': 'delete',
                'id': row_uuid
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    table_data_handler('match', $.cookie('manage_session'), $('#query-text').val());
                }
            }
        });
    } else {
        // do nothing
    }
    
}

function member_delete_handler(that) {
    // $('#delete-confirm').modal('show');
    // $('#modal-confirm').click(function() {
    //     alert('ok');
    //     $('#delete-confirm').modal('hide');
    // });
    var result = confirm("即将删除该条数据，确认？");
    if (result == true) {
        row_uuid = $(that).attr('data-row-id');
        console.log(row_uuid);
        // var send_data = new FormData();
        // send_data.append('session', $.cookie('session'));
        // send_data.append('mode', 'delete');
        // send_data.append('id', row_uuid);
        $.ajax({
            type: "POST",
            url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/editMemberData.php",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {
                'session': $.cookie('manage_session'),
                'mode': 'delete',
                'id': row_uuid
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    table_data_handler('member', $.cookie('manage_session'), $('#query-text').val());
                }
            }
        });
    } else {
        // do nothing
    }
    
}

function fix_delete_handler(that) {
    // $('#delete-confirm').modal('show');
    // $('#modal-confirm').click(function() {
    //     alert('ok');
    //     $('#delete-confirm').modal('hide');
    // });
    var result = confirm("即将删除该条数据，确认？");
    if (result == true) {
        row_uuid = $(that).attr('data-row-id');
        console.log(row_uuid);
        // var send_data = new FormData();
        // send_data.append('session', $.cookie('session'));
        // send_data.append('mode', 'delete');
        // send_data.append('id', row_uuid);
        $.ajax({
            type: "POST",
            url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/editFixData.php",
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: {
                'session': $.cookie('manage_session'),
                'mode': 'delete',
                'id': row_uuid
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    table_data_handler('fix', $.cookie('manage_session'), $('#query-text').val());
                }
            }
        });
    } else {
        // do nothing
    }
    
}

function signup_data_handler(session, query_text) {
    var send_data = 'session=' + session;
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: 'json',
        url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/getSignupData.php",
        data: send_data,
        success: function (response) {
            $('#result-table-head').after('<tr class="result-table-content" id="result-table-head-tr"></tr>');
            $('#result-table-head-tr').append('<th>operation</th>');
            for (var attr in response.table_head) {
                var append_text = $("<th></th>").text(response.table_head[attr]);
                $('#result-table-head-tr').append(append_text);
            }
            if (query_text == '') {
                $('#result-table').before('<p class="result-table-content">共'+response.table_rows+'条记录</p>');
                for (var attr in response.table_body) {
                    // add new table row and set uuid
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + response.table_body[attr]['id'] + '"></tr>');
                    // add operation button
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+response.table_body[attr]['id']+'" onclick="signup_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');
                    // $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-confirm" data-row-id="'+response.table_body[attr]['id']+'" onclick="confirm_delete_signup(this)"><span class="icon-trash"></span></button>');
                    // loop, add table data
                    for (var val in response.table_body[attr]) {
                        append_text = $("<td></td>").text(response.table_body[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
            } else {
                // need to search
                query_text = query_text.toUpperCase();  //大小写不敏感
                var search_result = new Array();
                // save result into an object
                for (var attr in response.table_body) {
                    for (var val in response.table_body[attr]) {
                        temp_value = response.table_body[attr][val]+"";
                        temp_value = temp_value.toUpperCase();
                        if (temp_value.indexOf(query_text) >= 0) {
                            // found target string in this value
                            search_result.push(response.table_body[attr]);
                            break;
                        }
                    }
                }
                // display results
                var count = 0;
                for (var attr in search_result) {
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + search_result[attr]['id'] + '"></tr>');
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+search_result[attr]['id']+'" onclick="signup_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');
                    count++;
                    for (var val in search_result[attr]) {
                        append_text = $("<td></td>").text(search_result[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
                $('#result-table').before('<p class="result-table-content">找到'+count+'条记录</p>');
            }

            
        }
    });
}
function match_data_handler(session, query_text) {
    var send_data = 'session=' + session;
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: 'json',
        url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/getMatchData.php",
        data: send_data,
        success: function (response) {
            $('#result-table-head').after('<tr class="result-table-content" id="result-table-head-tr"></tr>');
            $('#result-table-head-tr').append('<th>operation</th>');
            for (var attr in response.table_head) {
                var append_text = $("<th></th>").text(response.table_head[attr]);
                $('#result-table-head-tr').append(append_text);
            }
            if (query_text == '') {
                $('#result-table').before('<p class="result-table-content">共'+response.table_rows+'条记录</p>');
                for (var attr in response.table_body) {
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + response.table_body[attr]['id'] + '"></tr>');
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+response.table_body[attr]['id']+'" onclick="match_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');

                    for (var val in response.table_body[attr]) {
                        append_text = $("<td></td>").text(response.table_body[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
            } else {
                // need to search
                query_text = query_text.toUpperCase();  //大小写不敏感
                var search_result = new Array();
                for (var attr in response.table_body) {
                    for (var val in response.table_body[attr]) {
                        temp_value = response.table_body[attr][val]+"";
                        temp_value = temp_value.toUpperCase();
                        if (temp_value.indexOf(query_text) >= 0) {
                            // found target string in this value
                            search_result.push(response.table_body[attr]);
                            break;
                        }
                    }
                }
                var count = 0;
                for (var attr in search_result) {
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + search_result[attr]['id'] + '"></tr>');
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+search_result[attr]['id']+'" onclick="match_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');

                    count++;
                    for (var val in search_result[attr]) {
                        append_text = $("<td></td>").text(search_result[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
                $('#result-table').before('<p class="result-table-content">找到'+count+'条记录</p>');
            }

            
        }
    });
}
function member_data_handler(session, query_text) {
    var send_data = 'session=' + session;
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: 'json',
        url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/getMemberData.php",
        data: send_data,
        success: function (response) {
            $('#result-table-head').after('<tr class="result-table-content" id="result-table-head-tr"></tr>');
            $('#result-table-head-tr').append('<th>operation</th>');
            for (var attr in response.table_head) {
                var append_text = $("<th></th>").text(response.table_head[attr]);
                $('#result-table-head-tr').append(append_text);
            }
            if (query_text == '') {
                $('#result-table').before('<p class="result-table-content">共'+response.table_rows+'条记录</p>');
                for (var attr in response.table_body) {
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + response.table_body[attr]['id'] + '"></tr>');
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+response.table_body[attr]['id']+'" onclick="member_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');

                    for (var val in response.table_body[attr]) {
                        append_text = $("<td></td>").text(response.table_body[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
            } else {
                // need to search
                query_text = query_text.toUpperCase();  //大小写不敏感
                var search_result = new Array();
                for (var attr in response.table_body) {
                    for (var val in response.table_body[attr]) {
                        temp_value = response.table_body[attr][val]+"";
                        temp_value = temp_value.toUpperCase();
                        if (temp_value.indexOf(query_text) >= 0) {
                            // found target string in this value
                            search_result.push(response.table_body[attr]);
                            break;
                        }
                    }
                }
                var count = 0;
                for (var attr in search_result) {
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + search_result[attr]['id'] + '"></tr>');
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+search_result[attr]['id']+'" onclick="member_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');

                    count++;
                    for (var val in search_result[attr]) {
                        append_text = $("<td></td>").text(search_result[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
                $('#result-table').before('<p class="result-table-content">找到'+count+'条记录</p>');
            }

            
        }
    });
}
function fix_data_handler(session, query_text) {
    var send_data = 'session=' + session;
    $.ajax({
        type: "POST",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        dataType: 'json',
        url: "https://scnuradio-association.cn/wuxie2/web/manage/handler/getFixData.php",
        data: send_data,
        success: function (response) {
            $('#result-table-head').after('<tr class="result-table-content" id="result-table-head-tr"></tr>');
            $('#result-table-head-tr').append('<th>operation</th>');
            for (var attr in response.table_head) {
                var append_text = $("<th></th>").text(response.table_head[attr]);
                $('#result-table-head-tr').append(append_text);
            }
            if (query_text == '') {
                $('#result-table').before('<p class="result-table-content">共'+response.table_rows+'条记录</p>');
                for (var attr in response.table_body) {
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + response.table_body[attr]['id'] + '"></tr>');
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+response.table_body[attr]['id']+'" onclick="fix_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');

                    for (var val in response.table_body[attr]) {
                        append_text = $("<td></td>").text(response.table_body[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
            } else {
                // need to search
                query_text = query_text.toUpperCase();  //大小写不敏感
                var search_result = new Array();
                for (var attr in response.table_body) {
                    for (var val in response.table_body[attr]) {
                        temp_value = response.table_body[attr][val]+"";
                        temp_value = temp_value.toUpperCase();
                        if (temp_value.indexOf(query_text) >= 0) {
                            // found target string in this value
                            search_result.push(response.table_body[attr]);
                            break;
                        }
                    }
                }
                var count = 0;
                for (var attr in search_result) {
                    $('#result-table-body').append('<tr class="result-table-content" id="result-table-body-tr' + attr + 
                        '" data-db-id="' + search_result[attr]['id'] + '"></tr>');
                    $('#result-table-body-tr' + attr).append('<button type="button" class="btn btn-danger btn-sm signup-delete-button" data-class="row-delete-button" data-row-id="'+search_result[attr]['id']+'" onclick="fix_delete_handler(this)" ><span class="icon-trash"></span></button>'+
                        '<button type="button" class="btn btn-info btn-sm"><span class="icon-pencil"></span></button>');

                    count++;
                    for (var val in search_result[attr]) {
                        append_text = $("<td></td>").text(search_result[attr][val]);
                        $('#result-table-body-tr' + attr).append(append_text);
                    }
                }
                $('#result-table').before('<p class="result-table-content">找到'+count+'条记录</p>');
            }

            
        }
    });
}

function table_data_handler(table_name, session, query_text) {
    // $('#result-table-head').empty();
    // $('#result-table-body').empty();
    $('.result-table-content').remove();
    if (table_name == 'signup') {
        signup_data_handler(session, query_text);
    } else if (table_name == 'match') {
        match_data_handler(session, query_text);
    } else if (table_name == 'member') {
        member_data_handler(session, query_text);
    } else if (table_name == 'fix') {
        fix_data_handler(session, query_text);
    } 
}

$(function() {
    table_data_handler($('#table-select').val(), $.cookie('manage_session'), $('#query-text').val());

    $('#table-select').change(function () { 
        // when selections changed then
        // set #query-text null
        $('#query-text').val('');
        table_data_handler($('#table-select').val(), $.cookie('manage_session'), $('#query-text').val());
    });

    // $('#query-text').keyup(function () { 
    $('#query-text').on('input paste', function() {
        table_data_handler($('#table-select').val(), $.cookie('manage_session'), $('#query-text').val());
    });

});