var count 				= 0;
var $count_click		= 1;
var $debug              = 1;

//================================================================================
//FIELD CONFIG
var $defind_config_field_type_define    = 'text'; //Đặt giá trị mặc định load field khi tải trang
var $defind_config_field_box_content	= '.autoload-modules-contents';
var $defind_config_form_data_get        = ['.form-data', '.form-detail'];

var $defind_config_field_box_groups    = '.field-group-contents'; //Tải DS các input Group

//================================================================================
//MODAL CONFIG
var $defind_config_modalbox         = '#open-modalbox';
var $defind_config_modal_content    = '.modal_content';
var $defind_config_modal_title		= '.modal-title';
var $defind_config_modal_button		= '.modal-button-action';
var $defind_config_modal_error_box  = '.modal';

var $defind_config_time_alert         = 5000;
var $defind_config_time_scroll        = 600;
var $defind_config_time_reload        = 1000;

//LOAD AUTO FUNCTION
var $autofunc_boxid     = '.show_alert';

//DEFINE VARIABLES
var $define_required    = 'input-required';

//DEFINE CONTENT
var $defind_config_choose   = 'Vui lòng chọn....';


function app_debug() {
    var check_debug = $debug || 0;
    result  = false;
    if(check_debug == 1) {
        result = true;
    }
    return result;
}

//Hàm lấy url
function get_url(params) {
    var result = new Array();
    var urlParams   = new URLSearchParams(window.location.search);
    var loadid      = urlParams.get('loadid') || '';
    result = {
        loadid: loadid
    };
    return result;
}

//================================================================================
//FORM CONFIG
//option, button, divid, title
function main_form(data, modalbox, boxid, buttons_data, button_boxid) {

    var boxid           = boxid || $defind_config_modal_content; //Nếu không khái báo thì modal_content default
    var modalbox        = modalbox;
    var button_boxid    = button_boxid || $defind_config_modal_button;

    var data_title      = data.title;
    var data_class      = data.class;
    var data_feilds     = data.feilds;
    var data_button     = data.buttons;

    html = '';
    $.each(data_feilds, function(i, v) {
        html += show_form(i, v, '', '', data_class);
    });

    if(modalbox != '') {
        showpopup(data_title, modalbox, html, boxid, data_button, button_boxid);
    } else {
        $(boxid).html(html);
    }

    $('.multipleSelect').fastselect();
    
}

//XÓA ALERT BOX
function hideMessage(divid, time) {
    var time        = time || $defind_config_time_alert;
    var divid       = divid || $defind_config_modal_error_box;
    var boxid       = divid+'-alert';
    var boxerror    = divid+'-message';
    if(time > 0) {
        setTimeout(function() {
            $(boxid).html('');
            $(boxerror).html('');
            $(boxerror).removeClass('msg-error');
        }, time);
    } else {
        $(boxid).html('');
        $(boxerror).html('');
        $(boxerror).removeClass('msg-error');
    }
}

//SCROLL TO TOP
function scrollTop(boxid, values) {
    var values = values || 0;
    $(boxid).animate({ scrollTop: values }, $defind_config_time_scroll);
}

/**
 * HÀM KIỂM TRA VÀ SHOW GIÁ TRỊ FORM RA
 * type: Kiểm tra loại xem là 1 group hay là 1 input bình thường
 * rows: Nếu là group, thì xem đang duyệt qua tới dòng thứ mấy
 * Lưu ý: Nếu 2 name trong group là như nhau thì chỉ hiển thị 1 dòng thôi
 * actived: Cái nào sẽ mặc định được checked, áp dụng đối với radio và checkbox
 * input_value: custom value for radio or checkbox, Vì 2 đối tượng này có thể value và label khác nhau: vd: Label = Nam, value = 1
 * total_cols: Số lượng ô của nhóm cần phân
 * data_class: Class tổng truyền vào giống như title, form chạy cố định theo 1 class chính này.
 */
