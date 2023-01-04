<?php
global $wgl_blog_atts;

// Default settings for blog item
$trim = true;
if ( !(bool)$wgl_blog_atts ) {
    $opt_likes = InPulse_Theme_Helper::get_option('blog_list_likes');
    $opt_share = InPulse_Theme_Helper::get_option('blog_list_share');
    $opt_meta = InPulse_Theme_Helper::get_option('blog_list_meta');
    $opt_meta_author = InPulse_Theme_Helper::get_option('blog_list_meta_author');
    $opt_meta_comments = InPulse_Theme_Helper::get_option('blog_list_meta_comments');
    $opt_meta_categories = InPulse_Theme_Helper::get_option('blog_list_meta_categories');
    $opt_meta_date = InPulse_Theme_Helper::get_option('blog_list_meta_date');
    $opt_read_more = InPulse_Theme_Helper::get_option('blog_list_read_more');
    $opt_hide_media = InPulse_Theme_Helper::get_option('blog_list_hide_media');
    $opt_hide_title = InPulse_Theme_Helper::get_option('blog_list_hide_title');
    $opt_hide_content = InPulse_Theme_Helper::get_option('blog_list_hide_content');
    $opt_letter_count = InPulse_Theme_Helper::get_option('blog_list_letter_count');
    $opt_blog_columns = InPulse_Theme_Helper::get_option('blog_list_columns');
    $opt_blog_columns = empty($opt_blog_columns) ? '12' : $opt_blog_columns;

    global $wp_query;
    $wgl_blog_atts = array(
        'query' => $wp_query,
        // General
        'blog_layout' => 'grid',
        // Content
        'blog_columns' => $opt_blog_columns,
        'hide_media' => $opt_hide_media,
        'hide_content' => $opt_hide_content,
        'hide_blog_title' => $opt_hide_title,
        'hide_postmeta' => $opt_meta,
        'meta_author' => $opt_meta_author,
        'meta_comments' => $opt_meta_comments,
        'meta_categories' => $opt_meta_categories,
        'meta_date' => $opt_meta_date,
        'hide_likes' => !(bool)$opt_likes,
        'hide_share' => !(bool)$opt_share,
        'read_more_hide' => $opt_read_more,
        'content_letter_count' => empty($opt_letter_count) ? '85' : $opt_letter_count,
        'crop_square_img' => 'true',
        'heading_tag' => 'h3',
        'read_more_text' => esc_html__('Read More', 'inpulse'),
        'items_load'  => 4,
        'heading_margin_bottom' => '16px',

    );
    $trim = false;
}

extract($wgl_blog_atts);

if ((bool)$crop_square_img) {
    $image_size = 'inpulse-840-620';
}else {
     $image_size = 'full';
}

if($blog_columns === '12'){
    $image_size = 'full';
}

global $wgl_query_vars;
if(!empty($wgl_query_vars)){
    $query = $wgl_query_vars;
}

// Allowed HTML render
$allowed_html = array(
    'a' => array(
        'href' => true,
        'title' => true,
    ),
    'br' => array(),
    'b' => array(),
    'em' => array(),
    'strong' => array()
); 

$blog_styles = '';

$blog_attr = !empty($blog_styles) ? ' style="'.esc_attr($blog_styles).'"' : '';

$heading_attr = isset($heading_margin_bottom) && $heading_margin_bottom != '' ? ' style="margin-bottom: '.(int) $heading_margin_bottom.'px"' : '';
while ($query->have_posts()) : $query->the_post();          

    echo '<div class="wgl_col-'.esc_attr($blog_columns).' item">';

    $single = InPulse_SinglePost::getInstance();
    $single->set_data();

    $title = get_the_title();

    $blog_item_classes = ' format-'.$single->get_pf();
    $blog_item_classes .= (bool)$hide_media ? ' hide_media' : '';
    $blog_item_classes .= is_sticky() ? ' sticky-post' : '';

    $single->set_data_image(true, $image_size,$aq_image = true);
    $has_media = $single->meta_info_render;

    if((bool)$hide_media){
        $has_media = false;
    }
    
    $blog_item_classes .= !(bool) $has_media ? ' format-no_featured' : '';

    $meta_to_show = array(
        'comments' => !(bool)$meta_comments,
        'author' => !(bool)$meta_author,
        'date' => !(bool)$meta_date,
    );    
    $meta_to_show_cats = array(
        'category' => !(bool)$meta_categories,
    );

    ?>

    <div class="blog-post <?php echo esc_attr($blog_item_classes); ?>"<?php echo InPulse_Theme_Helper::render_html($blog_attr);?>>
        <div class="blog-post_wrapper">

            <?php

            // Media blog post
            if ( !(bool)$hide_media ) {
                $link_feature = true;
                $single->render_featured($link_feature, $image_size, $aq_image = true);
            }            

            ?>
            <div class="blog-post_content">
            <?php         
                if ( !(bool)$hide_postmeta && !empty($meta_to_show_cats) ) {
                    echo '<div class="blog-post_cats">';
                        $single->render_post_meta($meta_to_show_cats);
                    echo '</div>';
                }     

                // Blog Title
                if ( !(bool)$hide_blog_title && !empty($title) ) :
                    echo sprintf('<%1$s class="blog-post_title"%2$s><a href="%3$s">%4$s</a></%1$s>', esc_html($heading_tag), $heading_attr, esc_url(get_permalink()), wp_kses( $title, $allowed_html ) );
                endif;


                 if (  !(bool)$hide_likes) echo '<div class="blog-post_meta-wrap">';
                //Post Meta render comments,author
                if ( !(bool)$hide_postmeta ) {
                    $single->render_post_meta($meta_to_show);
                }  


                if ( !(bool)$hide_likes ) : ?>
                
                <div class="blog-post_likes-wrap">
                    <?php
                    if ( !(bool)$hide_likes && function_exists('wgl_simple_likes')) {
                        echo wgl_simple_likes()->likes_button( get_the_ID(), 0 );
                    } 
                    ?>
                </div> 
                <?php
                endif;    

                if ( !(bool)$hide_likes ): ?> 
                    </div>   
                    <?php
                endif;

                // Content Blog
                if ( !(bool)$hide_content ) $single->render_excerpt($content_letter_count, $trim, !(bool)$read_more_hide, $read_more_text);
                
                ?>

                <div class='blog-post_meta-desc'>  
                    <?php
                        // Read more link
                        if ( !(bool)$read_more_hide ) :
                            ?>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="button-read-more"><?php echo esc_html($read_more_text); ?></a> 
                       <?php
                        endif;

                        if ( !(bool)$hide_share ) echo '<div class="blog-post_meta-wrap">';

                        echo "<div class='divider_post_info'></div>";

                        // Likes in blog
                        if ( !(bool)$hide_share ) echo '<div class="blog-post_info-wrap">';
                     

                        // Render shares
                        if ( !(bool)$hide_share && function_exists('wgl_theme_helper') ) : 
                            echo wgl_theme_helper()->render_post_list_share();
                        endif;                        

                        if ( !(bool)$hide_share ): ?> 
                            </div>   
                            </div>   
                        <?php
                        endif;   

                    ?>
                </div>

                <?php
                
                wp_link_pages(array('before' => '<div class="page-link">' . esc_html__('Pages', 'inpulse') . ': ', 'after' => '</div>'));
                ?>
            </div>
        </div>
    </div>
    <?php

    echo '</div>';

endwhile;
wp_reset_postdata();
