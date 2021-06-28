<?php 
require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class AQButtonsListTableClass extends WP_List_Table 
{
    // Declare all the data set(variables) here
   


    // Given below are the function we are gonna override

    // prepare_items
    public function prepare_items()
    {
        global $wpdb;
        $orderby = isset($_GET['orderby']) ? trim($_GET['orderby']) : '';
        $order = isset($_GET['order']) ? trim($_GET['order']) : '';

        $search_term = isset($_POST['s']) ? trim($_POST['s']) : "";

        $per_page = 10;
        $total_items = $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE `post_type`='wp2checkout' AND `post_title`='Cart Button'");
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] - 1) * $per_page) : 0;

        $this->items = $this->aq_list_table_data($orderby, $order,$per_page,$total_items,$paged, $search_term);
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        
    }

    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    function column_shortcode($item)
    {
        $route = plugins_url() . '/wp-to-checkout/wp2chk-crud/btn_handler.php';

        $actions = array(
            'copy' => sprintf('<a href="javascript:" class="copyShortcode" data-id=%s data-action=copy>%s</a>', $item['id'], __('Copy', 'wp-to-checkout')),
            'edit' => sprintf('<a href="javascript:" class="wp2chkEdit" data-id=%s data-action=edit>%s</a>', $item['id'], __('Edit', 'wp-to-checkout')),
            'delete' => sprintf('<a href="%s?action=delete&ids=%s">%s</a>', $route, $item['id'], __('Delete', 'wp-to-checkout')),
        );

        return sprintf('%s %s',
            $item['shortcode'],
            $this->row_actions($actions)
        );

    }

    public function aq_list_table_data($orderby='', $order='',$per_page,$total_items,$paged, $search_term='')
    {
        
        $post_array = array();
        global $wpdb;

        if(!empty($search_term))
        {
            $all_posts = $wpdb->get_results(
                "SELECT * FROM $wpdb->posts WHERE `post_type`='wp2checkout' AND `post_title`='Cart Button' AND  `ID` LIKE '%".$search_term."%'"
            );
        }
        else{
            
            if($orderby == "id" && $order == "desc")
            {
                $all_posts = $wpdb->get_results(
                    "SELECT * FROM  $wpdb->posts WHERE `post_type`='wp2checkout' AND `post_title`='Cart Button' ORDER BY `ID` DESC LIMIT ".$per_page." OFFSET ".$paged.""
                );
                
            }else if($orderby == "id" && $order == "asc"){
                $all_posts = $wpdb->get_results(
                    "SELECT * FROM  $wpdb->posts WHERE `post_type`='wp2checkout' AND `post_title`='Cart Button'  ORDER BY `ID` ASC LIMIT ".$per_page." OFFSET ".$paged.""
                );
                
            }else{
            
                $all_posts = $wpdb->get_results(
                    "SELECT * FROM  $wpdb->posts WHERE `post_type`='wp2checkout' AND `post_title`='Cart Button' ORDER BY `ID` DESC LIMIT ".$per_page." OFFSET ".$paged.""
                );
            }
        }

        foreach($all_posts as $index => $post):
            $btnData = extract((array)json_decode($post->post_content));
            
            $post_array[] = array(
                'id' => $post->ID,
                'shortcode' => '[wp2chk id='.$post->ID.' /]',
                'preview' => '<div class="wp2-btn">
                                <a style="display:table-cell;background:' . $button_bg . ';color:' . $button_fg . ';border: 1px solid ' . $button_fg . ';" 
                                class="'.$selected_btn.' '.$selected_btn_size.'" href="' . $button . '" target="_blank"><i class="'.$button_icon.'"></i> ' . $button_text . '</a>
                            </div>',
                // 'content' => $post->post_content,
                // 'slug' => $post->guid
            );
            endforeach;

        $this->set_pagination_args(array(
            'total_items' => $total_items, 
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page) 
        ));

        return $post_array;
    }
    
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }

    // get_columns
    public function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />', 
            'id' => 'ID',
            'shortcode' => 'Shortcode',
            'preview' => 'Preview'
        );
        return $columns;
    }

    public function get_hidden_columns()
    {
        return array('');

    }

    public function get_sortable_columns()
    {
        return  array(
            'id' => array('id', false)
        );
    }
    //column_default 
    // it will be called by parent class when we call display method.
    public function column_default($item, $column_name)
    {
        switch($column_name)
        {
            // check whether column name is same as we defined inside get_columns method
            // if('id'==column_name || 'name' == column_name || 'email' == column_name )
            // then return $item[$column_name] the value of specific column
            // item means 1 row of data
            case 'id':
            case 'shortcode':
                return $item[$column_name];
            case 'preview':
                return $item[$column_name];
            default:
                return "no data found!";
        }
    } 
    
}

function aq_show_data_list_table()
{
    $aq_list = new AQButtonsListTableClass();

    // Make our data ready. items mean data
    $aq_list->prepare_items();
    
    echo '<h2 style="display:inline-block"> Buttons Table </h2>
    <a style="vertical-align:unset;" href="javascript:" id="wp2chkAddNew" class="button">Add New</a>';
    echo '<form method="post" name="frm_search_shortcode" action="'.$_SERVER["PHP_SELF"].'?page=wp-to-checkout">';
    $aq_list->search_box("Search ID", "wp2_search_shortcode_id");
    echo '</form>';
    displayNotice();

    $aq_list->display();

    displayAddNewPopup();
}

function displayNotice()
{
    if(isset($_GET['deletedCount']) && $_GET['deletedCount'])
    {
        do_action('admin_notices');
        echo "<div class='notice notice-info is-dismissible'><p>".$_GET['deletedCount']. " Item(s) deleted!</p></div>";
    }
}

function displayAddNewPopup()
{
    
    wp_enqueue_style('wp2-checkout-custom-fonts-icons-style', plugins_url('/wp-to-checkout/asset/public/icons/css/all.min.css'), null);	    

    ?>
        <link href="<?php echo plugins_url() ?>/wp-to-checkout/asset/public/css/fontawesome-iconpicker.min.css" rel="stylesheet">
        <link href="<?php echo plugins_url() ?>/wp-to-checkout/asset/admin/css/buttons.css" rel="stylesheet">
        <link href="<?php echo plugins_url() ?>/wp-to-checkout/asset/public/css/wp2checkout_ce_popup.css" rel="stylesheet">
        
        <script src="https://code.jquery.com/jquery-2.2.1.min.js"></script>
    
        <!-- Toastr alerts functioality -->
        

        <script src="<?php echo plugins_url() ?>/wp-to-checkout/asset/public/js/fontawesome-iconpicker.js"></script>
    
        <div id="wp2checkout_ce_editor_popup" style="display: none;">
            <div id="wp2checkout_ce_editor_popup_inner">
                <div class="wp2checkout-ce-top-head">
                    <div>
                        <h2>WP2CHECKOUT</h2>
                    </div>
                    <button type="button" class="wp2checkout-ce-close">&times;</button>
                </div>

               
<?php    include_once(plugin_dir_path(__DIR__) .'../../templates/button_popup_html.php');    ?>
<script>
    jQuery(function($){
        $('.social-icon').iconpicker();      
    });
              
</script>
<script src="<?php echo plugins_url() ?>/wp-to-checkout/asset/admin/js/popup-script.js"></script>
<script src="<?php echo plugins_url() ?>/wp-to-checkout/asset/admin/js/wp-list-popup-classic-script.js"></script>
<?php

}
// End of Popup method

aq_show_data_list_table();
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        

<script src="<?php echo plugins_url() ?>/wp-to-checkout/asset/admin/js/wp-list-button-script.js"></script>
   