function show_form(i, v, type, datagroup, data_class) {
    var html        = '';
    var type        = type || '';
    var data_class  = data_class || 'form-data';
    var input_name  = '', input_id = '', show_rows = '', input_modules='', input_label='', input_value='', input_actived='';
    var empty_class = '', row_class = '', data_key='', class_get='';
    input_label     = v.label || '';
    input_empty     = v.empty || '';
    input_class     = v.class || '';
    input_type      = v.type  || 'text';
    input_modules   = v.modules;
    input_value     = v.value;
    var input_placeholder   = v.placeholder || $defind_config_choose;
    var input_editor        = v.editor;
    var input_description   = v.description;
    var input_multiple      = v.multiple;
    var input_baseurl       = v.baseurl;
    input_readonly  = v.readonly || ''; // fields readyonly
    input_actived   = v.actived || ''; // fields active, selected
    input_id        = i || ''; // fields id
    input_name      = i || '';

    data_key        = v.key || ''; //Nếu ô này khác rỗng, thì thêm div class=form-get
    if(data_key != '') {
        class_get   = data_class+'-get';
    }


    var input_change = v.change || '';
    
    empty_text      = ''; //Show text
    if(input_empty == true) {
        empty_text  = '<span class="cl-red italic">(*)</span>';
        empty_class = $define_required;
    }

    if(input_label != '') {
        input_title = '<label for="'+input_id+'">'+input_label+' '+empty_text+'</label>';
    } else {
        input_title = '';
    }

    //Xử lý để lấy dữ liệu form
    var form_input = data_class+'-input';
    if(input_modules == 'hidden') {
        var form_input = '';
    }

    var start_div   = '<div class="'+row_class+' form-group '+form_input+' '+class_get+' form-'+input_modules+'" data-type="'+input_modules+'" data-name="'+input_name+'" data-key="'+data_key+'">';
    var end_div     = '</div>';

    html        += start_div;

    switch(input_modules) {
        case 'textarea':
            input_html  =   input_title
                                +'<textarea type="'+input_type+'" class="'+input_class+' '+empty_class+'" name="'+input_name+'" id="'+input_id+'" '+input_readonly+' >'+input_value+'</textarea>';
            break;
        case 'select':
            var options = v.options;
            var input_options = '';
            if(typeof options != 'undefined' && options.length > 0) {
                $.each(options, function(index, value) {
                    var option_name = '';
                    var option_value = '';
                    if(value.value != undefined) {
                        option_name     = value.name;
                        option_value    = value.value;
                    } else {
                        option_name     = value;
                        option_value    = value;
                    }
                    input_options   += '<option value="'+option_value+'">'+option_name+'</option>';
                });
            }
            input_html  =   input_title
                                +'<select type="'+input_type+'" class="'+input_class+' '+empty_class+'" name="'+input_name+'" id="'+input_id+'" '+input_readonly+' onchange="'+input_change+'">'+input_options+'</select>';
            break;
        case 'checkbox':
            input_html  =   input_title
                                +'<input type="'+input_type+'" class="'+input_class+' '+empty_class+'" '+empty_class+' '+input_actived+' name="'+input_name+'" id="'+input_id+'" value="'+input_value+'" '+input_readonly+' onchange="'+input_change+'" />';
            break;
        case 'radio':
            input_html  =   '<div class="'+input_modules+'-box">'
                                +'<input type="'+input_type+'" '+actived+' class="'+input_class+' '+empty_class+'" '+empty_class+' '+empty_class+' name="'+input_name+'" id="'+input_id+'" value="'+input_value+'" onchange="'+input_change+'" '+input_readonly+' />'
                                +input_title
                            +'</div>';
            break;
        case 'group':
            input_html  = '<div class="form-group">'+input_title+load_group(datagroup, input_class, input_modules)+'</div>';
            break;
            break;
        case 'image':
            input_html  = input_title
                    +'<input type="file" class="'+input_class+' '+empty_class+'" '+empty_class+' name="'+input_name+'" id="'+input_id+'" />';
            break;
        case 'multipleselect':
            input_baseurl   = parse_url([app_url, input_baseurl]);
            input_html  = input_title
                    +'<input type="text" class="'+input_class+' '+empty_class+' multipleSelect" '+input_multiple+' name="'+input_name+'" value="" data-initial-value="" data-url="'+input_baseurl+'" placeholder="'+input_placeholder+'" />';
            break;
        default:
            input_html  =   input_title
                                +'<input type="'+input_type+'" class="'+input_class+' '+empty_class+'" '+empty_class+' name="'+input_name+'" id="'+input_id+'" value="'+input_value+'" '+input_readonly+' onchange="'+input_change+'" />';
            break;
    }

    html += input_html+end_div;

    return html;
}

