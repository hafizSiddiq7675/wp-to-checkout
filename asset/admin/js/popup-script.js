                //  Generate Button or Link select box
jQuery(function($){

                $("#generate").on('change', function(){
                    var generated = $(this).val();

                    if(generated == 'link'){
                        $("#button_option").fadeOut();
                        $("#link_option").fadeIn();
                    }else if(generated == 'btn'){
                        $("#button_option").fadeIn();
                        $("#link_option").fadeOut();
                    }else{
                        $("#button_option").fadeIn();
                        $("#link_option").fadeOut();
                    }
                });

                // Link generate choice
                $("#wp2amazon_link").on('change', function(){
                    if($("#wp2amazon_link").is(":checked")){
                        $("#wp2_button").prop('disabled', true);
                        $("#wp2amzaccesskey").prop('disabled', false);
                        $("#wp2amzassociatetag").prop('disabled', false);
                        $("#wp2locale").prop('disabled', false);
                        $("#wp2asin").prop('disabled', false);
                        $("#wp2qty").prop('disabled', false);
                        // $("#wp2_generate_amazon_link").prop('disabled', false);
                    }else{
                        $("#wp2_button").prop('disabled', false);
                        $("#wp2amzaccesskey").prop('disabled', true);
                        $("#wp2amzassociatetag").prop('disabled', true);
                        $("#wp2locale").prop('disabled', true);
                        $("#wp2asin").prop('disabled', true);
                        $("#wp2qty").prop('disabled', true);
                        // $("#wp2_generate_amazon_link").attr('style','pointer-events:auto');
                        
                     }
                });

                // generate Link
                $("a#wp2_generate_amazon_link").on('click', function(){
                    if($("#wp2amazon_link").is(":checked")){
                        let accessKey = $("#wp2amzaccesskey").val();
                        let assocTag = $("#wp2amzassociatetag").val();
                        let locale = $("#wp2locale").val();
                        let asin = $("#wp2asin").val();
                        let qty = $("#wp2qty").val();
                        let amazonLink = wp2GenerateAmazonLink(accessKey, assocTag, locale, asin, qty);
                        $("#wp2_button").val(amazonLink);
                    }
                });

                function wp2GenerateAmazonLink(accessKey, assocTag, locale, asin, qty)
                {
                    let link = '';
                    link += `${locale}?AWSAccessKeyId=${accessKey}&AssociateTag=assocTag&ASIN.1=${asin}&Quantity.1=${qty}`;
                    return link;
                }
                
                function changeColors(element){ 
                    let selectedClass = element.attr("class");

                    // Buttons Fore Color & Bakcground Color 
                    if(selectedClass == "wp2btn btn btn-primary" || selectedClass == "wp2btn btn btn-secondary" 
                     || selectedClass == "wp2btn btn btn-success" || selectedClass == "wp2btn btn btn-danger"
                     || selectedClass == "wp2btn btn btn-info" || selectedClass == "wp2btn btn btn-dark"){
                        $("#wp2_fg_color").val("#ffffff");
                    }

                    if(selectedClass == "wp2btn btn btn-warning" || selectedClass == "wp2btn btn btn-light")
                    {
                        $("#wp2_fg_color").val("#212529");
                    }

                    if(selectedClass == "wp2btn btn btn-link")
                    {
                        $("#wp2_fg_color").val("#0056b3");
                    }
                    // Bg Color for buttons 
                    selectedClass == "wp2btn btn btn-primary" ? $("#wp2_bg_color").val("#0062cc") : $("#wp2_transparent").val("");
                    selectedClass == "wp2btn btn btn-success" ? $("#wp2_bg_color").val("#28a745") : $("#wp2_transparent").val("");
                    selectedClass == "wp2btn btn btn-secondary" ? $("#wp2_bg_color").val("#545b62") : $("#wp2_transparent").val("");
                    selectedClass == "wp2btn btn btn-danger" ? $("#wp2_bg_color").val("#bd2130") : $("#wp2_transparent").val("");
                    selectedClass == "wp2btn btn btn-warning" ? $("#wp2_bg_color").val("#d39e00")  : $("#wp2_transparent").val("");
                    selectedClass == "wp2btn btn btn-info" ? $("#wp2_bg_color").val("#117a8b") : $("#wp2_transparent").val("");
                    selectedClass == "wp2btn btn btn-light" ? $("#wp2_bg_color").val("#dae0e5") : $("#wp2_transparent").val("");
                    selectedClass == "wp2btn btn btn-dark" ? $("#wp2_bg_color").val("#1d2124") : $("#wp2_transparent").val("");
                    

                    if( selectedClass == "wp2btn btn btn-link"){
                        $("#wp2_bg_color").val("")
                        $("#wp2_transparent").val("transparent");
                    }

                    // Outline Buttons Fore Colors and Background Colors
                    // BG colors
                    if(selectedClass == "wp2btn btn btn-outline-primary" || selectedClass == "wp2btn btn btn-outline-secondary" 
                    || selectedClass == "wp2btn btn btn-outline-success" || selectedClass == "wp2btn btn btn-outline-danger"
                    || selectedClass == "wp2btn btn btn-outline-warning" || selectedClass == "wp2btn btn btn-outline-info" 
                    || selectedClass == "wp2btn btn btn-outline-light" || selectedClass == "wp2btn btn btn-outline-dark")
                    {
                        $("#wp2_bg_color").val("");
                        $("#wp2_transparent").val("transparent");
                    }
                    // Fore Color/ Text Color
                    selectedClass == "wp2btn btn btn-outline-primary" ? $("#wp2_fg_color").val("#007bff"): '';
                    selectedClass == "wp2btn btn btn-outline-success" ? $("#wp2_fg_color").val("#28a745") : '';
                    selectedClass == "wp2btn btn btn-outline-secondary" ? $("#wp2_fg_color").val("#6c757d") : '';
                    selectedClass == "wp2btn btn btn-outline-danger" ? $("#wp2_fg_color").val("#dc3545") : '';
                    selectedClass == "wp2btn btn btn-outline-warning" ? $("#wp2_fg_color").val("#ffc107") : '';
                    selectedClass == "wp2btn btn btn-outline-info" ? $("#wp2_fg_color").val("#17a2b8") : '';
                    selectedClass == "wp2btn btn btn-outline-light" ? $("#wp2_fg_color").val("#f8f9fa") : '';
                    selectedClass == "wp2btn btn btn-outline-dark" ? $("#wp2_fg_color").val("#343a40") : '';

            }
            
            // Button Scripts

                 $(".wp2btn").on('click', function(){
                    // alert($(this).attr('class'));
                    var selectedButtonClass = $(this).attr('class');
                    
                    $("#from_available_btns").val(selectedButtonClass);
                    $("#selected_button").val($(this).html());

                    changeColors($(this));

                 });

                 $(".btn-size").on('change', function(){
                     
                    if($("#large-btn").is(":checked")){
                        $("#selected_btn_size").val("btn-lg");
                    }
                    if($("#small-btn").is(":checked")){
                        $("#selected_btn_size").val("btn-sm");
                    }
                    if($("#default-btn").is(":checked")){
                        $("#selected_btn_size").val(" btn ");
                    }
                    if($("#block-btn").is(":checked")){
                        $("#selected_btn_size").val("btn-lg btn-block");
                    }
                    
                 });

                 $("#wp2_bg_color").on('change', function(){
                    $("#wp2_transparent").val("");
                 });
                 $("#wp2_fg_color").on('change', function(){
                    $("#wp2_transparent").val("");
                 });




                 
                // Preview Functionality
                function previewAjaxCall(shortcodeParam)
                {
                    var pluginUrl = myScript.pluginsUrl;
                    $.ajax({
                            url: pluginUrl + '/wp2chk-crud/btn_handler.php',
                            type: 'post',
                            async:false,
                            data: $.param(
                                {
                                    shortcode: shortcodeParam,
                                    preview: 1
                                }
                            ),
                            beforeSend: function(){
                                
                            },
                            success: function(response){
                                response =JSON.parse(response);
                                previewUrl = response.postUrl + '&preview=true';
                                window.open(previewUrl,'_blank'); 
                            },
                            complete: function (response) {
                                
                            },
                            error: function(){
                                alert("Something is wrong");
                            },
                        });
                }
                //  Preview Functionality
                $('#wp2checkout-ce-preview').on('click', function (e, para=0) {
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
                    let shortcodePreview = '<span class="wp2checkout-preview">[wp2chk_preview' + attributes + ' /] </span>';
                    previewAjaxCall(shortcodePreview);
                    // $('.wp2checkout-ce-close').trigger('click');
                    // $('#wp2checkout_ce_editor_popup').removeClass('wp2checkout-ce-popup-display');
                    // $('body').css('overflow', '');
                });
            
  
});              
 
// LINK SCRIPTS
