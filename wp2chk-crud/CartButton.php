<?php
$path = preg_replace('/wp-content.*$/','',__DIR__);
include($path.'wp-load.php');

class CartButton
{
    var $btnData = array();
    function __construct()
    {
        
    }
    public function setData($postData)
    {
        $this->btnData = $postData;
        if($this->btnData['button_text'] == ''){
            $this->btnData['button_text'] = "Add to Cart";
        }       
    }

    public function save()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "posts";
        $postId = wp_insert_post(array(
                'post_title' => 'Cart Button',
                'post_content' => json_encode($this->btnData),
                'post_name' => 'cart-button',
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
                'post_excerpt'   => '',
                'post_parent'    => 0,
                'post_status'    => 'publish',
                'post_type'      => 'wp2checkout',  
        ));

        if($postId){
            $tableData['newPostId'] = $postId;  
            $post_id = $postId;
            $message = 'Successfully Saved!';
            $response = array('success' => true, 'postId'=> $post_id, 'message' => $message);
        }else {
            $response = array('success' => false);
        }
        return $response;
    }

    public function edit($id)
    {
        global $wpdb;
        $response = [];
        $data = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE `post_title`='Cart Button' AND post_type='wp2checkout' AND `ID`=$id LIMIT 1");
        if(count($data))
        {
            $postData = $data[0];
            $response = [
                'ID' => $postData->ID,
                'post_content' => json_decode($postData->post_content),
                'success' => true,
            ];
        }else{
            $response = [
                'success' => '0',
                'message' => "No Data Found!",
            ];
        }

        return $response;
    }

    public function update($id)
    {
        $response = [];

        $my_post = array();
        $my_post['ID'] = $id;
        $my_post['post_content'] = json_encode($this->btnData);
        $updatedId = wp_update_post( $my_post );
        if($updatedId)
        {
            $response = [
                'updateId' => $updatedId,
                'message' => 'Successfully Updated',
                'success' => true,
            ];

        }else{
            $response = [
                'message' => "Error while updating post",
                'success' => '0',
            ];
        }

        return $response;
        
    }

    
    public function delete($ids)
    {
        global $wpdb;
        $deleted=0;
        $table_name = $wpdb->prefix . 'posts'; 
        
        // Delete in bulk
        if (is_array($ids)){
            $idss = implode(',', $ids);
            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE ID IN($idss)");
                $wpdb->query("DELETE FROM wp_postmeta WHERE post_id IN($idss)");
            }
            $deleted = count($ids);
        }else{
            wp_delete_post($ids, true); 
            $deleted = 1;
        }
        if(!session_id())
        {
            session_start();
        }
        session_start();

        $_SESSION['notice1'] = "<div class='notice notice-info is-dismissible'><p>".$deleted. " Item(s) deleted!</p></div>";
        
        $response = array(
            'redirectUrl' => admin_url('admin.php').'?page=wp-to-checkout&deletedCount='.$deleted,
            'success' => true
        );
        return $response;
    }

    public function wp2chkPreview($postData)
    {
        $shortcode = $postData['shortcode'];
        global $wpdb;
        $postTitle = 'wp2chk-preview-post';
        $postId = 0;
    
        // Search the post if it exists;
        $table_name = $wpdb->prefix . "posts";
        // get data query
        $result = $wpdb->get_results( "SELECT * FROM $table_name WHERE `post_title`='wp2chk-preview-post' AND post_type='wp2chk-preview' LIMIT 1");

        if(count($result)){
            $previewPost = $result[0];
            // Update section
                wp_update_post(array(
                    'ID' => $previewPost->ID,
                    'post_content' => $shortcode, 
                    'post_type' => 'wp2chk-preview'
                ));
            $postId = $previewPost->ID;
            
        } 
        else {
            // Create the new post
            $text = preg_replace('~[^\pL\d]+~u', '-', $postTitle);
            // transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
            // remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);
            // trim
            $text = trim($text, '-');
            // remove duplicate -
            $text = preg_replace('~-+~', '-', $text);
            // lowercase
            $table_slug = strtolower($text);

            $table_name = $wpdb->prefix . "posts";
            $postId = wp_insert_post(array(
                    'post_title' => $postTitle,
                    'post_content' => $shortcode,
                    'post_name' => $table_slug,
                    'comment_status' => 'closed',
                    'ping_status'    => 'closed',
                    'post_excerpt'   => '',
                    'post_parent'    => 0,
                    'post_status'    => 'draft',
                    'post_type'      => 'wp2chk-preview',  
                ));
            }

            if($postId){
                $url = get_permalink($postId);
                $response = array('success' => true, 'postId'=> $postId, 'postUrl' => $url);
            }
            else 
            {
                $response = array('success' => false, 'message' => 'Error: Can\'t Preview Post');
            }

            return $response;
        }


    
}