/**
 * HIỂN THỊ CÁC GIÁ TRỊ GROUP
 */
function load_group(data, boxid, type) {

    var button_type;
    var button_icon;
    var type = type || '';

    html = '<div class="group-box radio-group group-box-'+type+'">';

    $.each(data, function(i, v) {

        var show_label='', show_value='', group_value='', addr_value='', cols_class = '';
        var column  = v.column || 1;
        var class_cols  = v.class || '';
        var label   = v.label_custom != undefined ? v.label_custom : '';
        var input_value     = v.value_custom != undefined ? v.value_custom : '';
        var list    = v.items;
        var buttons = v.addbuttons || '';
        var actived = v.actived || '';
        var address = v.value || [];

        for (var j = 0; j < column; j++) {
            //Kiểm tra address
            addr_value='';
            if(address.length > 0) {
                if(typeof address[j] != 'undefined') {
                    addr_value  = Object.keys(address[j]).length !== 0 ? address[j].value : '';
                }
            }
            $.each(list, function(index, value) {
                if(label != '') {
                    show_label  = label[j]; // Lấy và hiển thị label custom (nhãn tùy chỉnh)                    
                }
                show_value  = (input_value[j] !== undefined && input_value[j] !== '') ? input_value[j] : show_label;
                html += show_form(index, value, type, j, show_label, actived, addr_value, show_value, class_cols);
            });
        }

        if(buttons != '') {
            button_type = buttons.type;
            button_icon = buttons.icon || '';
            button_data = buttons.data || {};
            html        += buttons.boxid;
            html        += '<button type="'+button_type+'" data-data="'+button_data+'" class="'+buttons.class+'">'+button_icon+' '+buttons.label+'</div>';
        }

    });


    html += '</div>';

    return html;

}

/**
 * SET VALUE WHEN CHANGE VALUE
 * inputset: fields id show value after get data
 * inputget: array: list field name/ field id
 * type: html for div, span,... or value for input
 * parse_en: use convertViToEnd if true
 */
function changeAndSetValue(inputset, inputget, type, parse_en) {
    var parse_en    = parse_en || true; //cho phép/không convert vi to en
    var type        = type || 'text';
    var values      = '', get_value;
    if(inputget.length > 0) {
        $.each(inputget, function(i, v) {
            get_value = $(v).val();
            values += parse_en == true ? convertViToEn(get_value) : get_value;
        });
    }
    addvalue(inputset, type, values);
}

/**
 * SET FUNCTION
 * Gọi tên biến để làm tên function
 */
function set_functions(func_name, baseurl, boxid) {
    if(func_name != '') {
        var functionName = window[func_name];
        if(typeof functionName !== 'undefined') {
            //Tải function từ button
            var boxid = boxid || $autofunc_boxid;
            window[func_name](id, baseurl, boxid); //Function name
        } else {
            if(app_debug()) {
                alert('Hàm được gọi không tồn tại, vui lòng kiểm tra lại: '+func_name);
            }
        }
    }
}

/**
 * CHECK FORM
 */
function do_action_check(formid) {

    var $error  = [];
    var $result = false;

    //Remove old error
    $(formid).find('.span-error').remove();
    $(formid).find('.'+$define_required).each(function()
    {
        if($.trim($(this).val()) == '') {
            $error.push('error');
            $(this).parent().append('<span class="span-error cl-red italic">Trường này không được bỏ trống</span>');
        }
    });

    if($error.length > 0) {
        $result = true;
    }

    return $result;

}

/**
 * CHECK EQUAL PASSWORD
 */
function do_equal_password(inputid, reinputid) {
    
    var $error  = [];
    var $result = false;

    var values      = $.trim($(inputid).val());
    var revalues    = $.trim($(reinputid).val());

    $(inputid).parent().find('.pw-error').remove();
    if(values != revalues) {
        $error.push('error');
        $(inputid).parent().append('<span class="pw-error cl-red italic">Mật khẩu không đúng</span>');
    } else {
        //RETURN TRUE
    }

    if($error.length > 0) {
        $result = true;
    }

    return $result;

}



/**
 * CHECK EMAIL
 */
function do_email(inputid) {

    var $error  = [];
    var $result = false;

    var email = $.trim($(inputid).val());
    
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var checkEmail =  emailReg.test(email);

    $(inputid).parent().find('.email-error').remove();
    if(!checkEmail) {
        $error.push('error');
        $(inputid).parent().append('<span class="email-error cl-red italic">Email không đúng định dạng</span>');
    }

    if($error.length > 0) {
        $result = true;
    }

    return $result;

}

