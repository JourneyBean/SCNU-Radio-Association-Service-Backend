function formToJsonString(formID) {
    var array = $('#' + formID).serializeArray();
    var obj = {};
    $(array).each(function() {
        obj[this.name] = this.value;
    });
    obj['key'] = 'wuxie2019apiAuthKeyZv5d7';
    console.log(obj);
    return JSON.stringify(obj);
}


$(function() {
    $('#signup-form-btn').click(function() {
        if (true) {
            $.ajax({
                type: 'POST',
                url: '../api/signup.php',
                data: formToJsonString('signup-form'),
                async: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    alert(data.msg);
                    console.log('get_data:'+ JSON.stringify(data));
                },
                error: function() {
                    alert('failed');
                }
            });
        }
    });

    $('#match-form-btn').click(function() {
        if (true) {
            $.ajax({
                type: 'POST',
                url: '../api/match.php',
                data: formToJsonString('match-form'),
                async: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    alert(data.msg);
                    console.log('get_data:'+ JSON.stringify(data));
                },
                error: function() {
                    alert('failed');
                }
            });
        }
    });

    $('#member-form-btn').click(function() {
        if (true) {
            $.ajax({
                type: 'POST',
                url: '../api/member.php',
                data: formToJsonString('member-form'),
                async: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    alert(data.msg);
                    console.log('get_data:'+ JSON.stringify(data));
                },
                error: function() {
                    alert('failed');
                }
            });
        }
    });

    $('#fix-form-btn').click(function() {
        if (true) {
            $.ajax({
                type: 'POST',
                url: '../api/fix.php',
                data: formToJsonString('fix-form'),
                async: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    alert(data.msg);
                    console.log('get_data:'+ JSON.stringify(data));
                },
                error: function() {
                    alert('failed');
                }
            });
        }
    });

});
