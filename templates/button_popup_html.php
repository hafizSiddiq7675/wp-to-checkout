<?php  
    $section = "to_checkout_checkout_opt";
    $wp2Options = get_option($section);  
?>
<div id="button_option">
          
             <form autocomplete="off" id="wp2checkout-ce-popup">
                <div class="wp2checkout-content">
                    <div class="form-group inline-group">
                        <input class="form-control" value="<?=$id?>" id="post_id" name="post_id" style="margin-left: 12px !important;display:none;"/>
                    </div>

                <div class="wp2checkout-fr" style="width: 30%;"> 
                    <label for="" style="display: block;">Choose Button:</label>
                    <button type="button" class="wp2btn btn btn-primary">Primary</button>
                    <button type="button" class="wp2btn btn btn-secondary">Secondary</button>
                    <button type="button" class="wp2btn btn btn-success">Success</button>
                    <button type="button" class="wp2btn btn btn-danger">Danger</button>
                    <button type="button" class="wp2btn btn btn-warning">Warning</button>
                    <button type="button" class="wp2btn btn btn-info">Info</button>
                    <button type="button" class="wp2btn btn btn-light">Light</button>
                    <button type="button" class="wp2btn btn btn-dark">Dark</button>
                    <button type="button" class="wp2btn btn btn-link">Link</button>

                    <hr>
                    <button type="button" class="wp2btn btn btn-outline-primary">Primary</button>
                    <button type="button" class="wp2btn btn btn-outline-secondary">Secondary</button>
                    <button type="button" class="wp2btn btn btn-outline-success">Success</button>
                    <button type="button" class="wp2btn btn btn-outline-danger">Danger</button>
                    <button type="button" class="wp2btn btn btn-outline-warning">Warning</button>
                    <button type="button" class="wp2btn btn btn-outline-info">Info</button>
                    <button type="button" class="wp2btn btn btn-outline-light">Light</button>
                    <button type="button" class="wp2btn btn btn-outline-dark">Dark</button>

                    <hr>
                    
                    <label for="" style="display: block;">Choose Size</label>

                    <label class="switch">
                            <input type="radio" name="btn_size" id="small-btn" class="btn-size">
                            <span class="slider round"></span>
                    </label>
                    <button type="button" class="btn btn-primary btn-sm">Small button</button>
                    <br>

                    <label class="switch">
                            <input type="radio" name="btn_size" id="default-btn" checked class="btn-size">
                            <span class="slider round"></span>
                    </label>
                    <button type="button" class="btn btn-primary">Default Size</button>
                
                    <br>

                    
                    <label class="switch">
                            <input type="radio" name="btn_size" id="large-btn" class="btn-size">
                            <span class="slider round"></span>
                    </label>
                    <button type="button" class="btn btn-primary btn-lg">Large button</button>
                     <br>

                     <hr>

                    <label class="switch">
                            <input type="radio" name="btn_size" id="block-btn" class="btn-size">
                            <span class="slider round"></span>
                    </label>
                   
                    <button type="button" class="btn btn-primary btn-lg btn-block">Block level button</button>

                   
                    
                </div>

                    <div id="wp2checkout-wr-btn-amazon .wp2checkout-fl" style="width: 60%;">
                      
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="from_available_btns" id="from_available_btns" value="">
                        <input type="hidden" name="selected_btn_size" id="selected_btn_size" value="">
                        <input type="hidden" name="wp2_transparent" id="wp2_transparent" value="">
                        <input type="hidden" name="action" id="wp2_action" value="Add">
                        <input type="hidden" name="btn_id" id="btn_id" value="">
                        <div class="form-group">
                            <label for="">Selected Button</label>
                            <input class="form-control" id="selected_button" name="selected_button" value="" disabled placeholder="No button is selected from available buttons" />
                        </div>

                        
                        <div class="form-group">
                            <label for="wp2checkout-cons">Button Text</label>
                            <input class="form-control" id="wp2_button_text" name="wp2_button_text" placeholder="Add to cart" />
                        </div>


                    <!-- Generate Amazon Link -->
                    <div style="text-align: center; margin-top:15px;">
                            <div class="form-group">
                                <label class="switch">
                                    <input type="checkbox" name="wp2amazon_link" id="wp2amazon_link" class="wp2amazon_link">
                                    <span class="slider round"></span>
                                </label>
                                <label for="wp2amazon_link">Generate Amazon Add to Cart link</label>
                            </div>
                    </div>

                    <div style="border: 1px solid lightgray; box-sizing:border-box; padding:.575rem; margin-bottom:10px;" class="generate-amazon-link">
                    
                        <div class="form-group">
                            <label for="wp2amzaccesskey">Amazon Access Key ID</label>
                            <input class="form-control fab fa-amazon" id="wp2amzaccesskey" name="amzaccesskey"
                            value="<?php 
                            
                                echo isset($wp2Options) && $wp2Options['aws_access_key_id'] ? $wp2Options['aws_access_key_id'] : "";
                            ?>"
                            disabled />
                            
                        </div>
                        <div class="form-group">
                            <label for="wp2amzassociatetag">Amazon Associate Tag</label>
                            <input class="form-control" id="wp2amzassociatetag" name="wp2amzassociatetag"
                            value="<?php 
                                echo isset($wp2Options) && $wp2Options['associate_tag'] ? $wp2Options['associate_tag'] : "";
                            ?>"
                            disabled />
                        </div>

                        <div class="form-group inline-group">
                            <label for="wp2locale">Choose Locale</label>
                            <select name="wp2locale" id="wp2locale" class="form-control" disabled>
                                <option value="https://www.amazon.com.au/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.com.au/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>  
                                >Australia</option>
                                <option value="https://www.amazon.com.br/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.com.br/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Brazil</option>
                                <option value="https://www.amazon.ca/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.ca/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Canada</option>
                                <option value="https://www.amazon.fr/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.fr/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >France</option>
                                <option value="https://www.amazon.de/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.de/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Germany</option>
                                <option value="https://www.amazon.in/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.in/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >India</option>
                                <option value="https://www.amazon.it/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.it/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Italy</option>
                                <option value="https://www.amazon.co.jp/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.co.jp/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Japan</option>
                                <option value="https://www.amazon.com.mx/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.com.mx/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Mexico</option>
                                <option value="https://www.amazon.nl/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.nl/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Netherlands</option>
                                <option value="https://www.amazon.pl/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.pl/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Poland</option>
                                <option value="https://www.amazon.sg/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.sg/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Singapore</option>
                                <option value="https://www.amazon.sa/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.sa/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Saudi Arabia</option>
                                <option value="https://www.amazon.es/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.es/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Spain</option>
                                <option value="https://www.amazon.se/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.se/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Sweden</option>
                                <option value="https://www.amazon.com.tr/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.com.tr/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >Turkey</option>
                                <option value="https://www.amazon.ae/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.ae/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >United Arab Emirates</option>
                                <option value="https://www.amazon.co.uk/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.co.uk/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >United Kingdom</option>
                                <option value="https://www.amazon.com/gp/aws/cart/add.html"
                                <?php 
                                    echo isset($wp2Options) && $wp2Options['wp2locale'] 
                                    && strcmp($wp2Options['wp2locale'], "https://www.amazon.com/gp/aws/cart/add.html")
                                    ? "" : "selected";
                                ?>
                                >United States</option>
                            </select>            
                        </div>

                        <div class="form-group">
                            <label for="wp2asin">ASIN</label>
                            <input class="form-control" id="wp2asin" name="wp2asin" disabled />
                        </div>

                        <div class="form-group">
                            <label for="wp2qty">Quantity</label>
                            <input class="form-control" id="wp2qty" name="wp2qty" value="1" disabled />
                        </div>

                        <!-- Generate Link Button -->
                        <div style="text-align: center;">
                        <a href="javascript:" id="wp2_generate_amazon_link" class="wp2checkout-button wp2checkout-generate">Generate Link</a>
                        </div>                    

                    </div>

                        <div class="form-group">
                            <label for="wp2checkout-cons">Button Url</label>
                            <input class="form-control" id="wp2_button" name="wp2_button" placeholder="https://www.example.com" />
                        </div>

                        <div class="form-group">
                            <label for="wp2checkout-cons">Button Icon</label>
                            <input class="form-control social-icon" id="wp2_btn_icon" name="wp2_btn_icon" />
                        </div>

                        <div class="form-group">
                            <label for="wp2checkout-cons">Background Color</label>
                            <input type="color" class="form-control" id="wp2_bg_color" name="wp2_bg_color" value="" />
                        </div>

                        <div class="form-group">
                            <label for="wp2checkout-cons">Text Color</label>
                            <input type="color" class="form-control" id="wp2_fg_color" name="wp2_fg_color" value="" />
                        </div>

                    </div>
                </div>
                <div class="clear"></div>
                <div class="wp2checkout-ce-footer">
                    <a href="#" id="footer-close" class="wp2checkout-button wp2checkout-default wp2checkout-fr">Cancel</a>
                    <a href="#" id="wp2checkout-ce-submit" class="wp2checkout-button wp2checkout-success  wp2checkout-fr">Make Shortcode</a>
                    <a href="#" id="wp2checkout-ce-preview" class="wp2checkout-button wp2checkout-primary  wp2checkout-fl">Preview</a>
                </div>
            </form>
            </div>