/**
 * SET FORM DATA
 * feilds is array
 * type: 
 * ** get: là lấy dữ liệu để so sánh: thêm, sửa,... 
 * ** form: lấy dữ liệu form để insert vào database
 * ** detail: Lấy dữ liệu theo kiểu data detial
 * get_class: class của div input để lấy dữ liệu
 * LẤY GIÁ TRỊ TỪ FIELDS TRUYỀN VÀO FORM_DATA
 */
function set_form_data(formid, feilds, type, get_class) {

    var get_class   = get_class || ['.form-data'];
    var type        = type || 'form';
    var $el         = $(formid);

    var $rows_div;

    var form_data   = [];
    var data_get    = []; //Lấy để làm điều kiền
    var data_data   = []; //Lấy dữ liệu để thêm vào database

    if(type == 'form') {

        if(get_class.length > 0) {

            $.each(get_class, function(i, v) {

                var $rows_div_get   = formid +' '+v+'-get'; //form-get, lấy điều kiện
                var $rows_div_data  = formid +' '+v+'-input'; //form-data, lấy dữ liệu

                //DATA GET
                $($rows_div_get).each(function(index, value) {

                    var feild_key   = $(this).attr('data-key')  || ''; //Lấy dữ liệu để so sánh, làm điều kiện khi thêm, sửa
                    var feild_type  = $(this).attr('data-type') || '';
                    var feild_name  = $(this).attr('data-name') || '';
                    var detail_type = $(this).attr('detail-type') || '';
                    var data_rows   = $(this).attr('data-rows') || '';

                    get_data = get_input_data(feild_type, $el, feild_name, '');

                    data_get.push({name:feild_key, value: get_data});

                });

                //DATA
                $($rows_div_data).each(function(index, value) {

                    var feild_key   = $(this).attr('data-key')  || ''; //Lấy dữ liệu để so sánh, làm điều kiện khi thêm, sửa
                    var feild_type  = $(this).attr('data-type') || '';
                    var feild_name  = $(this).attr('data-name') || '';
                    var detail_type = $(this).attr('detail-type') || '';
                    var data_rows   = $(this).attr('data-rows') || '';

                    get_data = get_input_data(feild_type, $el, feild_name, '');

                    data_data.push({name:feild_name, value: get_data});

                });

                form_data.push({get: data_get, data: data_data});

            });

        }

    }
    else if (type == 'multi-level') {
        
        // if(get_class.length > 0) {

        //     $.each(get_class, function(i, v) {

        //         var $rows_div_get   = formid +' '+v+'-parent'; //form-get, lấy điều kiện
        //         var $rows_div_data  = formid +' '+v+'-child'; //form-data, lấy dữ liệu

        //         //DATA GET
        //         $($rows_div_get).each(function(index, value) {

        //             var feild_key   = $(this).attr('data-key')  || ''; //Lấy dữ liệu để so sánh, làm điều kiện khi thêm, sửa
        //             var feild_type  = $(this).attr('data-type') || '';
        //             var feild_name  = $(this).attr('data-name') || '';
        //             var detail_type = $(this).attr('detail-type') || '';
        //             var data_rows   = $(this).attr('data-rows') || '';

        //             get_data = get_input_data(feild_type, $el, feild_name, '');

        //             data_get.push({name:feild_key, value: get_data});

        //         });

        //         //DATA
        //         $($rows_div_data).each(function(index, value) {

        //             var feild_key   = $(this).attr('data-key')  || ''; //Lấy dữ liệu để so sánh, làm điều kiện khi thêm, sửa
        //             var feild_type  = $(this).attr('data-type') || '';
        //             var feild_name  = $(this).attr('data-name') || '';
        //             var detail_type = $(this).attr('detail-type') || '';
        //             var data_rows   = $(this).attr('data-rows') || '';

        //             get_data = get_input_data(feild_type, $el, feild_name, '');

        //             data_data.push({name:feild_name, value: get_data});

        //         });

        //         form_data.push({get: data_get, data: data_data});

        //     });

        // }

    }
    else {

        var $feild_id       = feilds+' .rows-group';
        var detail_get      = [];
        var detail_get_data = [];
        var detail_data     = [];
        

        //Group data
        var groups_get      = [];
        var groups_data     = [];

        $($feild_id).each(function(key, items) {

            var rows_id         = $(this).attr('data-rows');

            if(get_class.length > 0) {

                $.each(get_class, function(k, item) {

                    var $rows_div_get   = '.listid'+rows_id+' '+item+'-get'; //form-get, lấy điều kiện
                    var $rows_div_data  = '.listid'+rows_id+' '+item+'-input'; //form-data, lấy dữ liệu
                    var $rows_div_group = '.listid'+rows_id+' '+'.rows-item'+rows_id+' .form-groups'; //form-groups, lấy dữ liệu
                    var count_rows_get  = $($rows_div_get).length; //Đếm con của từng rows get
                    var count_rows_data = $($rows_div_data).length; //Đếm con của từng rows data (detail)

                    //DATA GET
                    var objDataGet = {};
                    $($rows_div_get).each(function(i_get, v_get) {

                        var feild_key   = $(this).attr('data-key')  || ''; //Lấy dữ liệu để so sánh, làm điều kiện khi thêm, sửa
                        var feild_type  = $(this).attr('data-type') || '';
                        var feild_name  = $(this).attr('data-name') || '';
                        var detail_type = $(this).attr('detail-type') || '';
                        var data_rows   = $(this).attr('data-rows') || '';

                        var input_id    = feild_name+data_rows;

                        get_data        = get_input_data(feild_type, $el, '', input_id);

                        // detail_get.push({[feild_key]: get_data});
                        Object.assign(objDataGet, {[feild_key]: get_data});

                        if(i_get == count_rows_get - 1) {
                            var index = data_rows-1;
                            detail_get_data.push({[index]: objDataGet});
                            objDataGet =   {};
                        }

                    });

                    //GROUP
                    $($rows_div_group).each(function() {

                        var this_rows       = $(this).find('.form-groups-input');
                        var count_this_rows = this_rows.length;

                        $(this_rows).each(function(i_group, v_group) {

                            var feild_type  = $(this).attr('data-type') || '';
                            var feild_name  = $(this).attr('data-name') || '';
                            var detail_type = $(this).attr('detail-type') || '';
                            var data_rows   = $(this).attr('data-rows') || '';

                            var input_id    = feild_name+rows_id+data_rows;

                            get_data        = get_input_data(feild_type, $el, '', input_id);

                            groups_get.push({[feild_name]: get_data});

                            if(i_group == count_this_rows - 1) {
                                var index = data_rows-1;
                                groups_data.push(groups_get);
                                groups_get =   [];
                            }

                        });

                    });

                    //DATA
                    $($rows_div_data).each(function(i_data, v_data) {

                        var feild_key   = $(this).attr('data-key')  || ''; //Lấy dữ liệu để so sánh, làm điều kiện khi thêm, sửa
                        var feild_type  = $(this).attr('data-type') || '';
                        var feild_name  = $(this).attr('data-name') || '';
                        var detail_type = $(this).attr('detail-type') || '';
                        var data_rows   = $(this).attr('data-rows') || '';

                        var input_id    = feild_name+data_rows;

                        get_data        = get_input_data(feild_type, $el, '', input_id);

                        detail_data.push({name:feild_name, value: get_data});

                        if(i_data == count_rows_data - 1) {

                            var index = data_rows-1;

                            form_data.push({get:detail_get_data[index], data: detail_data, groups: groups_data});
                            detail_data = [];
                            groups_data = [];

                        }

                    });

                });

            }

        });

    }

    return form_data;

}

