<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglBlog;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wgl_Blog extends Widget_Base {
    
    public function get_name() {
        return 'wgl-blog';
    }

    public function get_title() {
        return esc_html__('Wgl Blog', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-blog';
    }

    public function get_script_depends() {
        return [
            'slick',
            'jarallax',
            'jarallax-video',
            'imagesloaded',
            'isotope',
            'wgl-elementor-extensions-widgets',
        ];
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    // Adding the controls fields for the premium title
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        $theme_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-custom-color'));
        $theme_secondary_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-secondary-color'));
        $main_font_color = esc_attr(\InPulse_Theme_Helper::get_option('main-font')['color']);
        $header_font_color = esc_attr(\InPulse_Theme_Helper::get_option('header-font')['color']);

        /* Start General Settings Section */
        $this->start_controls_section('wgl_blog_section',
            array(
                'label'         => esc_html__('Settings', 'inpulse-core'),
            )
        );
        
        /*Title Text*/ 
        $this->add_control('blog_title',
            array(
                'label'         => esc_html__('Title', 'inpulse-core'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'dynamic'       => [ 'active' => true ]
            )
        ); 

        $this->add_control('blog_subtitle',
            array(
                'label'         => esc_html__('Sub Title', 'inpulse-core'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'dynamic'       => [ 'active' => true ]
            )
        );

        $this->add_control(
            'blog_columns',
            array(
                'label'          => esc_html__( 'Grid Columns Amount', 'inpulse-core' ),
                'type'           => Controls_Manager::SELECT,
                
                'options'        => array(
                    '12' => esc_html__( 'One', 'inpulse-core' ),
                    '6'  => esc_html__( 'Two', 'inpulse-core' ),
                    '4'  => esc_html__( 'Three', 'inpulse-core' ),
                    '3'  =>esc_html__( 'Four', 'inpulse-core' ) 
                ),
                'default'        => '12',
                'tablet_default' => 'inherit',
                'mobile_default' => '1',
                'frontend_available' => true,
                'label_block'  => true,
            )
        );
        
        $this->add_control('blog_layout',
            array(
                'label'         => esc_html__( 'Layout', 'inpulse-core' ),
                'type'          => 'wgl-radio-image',
                'options'       => [
                    'grid'      => [
                        'title'=> esc_html__( 'Grid', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/layout_grid.png',
                    ],
                    'masonry'    => [
                        'title'=> esc_html__( 'Masonry', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/layout_masonry.png',
                    ],
                    'carousel'     => [
                        'title'=> esc_html__( 'Carousel', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/layout_carousel.png',
                    ],
                ],
                'default'       => 'grid',            )
        );     

        $this->add_control('blog_navigation',
            array(
                'label'             => esc_html__('Navigation Type', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'none'          => esc_html__('None', 'inpulse-core'),
                    'pagination'    => esc_html__('Pagination', 'inpulse-core'),
                    'load_more'     => esc_html__('Load More', 'inpulse-core'), 
                ],
                'default'           => 'none',
                'condition'     => [
                    'blog_layout'   => array('grid', 'masonry')
                ]
            )
        );         

        $this->add_control('blog_navigation_align',
            array(
                'label'             => esc_html__('Navigation\'s Alignment', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'left'          => esc_html__('Left', 'inpulse-core'),
                    'center'        => esc_html__('Center', 'inpulse-core'),
                    'right'         => esc_html__('Right', 'inpulse-core'), 
                ],
                'default'           => 'left',
                'condition'         => [
                    'blog_navigation'   => 'pagination'
                ]
            )
        );   

        $this->add_control(
            'spacer_navigation',
            array(
                'label' => esc_html__( 'Navigation Spacer Top', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 200,
                    ],
                ],
                'size_units' => [ 'px', 'em', 'rem', 'vw' ],
                'condition'     => [
                    'blog_navigation'   => 'pagination',
                    'blog_layout'   => array('grid', 'masonry')
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '-20',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            )
        );
        
        $this->add_control('items_load', 
            array(
                'label'         => esc_html__('Items to be loaded', 'inpulse-core'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('4','inpulse-core'),
                'condition'     => [
                    'blog_navigation'   => 'load_more',
                    'blog_layout'   => array('grid', 'masonry')
                ]
            )
        );        

        $this->add_control('name_load_more', 
            array(
                'label'         => esc_html__('Button Text', 'inpulse-core'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Load More','inpulse-core'),
                'condition'     => [
                    'blog_navigation'   => 'load_more',
                    'blog_layout'   => array('grid', 'masonry')
                ]
            )
        );

        $this->add_control(
            'spacer_load_more',
            array(
                'label' => esc_html__( 'Button Spacer Top', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 200,
                    ],
                ],
                'size_units' => [ 'px', 'em', 'rem', 'vw' ],
                'condition'     => [
                    'blog_navigation'   => 'load_more',
                    'blog_layout'   => array('grid', 'masonry')
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '20',
                ],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            )
        );
        
        /*End General Settings Section*/
        $this->end_controls_section();    

        $this->start_controls_section(
            'display_section',
            array(
                'label' => esc_html__('Display', 'inpulse-core' ),
            )
        );

        $this->add_control(
            'hide_media',
            array(
                'label'        => esc_html__('Hide Media?','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );        

        $this->add_control(
            'hide_blog_title',
            array(
                'label'        => esc_html__('Hide Title?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );        

        $this->add_control(
            'hide_content',
            array(
                'label'        => esc_html__('Hide Content?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );
        
        $this->add_control(
            'hide_postmeta',
            array(
                'label'        => esc_html__('Hide all post-meta?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );        

        $this->add_control(
            'meta_author',
            array(
                'label'        => esc_html__('Hide post-meta author?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'     => [
                    'hide_postmeta!'   => 'yes',
                ],
                'default'      => 'yes'
            )
        );        

        $this->add_control(
            'meta_comments',
            array(
                'label'        => esc_html__('Hide post-meta comments?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'     => [
                    'hide_postmeta!'   => 'yes',
                ],
                'default'      => 'yes'
            )
        );        

        $this->add_control(
            'meta_categories',
            array(
                'label'        => esc_html__('Hide post-meta categories?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'     => [
                    'hide_postmeta!'   => 'yes',
                ]
            )
        );        

        $this->add_control(
            'meta_date',
            array(
                'label'        => esc_html__('Hide post-meta date?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'     => [
                    'hide_postmeta!'   => 'yes',
                ]
            )
        );        

        $this->add_control(
            'hide_likes',
            array(
                'label'        => esc_html__('Hide Likes?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );        

        $this->add_control(
            'hide_share',
            array(
                'label'        => esc_html__('Hide Post Share?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );        

        $this->add_control(
            'read_more_hide',
            array(
                'label'        => esc_html__('Hide \'Read More\' button?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control('read_more_text',
            array(
                'label'         => esc_html__('Read More Text', 'inpulse-core'),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Read More','inpulse-core'),
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'read_more_hide'   => '',
                ]
            )
        ); 

        $this->add_control('content_letter_count',
            array(
                'label'       => esc_html__('Characters Amount in Content', 'inpulse-core'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '95',
                'min'         => 1,
                'step'        => 1,
                'condition'     => [ 
                    'hide_content'   => '',
                ]
            )
        );

        $this->add_control(
            'crop_square_img',
            array(
                'label'        => esc_html__('Crop Images for Posts List?','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'description'  => esc_html__( 'For correctly work uploaded image size should be larger than 700px height and width.', 'text-domain' ),
            )
        );
       
        $this->end_controls_section();


        /* Start Carousel General Settings Section */
        $this->start_controls_section('wgl_carousel_section',
            array(
                'label'         => esc_html__('Carousel Options', 'inpulse-core'),
                'condition'     => [
                    'blog_layout'   => 'carousel',
                ]
            )
        );

        $this->add_control(
            'autoplay',
            array(
                'label'        => esc_html__('Autoplay','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );  

        $this->add_control('autoplay_speed',
            array(
                'label'       => esc_html__('Autoplay Speed', 'inpulse-core'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '3000',
                'min'         => 1,
                'step'        => 1,
                'condition'     => [
                    'autoplay'  => 'yes',
                ]
            )
        );
        
        $this->add_control(
            'use_pagination',
            array(
                'label'        => esc_html__('Add Pagination control','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->add_control('pag_type',
            array(
                'label'         => esc_html__( 'Pagination Type', 'inpulse-core' ),
                'type'          => 'wgl-radio-image',
                'options'       => [
                    'circle'      => [
                        'title'=> esc_html__( 'Circle', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_circle.png',
                    ],                    
                    'circle_border' => [
                        'title'=> esc_html__( 'Empty Circle', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_circle_border.png',
                    ],
                    'square'    => [
                        'title'=> esc_html__( 'Square', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_square.png',
                    ],   
                    'square_border'    => [
                        'title'=> esc_html__( 'Empty Square', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_square_border.png',
                    ],                  
                    'line'    => [
                        'title'=> esc_html__( 'Line', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_line.png',
                    ],                    
                    'line_circle'    => [
                        'title'=> esc_html__( 'Line - Circle', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_line_circle.png',
                    ],                    
                ],
                'default'       => 'circle',     
                'condition'     => [
                    'use_pagination'  => 'yes',
                ]       
            )
        );   

        $this->add_control('pag_offset',
            array(
                'label'       => esc_html__('Pagination Top Offset', 'inpulse-core'),
                'type'        => Controls_Manager::NUMBER,
                'min'         => 1,
                'step'        => 1,
                'default'     => 70,
                'condition'     => [
                    'use_pagination'  => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
                ],
            )
        );
        
        $this->add_control(
            'custom_pag_color',
            array(
                'label'        => esc_html__('Custom Pagination Color','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->add_control(
            'pag_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default'      => esc_attr($header_font_color),
                'condition'     => [
                    'custom_pag_color'  => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots li button' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wgl-carousel.pagination_line .slick-dots li button:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wgl-carousel.pagination_square .slick-dots li' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wgl-carousel.pagination_circle_border .slick-dots li.slick-active button' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-carousel.pagination_square_border .slick-dots li button:before' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .wgl-carousel.pagination_square_border .slick-dots li.slick-active button' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-carousel.pagination_circle_border .slick-dots li button:before' => 'background: {{VALUE}};',
                ],
            )
        );

        $this->add_control(
            'use_navigation',
            array(
                'label'        => esc_html__('Add Navigation control','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );   


        $this->add_control('custom_resp',
            array(
                'label'        => esc_html__('Customize Responsive','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control(
            'heading_desktop',
            array(
                'label' => esc_html__( 'Desktop Settings', 'inpulse-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );

        $this->add_control('resp_medium',
            array(
                'label'             => esc_html__('Desktop Screen Breakpoint', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'default'           => '1025',
                'min'               => 1,
                'step'              => 1,
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );         

        $this->add_control('resp_medium_slides',
            array(
                'label'             => esc_html__('Slides to show', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'min'               => 1,
                'step'              => 1,
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );         

        $this->add_control(
            'heading_tablet',
            array(
                'label' => esc_html__( 'Tablet Settings', 'inpulse-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );

        $this->add_control('resp_tablets',
            array(
                'label'             => esc_html__('Tablet Screen Breakpoint', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'default'           => '800',
                'min'               => 1,
                'step'              => 1,
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );         

        $this->add_control('resp_tablets_slides',
            array(
                'label'             => esc_html__('Slides to show', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'min'               => 1,
                'step'              => 1,
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );         

        $this->add_control(
            'heading_mobile',
            array(
                'label' => esc_html__( 'Mobile Settings', 'inpulse-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );

        $this->add_control('resp_mobile',
            array(
                'label'             => esc_html__('Mobile Screen Breakpoint', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'default'           => '480',
                'min'               => 1,
                'step'              => 1,
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );         

        $this->add_control('resp_mobile_slides',
            array(
                'label'             => esc_html__('Slides to show', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'min'               => 1,
                'step'              => 1,
                'condition'         => [
                    'custom_resp'   => 'yes',
                ]
            )
        );       

        /*End General Settings Section*/
        $this->end_controls_section();



        /*-----------------------------------------------------------------------------------*/
        /*  Build Query Section 
        /*-----------------------------------------------------------------------------------*/

        Wgl_Loop_Settings::init( $this, array( 'post_type' => 'post') );

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/    
        $this->start_controls_section(
            'headings_style_section',
            array(
                'label'     => esc_html__( 'Headings', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control('heading_tag',
            array(
                'label'         => esc_html__('Heading tag', 'inpulse-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h3',
                'options'       => [
                    'h1'    => 'H1',
                    'h2'    => 'H2',
                    'h3'    => 'H3',
                    'h4'    => 'H4',
                    'h5'    => 'H5',
                    'h6'    => 'H6',
                ],
            )
        );
        
        $this->add_responsive_control(
            'heading_margin',
            array(
                'label' => esc_html__( 'Heading margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => 6,
                    'left'      => 0,
                    'right'     => 0,
                    'bottom'    => 7,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );


        $this->start_controls_tabs( 'headings_color' );

        $this->start_controls_tab(
            'custom_headings_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_headings_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($header_font_color),
                'selectors' => array(
                    '{{WRAPPER}} .blog-post_title a' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_headings_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_hover_headings_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_secondary_color),
                'selectors' => array(
                    '{{WRAPPER}} .blog-post_title a:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_blog_headings',
                'selector' => '{{WRAPPER}} .blog-post_title, {{WRAPPER}} .blog-post_title > a',
            )
        );

        $this->end_controls_section();            

        $this->start_controls_section(
            'content_style_section',
            array(
                'label'     => esc_html__( 'Content', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'content_margin',
            array(
                'label' => esc_html__( 'Margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => 9,
                    'left'      => 0,
                    'right'     => 0,
                    'bottom'    => 18,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-style-standard .blog-post_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );


        $this->add_control(
            'custom_content_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($main_font_color),
                'selectors' => array(
                    '{{WRAPPER}} .blog-post_text' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_blog_content',
                'selector' => '{{WRAPPER}} .blog-post_text',
            )
        );

        $this->end_controls_section();             

        $this->start_controls_section(
            'meta_info_style_section',
            array(
                'label'     => esc_html__( 'Meta Info', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'meta_info_margin',
            array(
                'label' => esc_html__( 'Margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => -8,
                    'right'     => 0,
                    'bottom'    => 0,
                    'left'      => 0,         
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-style-standard .blog-post .blog-post_content > .meta-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blog-style-standard .blog-post .blog-post_content > .blog-post_meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->start_controls_tabs( 'tabs_meta_info' );

        $this->start_controls_tab(
            'tab_meta_info_normal',
            [
                'label' => esc_html__( 'Normal', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'custom_main_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#b7b7b7',
                'selectors' => array(
                    '{{WRAPPER}} .blog-post_content > .meta-wrapper' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blog-post_content > .meta-wrapper a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blog-post_likes-wrap .sl-count' => 'color: {{VALUE}};',
                ),
            )
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_meta_hover',
            [
                'label' => esc_html__( 'Hover', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'custom_main_color_hover',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_color),
                'selectors' => array(
                    '{{WRAPPER}} .blog-post_likes-wrap:hover .sl-count' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blog-post_content > .meta-wrapper a:hover' => 'color: {{VALUE}};',
                ),
            )
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();            

        $this->start_controls_section(
            'media_style_section',
            array(
                'label'     => esc_html__( 'Media', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'custom_blog_mask',
            array(
                'label'        => esc_html__('Add Image Idle Overlay','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'custom_image_mask_color',
                'label' => esc_html__( 'Background', 'inpulse-core' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .wrapper',
                'default'  => 'rgba(14,21,30,.6)',
                'condition'     => [ 
                    'custom_blog_mask'   => 'yes',
                ],
                'selector' => '{{WRAPPER}} .blog-post_bg_media:before,
                {{WRAPPER}} .blog-post.format-standard-image .blog-post_media .blog-post_feature-link:before',
            )
        );        

        $this->add_control(
            'custom_blog_hover_mask',
            array(
                'label'        => esc_html__('Add Image Hover Overlay','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'custom_image_hover_mask_color',
                'label' => esc_html__( 'Background', 'inpulse-core' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .wrapper',
                'default'  => 'rgba(14,21,30,.6)',
                'condition'     => [ 
                    'custom_blog_hover_mask'   => 'yes',
                ],
                'selector' => '{{WRAPPER}} .blog-post:hover .blog-post_bg_media:before,
                {{WRAPPER}} .blog-post.hide_media:hover,
                {{WRAPPER}} .blog-post.format-standard-image .blog-post_media:hover .blog-post_feature-link:before',
            )
        );        

        $this->add_control(
            'custom_blog_bg_item',
            array(
                'label'        => esc_html__('Add Items Background','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );


        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'custom_bg_color',
                'label' => esc_html__( 'Background', 'inpulse-core' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .wrapper',
                'default'  => 'rgba(19,17,31,1)',
                'condition'     => [ 
                    'custom_blog_bg_item'   => 'yes',
                ],
                'selector' => '{{WRAPPER}} .blog-post, {{WRAPPER}} .blog-post .blog-post_content,
                {{WRAPPER}} .blog-post .blog-post_media .meta-wrapper',
            )
        );

        $this->end_controls_section();        

    }


    protected function render() {
        $atts = $this->get_settings_for_display();

        $blog = new WglBlog();
        echo $blog->render($atts);
    }
    
}