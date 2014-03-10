<?php
   /* 
    Plugin Name: WP Image Slider With Lightbox
    Plugin URI:http://www.my-php-scripts.net 
    Author URI:http://www.postfreeadvertising.com
    Description:This is beautiful thumbnail image slider plugin for WordPress with lightbox.Add any number of images from admin panel.
    Author:nik00726
    Version:1.0
    */

    add_action('admin_menu', 'slider_plus_lightbox_add_admin_menu');
    add_action( 'admin_init', 'slider_plus_lightbox_plugin_admin_init' );
    register_activation_hook(__FILE__,'install_slider_plus_lightbox');
    add_action('wp_enqueue_scripts', 'slider_plus_lightbox_load_styles_and_js');
    add_shortcode( 'print_slider_plus_lightbox', 'print_slider_plus_lightbox_func' );
    
    function slider_plus_lightbox_load_styles_and_js(){
        
         if (!is_admin()) {                                                       
             
            wp_enqueue_style( 'slider-plus-lightbox-style', plugins_url('/css/slider-plus-lightbox-style.css', __FILE__) );
            wp_enqueue_style( 'jquery.lbox', plugins_url('/css/jquery.lbox.css', __FILE__) );
            wp_enqueue_script('jquery'); 
            wp_enqueue_script('slider-plus-lightbox-js',plugins_url('/js/slider-plus-lightbox-js.js', __FILE__));
            wp_enqueue_script('jquery.lbox.min',plugins_url('/js/jquery.lbox.min.js', __FILE__));
            
         }  
      }
      
     function install_slider_plus_lightbox(){
         
           set_time_limit(500);
           global $wpdb;
           $table_name = $wpdb->prefix . "slider_plus_lightbox";
           
                  $sql = "CREATE TABLE " . $table_name . " (
                       id int(10) unsigned NOT NULL auto_increment,
                       title varchar(1000) NOT NULL,
                       image_name varchar(500) NOT NULL,
                       createdon datetime NOT NULL,
                       custom_link varchar(1000) default NULL,
                       post_id int(10) unsigned default NULL,
                      PRIMARY KEY  (id)
                );";
               require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
               dbDelta($sql);
               
               $slider_plus_lightbox_settings=array('pauseonmouseover' => '1','auto' =>'','speed' => '1000','circular' => '1','imageheight' => '120','imagewidth' => '120','visible'=> '5','scroll' => '1','resizeImages'=>'0','scollerBackground'=>'#FFFFFF');
               
               if( !get_option( 'slider_plus_lightbox_settings' ) ) {
                   
                    update_option('slider_plus_lightbox_settings',$slider_plus_lightbox_settings);
                } 
               
     } 
    
    
    
   
    function slider_plus_lightbox_add_admin_menu(){
        
        add_menu_page( __( 'Thumbnail Slider With Lightbox'), __( 'Thumbnail Slider With Lightbox' ), 'administrator', 'thumbnail_slider_with_lightbox', 'thumbnail_slider_with_lightbox_admin_options_func' );
        add_submenu_page( 'thumbnail_slider_with_lightbox', __( 'Slider Settings'), __( 'Slider Setting' ),'administrator', 'thumbnail_slider_with_lightbox', 'thumbnail_slider_with_lightbox_admin_options_func' );
        add_submenu_page( 'thumbnail_slider_with_lightbox', __( 'Manage Images'), __( 'Manage Images'),'administrator', 'thumbnail_slider_with_lightbox_image_management', 'thumbnail_slider_with_lightbox_image_management_func' );
        add_submenu_page( 'thumbnail_slider_with_lightbox', __( 'Preview Slider'), __( 'Preview Slider'),'administrator', 'thumbnail_slider_with_lightbox_preview', 'thumbnail_slider_with_lightbox_admin_preview_func' );
        
        
    }
    
    function slider_plus_lightbox_plugin_admin_init(){
      
        $url = plugin_dir_url(__FILE__);  
        wp_enqueue_script( 'jquery.validate', $url.'js/jquery.validate.js' );  
        wp_enqueue_style( 'slider-plus-lightbox-style', plugins_url('/css/slider-plus-lightbox-style.css', __FILE__) );
        wp_enqueue_style( 'jquery.lbox', plugins_url('/css/jquery.lbox.css', __FILE__) );
        wp_enqueue_script('jquery'); 
        wp_enqueue_script('slider-plus-lightbox-js',plugins_url('/js/slider-plus-lightbox-js.js', __FILE__));
        wp_enqueue_script('jquery.lbox.min',plugins_url('/js/jquery.lbox.min.js', __FILE__));
    }
    
   function thumbnail_slider_with_lightbox_admin_options_func(){
       
     if(isset($_POST['btnsave'])){
         
         $auto=trim($_POST['isauto']);
         
         if($auto=='auto')
           $auto=true;
         else
           $auto=false; 
            
         $speed=(int)trim($_POST['speed']);
         
         if(isset($_POST['circular']))
           $circular=true;  
        else
           $circular=false;  

         //$scrollerwidth=$_POST['scrollerwidth'];
         
         $visible=trim($_POST['visible']);

        
         if(isset($_POST['pauseonmouseover']))
           $pauseonmouseover=true;  
         else 
          $pauseonmouseover=false;
         
         
         $scroll=trim($_POST['scroll']);
         
         if($scroll=="")
          $scroll=1;
         
         $imageheight=(int)trim($_POST['imageheight']);
         $imagewidth=(int)trim($_POST['imagewidth']);
         $resizeImages=(int)trim($_POST['resizeImages']);
         $scollerBackground=trim($_POST['scollerBackground']);
         
         $options=array();
         $options['pauseonmouseover']=$pauseonmouseover;  
         $options['auto']=$auto;  
         $options['speed']=$speed;  
         $options['circular']=$circular;  
         //$options['scrollerwidth']=$scrollerwidth;  
         $options['imageheight']=$imageheight;  
         $options['imagewidth']=$imagewidth;  
         $options['visible']=$visible;  
         $options['scroll']=$scroll;  
         $options['resizeImages']=$resizeImages;  
         $options['scollerBackground']=$scollerBackground;  
        
         
         $settings=update_option('slider_plus_lightbox_settings',$options); 
         $slider_with_lightbox_messages=array();
         $slider_with_lightbox_messages['type']='succ';
         $slider_with_lightbox_messages['message']='Settings saved successfully.';
         update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);

        
         
     }  
      $settings=get_option('slider_plus_lightbox_settings');
      
