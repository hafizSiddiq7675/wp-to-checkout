let globalPostId='';

jQuery(function ($) {
    
$('#wp2checkout-ce-submit').on('click', function (e, para=0) {
    e.preventDefault();

    var attributes = '';
    var selected_btn = $('#from_available_btns').val();
    if (!selected_btn.isEmpty()) {
        attributes += ' selected_btn="' + selected_btn + '"';
    }else{
        attributes += ' selected_btn=""';
    }

    var selected_btn_size = $('#selected_btn_size').val();
    if (!selected_btn_size.isEmpty()) {
        attributes += ' selected_btn_size="' + selected_btn_size + '"';
    }else{
        attributes += ' selected_btn_size=""';
    }

    var button_text = $('#wp2_button_text').val();
    if (!button_text.isEmpty()) {
        attributes += ' button_text="' + button_text + '"';
    }else{
        attributes += ' button_text="Add to cart"';
    }


    let accessKey = $("#wp2amzaccesskey").val();
    if (!accessKey.isEmpty()) {
        attributes += ' accessKey="' + accessKey + '"';
    }else{
        attributes += ' accessKey=""';
    }
    
    let assocTag = $("#wp2amzassociatetag").val();
    if (!assocTag.isEmpty()) {
        attributes += ' assocTag="' + assocTag + '"';
    }else{
        attributes += ' assocTag=""';
    }
    
    let locale = $("#wp2locale").val();
    if(locale)
    {
        if (!locale.isEmpty()) {
            attributes += ' locale="' + locale + '"';
        }else{
            attributes += ' locale=""';
        }
    }

    let asin = $("#wp2asin").val();
    if (!asin.isEmpty()) {
        attributes += ' asin="' + asin + '"';
    }else{
        attributes += ' asin=""';
    }

    let qty = $("#wp2qty").val();
    if (!qty.isEmpty()) {
        attributes += ' qty="' + qty + '"';
    }else{
        attributes += ' qty=""';
    }    

    var button = $('#wp2_button').val();
    if (!button.isEmpty()) {
        attributes += ' button="' + button + '"';
    }else{
        attributes += ' button=""';
    }

    var button_icon = $('#wp2_btn_icon').val();
    if (!button_icon.isEmpty()) {
        attributes += ' button_icon="' + button_icon + '"';
    }else{
        attributes += ' button_icon=""';
    }

    var button_bg = $('#wp2_bg_color').val();
    var transparent = $('#wp2_transparent').val();
    if(! transparent.isEmpty()){
        button_bg = "transparent";
    }
    if (!button_bg.isEmpty()) {
        attributes += ' button_bg="' + button_bg + '"';
    }else{
        attributes += ' button_bg=""';
    }

    var button_fg = $('#wp2_fg_color').val();
    if (!button_fg.isEmpty()) {
        attributes += ' button_fg="' + button_fg + '"';
    }else{
        attributes += ' button_fg=""';
    }

    var action = $("#wp2_action").val();
    var id = $("#btn_id").val();
    if(id.isEmpty()){
        id = 0;
    }

    saveAttributesAjaxCall(selected_btn,selected_btn_size,button_text,button,accessKey,assocTag,locale,asin,qty,button_icon,button_bg,button_fg,action,id);
    
    console.log(globalPostId);
    
    $('.wp2checkout-ce-close').trigger('click');
    $('#wp2checkout_ce_editor_popup').removeClass('wp2checkout-ce-popup-display');
    $('body').css('overflow', '');
});

$('#footer-close, .wp2checkout-ce-close').on('click', function (e) {
    e.preventDefault();
    $('#wp2checkout_ce_editor_popup').removeClass('wp2checkout-ce-popup-display');
    $('body').css('overflow', '');
});


String.prototype.isEmpty = function () {
    return this.length === 0 || !this.trim();
};	
});

function saveAttributesAjaxCall(selected_btn,selected_btn_size,button_text,button,accessKey,assocTag,locale,asin,qty
                            ,button_icon,button_bg,button_fg,action,id)
{
var pluginUrl = myScript.pluginsUrl;
    $.ajax({
            url: pluginUrl + '/wp2chk-crud/btn_handler.php',
            type: 'post',
            async:false,
            data: $.param(
                {
                    id:id,
                    selected_btn: selected_btn,
                    selected_btn_size: selected_btn_size,
                    button_text: button_text,
                    button: button,
                    access_key: accessKey,
                    assoc_tag: assocTag,
                    locale:locale,
                    asin:asin,
                    qty:qty,
                    button_icon: button_icon,
                    button_bg: button_bg,
                    button_fg: button_fg,
                    action: action
                }
            ),
            beforeSend: function(){
                $("#wp2checkout-ce-popup").trigger('reset');
                $('.wp2checkout-ce-footer #footer-close').trigger('click');
            },
            success: function(response){
                response =JSON.parse(response);
                if(response.success)
                {
                    globalPostId = response.postId;
                    window.open(myScript.adminsUrl + "?page=wp-to-checkout", "_self" );
                }
            },
            
            error: function(){
                alert("Something is wrong");
            },
        });
}
