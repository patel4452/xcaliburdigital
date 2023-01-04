"use strict";

is_visible_init ();
inpulse_slick_navigation_init();

jQuery(document).ready(function($) {
	inpulse_split_slider();
	inpulse_sticky_init();
	inpulse_search_init();
	inpulse_side_panel_init();
	inpulse_mobile_header();
	inpulse_woocommerce_helper();
	inpulse_woocommerce_login_in();
	inpulse_init_timeline_appear();
	inpulse_accordion_init();
	inpulse_striped_services_init();
	inpulse_progress_bars_init();
	inpulse_carousel_slick();
	inpulse_image_comparison();
	inpulse_counter_init();
	inpulse_countdown_init ();
	inpulse_circuit_services();
	inpulse_circuit_services_resize();
	inpulse_img_layers();
	inpulse_page_title_parallax();
	inpulse_extended_parallax();
	inpulse_portfolio_parallax();
	inpulse_message_anim_init();
	inpulse_scroll_up();
	inpulse_link_scroll();
	inpulse_skrollr_init();
	inpulse_sticky_sidebar ();
	inpulse_videobox_init ();
	inpulse_parallax_video();
	inpulse_tabs_init();
	inpulse_select_wrap();
	jQuery( '.wgl_module_title .carousel_arrows' ).inpulse_slick_navigation();
	jQuery( '.wgl-products > .carousel_arrows' ).inpulse_slick_navigation();
	jQuery( '.inpulse_module_custom_image_cats > .carousel_arrows' ).inpulse_slick_navigation();
	inpulse_scroll_animation();
	inpulse_woocommerce_mini_cart();
	inpulse_text_background();
	inpulse_dynamic_styles();
});

jQuery(window).load(function() {
	inpulse_isotope();
	inpulse_blog_masonry_init();
	setTimeout(function(){
		jQuery('#preloader-wrapper').fadeOut();
	},1100);
	particles_custom();

	inpulse_menu_lavalamp();
	jQuery(".wgl-currency-stripe_scrolling").each(function(){
    	jQuery(this).simplemarquee({
	        speed: 40,
	        space: 0,
	        handleHover: true,
	        handleResize: true
	    });
    })
});