?>      
     <div style="width: 100%;">  
        <div style="float:left;width:69%;">
            <div class="wrap">
               <table><tr><td><a href="https://twitter.com/FreeAdsPost" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @FreeAdsPost</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
                <td>
                <a target="_blank" title="Donate" href="http://my-php-scripts.net/donate-wordpress_image_thumbnail.php">
                <img id="help us for free plugin" height="30" width="90" src="http://www.postfreeadvertising.com/images/paypaldonate.jpg" border="0" alt="help us for free plugin" title="help us for free plugin">
                </a>
                </td>
                </tr>
                </table>
                <a target="_blank" href="http://www.shareasale.com/r.cfm?b=357716&amp;u=675922&amp;m=29819&amp;urllink=&amp;afftrack="><img src="http://www.shareasale.com/image/29819/468x60.jpg" alt="Catalyst Theme - WordPress Accelerated" border="0" /></a>
                <span><h3 style="color: blue;"><a target="_blank" href="http://www.my-php-scripts.net/index.php/Wordpress/wordpress-lightbox-gallery-slider-pro.html">Upgrade To WordPress Slider With Lightbox Pro</a></h3></span>
                
      
              <?php
                    $messages=get_option('slider_with_lightbox_messages'); 
                    $type='';
                    $message='';
                    if(isset($messages['type']) and $messages['type']!=""){

                    $type=$messages['type'];
                    $message=$messages['message'];

                    }  


                    if($type=='err'){ echo "<div class='errMsg'>"; echo $message; echo "</div>";}
                    else if($type=='succ'){ echo "<div class='succMsg'>"; echo $message; echo "</div>";}


                    update_option('slider_with_lightbox_messages', array());     
              ?>      

                    <h2>Slider Settings</h2>
            <br>
            <div id="poststuff">
              <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                  <form method="post" action="" id="scrollersettiings" name="scrollersettiings" >
                    
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Auto Scroll ?</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input style="width:20px;" type='radio' <?php if($settings['auto']==true){echo "checked='checked'";}?>  name='isauto' value='auto' >Auto &nbsp;<input style="width:20px;" type='radio' name='isauto' <?php if($settings['auto']==false){echo "checked='checked'";} ?> value='manuall' >Scroll By Left & Right Arrow
                                   <div style="clear:both"></div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label >Speed</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="text" id="speed" size="30" name="speed" value="<?php echo $settings['speed']; ?>" style="width:100px;">
                                      <div style="clear:both"></div>
                                      <div></div>
                                 </td>
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                           
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label >Circular Slider ?</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="checkbox" id="circular" size="30" name="circular" value="" <?php if($settings['circular']==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;Circular Slider ? 
                                     <div style="clear:both"></div>
                                     <div></div>
                                 </td>
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                           
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Slider Background color</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="text" id="scollerBackground" size="30" name="scollerBackground" value="<?php echo $settings['scollerBackground']; ?>" style="width:100px;">
                                   <div style="clear:both"></div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Visible</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="text" id="visible" size="30" name="visible" value="<?php echo $settings['visible']; ?>" style="width:100px;">
                                   <div style="clear:both">This will decide your slider width automatically</div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             specifies the number of items visible at all times within the slider.
                             <div style="clear:both"></div>
                           
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Scroll</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="text" id="scroll" size="30" name="scroll" value="<?php echo $settings['scroll']; ?>" style="width:100px;">
                                   <div style="clear:both"></div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             You can specify the number of items to scroll when you click the next or prev buttons.
                             <div style="clear:both"></div>
                         </div>
                      </div>
                       <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Pause On Mouse Over ?</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="checkbox" id="pauseonmouseover" size="30" name="pauseonmouseover" value="" <?php if($settings['pauseonmouseover']==true){echo "checked='checked'";} ?> style="width:20px;">&nbsp;Pause On Mouse Over ? 
                                   <div style="clear:both"></div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                     <!-- <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Slider Width</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="text" id="scrollerwidth" size="30" name="scrollerwidth" value="<?php echo $settings['scrollerwidth']; ?>" style="width:100px;">
                                      <div style="clear:both"></div>
                                      <div></div>
                                 </td>
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                           
                         </div>
                      </div>-->
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Image Height</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="text" id="imageheight" size="30" name="imageheight" value="<?php echo $settings['imageheight']; ?>" style="width:100px;">
                                   <div style="clear:both"></div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Image Width</label></h3>
                        <div class="inside">
                             <table>
                               <tr>
                                 <td>
                                   <input type="text" id="imagewidth" size="30" name="imagewidth" value="<?php echo $settings['imagewidth']; ?>" style="width:100px;">
                                   <div style="clear:both"></div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label>Physically resize images ?</label></h3>
                        <div class="inside">
                              <table>
                               <tr>
                                 <td>
                                   <input style="width:20px;" type='radio' <?php if($settings['resizeImages']==1){echo "checked='checked'";}?>  name='resizeImages' value='1' >Yes &nbsp;<input style="width:20px;" type='radio' name='resizeImages' <?php if($settings['resizeImages']==0){echo "checked='checked'";} ?> value='0' >Resize using css
                                   <div style="clear:both;padding-top:5px">If you choose "<b>Resize using css</b>" the quality will be good but some times large images takes time to load </div>
                                   <div></div>
                                 </td>
                               </tr>
                             </table>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                    <input type="submit"  name="btnsave" id="btnsave" value="Save Changes" class="button-primary">&nbsp;&nbsp;<input type="button" name="cancle" id="cancle" value="Cancel" class="button-primary" onclick="location.href='admin.php?page=thumbnail_slider_with_lightbox_image_management'">
                                  
                 </form> 
                  <script type="text/javascript">
                  
                     var $n = jQuery.noConflict();  
                     $n(document).ready(function() {
                     
                        $n("#scrollersettiings").validate({
                            rules: {
                                      isauto: {
                                      required:true
                                    },speed: {
                                      required:true, 
                                      number:true, 
                                      maxlength:15
                                    },
                                    visible:{
                                        required:true, 
                                        number:true,
                                        maxlength:15
                                        
                                    },
                                    scroll:{
                                      required:true,
                                      number:true,
                                      maxlength:15  
                                    },
                                    scollerBackground:{
                                      required:true,
                                      maxlength:7  
                                    },
                                    /*scrollerwidth:{
                                      required:true,
                                      number:true,
                                      maxlength:15    
                                    },*/imageheight:{
                                      required:true,
                                      number:true,
                                      maxlength:15    
                                    },
                                    imagewidth:{
                                      required:true,
                                      number:true,
                                      maxlength:15    
                                    }
                                    
                               },
                                 errorClass: "image_error",
                                 errorPlacement: function(error, element) {
                                 error.appendTo( element.next().next());
                             } 
                             

                        })
                    });
                  
                </script> 

                </div>
          </div>
        </div>  
     </div>      
</div>
           <div id="poststuff" class="metabox-holder has-right-sidebar" style="float:right;width:30%;margin-top:200px"> 
                         
           <div class="postbox"> 
              <h3 class="hndle"><span></span>Recommended WordPress Themes</h3> 
              <div class="inside">
                   <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="http://www.elegantthemes.com/affiliates/banners/300x250.gif" width="300" height="250"></a></center>

                  <div style="margin:10px 5px">
          
                  </div>
          </div></div>
           <div class="postbox"> 
              <h3 class="hndle"><span></span>Recommended WordPress Themes</h3> 
              <div class="inside">
                   <center><a target="_blank" href="http://www.shareasale.com/r.cfm?b=202505&amp;u=675922&amp;m=24570&amp;urllink=&amp;afftrack="><img src="http://www.shareasale.com/image/24570/thesis-300x250-1.png" alt="Thesis Theme for WordPress:  Options Galore and a Helpful Support Community" border="0" /></a></center>

                  <div style="margin:10px 5px">
          
                  </div>
          </div></div>
           
           </div>
     
    
<div class="clear"></div></div>  
<?php
   } 
   function thumbnail_slider_with_lightbox_image_management_func(){
     
     $action='gridview';
      global $wpdb;
      
     
      if(isset($_GET['action']) and $_GET['action']!=''){
         
   
         $action=trim($_GET['action']);
       }
       
    ?>
   
  <?php 
      if(strtolower($action)==strtolower('gridview')){ 
      
          
          $wpcurrentdir=dirname(__FILE__);
          $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
          
          
      
   ?> 
       <div class="wrap">
           <style type="text/css">
          .pagination {
            clear:both;
            padding:20px 0;
            position:relative;
            font-size:11px;
            line-height:13px;
            }
             
            .pagination span, .pagination a {
            display:block;
            float:left;
            margin: 2px 2px 2px 0;
            padding:6px 9px 5px 9px;
            text-decoration:none;
            width:auto;
            color:#fff;
            background: #555;
            }
             
            .pagination a:hover{
            color:#fff;
            background: #3279BB;
            }
             
            .pagination .current{
            padding:6px 9px 5px 9px;
            background: #3279BB;
            color:#fff;
            }
        </style>
          <table><tr><td><a href="https://twitter.com/FreeAdsPost" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @FreeAdsPost</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
                <td>
                <a target="_blank" title="Donate" href="http://my-php-scripts.net/donate-wordpress_image_thumbnail.php">
                <img id="help us for free plugin" height="30" width="90" src="http://www.postfreeadvertising.com/images/paypaldonate.jpg" border="0" alt="help us for free plugin" title="help us for free plugin">
                </a>
                </td>
                </tr>
                </table>
                <a target="_blank" href="http://www.shareasale.com/r.cfm?b=357716&amp;u=675922&amp;m=29819&amp;urllink=&amp;afftrack="><img src="http://www.shareasale.com/image/29819/468x60.jpg" alt="Catalyst Theme - WordPress Accelerated" border="0" /></a>
                <span><h3 style="color: blue;"><a target="_blank" href="http://www.my-php-scripts.net/index.php/Wordpress/wordpress-lightbox-gallery-slider-pro.html">Upgrade To WordPress Slider With Lightbox Pro</a></h3></span>
             
        <?php 
             
             $messages=get_option('slider_with_lightbox_messages'); 
             $type='';
             $message='';
             if(isset($messages['type']) and $messages['type']!=""){
             
                $type=$messages['type'];
                $message=$messages['message'];
                
             }  
             
  
             if($type=='err'){ echo "<div class='errMsg'>"; echo $message; echo "</div>";}
             else if($type=='succ'){ echo "<div class='succMsg'>"; echo $message; echo "</div>";}
             
             
             update_option('slider_with_lightbox_messages', array());     
        ?>

       <div style="width: 100%;">  
        <div style="float:left;width:69%;" >
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2>Images <a class="button add-new-h2" href="admin.php?page=thumbnail_slider_with_lightbox_image_management&action=addedit">Add New</a> </h2>
        <br/>    
        
        <form method="POST" action="admin.php?page=thumbnail_slider_with_lightbox_image_management&action=deleteselected"  id="posts-filter">
              <div class="alignleft actions">
                <select name="action_upper">
                    <option selected="selected" value="-1">Bulk Actions</option>
                    <option value="delete">delete</option>
                </select>
                <input type="submit" value="Apply" class="button-secondary action" id="deleteselected" name="deleteselected">
            </div>
         <br class="clear">
        <?php 
        
          $settings=get_option('slider_plus_lightbox_settings'); 
          $visibleImages=$settings['visible'];
          $query="SELECT * FROM ".$wpdb->prefix."slider_plus_lightbox order by createdon desc";
          $rows=$wpdb->get_results($query,'ARRAY_A');
          $rowCount=sizeof($rows);
          
        ?>
        <?php if($rowCount<$visibleImages){ ?>
            <h4 style="color: green"> Current slider setting - Total visible images <?php echo $visibleImages; ?></h4>
            <h4 style="color: green">Please add atleast <?php echo $visibleImages; ?> images</h4>
        <?php } else{
            echo "<br/>";
        }?>
         <table cellspacing="0" class="wp-list-table widefat fixed posts" style="width:500px">
         <thead>
         <tr>
         <th style="width:30px" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
        <th style="width:150px" class="manage-column column-title sortable desc" scope="col"><span>Title</span></th>
        <th style="width:100px" class="manage-column column-title sortable desc" scope="col"><span></span></th>
        <th style="width:100px"  class="manage-column column-author sortable desc" scope="col"><span>Published On</span></th>
        <th style="width:50px" class="manage-column column-author sortable desc" scope="col"><span>Edit</span></th>
        <th style="width:50px" class="manage-column column-author sortable desc" scope="col"><span>Delete</span></th>
        </thead>

    <tfoot>
    <tr>
        <th  style="width:30px" class="manage-column column-cb check-column" scope="col"><input type="checkbox"></th>
        <th style="width:150px" class="manage-column column-title sortable desc" scope="col"><span>Title</span></th>
        <th style="width:100px" class="manage-column column-title sortable desc" scope="col"><span></span></th>
        <th style="width:100px" class="manage-column column-author sortable desc" scope="col"><span>Published On</span></th>
        <th style="width:50px" class="manage-column column-author sortable desc" scope="col"><span>Edit</span></th>
        <th style="width:50px" class="manage-column column-author sortable desc" scope="col"><span>Delete</span></th>
    </tr>
    </tfoot>

    <tbody id="the-list">
                   <?php
                     
                    if(count($rows) > 0){
                    
                        global $wp_rewrite;
                            $rows_per_page = 5;
                            
                            $current = (isset($_GET['paged'])) ? ($_GET['paged']) : 1;
                            $pagination_args = array(
                            'base' => @add_query_arg('paged','%#%'),
                            'format' => '',
                            'total' => ceil(sizeof($rows)/$rows_per_page),
                            'current' => $current,
                            'show_all' => false,
                            'type' => 'plain',
                           );
                            
                          
                          $start = ($current - 1) * $rows_per_page;
                          $end = $start + $rows_per_page;
                          $end = (sizeof($rows) < $end) ? sizeof($rows) : $end;
                         
                                      
                           for ($i=$start;$i < $end ;++$i ) { 
                                $row = $rows[$i];
                               $id=$row['id'];
                               $editlink="admin.php?page=thumbnail_slider_with_lightbox_image_management&action=addedit&id=$id";
                               $deletelink="admin.php?page=thumbnail_slider_with_lightbox_image_management&action=delete&id=$id";
                               $outputimgmain = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name']; 
                               
                            ?>
                            <tr valign="top" class="alternate author-self status-publish format-default iedit" id="post-113">
                                <th style="width:30px" class="check-column" scope="row"><input type="checkbox" value="<?php echo $row['id'] ?>" name="thumbnails[]"></th>
                                <td style="width:150px" class="post-title page-title column-title"><strong><?php echo stripslashes($row['title']) ?></strong></td>  
                                <td style="width:50px" class="post-title page-title column-title">
                                  <img src="<?php echo $outputimgmain;?>" style="width:50px" height="50px"/>
                                </td>  
                                <td style="width:100px" class="date column-date"><abbr title="2011/12/22 11:57:24 AM"><?php echo $row['createdon'] ?></td>
                                <td style="width:50px" class="post-title page-title column-title"><strong><a href='<?php echo $editlink; ?>' title="edit">Edit</a></strong></td>  
                                <td style="width:50px" class="post-title page-title column-title"><strong><a href='<?php echo $deletelink; ?>' onclick="return confirmDelete();"  title="delete">Delete</a> </strong></td>  
                           </tr>
                     <?php 
                             } 
                    }
                   else{
                       ?>
                   
                      <tr valign="top" class="alternate author-self status-publish format-default iedit" id="post-113">
                                <td colspan="5" class="post-title page-title column-title" align="center"><strong>No Images Found</strong></td>  
                           </tr>
                  <?php 
                   } 
                 ?>      
        </tbody>
  </table>
 <?php
    if(sizeof($rows)>0){
     echo "<div class='pagination' style='padding-top:10px'>";
     echo paginate_links($pagination_args);
     echo "</div>";
    }
  ?>
    <br/>
    <div class="alignleft actions">
        <select name="action">
            <option selected="selected" value="-1">Bulk Actions</option>
            <option value="delete">delete</option>
        </select>
        <input type="submit" value="Apply" class="button-secondary action" id="deleteselected" name="deleteselected">
    </div>

    </form>
        <script type="text/JavaScript">

            function  confirmDelete(){
            var agree=confirm("Are you sure you want to delete this image ?");
            if (agree)
                 return true ;
            else
                 return false;
        }
     </script>

        <br class="clear">
          <h3>To print this slider into WordPress Post/Page use bellow code</h3>
    <pre class="printCode">
      [print_slider_plus_lightbox]
    </pre>
    <div class="clear"></div>
    <h3>To print this slider into WordPress theme/template PHP files use bellow code</h3>
    <pre class="printCode">
      echo do_shortcode('[print_slider_plus_lightbox]'); 
    </pre>
    <div class="clear"></div>
        </div>
         <div id="poststuff" class="metabox-holder has-right-sidebar" style="float:right;width:30%;"> 
           <div class="postbox"> 
              <h3 class="hndle"><span></span>Best Hosting for WordPress</h3> 
              <div class="inside">
                   <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="http://www.elegantthemes.com/affiliates/banners/300x250.gif" width="300" height="250"></a></center>

                  <div style="margin:10px 5px">
          
                  </div>
          </div></div>
             <div class="postbox"> 
              <h3 class="hndle"><span></span>Recommended WordPress SEO Tools</h3> 
              <div class="inside">
                   <center><a href="http://www.semrush.com/sem.html?ref=961672083"> <img width="300" height="250" src="http://www.berush.com/images/240x240_semrush_en.png" /></a></center>

                  <div style="margin:10px 5px">
          
                  </div>
          </div></div>
           

           
           
           </div> 
        <div style="clear: both;"></div>
        <?php $url = plugin_dir_url(__FILE__);  ?>
        
        
      </div>  
    </div>  
<?php 
  }   
  else if(strtolower($action)==strtolower('addedit')){
      $url = plugin_dir_url(__FILE__);
       
    ?>
    <?php        
    if(isset($_POST['btnsave'])){
       
       //edit save
       if(isset($_POST['imageid'])){
       
            //add new
                $location='admin.php?page=thumbnail_slider_with_lightbox_image_management';
                $title=trim(addslashes($_POST['imagetitle']));
                $imageurl=trim($_POST['imageurl']);
                $imageid=trim($_POST['imageid']);
                $imagename="";
                if($_FILES["image_name"]['name']!="" and $_FILES["image_name"]['name']!=null){
                
                    if ($_FILES["image_name"]["error"] > 0)
                    {
                        $slider_with_lightbox_messages=array();
                        $slider_with_lightbox_messages['type']='err';
                        $slider_with_lightbox_messages['message']='Error while file uploading.';
                        update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);

                        echo "<script type='text/javascript'> location.href='$location';</script>";
                         
                    }
                    else{
                            $wpcurrentdir=dirname(__FILE__);
                            $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                            $imagename=$_FILES["image_name"]["name"];
                            $imageUploadTo=$wpcurrentdir.'/imagestoscroll/'.$_FILES["image_name"]["name"];
                            move_uploaded_file($_FILES["image_name"]["tmp_name"],$imageUploadTo ); 
                                   
                         }
                    }    
               
                     
                        try{
                                if($imagename!=""){
                                    $query = "update ".$wpdb->prefix."slider_plus_lightbox set title='$title',image_name='$imagename',
                                              custom_link='$imageurl' where id=$imageid";
                                 }
                                else{
                                     $query = "update ".$wpdb->prefix."slider_plus_lightbox set title='$title',
                                               custom_link='$imageurl' where id=$imageid";
                                } 
                                $wpdb->query($query); 
                               
                                 $slider_with_lightbox_messages=array();
                                 $slider_with_lightbox_messages['type']='succ';
                                 $slider_with_lightbox_messages['message']='image updated successfully.';
                                 update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);

             
                         }
                       catch(Exception $e){
                       
                              $slider_with_lightbox_messages=array();
                              $slider_with_lightbox_messages['type']='err';
                              $slider_with_lightbox_messages['message']='Error while updating image.';
                              update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);
                        }  
                
                          
              echo "<script type='text/javascript'> location.href='$location';</script>";
       }
      else{
      
             //add new
                
                $location='admin.php?page=thumbnail_slider_with_lightbox_image_management';
                $title=trim(addslashes($_POST['imagetitle']));
                $imageurl=trim($_POST['imageurl']);
                $createdOn=date('Y-m-d h:i:s');
                
                if(function_exists('date_i18n')){
                    
                    $createdOn=date_i18n('Y-m-d'.' '.get_option('time_format') ,false,false);
                    if(get_option('time_format')=='H:i')
                        $createdOn=date('Y-m-d H:i:s',strtotime($createdOn));
                    else   
                        $createdOn=date('Y-m-d h:i:s',strtotime($createdOn));
                }
                
                if ($_FILES["image_name"]["error"] > 0)
                {
                    $slider_with_lightbox_messages=array();
                    $slider_with_lightbox_messages['type']='err';
                    $slider_with_lightbox_messages['message']='Error while file uploading.';
                    update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);

                    echo "<script type='text/javascript'> location.href='$location';</script>";
                     
                }
                else{
                         $location='admin.php?page=thumbnail_slider_with_lightbox_image_management';
               
                         try{
                                
                                
                                $wpcurrentdir=dirname(__FILE__);
                                $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                                $imagename=$_FILES["image_name"]["name"];
                                $imageUploadTo=$wpcurrentdir.'/imagestoscroll/'.$_FILES["image_name"]["name"];
                                move_uploaded_file($_FILES["image_name"]["tmp_name"],$imageUploadTo ); 
                               
                                $query = "INSERT INTO ".$wpdb->prefix."slider_plus_lightbox (title, image_name,createdon,custom_link) 
                                          VALUES ('$title','$imagename','$createdOn','$imageurl')";
                                                                             
                                $wpdb->query($query); 
                               
                                 $slider_with_lightbox_messages=array();
                                 $slider_with_lightbox_messages['type']='succ';
                                 $slider_with_lightbox_messages['message']='New image added successfully.';
                                 update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);

             
                         }
                       catch(Exception $e){
                       
                              $slider_with_lightbox_messages=array();
                              $slider_with_lightbox_messages['type']='err';
                              $slider_with_lightbox_messages['message']='Error while adding image.';
                              update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);
                        }  
                     
                     }     
                echo "<script type='text/javascript'> location.href='$location';</script>";          
            
       } 
        
    }
   else{ 
        
  ?>
     <div style="width: 100%;">  
        <div style="float:left;width:69%;" >
            <div class="wrap">
          <?php if(isset($_GET['id']) and $_GET['id']>0)
          { 
               
                
                $id= $_GET['id'];
                $query="SELECT * FROM ".$wpdb->prefix."slider_plus_lightbox WHERE id=$id";
                $myrow  = $wpdb->get_row($query);
                
                if(is_object($myrow)){
                
                  $title=stripslashes($myrow->title);
                  $image_link=$myrow->custom_link;
                  $image_name=stripslashes($myrow->image_name);
                  
                }   
              
          ?>
           
            <h2>Update Image </h2>
               
          <?php }else{ 
                  
                  $title='';
                  $image_link='';
                  $image_name='';
          
          ?>
          <h2>Add Image </h2>
          <?php } ?>
            
            <br/>
            <div id="poststuff">
              <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                  <form method="post" action="" id="addimage" name="addimage" enctype="multipart/form-data" >
                
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label for="link_name">Image Title (<span style="font-size: 11px;font-weight: normal"><?php _e('Used into lightbox'); ?></span>)</label></h3>
                        <div class="inside">
                            <input type="text" id="imagetitle"  tabindex="1" size="30" name="imagetitle" value="<?php echo $title;?>">
                             <div style="clear:both"></div>
                             <div></div>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label for="link_name">Image Url (<span style="font-size: 11px;font-weight: normal"><?php _e(' On click redirect to this url.Used in lightbox for image title'); ?></span>)</label></h3>
                        <div class="inside">
                            <input type="text" id="imageurl" class="url"  tabindex="1" size="30" name="imageurl" value="<?php echo $image_link; ?>">
                             <div style="clear:both"></div>
                             <div></div>
                             <div style="clear:both"></div>
                         </div>
                      </div>
                      <div class="stuffbox" id="namediv" style="min-width:550px;">
                         <h3><label for="link_name">Upload Image</label></h3>
                        <div class="inside" id="fileuploaddiv">
                              <?php if($image_name!=""){ ?>
                                    <div><b>Current Image : </b><a id="currImg" href="<?php echo $url;?>imagestoscroll/<?php echo $image_name; ?>" target="_new"><?php echo $image_name; ?></a></div>
                              <?php } ?>      
                             <input type="file" name="image_name" onchange="reloadfileupload();"  id="image_name" size="30" />
                             <div style="clear:both"></div>
                             <div></div>
                         </div>
                       </div>
                        <?php if(isset($_GET['id']) and $_GET['id']>0){ ?> 
                           <input type="hidden" name="imageid" id="imageid" value="<?php echo $_GET['id'];?>">
                        <?php
                        } 
                        ?>
                       <input type="submit" onclick="return validateFile();" name="btnsave" id="btnsave" value="Save Changes" class="button-primary">&nbsp;&nbsp;<input type="button" name="cancle" id="cancle" value="Cancel" class="button-primary" onclick="location.href='admin.php?page=thumbnail_slider_with_lightbox_image_management'">
                                  
                 </form> 
                  <script type="text/javascript">
                  
                     var $n = jQuery.noConflict();  
                     $n(document).ready(function() {
                     
                        $n("#addimage").validate({
                            rules: {
                                    imagetitle: {
                                      maxlength: 200
                                    },imageurl: {
                                      url:true,  
                                      maxlength: 500
                                    },
                                    image_name:{
                                      isimage:true  
                                    }
                               },
                                 errorClass: "image_error",
                                 errorPlacement: function(error, element) {
                                 error.appendTo( element.next().next().next());
                             } 
                             

                        })
                    });
                  
                  function validateFile(){
                     
                     var $n = jQuery.noConflict();   
                     if($n('#currImg').length>0){
                         return true;
                     }
                        var fragment = $n("#image_name").val();
                        var filename = $n("#image_name").val().replace(/.+[\\\/]/, "");  
                        var imageid=$n("#image_name").val();
                        
                        if(imageid==""){
                        
                            if(filename!="")
                             return true;
                            else
                            {
                                $n("#err_daynamic").remove();
                                $n("#image_name").after('<label class="image_error" id="err_daynamic">Please select file.</label>');
                                return false;  
                            } 
                        }
                       else{
                           return true;
                       }      
                  }
                  function reloadfileupload(){
    
                                var $n = jQuery.noConflict();  
                                var fragment = $n("#image_name").val();
                                var filename = $n("#image_name").val().replace(/.+[\\\/]/, "");
                                var validExtensions=new Array();
                                validExtensions[0]='jpg';
                                validExtensions[1]='jpeg';
                                validExtensions[2]='png';
                                validExtensions[3]='gif';
                                validExtensions[4]='bmp';
                                validExtensions[5]='tif';
                                
                                var extension = filename.substr( (filename.lastIndexOf('.') +1) ).toLowerCase();
                                
                                var inarr=parseInt($n.inArray( extension, validExtensions));
                                
                                if(inarr<0){
                                 
                                  $n("#err_daynamic").remove();
                                  $n('#fileuploaddiv').html($n('#fileuploaddiv').html());   
                                  $n("#image_name").after('<label class="image_error" id="err_daynamic">Invalid file extension</label>');
                                 
                                }
                               else{
                                   $n("#err_daynamic").remove();
                                 
                               } 

                       
                    }  
                </script> 

                </div>
          </div>
        </div>  
     </div>      
         </div>
      
     
    <?php 
    } 
  }  
       
  else if(strtolower($action)==strtolower('delete')){
  
        $location='admin.php?page=thumbnail_slider_with_lightbox_image_management';
        $deleteId=(int)$_GET['id'];
                
                try{
                         
                    
                        $query="SELECT * FROM ".$wpdb->prefix."slider_plus_lightbox WHERE id=$deleteId";
                        $myrow  = $wpdb->get_row($query);
                                    
                        if(is_object($myrow)){
                            
                            $image_name=stripslashes($myrow->image_name);
                            $wpcurrentdir=dirname(__FILE__);
                            $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                            $imagename=$_FILES["image_name"]["name"];
                            $imagetoDel=$wpcurrentdir.'/imagestoscroll/'.$image_name;
                            @unlink($imagetoDel);
                                        
                             $query = "delete from  ".$wpdb->prefix."slider_plus_lightbox where id=$deleteId";
                             $wpdb->query($query); 
                           
                             $slider_with_lightbox_messages=array();
                             $slider_with_lightbox_messages['type']='succ';
                             $slider_with_lightbox_messages['message']='Image deleted successfully.';
                             update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);
                        }    

     
                 }
               catch(Exception $e){
               
                      $slider_with_lightbox_messages=array();
                      $slider_with_lightbox_messages['type']='err';
                      $slider_with_lightbox_messages['message']='Error while deleting image.';
                      update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);
                }  
                          
          echo "<script type='text/javascript'> location.href='$location';</script>";
              
  }  
  else if(strtolower($action)==strtolower('deleteselected')){
  
           $location='admin.php?page=thumbnail_slider_with_lightbox_image_management'; 
          if(isset($_POST) and isset($_POST['deleteselected']) and  ( $_POST['action']=='delete' or $_POST['action_upper']=='delete')){
          
                if(sizeof($_POST['thumbnails']) >0){
                
                        $deleteto=$_POST['thumbnails'];
                        $implode=implode(',',$deleteto);   
                        
                        try{
                                
                               foreach($deleteto as $img){ 
                                   
                                    $query="SELECT * FROM ".$wpdb->prefix."slider_plus_lightbox WHERE id=$img";
                                    $myrow  = $wpdb->get_row($query);
                                    
                                    if(is_object($myrow)){
                                        
                                        $image_name=stripslashes($myrow->image_name);
                                        $wpcurrentdir=dirname(__FILE__);
                                        $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                                        $imagename=$_FILES["image_name"]["name"];
                                        $imagetoDel=$wpcurrentdir.'/imagestoscroll/'.$image_name;
                                        @unlink($imagetoDel);
                                        $query = "delete from  ".$wpdb->prefix."slider_plus_lightbox where id=$img";
                                        $wpdb->query($query); 
                                   
                                        $slider_with_lightbox_messages=array();
                                        $slider_with_lightbox_messages['type']='succ';
                                        $slider_with_lightbox_messages['message']='selected images deleted successfully.';
                                        update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);
                                   }
                                  
                             }
             
                         }
                       catch(Exception $e){
                       
                              $slider_with_lightbox_messages=array();
                              $slider_with_lightbox_messages['type']='err';
                              $slider_with_lightbox_messages['message']='Error while deleting image.';
                              update_option('slider_with_lightbox_messages', $slider_with_lightbox_messages);
                        }  
                              
                       echo "<script type='text/javascript'> location.href='$location';</script>";
                
                
                }
                else{
                
                    echo "<script type='text/javascript'> location.href='$location';</script>";   
                }
            
           }
           else{
           
                echo "<script type='text/javascript'> location.href='$location';</script>";      
           }
     
      }      
   } 
   function thumbnail_slider_with_lightbox_admin_preview_func(){
       
       $settings=get_option('slider_plus_lightbox_settings');
       if(isset($_SERVER['HTTP_USER_AGENT'])){
            
            preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
            if (count($matches)>1){
                
              //Then we're using IE
              $version = $matches[1];

              switch(true){
                case ($version<=8):
                  $is_ie_8_or_ie_7=true;
                  break;

                case ($version==9):
                  //IE9!
                  break;

                default:
            
              }
            }
        }
       
 ?>      
   <div style="width: 100%;">  
        <div style="float:left;width:69%;">
            <div class="wrap">
                    <h2>Slider Preview</h2>
            <br>
            <div id="poststuff">
              <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                     <div style="clear: both;"></div>
                    <?php $url = plugin_dir_url(__FILE__);  ?>
                    <table class="mainTable"  style="background:<?php echo $settings['scollerBackground'];?>">
                      <tr>
                        <?php if($settings['auto']==false){?>
                            <td class="arrowleft">
                             <!--<img class="prev previmg" src="<?php echo $url;?>images/image_left.png" class="imageleft" />-->
                              <div class="prev previmg"></div>
                            </td>
                         <?php } ?>   
                         <td id="mainscollertd" style="visibility: hidden;background:<?php echo $settings['scollerBackground'];?>">
                            <div class="mainSliderDiv">
                                <ul class="sliderUl">
                                  <?php
                                      global $wpdb;
                                      $imageheight=$settings['imageheight'];
                                      $imagewidth=$settings['imagewidth'];
                                      $query="SELECT * FROM ".$wpdb->prefix."slider_plus_lightbox order by createdon desc";
                                      $rows=$wpdb->get_results($query,'ARRAY_A');
                                    
                                    if(count($rows) > 0){
                                        foreach($rows as $row){
                                            
                                            $wpcurrentdir=dirname(__FILE__);
                                            $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                                            $imagename=$row['image_name'];
                                            $imageUploadTo=$wpcurrentdir.'/imagestoscroll/'.$imagename;
                                            $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                                            $pathinfo=pathinfo($imageUploadTo);
                                            $filenamewithoutextension=$pathinfo['filename'];
                                            $outputimg="";
                                            
                                            $outputimgmain = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name']; 
                                            if($settings['resizeImages']==0){
                                                
                                               $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name']; 
                                               
                                            }
                                            else{
                                                    $imagetoCheck=$wpcurrentdir.'/imagestoscroll/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                    
                                                    if(file_exists($imagetoCheck)){
                                                        $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                    }
                                                   else{
                                                         
                                                         if(function_exists('wp_get_image_editor')){
                                                                
                                                                $image = wp_get_image_editor($wpcurrentdir."/imagestoscroll/".$row['image_name']); 
                                                                
                                                                if ( ! is_wp_error( $image ) ) {
                                                                    $image->resize( $imagewidth, $imageheight, true );
                                                                    $image->save( $imagetoCheck );
                                                                    $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                                }
                                                               else{
                                                                     $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name'];
                                                               }     
                                                            
                                                          }
                                                         else if(function_exists('image_resize')){
                                                            
                                                            $return=image_resize($wpcurrentdir."/imagestoscroll/".$row['image_name'],$imagewidth,$imageheight) ;
                                                            if ( ! is_wp_error( $return ) ) {
                                                                
                                                                  $isrenamed=rename($return,$imagetoCheck);
                                                                  if($isrenamed){
                                                                    $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];  
                                                                  }
                                                                 else{
                                                                      $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name']; 
                                                                 } 
                                                            }
                                                           else{
                                                                 $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name'];
                                                             }  
                                                         }
                                                        else{
                                                            
                                                            $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name'];
                                                        }  
                                                            
                                                          //$url = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                          
                                                   } 
                                            }
                                            
                                      $title="";
                                      $rowTitle=stripslashes($row['title']);
                                      $rowTitle=str_replace("'","’",$rowTitle); 
                                      $rowTitle=str_replace('"','”',$rowTitle); 
                                      if(trim($row['title'])!='' and trim($row['custom_link'])!=''){
                                                      
                                           $title="<a class='Imglink' target='_blank' href='{$row['custom_link']}'>{$rowTitle}</a>";
                                           
                                      }
                                      else if(trim($row['title'])!='' and trim($row['custom_link'])==''){
                                          
                                          $title="<a class='Imglink' href='#'>{$rowTitle}</a>"; 
                                         
                                      }
                                      else{
                                          
                                          if($row['title']!='')
                                             $title="<a class='Imglink' target='_blank' href='#'>{$rowTitle}</a>"; 
                                      }    
                                      
                                   ?>
                                   
                                     <li class="sliderimgLi">
                                       <a  title="<?php echo $title;?>" rel="lightbox" href="<?php echo $outputimgmain;?>">
                                         <img src="<?php echo $outputimg; ?>" alt="<?php echo $rowTitle; ?>" title="<?php echo $rowTitle;?>" <?php if($is_ie_8_or_ie_7!=true){ ?> style="width:<?php echo $settings['imagewidth']; ?>px !important;height:<?php echo $settings['imageheight']; ?>px !important" <?php }?>  />
                                      </a> 
                                     </li> 
                                   <?php
                                        }
                                    }  
                                    ?>
                                </ul>
                            </div>
                          </td>  
                          <?php if($settings['auto']==false){?>
                            <td class="arrowright"><div class="nextimg next"></div></td>
                          <?php }?>  
                        </tr> 
                    </table>        
                    <script type="text/javascript">
                     var $n = jQuery.noConflict();  
                    $n(document).ready(function() {
                        
                        
                        $n(".mainSliderDiv").jCarouselLite({
                            btnNext: ".next",
                            btnPrev: ".prev",
                            <?php if($settings['auto']){?>
                            auto: <?php echo $settings['speed']; ?>,
                            <?php } ?>
                            speed: <?php echo $settings['speed']; ?>,
                            <?php if($settings['pauseonmouseover'] and $settings['auto']){ ?>
                            hoverPause: true,
                            <?php }else{ if($settings['auto']){?>   
                             hoverPause: false,
                            <?php }} ?>
                            circular: <?php echo ($settings['circular'])? 'true':'false' ?>,
                            <?php if($settings['visible']!=""){ ?>
                              visible: <?php echo $settings['visible'].','; ?>
                            <?php } ?>
                            scroll: <?php echo $settings['scroll']; ?>
                             
                        });
                        
                           $n("#mainscollertd").css("visibility","visible")
                        
                           $n("a[rel=lightbox]").fancybox({
                                'transitionIn': 'none',
                                'transitionOut': 'none',
                                'titlePosition': 'over',
                                'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                                    
                                            
                                           if(title!=""){
                                            return '<span id="fancybox-title-over">' + title  + '</span>';
                                           }
                                           else{
                                               return '';
                                           } 
                                    
                                }
                           });
                        
                        
                    });
                    </script>      
                </div>
          </div>      
        </div>  
     </div>      