/** 
 * LẤY DỮ LIỆU THEO LOẠI
 * field_name: Input name
 * field_id: Input id
 * rows: Dùng khi chi tiết, có các dòng
 */
function get_input_data(type, formid, field_name, field_id, rows) {

    var field_name  = field_name || '';
    var field_id    = field_id || '';
    var rows        = rows || '';
    var type        = type || 'input';

    var input_get   = field_name != '' ? '[name="'+field_name+'"]' : field_id;

    switch(type) {
        case 'array':                   
            get_data    = pushdata($el, input_get);
            break;
        case 'file':
            get_data    = $(input_get).prop('files')[0];
            break;
        case 'textarea.editor':
            get_data    = getContent(input_get+rows);
            break;
        case 'checkbox':
            if(field_name != '') {
                get_data    = formid.find('[name="'+field_name+'"]:checked').val();
            } else {
                get_data    = formid.find('[id="'+field_id+'"]:checked').val();
            }
            break;
        case 'select':
            if(field_name != '') {
                get_data    = formid.find('[name="'+field_name+'"]').val();
            } else {
                get_data    = formid.find('[id="'+field_id+'"]').val();
            }
            break;
        default:
            if(field_name != '') {
                get_data    = formid.find('[name="'+field_name+'"]').val();
            } else {
                get_data    = formid.find('[id="'+field_id+'"]').val();
            }
            break;
    }
    return get_data;
}


