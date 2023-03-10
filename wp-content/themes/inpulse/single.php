<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage InPulse
 * @since 1.0
 * @version 1.0
 */

use WglAddons\Templates\WglBlogHero;
 
get_header();
the_post();

$sb = InPulse_Theme_Helper::render_sidebars('single');


$single_type = InPulse_Theme_Helper::get_option('single_type_layout'); 
if(empty($single_type)){
	$single_type = 2;
}

if (class_exists( 'RWMB_Loader' )) {
	$mb_type = rwmb_meta('mb_post_layout_conditional');
	if(!empty($mb_type) && $mb_type != 'default' ){
		$single_type = rwmb_meta('mb_single_type_layout');
	}
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

$column = $sb['column'];
$row_class = $sb['row_class'];
$container_class = $sb['container_class'];
$layout = $sb['layout'];

$row_class .= ' single_type-'.$single_type;

if($single_type === '3'){
	echo '<div class="post_featured_bg">';
		get_template_part('templates/post/single/post', $single_type.'_image');
	echo '</div>';
}
?>

<div class="wgl-container<?php echo apply_filters('inpulse_container_class', $container_class); ?>">
        <div class="row<?php echo apply_filters('inpulse_row_class', $row_class); ?>">
			<div id='main-content' class="wgl_col-<?php echo apply_filters('inpulse_column_class', $column); ?>">
				<?php
					get_template_part('templates/post/single/post', $single_type);



				$previousPost = get_adjacent_post(false, '', true);
				$nextPost  = get_adjacent_post(false, '', false);

				if ($nextPost || $previousPost):
					?>
					<div class="inpulse-post-navigation">
						<?php
						if(is_a( $previousPost, 'WP_Post' )){							
							$image_prev_url = wp_get_attachment_image_src(get_post_thumbnail_id($previousPost->ID), 'thumbnail');

							$img_prev_html = '';
							$class_image_prev = isset($image_prev_url[0]) && !empty($image_prev_url[0]) ? ' image_exist' : ' no_image';
							$img_prev_html .= "<span class='image_prev". esc_attr($class_image_prev)."'>";
							if(isset($image_prev_url[0]) && !empty($image_prev_url[0])){
								$img_prev_html .= "<img src='" . esc_url( $image_prev_url[0] ) . "' alt='".esc_attr( $previousPost->post_title) ."'/>";
							}else{
								$img_prev_html .= "<span class='no_image_post'></span>";
							}
							$img_prev_html .= "</span>";

							echo '<div class="prev-link_wrapper">';
								echo '<div class="info_prev-link_wrapper"><a href="' . esc_url(get_permalink($previousPost->ID)) . '" title="' . esc_attr($previousPost->post_title) . '">'.$img_prev_html.'<span class="prev-link-info_wrapper"><span class="prev_title">'.wp_kses( $previousPost->post_title, $allowed_html ).'</span><span class="meta-wrapper"><span class="date_post">'.esc_html(get_the_time(get_option( 'date_format' ), $previousPost->ID)).'</span></span></span></a></div>';
							echo '</div>';
						}
						if(is_a( $nextPost, 'WP_Post' )) {
							$image_next_url = wp_get_attachment_image_src(get_post_thumbnail_id($nextPost->ID), 'thumbnail');

							$img_next_html = '';
							$class_image_next = isset($image_next_url[0]) && !empty($image_next_url[0]) ? ' image_exist' : ' no_image';
							$img_next_html .= "<span class='image_next".esc_attr($class_image_next)."'>";
							if(isset($image_next_url[0]) && !empty($image_next_url[0])){
								$img_next_html .= "<img src='" . esc_url( $image_next_url[0] ) . "' alt='". esc_attr( $nextPost->post_title ) ."'/>";
							}else{
								$img_next_html .= "<span class='no_image_post'></span>";
							}
							$img_next_html .= "</span>";
							echo '<div class="next-link_wrapper">';
							echo '<div class="info_next-link_wrapper"><a href="' . esc_url(get_permalink($nextPost->ID)) . '" title="' . esc_attr( $nextPost->post_title ) . '"><span class="next-link-info_wrapper"><span class="next_title">'.wp_kses( $nextPost->post_title, $allowed_html ) .'</span><span class="meta-wrapper"><span class="date_post">'.esc_html(get_the_time(get_option( 'date_format' ), $nextPost->ID)).'</span></span></span>'.$img_next_html.'</a></div>';
							echo '</div>';
						}
						if(is_a( $previousPost, 'WP_Post' ) || is_a( $nextPost, 'WP_Post' )){
							echo '<a class="back-nav_page" href="#" onclick="location.href = document.referrer; return false;">';
								echo '<span></span>';
								echo '<span></span>';
								echo '<span></span>';
								echo '<span></span>';
							echo '</a>';
						}	
						?>
					</div>
					<?php
				endif;

				$show_post_related = InPulse_Theme_Helper::get_option('single_related_posts');

				if (class_exists( 'RWMB_Loader' )) {
					$mb_blog_show_r = rwmb_meta('mb_blog_show_r');
					if(!empty($mb_blog_show_r) && $mb_blog_show_r != 'default' ){
						$show_post_related = $mb_blog_show_r === 'off' ? null : $mb_blog_show_r;
					}
				}


				
				if ( (bool)$show_post_related && class_exists('InPulse_Core') && class_exists('\Elementor\Plugin')) : ?>
					<?php
 
					$mb_blog_carousel_r = $mb_blog_column_r = $mb_blog_number_r = $mb_blog_title_r ='';
					$mb_blog_cat_r = array();


					$mb_blog_carousel_r 	  = InPulse_Theme_Helper::options_compare('blog_carousel_r', 'mb_blog_show_r', 'custom');
					$mb_blog_title_r 	  	  = InPulse_Theme_Helper::options_compare('blog_title_r', 'mb_blog_show_r', 'custom');

					$cats = InPulse_Theme_Helper::get_option('blog_cat_r');
					if(!empty($cats)){
						$mb_blog_cat_r[] = implode(",", $cats);
					}
					

					if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
						if(rwmb_meta('mb_blog_show_r') == 'custom'){
							$mb_blog_cat_r    = get_post_meta(get_the_id(), 'mb_blog_cat_r');
						}
					}
					
					$mb_blog_column_r 	  	  = InPulse_Theme_Helper::options_compare('blog_column_r', 'mb_blog_show_r', 'custom');
					$mb_blog_number_r 	      = InPulse_Theme_Helper::options_compare('blog_number_r', 'mb_blog_show_r', 'custom');
		    
					?>

					<div class='single related_posts'>
					<?php
						// Related Posts
						// Get Cats_Slug
						$categories = $post_category_compile = '';
						if (get_the_category()) $categories = get_the_category();
						
						if ($categories) {
							$post_categ = '';
							foreach ($categories as $category) {
								$post_categ = $post_categ . $category->slug . ',';
							}
							$post_category_compile .= '' . trim($post_categ, ',') . '';
							
							if(!empty($mb_blog_cat_r[0])){
								$categories = get_categories( array( 'include' => $mb_blog_cat_r[0]  ) ); 
								$post_categ = $post_category_compile = '';
								foreach ($categories as $category) {
									$post_categ = $post_categ . $category->slug . ',';
								}
								$post_category_compile .= '' . trim($post_categ, ',') . '';
							}

							$mb_blog_cat_r = $post_category_compile;
						}
						echo '<div class="inpulse_module_title"><h4>'.(!empty($mb_blog_title_r) ? esc_html($mb_blog_title_r) : esc_html__('Related Posts', 'inpulse')) .' </h4></div>';

						$atts = array();
						$atts['blog_navigation'] 		= 'none';
						$atts['use_navigation']  		= null;
						$atts['blog_layout']     		= !empty($mb_blog_carousel_r) ? 'carousel' : 'grid';
						$atts['hide_share']      		= true;
						$atts['hide_content']    		= null;
						$atts['hide_likes']      		= true;
						$atts['meta_author']      		= true;
						$atts['meta_comments']      	= true;
						$atts['read_more_hide'] 		= true;
						$atts['read_more_text'] 		= esc_html__('Read More', 'inpulse');
						$atts['heading_tag'] 			= 'h4';
						$atts['content_letter_count'] 	= 130;
						$atts['crop_square_img'] 		= 1;
						$atts['items_load'] 			= 4;
						$atts['name_load_more'] 		= esc_html__('Load More','inpulse');
						$atts['blog_columns'] 			= !empty($mb_blog_column_r) ? $mb_blog_column_r : (($layout == "none") ? "4" : "6"); 
						$atts['autoplay'] 				= null; 
						$atts['autoplay_speed'] 		= 3000; 
						$atts['use_pagination'] 		= null; 
						$atts['pag_type'] 				= 'circle'; 
						$atts['pag_offset'] 			= ''; 
						$atts['custom_resp'] 			= true; 
						$atts['resp_medium'] 			= null; 
						$atts['pag_color'] 				= null; 
						$atts['custom_pag_color'] 		= null; 
						$atts['resp_tablets_slides'] 	= null; 
						$atts['resp_tablets'] 			= null; 
						$atts['resp_medium_slides'] 	= null; 
						$atts['resp_mobile'] 			= '767'; 
						$atts['resp_mobile_slides'] 	= '1'; 
						$atts['number_of_posts'] 		= (int) $mb_blog_number_r; 
						$atts['categories'] 	    	= $mb_blog_cat_r; 
						$atts['order_by'] 	    		= 'rand'; 

						$related_items = new WglBlogHero();
        				echo InPulse_Theme_Helper::render_html($related_items->render($atts));
						?>
					</div>
					<?php
				endif;
				if (comments_open() || get_comments_number()) {?>
					<div class="row">
						<div class="wgl_col-12">
							<?php comments_template(); ?>
						</div>
					</div>
				<?php } ?>
			</div>	
			<?php
				echo (isset($sb['content']) && !empty($sb['content']) ) ? $sb['content'] : '';
			?>
		</div>

</div>

<?php
	get_footer();
?>