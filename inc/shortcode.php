<?php
function wp2_btn_func_preview( $atts, $content=null ) {
    // extracting array indexes into variables
    extract(shortcode_atts( array(
        'selected_btn' => '',
        'selected_btn_size' => '',
        'button_text' => 'Add to cart',
        'button' => '',
        'button_icon' => '',
        'button_bg' => '',
        'button_fg' => '',
    ), $atts));
  
    $data = '';

    if(strpos($selected_btn, 'outline') !== false)
    {
        
        $data .= '
        <div class="wp2-btn">
            <a style="background:' . $button_bg . ';color:' . $button_fg . ';border: 1px solid ' . $button_fg . ';" 
            class="'.$selected_btn.' '.$selected_btn_size.'" href="' . $button . '" target="_blank"><i class="'.$button_icon.'"></i> ' . $button_text . '</a>
        </div>';
    }else{
        $data .= '
        <div class="wp2-btn">
            <a style="background:' . $button_bg . ';color:' . $button_fg . ';border:' . $button_bg . ';" 
            class="'.$selected_btn.' '.$selected_btn_size.'" href="' . $button . '" target="_blank"><i class="'.$button_icon.'"></i> ' . $button_text . '</a>
        </div>';
    }

    return $data;
}
function wp2_btn_func( $atts, $content=null ) {
    // extracting array indexes into variables
    extract(shortcode_atts( array(
        'id' => '',
    ), $atts));  
    $content_post = get_post($id);
    
if($content_post != ''):
    extract((array)json_decode($content_post->post_content));
    
    $data = '';
    if(strpos($selected_btn, 'outline') !== false)
    {
        
        $data .= '
        <div class="wp2-btn">
            <a style="background:' . $button_bg . ';color:' . $button_fg . ';border: 1px solid ' . $button_fg . ';" 
            class="'.$selected_btn.' '.$selected_btn_size.'" href="' . $button . '" target="_blank"><i class="'.$button_icon.'"></i> ' . $button_text . '</a>
        </div>';
    }else{
        $data .= '
        <div class="wp2-btn">
            <a style="background:' . $button_bg . ';color:' . $button_fg . ';border:' . $button_bg . ';" 
            class="'.$selected_btn.' '.$selected_btn_size.'" href="' . $button . '" target="_blank"><i class="'.$button_icon.'"></i> ' . $button_text . '</a>
        </div>';
    }
    return $data;
endif;
}

add_shortcode( 'wp2chk_preview', 'wp2_btn_func_preview' );
add_shortcode( 'wp2chk', 'wp2_btn_func' );