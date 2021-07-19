// Get the element with id="defaultOpen" and click on it
// document.getElementById("defaultOpen").click();

//< ![CDATA[
// var customForm = new VarienForm('person-form-validate');
//]]>

//$(function () {
  
    // updateStyleApp('<?= json_encode($company->getData()) ?>');
    // $("#desktop_preview").on("click", function () {
    //     var bgColor = '#' + $("#cms_bg_color").val();
    //     var fontColor = '#' + $("#cms_font_color").val();
    //     updateStyle(bgColor, fontColor);
    // });
    // $("#reset_preview").on("click", function () {
    //     location.reload();
    // });

    // $("#mobile_preview").on("click", function () {
    //     console.log("priview clicked")
    //     var t = {};
    //     $(".mobile_form input:text").each(function (e) {
    //         t[this.name] = this.value;

    //     });
    //     var jsonStr = JSON.stringify(t); //"{"first_name":"Robert","last_name":"Dougan"}"
    //     updateStyleApp(jsonStr);

    // });
    //Phone Slider

//});





(function  () {
    require(["jquery"],function($) {

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image_upload_preview').attr('src', e.target.result);
            $('.accountSection .section-right img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#logo").change(function () {
    readURL(this);
});

function updateStyle(bgColor, fontColor) {
    $(".page-title h1").css('background-color', bgColor);
    $(".page-title h1").css('color', fontColor);
    $(".button").css('background-color', bgColor);
    $(".button").css('color', fontColor);
    $(".block-content ul li.current a").css('background-color', bgColor);
    $(".block-content ul li.current a").css('color', fontColor);
    $(".block-content ul li.current a").css('border-bottom-color', '#ccc');
    $(".block-content ul li a").hover(function () {
        $(this).css("background-color", bgColor);
        $(this).css("color", fontColor);
    }, function () {
        $(this).css("background-color", '#F2F2F2');
        $(this).css("color", '#636363');
        $(".block-content ul li.current a").css('background-color', bgColor);
        $(".block-content ul li.current a").css('color', fontColor);
    });
}

function updateStyleApp(theme) {
    var obj = $.parseJSON(theme);
    $("#phone-view-1 .topBar").css("background-color", '#' + obj.panel_bg_color);
    $("#phone-view-1 .topBar h1").css("color", '#' + obj.panel_font_color);
    $(".btn-proceed").css("background-color", '#' + obj.large_action_button2_bg_color);
    $(".btn-proceed").css("color", '#' + obj.large_action_button2_font_color);
    $(".btn-draft").css("background-color", '#' + obj.small_buttons_bg_color);
    $(".btn-draft").css("color", '#' + obj.small_buttons_font_color);
    $(".btn-edit").css("background-color", '#' + obj.small_buttons_bg_color);
    $(".btn-edit").css("color", '#' + obj.small_buttons_font_color);
    $(".accountList li span").css("background-color", '#' + obj.heading_font_color);
    $(".accountList li").css("color", '#' + obj.heading_font_color);
    $(".requisitionHead").css("color", '#' + obj.heading_font_color);
    $(".accountSection .section-left h2").css("color", '#' + obj.heading_font_color);
    $(".accountSection .section-left a").css("color", '#' + obj.heading_font_color);
    $(".phone-view #bottomBar").css("background-color", '#' + obj.panel_bg_color);
    $(".push-notification").css("color", '#' + obj.heading_font_color);
    $(".checkbox_img").css("background-color", '#' + obj.panel_bg_color);
    $(".btn-register").css("background-color", '#' + obj.large_action_button1_bg_color);
    $(".btn-register").css("color", '#' + obj.large_action_button1_font_color);
    return false;

}

$(function () {

    // add multiple select / deselect functionality
    $("#selectall").click(function () {
        if (this.checked == true) {
            $('input:text').removeAttr("disabled");
            $('.case').attr('checked', "checked");
            $('.case').prop("checked", true);
        }
        else {
            $('input:text').attr('disabled', "disabled");
            $('.case').removeAttr("checked");
            $('.case').prop("checked", false);
        }
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function () {
        if (this.checked == true) {
            $('#item_qty_' + this.value).removeAttr("disabled");
        }
        else {
            $('#item_qty_' + this.value).attr('disabled', "disabled");
        }
        if ($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }

    });

    $(".del").click(function () {
        str = '';
        if (this.id != '')
            str = ' ' + this.id + ' cabinet';
        if (!confirm("Are you sure you want to delete" + str + '?')) {
            return false;
        }
    });
});

$(document).ready(function () {
    var textVal = '';
    $(".goto").each(function () {
        $(this).change(function () {
            if ($(this).val() != '') {
                textVal = $(this).find("option:selected").text();

                if (textVal == 'Reject') {
                    $("#send-test-email-window").show();
                    $(".cr-overlay").show();
                    $("#order_id").val($(this).val());
                    return false;
                }
                
                if (textVal != 'Delete') {
                    window.location.href = $(this).val();
                } else {
                    str = '.';
                    if ($(this).find("option:selected").attr("id"))
                        str = ' ' + $(this).find("option:selected").attr("id") + ' safety item.';
                    c = confirm("Are you sure you want to delete" + str);
                    if (c === true) {
                        window.location.href = $(this).val();
                    } else {
                        $(this).get(0).selectedIndex = 0;
                    }
                }

            }
        });
    });
});
function isInteger(x) {
    return x % 1 === 0;
}


function setColumns(actionUrl, section, value, checkUncheck) {
    $.ajax({
        url: actionUrl, // link of your "whatever" php
        type: "POST",
        async: true,
        cache: false,
        data: 'section=' + section + '&value=' + value + '&checkuncheck=' + checkUncheck,
        success: function (data) {
            //$.parseJSON(data.status);
            //console.log($.parseJSON(data.message)) // The data that is echoed from the ajax.php
        }
    });
}

function setDefaultLimit(actionUrl, settingId, currentPage) {
    var limitId = parseInt($('#limit_id option:selected').text());
    $.ajax({
        url: actionUrl, // link of your "whatever" php
        type: "POST",
        async: true,
        cache: false,
        data: 'limit=' + limitId + '&id=' + settingId + '&currSection=' + currentPage,
        success: function (data) {
            var obj = $.parseJSON(data);
            alert(obj.message);
        }
    });
}

});
})();