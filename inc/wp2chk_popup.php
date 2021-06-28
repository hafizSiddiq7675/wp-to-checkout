<?php
namespace TO_CHECKOUT;
require_once(ABSPATH . '/wp-content/plugins/wp-to-checkout/to_checkout.php');
use TO_CHECKOUT;

class Wp2chk_popup
{
    /**
	 * constructor.
	 */
	public function __construct() {

        // Below method call loads bootstrap on public side where posts are being displayed.
        add_action('enqueue_block_assets', [$this,'wp2_checkout_block_assets']);
        
        // Below method call to insert button inside tinymce and capture value on submit
        add_filter("mce_external_plugins", [$this,"wp2checkout_ce_enqueue_editor_scripts"]);

        // Below method call to register our plugin's custom buttons.
        add_filter("mce_buttons", [$this,"wp2checkout_ce_register_buttons_editor"]);

        // Below method call to decide when to display popup
        add_action('admin_enqueue_scripts', [$this,'wp2checkout_ce_editor_style']);

        // get the path of plugin url for javascript
       
        // first of all we registered a script named my-script that contains url of stylesheet
        wp_enqueue_script('my-script', plugins_url(). '/tocheckout/asset/public/js/wp2checkout-popup-classic-editor.js');
        // This function localizes a registered script with data for a JavaScript variable.
        // myScript is a javascript variable(object)
        // myScript.pluginsUrl is the value you want to use.
        // this variable is available to the javascript files those are included in this class
        wp_localize_script('my-script', 'myScript', array(
            'pluginsUrl' => plugins_url().'/wp-to-checkout',
            'adminsUrl' => admin_url('admin.php'),
        ));

	}

   
    // Link bootstrap on public side to stylize the buttons
    function wp2_checkout_block_assets()
    { 
        wp_enqueue_style('wp2-checkout-bootstrap', plugins_url('/wp-to-checkout/asset/public/css/bootstrap.min.css'), null);
        // Fonts added on public side as well.
		wp_enqueue_style('wp2-checkout-custom-fonts-icons-style', plugins_url('/wp-to-checkout/asset/public/icons/css/all.min.css'), null);	    
    }
    
    function wp2checkout_ce_enqueue_editor_scripts($plugin_array)
    {
        //enqueue TinyMCE plugin script with its ID.
        $plugin_array["wp2checkout_ce_popup_button"] =   plugins_url('wp-to-checkout/asset/public/js/wp2checkout-popup-classic-editor.js');
        return $plugin_array;
    }

    
    function wp2checkout_ce_register_buttons_editor($buttons)
    {
        //wp2checkout_ce_popup_button is the name/id of button it is now registered to mce_buttons.
        array_push($buttons, "wp2checkout_ce_popup_button");
        return $buttons;
    }

    function wp2checkout_ce_editor_style($hook)
    {
        if (($hook == 'post-new.php' || $hook == 'post.php') && get_user_option('rich_editing') == 'true') {
            wp_enqueue_style('wp2checkout_ce_editor_style', plugins_url('wp-to-checkout/asset/public/css/wp2checkout_ce_popup.css'), null,);
            add_filter('admin_footer',[$this, 'wp2checkout_ce_editor_popup']);
        }
    }

    function wp2checkout_ce_editor_popup($id=null)
    {
    
        wp_enqueue_style('wp2-checkout-custom-fonts-icons-style', plugins_url('/wp-to-checkout/asset/public/icons/css/all.min.css'), null);	    

?>
    <link href="<?php echo plugins_url() ?>/wp-to-checkout/asset/public/css/fontawesome-iconpicker.min.css" rel="stylesheet">
    <link href="<?php echo plugins_url() ?>/wp-to-checkout/asset/admin/css/buttons.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
    <!-- <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <script src="<?php echo plugins_url() ?>/wp-to-checkout/asset/public/js/fontawesome-iconpicker.js"></script>

    <div id="wp2checkout_ce_editor_popup" style="display: none;">
        <div id="wp2checkout_ce_editor_popup_inner">
            <div class="wp2checkout-ce-top-head">
                <div>
                    <h2>WP2CHECKOUT</h2>
                </div>
                <div style="text-align: center;">
                    <!-- <div class="form-group inline-group">
                        <select name="generate" id="generate" class="form-control">
                            <option value="btn">Generate Button</option>
                            <option value="link">Generate Link</option>
                        </select>            
                    </div> -->
                </div>
                <button type="button" class="wp2checkout-ce-close">&times;</button>
            </div>
            <?php include_once(ABSPATH . 'wp-content/plugins/wp-to-checkout/templates/button_popup_html.php')  ?>
            <script>
                 $('.social-icon').iconpicker();                
            </script>
            <script src="<?php echo plugins_url() ?>/wp-to-checkout/asset/admin/js/popup-script.js"></script>
    <?php }

}

$wp2 = new Wp2chk_popup();

