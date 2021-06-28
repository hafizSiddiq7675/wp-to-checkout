	var wp2checkoutModule = {};
	(function() {
	tinymce.create('tinymce.plugins.wp2checkout_ce_popup_plugin', {
		//url argument holds the absolute url of our plugin directory		
		init: function (ed, url) {
			//add new button
			ed.addButton('wp2checkout_ce_popup_button', {
				title: 'Wp2Checkout',
				cmd: 'wp2checkout_ce_popup_shortcode_command',
                text:'WP2CHK',
				// image: url + '/../img/Favicon.png',
                // onclick: function (e) {
                //     editor.windowManager.open( {
                //         title: 'THE_TITLE_OF_THE_POPUP_WINDOW',
                //         body: [{
                //             type: 'textbox',
                //             name: 'title',
                //             placeholder: 'PLACE_HOLDER_TEXT',
                //             multiline: true,
                //             minWidth: 700,
                //             minHeight: 50,
                //         }]  
                //     });
                // }
    
			});

			//button functionality.
			ed.addCommand('wp2checkout_ce_popup_shortcode_command', function (ui, v) {
				
				var content = tinyMCE.activeEditor.selection.getContent();
				
				var attrs = wp.shortcode.attrs(content).named;
				
				wp2checkoutModule.wp2checkout_show_popup(attrs,content);

			});
		},

		getInfo: function () {
			return {
				longname: 'WP2CHECKOUT',
				author: 'Bitsoft Solutions',
				// version: '1'
			};
		}
	});

	tinymce.PluginManager.add('wp2checkout_ce_popup_button', tinymce.plugins.wp2checkout_ce_popup_plugin);
})();


let globalPostId='';

jQuery(function ($) {
	
	wp2checkoutModule.wp2checkout_show_popup  = function (attrs,content){
		
		//console.log($('#wp2checkout_ce_editor_popup').length);
		$('#wp2checkout_ce_editor_popup').addClass('wp2checkout-ce-popup-display');
		$('body').css('overflow', 'hidden');
	}
	//wp2checkoutModule.wp2checkout_show_popup = wp2checkout_show_popup;

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
    if (!locale.isEmpty()) {
        attributes += ' locale="' + locale + '"';
    }else{
        attributes += ' locale=""';
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
		var action="Add";
		saveAttributesAjaxCall(selected_btn,selected_btn_size,button_text,button,accessKey,assocTag,locale,asin,qty
												,button_icon,button_bg,button_fg,action);
		console.log(globalPostId);
		tinymce.execCommand('mceInsertContent', false, '<span class="wp2checkout">[wp2chk id=' + globalPostId + ' /] </span>');

		$("#wp2checkout-ce-popup").trigger("reset");
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
								,button_icon,button_bg,button_fg,action)
{
	var pluginUrl = myScript.pluginsUrl;
	    $.ajax({
                url: pluginUrl + '/wp2chk-crud/btn_handler.php',
                type: 'post',
				async:false,
                data: $.param(
                    {
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
						action:action,
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
					}
                },
				complete: function (response) {
					response =JSON.parse(response);
					if(response.success)
					{
						globalPostId = response.postId;	
					}
				},
                error: function(){
                    alert("Something is wrong");
                },
            });
}
