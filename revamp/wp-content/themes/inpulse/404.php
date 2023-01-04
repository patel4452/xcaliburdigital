<?php
/**
 * The template for displaying 404 page
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package    WordPress
 * @subpackage InPulse
 * @since      1.0
 * @version    1.0
 */
get_header();

$styles = '';
$bg_render = InPulse_Theme_Helper::bg_render('404_page_main');
$main_bg_color = InPulse_Theme_Helper::get_option('404_page_main_bg_image')['background-color'];

$styles .= !empty($main_bg_color) ? 'background-color:'.$main_bg_color.';' : '';
$styles .= !empty($bg_render) ? $bg_render : '';
?>
	<div class="wgl-container full-width">
		<div class="row">
			<div class="wgl_col-12">
				<section class="page_404_wrapper"<?php echo (!empty($styles) ? ' style="'.esc_attr($styles).'"' : '');?>>
					<div class="page_404_wrapper-container">
						<div class="row">
							<div class="wgl_col-12 wgl_col-md-12">
								<div class="main_404-wrapper">
									<div class="banner_404"><img src="<?php echo esc_url(get_template_directory_uri() . "/img/404.png"); ?>" alt="<?php echo esc_attr__('404','inpulse'); ?>"></div>
									<h2 class="banner_404_title"><?php echo esc_html__( 'Sorry We Can\'t Find That Page!', 'inpulse' ); ?></h2>
									<p class="banner_404_text"><?php echo esc_html__( 'The page you are looking for was moved, removed, renamed or never existed.', 'inpulse' ); ?></p>
									<div class="inpulse_404_search">
										<?php get_search_form(); ?>
									</div>
									<div class="inpulse_404_button inpulse_module_button wgl_button wgl_button-l wgl_button-icon_right btn-gradient">
										<a class="wgl_button_link" href="<?php echo esc_url(home_url('/')); ?>"><span><?php esc_html_e( 'Take Me Home', 'inpulse' ); ?></span></a>
									</div>									
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
<?php get_footer(); ?>