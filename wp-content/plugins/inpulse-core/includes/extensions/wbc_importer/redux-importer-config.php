<?php
/*
* @package     WBC_Importer - Extension for Importing demo content
* @author      Webcreations907
* @version     1.0
*/

// function for adding menu and rev slider to demo content
if ( !function_exists( 'wbc_extended_example' ) ) {
     function wbc_extended_example( $demo_active_import , $demo_directory_path ) {

        reset( $demo_active_import );
        $current_key = key( $demo_active_import );

        /************************************************************************
        * Import slider(s) for the current demo being imported
        *************************************************************************/
        if ( class_exists( 'RevSlider' ) ) {
          $wbc_sliders_array = array(
              'demo' => array(
                '1' => 'home1.zip',
                '2' => 'home2.zip'
              ) //Set slider zip name 
           );
           if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_sliders_array ) ) {
              $wbc_slider_import = $wbc_sliders_array[$demo_active_import[$current_key]['directory']];
              if (is_array ( $wbc_slider_import )) {
                $sliders = array();
                foreach ( $wbc_slider_import as $key => $value ) {
                  if ( file_exists( $demo_directory_path.$value ) ) {
                    $slider[$key] = new RevSlider();
                    $slider[$key]->importSliderFromPost( true, true, $demo_directory_path.$value );
                  }
                }
              } else {
                if ( file_exists( $demo_directory_path.$wbc_slider_import ) ) {
                   $slider = new RevSlider();
                   $slider->importSliderFromPost( true, true, $demo_directory_path.$wbc_slider_import );
                }
              }
           }
        }
        /************************************************************************
        * Setting Menus
        *************************************************************************/
        // If it's demo1 - demo6
        $wbc_menu_array = array(
           'demo' => 'main' 
        );

        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_menu_array ) ) {
           $top_menu = get_term_by( 'name', $wbc_menu_array[$demo_active_import[$current_key]['directory']], 'nav_menu' );
           if ( isset( $top_menu->term_id ) ) {
              set_theme_mod( 'nav_menu_locations', array(
                    'main_menu' => $top_menu->term_id,
                 )
              );
           }
        }
        /************************************************************************
        * Set HomePage
        *************************************************************************/
        // array of demos/homepages to check/select from
        $wbc_home_pages = array(
           'demo' => 'Home 1',
        );
        if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] ) && array_key_exists( $demo_active_import[$current_key]['directory'], $wbc_home_pages ) ) {
           $page = get_page_by_title( $wbc_home_pages[$demo_active_import[$current_key]['directory']] );
           if ( isset( $page->ID ) ) {
              update_option( 'page_on_front', $page->ID );
              update_option( 'show_on_front', 'page' );
           }
        }

        $cpt_support = get_option( 'elementor_cpt_support' );
    
        if( ! $cpt_support ) {
            $cpt_support = [ 'page', 'post', 'portfolio', 'team', 'footer', 'side_panel' ];
            update_option( 'elementor_cpt_support', $cpt_support );
        }
        
        else if( ! in_array( 'portfolio', $cpt_support ) ) {
            $cpt_support[] = 'portfolio'; 
            update_option( 'elementor_cpt_support', $cpt_support ); 
        }  
        else if( ! in_array( 'team', $cpt_support ) ) {
            $cpt_support[] = 'team'; 
            update_option( 'elementor_cpt_support', $cpt_support ); 
        }  
        else if( ! in_array( 'footer', $cpt_support ) ) {
            $cpt_support[] = 'footer'; 
            update_option( 'elementor_cpt_support', $cpt_support ); 
        }  
        else if( ! in_array( 'side_panel', $cpt_support ) ) {
            $cpt_support[] = 'side_panel'; 
            update_option( 'elementor_cpt_support', $cpt_support ); 
        }
    
        //Add Wgl Default Container Width 
        update_option( 'elementor_container_width', 1170 );
     }
     
     // Uncomment the below
     add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );

  }
?>