//ADD VALUE
function addvalue(boxid, type, value) {
 	var type = type || "html";
 	if(type == 'input' || type == 'text') {
 		$(boxid).attr('value', value);
 	} else {
 		$(boxid).html(value);
 	}
}

//Chuyển tiếng việt có dấu sang không dấu
function convertViToEn(str, space, strTo) {
	var space = space || ' ';
	var strTo = strTo || ''; // lower or upper
    str = str.toString().replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
    str = str.toString().replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
    str = str.toString().replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
    str = str.toString().replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
    str = str.toString().replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
    str = str.toString().replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
    str = str.toString().replace(/đ/g,"d");
    str = str.toString().replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.toString().replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.toString().replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.toString().replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.toString().replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.toString().replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.toString().replace(/Đ/g, "D");
    str = str.toString().replace(/" "/g, space);
    // // Some system encode vietnamese combining accent as individual utf-8 characters
    // // Một vài bộ encode coi các dấu mũ, dấu chữ như một kí tự riêng biệt nên thêm hai dòng này
    str = str.toString().replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, space); // ̀ ́ ̃ ̉ ̣  huyền, sắc, ngã, hỏi, nặng
    str = str.toString().replace(/\u02C6|\u0306|\u031B/g, space); // ˆ ̆ ̛  Â, Ê, Ă, Ơ, Ư
    // // Remove extra spaces
    // // Bỏ các khoảng trắng liền nhau
    str = str.toString().replace(/\s/g, space);
    str = str.toString().replace(/ + /g, space);
    str = str.toString().trim();
    // // Remove punctuations
    // // Bỏ dấu câu, kí tự đặc biệt
    str = str.toString().replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g, space);
    switch (strTo) {
    	case 'lower':
    		str = str.toLowerCase();
    		break;
		case 'upper':
    		str = str.toUpperCase();
    		break;
		default:
    		str = str;
    		break;
    }
    return str;
}

/**
 * OPEN MODALBOX
 * button: is array button action to add (add, edit, remove,...)
 */
function showpopup(title, option, content, boxid, buttons, buttonboxid) {
	var option	= option || $defind_config_modalbox;
    var title   = title || 'Tiêu đề';
	var boxid	= boxid || $defind_config_modal_content; // show content
    var content = content || '';
	var button 	= button || []; //data button
    var buttonboxid = buttonboxid || ''; //show button content
	var button_type;
    var button_html = '';
	if(typeof buttons != 'undefined' && buttons.length > 0) {
		$.each(buttons, function(i, v) {
			button_type	= v.type || 'button'; //Type button
			button_html += '<button type="'+button_type+'" class="'+v.class+'">'+v.icon+' '+v.text+'</button>';
		});
	}
    hideMessage($defind_config_modal_error_box, $defind_config_time_alert); //Xóa alert (nếu có)
	$(boxid).html(content);
    $(buttonboxid).html(button_html);
	$($defind_config_modal_title).html(title);
	$(option).modal('show');
}

/**
 *  SHOW POPUP ALERT
 */
function showPopupAlert(time, divid) {
    var time = time || $defind_config_time_alert;
    var divid = divid || 'open-modalbox';
    var boxid = '#'+divid;
    $(boxid).modal('show');
    $(boxid+' .modal-header').hide();
    $(boxid+' .modal-footer').hide();
    //Giá trị 0 để không tắt modal
    if(time > 0) {
        setTimeout(function() {
            $(boxid).modal('hide');
        }, time);
    }
}

//Get icon
function getIcon(status) {
    var param = {
        success: '<i class="fa fa-check"></i>',
        warning: '<i class="fa fa-times"></i>',
        empty: ''
    };
    return param[status];
}