</div>
<div class="clear"></div>
</div>
<h3>To print this slider into WordPress Post/Page use bellow code</h3>
<pre class="printCode">
  [print_slider_plus_lightbox]
</pre>
<div class="clear"></div>
<h3>To print this slider into WordPress theme/template PHP files use bellow code</h3>
<pre class="printCode">
  echo do_shortcode('[print_slider_plus_lightbox]'); 
</pre>
<div class="clear"></div>
<?php       
   }
   
   function print_slider_plus_lightbox_func(){
       $settings=get_option('slider_plus_lightbox_settings');
       ob_start();
        
        $is_ie_8_or_ie_7=false;
        
        if(isset($_SERVER['HTTP_USER_AGENT'])){
            
            preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
            if (count($matches)>1){
                
              //Then we're using IE
              $version = $matches[1];

              switch(true){
                case ($version<=8):
                  $is_ie_8_or_ie_7=true;
                  break;

                case ($version==9):
                  //IE9!
                  break;

                default:
            
              }
            }
        }  
        
 ?>      
            
        <div style="clear: both;"></div>
        <?php $url = plugin_dir_url(__FILE__);  ?>
        <table class="mainTable"  style="background:<?php echo $settings['scollerBackground'];?>">
          <tr>
            <?php if($settings['auto']==false){?>
                <td class="arrowleft">
                 <!--<img class="prev previmg" src="<?php echo $url;?>images/image_left.png" class="imageleft" />-->
                  <div class="prev previmg"></div>
                </td>
             <?php } ?>   
             <td id="mainscollertd" style="visibility: hidden;background:<?php echo $settings['scollerBackground'];?>">
                <div class="mainSliderDiv">
                    <ul class="sliderUl">
                      <?php
                          global $wpdb;
                          $imageheight=$settings['imageheight'];
                          $imagewidth=$settings['imagewidth'];
                          $query="SELECT * FROM ".$wpdb->prefix."slider_plus_lightbox order by createdon desc";
                          $rows=$wpdb->get_results($query,'ARRAY_A');
                        
                        if(count($rows) > 0){
                            foreach($rows as $row){
                                
                                $wpcurrentdir=dirname(__FILE__);
                                $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
                                $imagename=$row['image_name'];
                                $imageUploadTo=$wpcurrentdir.'/imagestoscroll/'.$imagename;
                                $imageUploadTo=str_replace("\\","/",$imageUploadTo);
                                $pathinfo=pathinfo($imageUploadTo);
                                $filenamewithoutextension=$pathinfo['filename'];
                                $outputimg="";
                                
                                $outputimgmain = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name']; 
                                if($settings['resizeImages']==0){
                                    
                                   $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name']; 
                                   
                                }
                                else{
                                        $imagetoCheck=$wpcurrentdir.'/imagestoscroll/'.$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                        if(file_exists($imagetoCheck)){
                                            $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                        }
                                       else{
                                             
                                             if(function_exists('wp_get_image_editor')){
                                                 
                                                    $image = wp_get_image_editor($wpcurrentdir."imagestoscroll/".$row['image_name']); 
                                                    if ( ! is_wp_error( $image ) ) {
                                                        $image->resize( $imagewidth, $imageheight, true );
                                                        $image->save( $imagetoCheck );
                                                        $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                                    }
                                                   else{
                                                         $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name'];
                                                   }     
                                                
                                              }
                                             else if(function_exists('image_resize')){
                                                
                                                $return=image_resize($wpcurrentdir."/imagestoscroll/".$row['image_name'],$imagewidth,$imageheight) ;
                                                if ( ! is_wp_error( $return ) ) {
                                                    
                                                      $isrenamed=rename($return,$imagetoCheck);
                                                      if($isrenamed){
                                                        $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];  
                                                      }
                                                     else{
                                                          $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name']; 
                                                     } 
                                                }
                                               else{
                                                     $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name'];
                                                 }  
                                             }
                                            else{
                                                
                                                $outputimg = plugin_dir_url(__FILE__)."imagestoscroll/".$row['image_name'];
                                            }  
                                                
                                              //$url = plugin_dir_url(__FILE__)."imagestoscroll/".$filenamewithoutextension.'_'.$imageheight.'_'.$imagewidth.'.'.$pathinfo['extension'];
                                              
                                       } 
                                }
                                
                              
                              $title="";
                              $rowTitle=stripslashes($row['title']);
                              $rowTitle=str_replace("'","’",$rowTitle); 
                              $rowTitle=str_replace('"','”',$rowTitle); 
                              
                              if(trim($row['title'])!='' and trim($row['custom_link'])!=''){
                                              
                                   $title="<a class='Imglink' target='_blank' href='{$row['custom_link']}'>{$rowTitle}</a>";
                                   
                              }
                              else if(trim($row['title'])!='' and trim($row['custom_link'])==''){
                                  
                                 $title="<a class='Imglink' href='#'>{$rowTitle}</a>"; 
                                 
                              }
                              else{
                                  
                                  if($row['title']!='')
                                     $title="<a class='Imglink' target='_blank' href='#'>{$rowTitle}</a>"; 
                              }
                              
                      
                       ?>
                        <li class="sliderimgLi">
                           <a  title="<?php echo $title;?>" rel="lightbox" href="<?php echo $outputimgmain;?>">
                             <img src="<?php echo $outputimg; ?>" alt="<?php echo $rowTitle; ?>" title="<?php echo $rowTitle;?>" <?php if($is_ie_8_or_ie_7!=true){ ?> style="width:<?php echo $settings['imagewidth']; ?>px !important;height:<?php echo $settings['imageheight']; ?>px !important" <?php }?>  />
                          </a> 
                         </li> 
                         
                       <?php
                            }
                        }  
                        ?>
                    </ul>
                </div>
              </td>  
              <?php if($settings['auto']==false){?>
                <td class="arrowright"><div class="nextimg next"></div></td>
              <?php }?>  
            </tr> 
        </table>        
        <script type="text/javascript">
         var $n = jQuery.noConflict();  
        $n(document).ready(function() {
            
            
            $n(".mainSliderDiv").jCarouselLite({
                btnNext: ".next",
                btnPrev: ".prev",
                <?php if($settings['auto']){?>
                auto: <?php echo $settings['speed']; ?>,
                <?php } ?>
                speed: <?php echo $settings['speed']; ?>,
                <?php if($settings['pauseonmouseover'] and $settings['auto']){ ?>
                hoverPause: true,
                <?php }else{ if($settings['auto']){?>   
                 hoverPause: false,
                <?php }} ?>
                circular: <?php echo ($settings['circular'])? 'true':'false' ?>,
                <?php if($settings['visible']!=""){ ?>
                  visible: <?php echo $settings['visible'].','; ?>
                <?php } ?>
                scroll: <?php echo $settings['scroll']; ?>
                 
            });
            
               $n("#mainscollertd").css("visibility","visible")
            
               $n("a[rel=lightbox]").fancybox({
                    'transitionIn': 'none',
                    'transitionOut': 'none',
                    'titlePosition': 'over',
                    'titleFormat': function(title, currentArray, currentIndex, currentOpts) {
                    
                       if(title!=""){
                        return '<span id="fancybox-title-over">' + title  + '</span>';
                       }
                       else{
                           return '';
                       }
                        
                    }
               });
            
            
        });
        </script>              

<?php
       $output = ob_get_clean();
       return $output;
   }
?>