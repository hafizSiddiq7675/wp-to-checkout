// Align preview td's 

jQuery(function($){


$("td.preview.column-preview").css({'display':'contents'}); 


// Copy to clipboard with toastr notifications
$(".copyShortcode").on('click', function(){
    let id = $(this).data('id');
    shortcode = "[wp2chk id="+id+" /]";
    // alert(shortcode);
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "0",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
    // select() only works on html elements
    // so first assign the text to be copied to any element
    // select that text from it and exec copy code. 
    var $temp = $("<textarea id=clipboardCopy> "+shortcode+" </textarea>");
    $("body").append($temp);
    $temp.val($("#clipboardCopy").html()).select();
    document.execCommand("copy");
    $temp.remove();
    
    toastr.info(shortcode + " copied to clipboard");

});

// Jquery Bulk action
jQuery(".bulkactions #doaction.button.action").on('click', function(){
    var checkedRows = jQuery("input[name='id[]']:checked")
                         .map(function(){return jQuery(this).val();})
                         .get();
    console.log(checkedRows);
    var action = jQuery(".bulkactions #bulk-action-selector-top").val();
    if(action == 'delete'){
        let pluginUrl = myScript.pluginsUrl;
        jQuery.ajax({
            url: pluginUrl + '/wp2chk-crud/btn_handler.php',
            type: 'get',
            data: jQuery.param(
                {
                    'ids': checkedRows,
                    'action': action
                }
            ),
            success: function(response){
                response = JSON.parse(response);
                console.log(response);
                window.open(response.redirectUrl, '_self');      
            }
            
        });
    }
});

// reset form on add new
$("#wp2chkAddNew").click(function(){
    $("#wp2checkout-ce-popup").trigger("reset");
    $("#wp2_action").val("Add");
    $("#wp2checkout-ce-submit").html('Make Shortcode');
    $('#wp2checkout_ce_editor_popup').addClass('wp2checkout-ce-popup-display');
    $('body').css('overflow', 'hidden');
});

// Edit functionality assign values to input fields
function assignToPopup(Id, selected_btn, selected_btn_size, button_text, button, button_bg, button_fg, button_icon, access_key,assoc_tag,locale,asin,qty)
{
    // resume from here
    $("#btn_id").val(Id);
    $('#from_available_btns').val(selected_btn);
    $("#selected_button").val(selected_btn);
    $('#wp2_button_text').val(button_text);
    $('#wp2amzaccesskey').val(access_key);
    $("#wp2amzassociatetag").val(assoc_tag);
    $("#wp2locale").val(locale);
    $("#wp2asin").val(asin);
    $("#wp2qty").val(qty);
    $('#wp2_button').val(button);
    $('#wp2_btn_icon').val(button_icon);
    if(button_bg == 'transparent'){
        $('#wp2_transparent').val('transparent');
    }else {
        $('#wp2_bg_color').val(button_bg);
    }
   
    $('#wp2_fg_color').val(button_fg);

    // Make Radio box checked
    if(selected_btn_size == "btn-lg")
    {
        $('#large-btn').prop('checked',true);
    }
    if(selected_btn_size == "btn-sm")
    {
        $('#small-btn').prop('checked',true);
    }
    if(selected_btn_size == "")
    {
        $('#default-btn').prop('checked',true);
    }
    if(selected_btn_size == "btn-lg btn-block")
    {
        $('#block-btn').prop('checked',true);
    }

    $("#selected_btn_size").val(selected_btn_size);

    $("#wp2_action").val("Update");
    
    $("#wp2checkout-ce-submit").html('Update Shortcode');

    $('#wp2checkout_ce_editor_popup').addClass('wp2checkout-ce-popup-display');
    $('body').css('overflow', 'hidden');

}

jQuery(".wp2chkEdit").click(function(){
    // alert(jQuery(this).data('id'));
    let id = jQuery(this).data('id');
    let action = jQuery(this).data('action'); 
    // alert(jQuery(this).data('action'));
    let gotoUrl = myScript.pluginsUrl + '/wp2chk-crud/btn_handler.php';
    
    $.ajax({
        url: gotoUrl,
        type: 'get',
        async:false,
        data: $.param(
            {
                id: id,
                action: action,
            }
        ),
        beforeSend: function(){
            
        },
        success: function(response){
            response =JSON.parse(response);
            console.log(response);
            if(response.success)
            {
                Id = response.ID;
                selected_btn = response.post_content.selected_btn; 
                selected_btn_size = response.post_content.selected_btn_size;;
                button_text = response.post_content.button_text;
                button = response.post_content.button;
                button_bg = response.post_content.button_bg;
                button_fg = response.post_content.button_fg;
                button_icon = response.post_content.button_icon;
                access_key = response.post_content.access_key;
                assoc_tag = response.post_content.assoc_tag;
                locale = response.post_content.locale;
                asin = response.post_content.asin;
                qty = response.post_content.qty;
                
                assignToPopup(Id, selected_btn, selected_btn_size, button_text, button, button_bg, button_fg, button_icon, access_key,assoc_tag,locale,asin,qty);
            }
        },
        complete: function (response) {
            // response =JSON.parse(response);
            // if(response.success)
            // {
            //     globalPostId = response.postId;	
            // }
        },
        error: function(){
            alert("Something is wrong");
        },
    });

});


});