/**
 *  HÀM TẢI LẠI TRANG
 */
function reload(type, time, url) {
    var url     = url || '';
    var time    = time || $defind_config_time_reload;
    if(type == 'success' || type == 'reload') {
        setTimeout(function() {
            if(url != "") {
                window.location.href = url;
            } else {
                location.reload();
            }
        }, time);
    } else {
        return false;
    }
}

/**
 * HÀM TRUYỀN VÀO CÁC GIÁ TRỊ ĐỂ TẠO RA 1 URL
 * vd: ['pages', 'add'] => url = pages/add
 */
function parse_url(data) {
    var baseurl = '', count=0;
    if(data.length > 0) {
        count = data.length;
        $.each(data, function(i, v) {
            if(i < count-1) {
                baseurl += v+'/';
            } else {
                baseurl += v;
            }
        });
    }
    return baseurl;
}

/**
 * HÀM TẢI ERROR
 * -- Tải thông báo lỗi nếu có
 */
function loadError(data, boxid) {

    var boxid = boxid || '.msg-error';

    if(typeof data !== 'undefined' && data.length > 0) {
        $(boxid).html('');
        $.each(data, function(i, v) {
            $(boxid).append('<div class="showerror"><li>'+v+'</li></div>');
        });
    }

}

/**
 * HÀM CHO PHÉP ENABLE/DISABLE
 */
function buttonAccess(divid, access) {
    var access = access || false;
    $(divid).prop('disabled', access);
}

// Hàm push data by name or id
function pushdata(formid, name, type) {
    var type = type || '';
    var data = [];
    formid.find('[name="'+name+'"]'+type).each(function()
    {
        data.push($(this).val());
    });
    return data;
}

/**
 *  GET CONTENT CKEDITOR
 */
function getContent(id) {
    var data = CKEDITOR.instances[id].getData();
    return data;
}

/**
 * IMPORT ICHECK
 */
function importIcheck() {
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
    });
}

function checkedIcheck(inputID, type) {
    var type = type || 'check';
    $(inputID).iCheck(type);
}

/**
 * RESET FASTSELECT INPUT
 * inputID: NAME or ID of input
 * boxid: box show input again
 */
function resetFastSelect(inputID, boxid) {
    var selectbox = $(inputID);
    var fstexist = $(".fstElement").length > 0;
    if (fstexist) {
      $('.fstElement').remove();
      $(boxid).append(selectbox);
    }
    $('.multipleSelect').fastselect();
}

/**
 * CALL SORTABLE
 */
function useSortable(getClass) {

    $(document).find(getClass).each(function() {
        var boxid       = $(this).attr('id');
        var status      = $(this).attr('data-pull');
        new Sortable(document.getElementById(boxid), {
            group: {
                name: 'shared',
                pull: convertPullStatus(status) // To clone: set pull to 'clone'
            },
            animation: 150
        });
    });

}

//GET SORTABLE STATUS
function convertPullStatus(string) {
    var result;
    switch(string) {
        case 'true':
            result = true;
            break;
        case 'clone':
            result = 'clone';
            break;
        default:
            result = false;
            break;
    }
    return result;
}

// @koala-prepend "../aGlobal/js/config.js";
$(document).ready(function(){
	/**
	*	Author: Nguyen Minh Truc
	*	Date: 27/03/2018
	*/
	var $el = $('form[name="loginCheck"]');

	$('.btnLogin').on('click', function() {

		login($el, '.login_show_error');

		return false;

	});

});

function login(formid, boxid) {
	var username 	= formid.find('[name="txtUser"]').val();
	var userpass 	= formid.find('[name="txtPass"]').val();
	var url 		= app_url+'/postlogin';
	var form_data = new FormData();
	form_data.append('username',username);
	form_data.append('userpass',userpass);
	if(!do_action_check(formid)) {
		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});
		$.ajax({
			url: url,
			type: 'POST',
			data: form_data,
			contentType: false,
	        cache: false,
	        processData: false,
	        beforeSend:function(){
				$(boxid).html('<div class="info"><i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i> Đang xử lý. Chờ xíu...</div>');
				hideMessage('.login_show_error', 5000);
			},
			success: function(response){
				data = response;
				$(boxid).fadeIn('slow').html('<div class="'+data.status+'">'+getIcon(data.status)+' '+data.alert+'</div>');
				reload(data.status);
			}
		});
	}
}