<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglTestimonials;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wgl_Testimonials extends Widget_Base {
    
    public function get_name() {
        return 'wgl-testimonials';
    }

    public function get_title() {
        return esc_html__('Wgl Testimonials', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-testimonials';
    }

    public function get_script_depends() {
        return [
            'slick',
        ];
    }
 
    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    // Adding the controls fields for the premium title
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        $theme_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-custom-color'));
        $main_font_color = esc_attr(\InPulse_Theme_Helper::get_option('main-font')['color']);
        $header_font_color = esc_attr(\InPulse_Theme_Helper::get_option('header-font')['color']);
        
        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section('wgl_testimonials_section',
            array(
                'label'         => esc_html__('Testimonials Settings', 'inpulse-core'),
            )
        );
        $this->add_control('posts_per_line',
            array(
                'label'             => esc_html__('Columns Amount', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    '1'          => esc_html__('One Column', 'inpulse-core'),
                    '2'          => esc_html__('Two Columns', 'inpulse-core'),
                    '3'          => esc_html__('Three Columns', 'inpulse-core'),
                    '4'          => esc_html__('Four Columns', 'inpulse-core'),
                    '5'          => esc_html__('Five Columns', 'inpulse-core'),
                ],
                'default'           => '1',
            )
        ); 


        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            array(
                'label'       => esc_html__( 'Image', 'inpulse-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            )
        );  

        $repeater->add_control(
            'author_name',
            array(
                'label'       => esc_html__( 'Author Name', 'inpulse-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true
            )
        );

        $repeater->add_control('link_author',
            array(
                'label'             => esc_html__('Link Author', 'inpulse-core'),
                'type'              => Controls_Manager::URL,
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'author_position',
            array(
                'label'       => esc_html__( 'Author Position', 'inpulse-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true
            )
        );        

        $repeater->add_control(
            'quote',
            array(
                'label'       => esc_html__( 'Quote', 'inpulse-core' ),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true
            )
        );

        $this->add_control(
            'list',
            array(
                'label'   => esc_html__( 'Items', 'inpulse-core' ),
                'type'    => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'author_name' => esc_html__( '- TINA JOHANSON', 'inpulse-core' ),
                        'author_position' => '',
                        'quote' => esc_html__( '“Choosing online studies was the best way to do it – the internet is fast, cheap & popular and it’s easy to communicate in social media with native speakers.”', 'inpulse-core' ),
                        'thumbnail' => Utils::get_placeholder_image_src()
                    ],
                ],

                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ author_name }}}'
            )
        );
        
        $this->add_control('item_type',
            array(
                'label'         => esc_html__( 'Overall Layout', 'inpulse-core' ),
                'type'          => 'wgl-radio-image',
                'options'       => [
                    'author_top'      => [
                        'title'=> esc_html__( 'Top', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/testimonials_1.png',
                    ],                    
                    'author_bottom'     => [
                        'title'=> esc_html__( 'Bottom', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/testimonials_4.png',
                    ],
                    'inline_top'    => [
                        'title'=> esc_html__( 'Top Inline', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/testimonials_2.png',
                    ],                    
                    'inline_bottom'    => [
                        'title'=> esc_html__( 'Bottom Inline', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/testimonials_3.png',
                    ],                    

                ],
                'default'       => 'inline_bottom',            
            )
        );

        $this->add_control(
            'item_align',
            array(
                'label' => esc_html__( 'Alignment', 'inpulse-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'inpulse-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'inpulse-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'inpulse-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true, 
            )
        );

        $this->add_control('hover_animation',
            array(
                'label'        => esc_html__('Enable Hover Animation','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'description'  => esc_html__( 'Lift up the item on hover.', 'inpulse-core' ),
            )
        ); 

        $this->end_controls_section(); 

        /*-----------------------------------------------------------------------------------*/
        /*  Carousel options
        /*-----------------------------------------------------------------------------------*/ 

        Wgl_Carousel_Settings::options($this);

/*        $this->start_controls_section('wgl_carousel_section',
            array(
                'label'         => esc_html__('Carousel Options', 'inpulse-core'),
            )
        );

        $this->end_controls_section(); */
        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/ 

        $this->start_controls_section(
            'section_style_testimonials_image',
            array(
                'label' => esc_html__( 'Image', 'inpulse-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'image_size',
            array(
                'label' => esc_html__( 'Image Size', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 1000,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
            )
        );

        $this->add_responsive_control(
            'image_margin',
            array(
                'label' => esc_html__( 'Margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'testimonials_image_shadow',
                'selector' =>  '{{WRAPPER}} .wgl-testimonials_image img',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_image img',
                'separator' => 'before',
            )
        );

        $this->add_control(
            'image_border_radius',
            array(
                'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'   => [
                    'top'       => 80,
                    'left'      => 80,
                    'right'     => 80,
                    'bottom'    => 80,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'quote_style_section',
            array(
                'label'     => esc_html__( 'Quote', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control('quote_tag',
            array(
                'label'         => esc_html__('Quote tag', 'inpulse-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'div',
                'options'       => [
                    'div'   => 'div',
                    'span'  => 'span',
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
            'quote_padding',
            array(
                'label' => esc_html__( 'Padding', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => 42,
                    'left'      => 40,
                    'right'     => 30,
                    'bottom'    => 22,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_responsive_control(
            'quote_margin',
            array(
                'label' => esc_html__( 'Margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => 0,
                    'left'      => 0,
                    'right'     => 0,
                    'bottom'    => 20,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->start_controls_tabs( 'quote_color' );

        $this->start_controls_tab(
            'custom_quote_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_quote_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($header_font_color),
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'custom_quote_color_bg',
            array(
                'label' => esc_html__( 'Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6f0ec',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:before' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_quote_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_hover_quote_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($header_font_color),
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'custom_hover_quote_color_bg',
            array(
                'label' => esc_html__( 'Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f6f0ec',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_quote',
                'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote',
            )
        );

        $this->end_controls_section();        

        $this->start_controls_section(
            'author_name_style_section',
            array(
                'label'     => esc_html__( 'Name', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control('name_tag',
            array(
                'label'         => esc_html__('HTML tag', 'inpulse-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h3',
                'options'       => [
                    'div'   => 'div',
                    'span'  => 'span',
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
            'name_padding',
            array(
                'label' => esc_html__( 'Padding', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => 5,
                    'left'      => 0,
                    'right'     => 0,
                    'bottom'    => 0,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->start_controls_tabs( 'name_color' );

        $this->start_controls_tab(
            'custom_name_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_name_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_name' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_name_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_hover_name_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials_item .wgl-testimonials_name:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_name',
                'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_name',
            )
        );

        $this->end_controls_section();          

        $this->start_controls_section(
            'author_position_style_section',
            array(
                'label'     => esc_html__( 'Position', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control('position_tag',
            array(
                'label'         => esc_html__('HTML tag', 'inpulse-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'span',
                'options'       => [
                    'div'   => 'div',
                    'span'  => 'span',
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
            'position_padding',
            array(
                'label' => esc_html__( 'Padding', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => 10,
                    'left'      => 0,
                    'right'     => 0,
                    'bottom'    => 0,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->start_controls_tabs( 'position_color' );

        $this->start_controls_tab(
            'custom_position_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_position_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#8d8d8d',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_position_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'custom_hover_position_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#8d8d8d',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_position',
                'selector' => '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_position',
            )
        );

        $this->end_controls_section(); 

        $this->start_controls_section(
            'quote_icon_style_section',
            array(
                'label'     => esc_html__( 'Quote Icon', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'item_type'   => array('inline_top', 'inline_bottom'),
                ]
            )
        );

        $this->add_control('quote_icon_switcher',
            array(
                'label'        => esc_html__('Enable Quote Icon','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'       => 'yes',
                'condition'     => [
                    'item_type'   => array('inline_top', 'inline_bottom'),
                ]
            )
        ); 

        $this->start_controls_tabs( 'quote_icon_color' );


        $this->start_controls_tab(
            'custom_quote_icon_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
                'condition'     => [
                    'quote_icon_switcher'   => 'yes',
                ]
            )
        );

        $this->add_control(
            'custom_quote_icon_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_color),
                'selectors' => array(
                    '{{WRAPPER}} .wgl-testimonials .wgl-testimonials_quote:after' => 'background-color: {{VALUE}};',
                ),
                'condition'     => [
                    'quote_icon_switcher'   => 'yes',
                ]
            )
        );        

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_quote_icon_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
                'condition'     => [
                    'quote_icon_switcher'   => 'yes',
                ]
            )
        );

        $this->add_control(
            'custom_hover_quote_icon_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_color),
                'selectors' => array(
                    '{{WRAPPER}}:hover .wgl-testimonials .wgl-testimonials_item:after' => 'background-color: {{VALUE}};',
                ),
                'condition'     => [
                    'quote_icon_switcher'   => 'yes',
                ]
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();          

        $this->start_controls_section(
            'secondary_style_section',
            array(
                'label'     => esc_html__( 'Content Box Styles', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'background_item',
                'label' => esc_html__( 'Background', 'inpulse-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wgl-testimonials_item',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'testimonials_shadow',
                'selector' =>  '{{WRAPPER}} .wgl-testimonials_item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'testimonials_border',
                'label'    => esc_html__( 'Border', 'inpulse-core' ),
                'selector' => '{{WRAPPER}} .wgl-testimonials_item',
            )
        );

        $this->add_control(
            'border_radius',
            array(
                'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_responsive_control(
            'content_padding',
            array(
                'label' => esc_html__( 'Content Padding', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top'       => 30,
                    'left'      => 30,
                    'right'     => 0,
                    'bottom'    => 0,
                    'unit'      => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-testimonials_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->end_controls_section();                            

    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        
       	$testimonials = new WglTestimonials();
        echo $testimonials->render($this, $atts);
    }
    
}