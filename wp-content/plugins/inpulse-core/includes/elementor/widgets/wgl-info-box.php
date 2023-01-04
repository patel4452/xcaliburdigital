<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglInfoBoxes;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wgl_Info_Box extends Widget_Base {

    public function get_name() {
        return 'wgl-info-box';
    }

    public function get_title() {
        return esc_html__('Wgl Info Box', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-info-box';
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
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/
        $output = array();
        $output['view'] = array(
            'label' => esc_html__( 'View', 'inpulse-core' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'default' => esc_html__( 'Default', 'inpulse-core' ),
                'stacked' => esc_html__( 'Stacked', 'inpulse-core' ),
                'framed' => esc_html__( 'Framed', 'inpulse-core' ),
            ],
            'default' => 'default',
            'prefix_class' => 'elementor-view-',
            'condition'     => [
                'icon_type'  => 'font',
            ]
        );

        $output['shape'] = array(
            'label' => esc_html__( 'Shape', 'inpulse-core' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'circle' => esc_html__( 'Circle', 'inpulse-core' ),
                'square' => esc_html__( 'Square', 'inpulse-core' ),
            ],
            'default' => 'circle',
            'condition'     => [
                'icon_type'  => 'font',
                'view!' => 'default',
            ],
            'prefix_class' => 'elementor-shape-',
        );

        $output['link_t'] = array(
            'label' => esc_html__( 'Link', 'inpulse-core' ),
            'type' => Controls_Manager::URL,
            'dynamic' => [
                'active' => true,
            ],
            'placeholder' => esc_html__( 'https://your-link.com', 'inpulse-core' ),
            'separator' => 'before',
            'condition' => [
                'icon_type!' => '',
            ],
        );

        $output['position'] = array(
            'label'         => esc_html__( 'Position', 'inpulse-core' ),
            'type'          => 'wgl-radio-image',
            'options'       => [
                'top' => [
                    'title'=> esc_html__( 'Top', 'inpulse-core' ),
                    'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/style_def.png',
                ],
                'left'      => [
                    'title'=> esc_html__( 'Left', 'inpulse-core' ),
                    'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/style_left.png',
                ],
                'right'    => [
                    'title'=> esc_html__( 'Right', 'inpulse-core' ),
                    'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/style_right.png',
                ],
            ],
            'prefix_class' => 'elementor-position-',
            'default'       => 'top',
            'condition' => [
                'icon_type!' => '',
            ],
        );

        Wgl_Icons::init( $this, array( 'label' => esc_html__('Info Box ', 'inpulse-core'), 'output' => $output,'section' => true, 'prefix' => '' ) );

        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section('wgl_ib_content',
            array(
                'label'         => esc_html__('Info Box Content', 'inpulse-core'),
            )
        );

        $this->add_control('ib_title',
            array(
                'label'         => esc_html__('Title', 'inpulse-core'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => esc_html__('This is the heading​', 'inpulse-core'),
                'dynamic'       => [ 'active' => true ]
            )
        );

        $this->add_control(
            'add_background_title',
            array(
                'label'        => esc_html__('Add Background Title','inpulse-core' ),

                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',

            )
        );
        $this->add_control('ib_bg_title',
            array(
                'label'         => esc_html__('Background Title', 'inpulse-core'),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true,
                'default'       => esc_html__('This is the heading​', 'inpulse-core'),
                'dynamic'       => [ 'active' => true ],
                'condition'     => [
                    'add_background_title'   => 'yes',
                ],
            )
        );

        $this->add_control('ib_content',
            array(
                'label'             => esc_html__('Info Box Text', 'inpulse-core'),
                'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Description Text', 'inpulse-core' ),
				'label_block' => true,
                'default'       => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'inpulse-core'),
            )
        );

        $this->add_control(
            'alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_wrapper' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .wgl-infobox_wrapper .wgl-infobox_bg_title' => 'text-align: {{VALUE}};',
                ],
            )
        );

        $this->add_control('hover_animation',
            array(
                'label'        => esc_html__('Enable hover animation','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'description' => esc_html__( 'Lift up the item on hover.', 'inpulse-core' ),
                'prefix_class' => 'wgl-hover_shift-',
            )
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            [
                'label' => esc_html__( 'Infobox Link', 'inpulse-core' ),
            ]
        );

        $this->add_control('add_item_link',
            array(
                'label'        => esc_html__('Add Link To Whole Item','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition' => [
                    'add_read_more!' => 'yes',
                ],

            )
        );

        $this->add_control('item_link',
            array(
                'label'             => esc_html__('Link', 'inpulse-core'),
                'type'              => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'condition'     => [
                    'add_item_link'   => 'yes',
                ],
            )
        );

        $this->add_control('add_read_more',
            array(
                'label'             => esc_html__('Add \'Read More\' Button', 'inpulse-core'),
                'type'              => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition' => [
                    'add_item_link!' => 'yes',
                ],
            )
        );

        $this->add_control('read_more_text',
            array(
                'label'             => esc_html__('Button Text', 'inpulse-core'),
                'type'              => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
                'condition'     => [
                    'add_read_more'   => 'yes',
                ],
            )
        );

        $this->add_control('link',
            array(
                'label'             => esc_html__('Button Link', 'inpulse-core'),
                'type'              => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
                'condition'     => [
                    'add_read_more'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'hr_link',
            [
                'type' => Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'read_more_icon_sticky',
            array(
                'label'        => esc_html__('Stick the button','inpulse-core' ),

                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'description' => esc_html__( 'Attach to the bottom right or left corner.', 'inpulse' ),
                'condition'     => [
                    'add_read_more'   => 'yes',
                ],
            )
        );

        $this->add_control('read_more_icon_sticky_pos',
            array(
                'label'             => esc_html__('Read More Position', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'right'         => esc_html__('Right', 'inpulse-core'),
                    'left'          => esc_html__('Left', 'inpulse-core'),
                ],
                'default'           => 'right',
                'condition'     => [
                    'add_read_more'   => 'yes',
                    'read_more_icon_sticky'   => 'yes',
                ],
            )
        );

        $this->add_control('icon_read_more_pack',
            array(
                'label'             => esc_html__('Icon Pack', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'fontawesome'               => esc_html__('Fontawesome', 'inpulse-core'),
                    'flaticon'          => esc_html__('Flaticon', 'inpulse-core'),
                ],
                'default'           => 'fontawesome',
                'condition'     => [
                    'add_read_more'   => 'yes',
                ],
            )
        );

        $this->add_control('read_more_icon_flaticon',
            array(
                'label'       => esc_html__( 'Icon', 'inpulse-core' ),
                'type'        => 'wgl-icon',
                'label_block' => true,
                'condition'     => [
                    'add_read_more'   => 'yes',
                    'icon_read_more_pack'   => 'flaticon',
                ],
                'description' => esc_html__( 'Select icon from Flaticon library.', 'inpulse-core' ),
            )
        );

        $this->add_control('read_more_icon_fontawesome',
            array(
                'label'       => esc_html__( 'Icon', 'inpulse-core' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,
                'condition'     => [
                    'add_read_more'   => 'yes',
                    'icon_read_more_pack'   => 'fontawesome',
                ],
                'description' => esc_html__( 'Select icon from Fontawesome library.', 'inpulse-core' ),
            )
        );

        $this->add_control(
            'read_more_icon_align',
            array(
                'label' => esc_html__( 'Icon Position', 'inpulse-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__( 'Before', 'inpulse-core' ),
                    'right' => esc_html__( 'After', 'inpulse-core' ),
                ],
                'condition'     => [
                    'add_read_more'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'read_more_icon_spacing',
            array(
                'label' => esc_html__( 'Icon Spacing', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unix' => 'px'
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button.icon-position-right i' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-infobox_button.icon-position-left i' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'add_read_more'   => 'yes',
                ],
            )
        );

        /*End Link Settings Section*/
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'inpulse-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_type'  => 'font',
                ],
            ]
        );

        $this->start_controls_tabs( 'icon_colors' );

        $this->start_controls_tab(
            'icon_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__( 'Primary Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .wgl-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .wgl-icon, {{WRAPPER}}.elementor-view-default .wgl-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => esc_html__( 'Secondary Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .wgl-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .wgl-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__( 'Primary Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .wgl-icon:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .wgl-icon:hover, {{WRAPPER}}.elementor-view-default .wgl-icon:hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_secondary_color',
            [
                'label' => esc_html__( 'Secondary Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .wgl-icon:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .wgl-icon:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation_icon',
            [
                'label' => esc_html__( 'Hover Animation', 'inpulse-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'hr_icon_style',
            array(
                'type' => Controls_Manager::DIVIDER,
            )
        );

        $this->add_responsive_control(
            'icon_space',
            array(
                'label' => esc_html__( 'Margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Size', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default'   => [
                    'unit' => 'px',
                    'size' => 60,
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__( 'Padding', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->add_control(
            'rotate',
            [
                'label' => esc_html__( 'Rotate', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => 'deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__( 'Border Width', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view' => 'framed',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__( 'Image', 'inpulse-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'icon_type'   => 'image',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_space',
            array(
                'label' => esc_html__( 'Margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__( 'Width', 'inpulse-core' ) . ' (%)',
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 5,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation_image',
            [
                'label' => esc_html__( 'Hover Animation', 'inpulse-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => esc_html__( 'Normal', 'inpulse-core' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .wgl-image-box_img img',
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => esc_html__( 'Opacity', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__( 'Transition Duration', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-image-box_img img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => esc_html__( 'Hover', 'inpulse-core' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}}:hover .wgl-image-box_img img',
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label' => esc_html__( 'Opacity', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .wgl-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'title_style_section',
            array(
                'label'     => esc_html__( 'Title', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control('title_tag',
            array(
                'label'         => esc_html__('Title Tag', 'inpulse-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'h3',
                'description'   => esc_html__( 'Choose your tag for info box title', 'inpulse-core' ),
                'options'       => [
                    'h1'      => 'H1',
                    'h2'      => 'H2',
                    'h3'      => 'H3',
                    'h4'      => 'H4',
                    'h5'      => 'H5',
                    'h6'      => 'H6',
                    'div'     => 'DIV',
                    'span'    => 'SPAN',
                ],
            )
        );

        $this->add_responsive_control(
            'title_offset',
            array(
                'label' => esc_html__( 'Title Offset', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'default'   => [
                    'top' => '',
                    'right' => '',
                    'bottom' => 10,
                    'left' => '',
                    'unit'  => 'px',
                    'isLinked'  => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .wgl-infobox_title',
            )
        );


        $this->start_controls_tabs( 'title_color_tab' );

        $this->start_controls_tab(
            'custom_title_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#232323',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-infobox_title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'title_color_hover',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_color),
                'selectors' => array(
                    '{{WRAPPER}}:hover .wgl-infobox_title' => 'color: {{VALUE}};',
                    '{{WRAPPER}}:hover .wgl-infobox_title a' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Headings Section)
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'bg_title_style_section',
            array(
                'label'     => esc_html__( 'Background Title', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'add_background_title'   => 'yes',
                ],
            )
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_bg_title',
                'selector' => '{{WRAPPER}} .wgl-infobox_bg_title',
            )
        );

        $this->start_controls_tabs( 'title_bg_color_tab' );

        $this->start_controls_tab(
            'custom_bg_title_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'bg_title_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f7f7f7',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-infobox_bg_title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_bg_title_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'title_bg_color_hover',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f7f7f7',
                'selectors' => array(
                    '{{WRAPPER}}:hover .wgl-infobox_bg_title' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'content_style_section',
            array(
                'label'     => esc_html__( 'Content', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control('content_tag',
            array(
                'label'         => esc_html__('Content Tag', 'inpulse-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'div',
                'description'   => esc_html__( 'Choose your tag for info box content', 'inpulse-core' ),
                'options'       => [
                    'h1'      => 'H1',
                    'h2'      => 'H2',
                    'h3'      => 'H3',
                    'h4'      => 'H4',
                    'h5'      => 'H5',
                    'h6'      => 'H6',
                    'div'     => 'DIV',
                    'span'    => 'SPAN',
                ],
            )
        );

        $this->add_responsive_control(
            'content_offset',
            array(
                'label' => esc_html__( 'Content Offset', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'       => [
                    'top'   => 0,
                    'right' => 0,
                    'bottom'=> 30,
                    'left'  => 0,
                    'unit'  => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_responsive_control(
            'content_padding',
            array(
                'label' => esc_html__( 'Content Padding', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'custom_content_mask_color',
                'label' => esc_html__( 'Background', 'inpulse-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wgl-infobox_content',
                'condition'     => [
                    'custom_bg'   => 'custom',
                ],
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_content',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_3['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .wgl-infobox_content',
            )
        );

        $this->start_controls_tabs( 'content_color_tab' );

        $this->start_controls_tab(
            'custom_content_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'content_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($main_font_color),
                'selectors' => array(
                    '{{WRAPPER}} .wgl-infobox_content' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_content_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'content_color_hover',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($main_font_color),
                'selectors' => array(
                    '{{WRAPPER}}:hover .wgl-infobox_content' => 'color: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();


        $this->start_controls_section(
            'button_style_section',
            array(
                'label'     => esc_html__( 'Button', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'add_read_more!'   => '',
                ],
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'custom_fonts_button',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .wgl-infobox_button',
            )
        );

        $this->add_responsive_control(
            'custom_button_padding',
            array(
                'label' => esc_html__( 'Padding', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'   => [
                    'top' => 27,
                    'right' => 27,
                    'bottom' => 27,
                    'left' => 27,
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            )
        );

        $this->add_control(
            'custom_button_border',
            array(
                'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-infobox_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            )
        );

        $this->start_controls_tabs( 'button_color_tab' );

        $this->start_controls_tab(
            'custom_button_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'button_background',
            array(
                'label' => esc_html__( 'Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-infobox_button' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'button_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($header_font_color),
                'selectors' => array(
                    '{{WRAPPER}} .wgl-infobox_button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-infobox_button.read-more-icon:empty:after, {{WRAPPER}} .wgl-infobox_button.read-more-icon:empty:before' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'button_border',
                'label'    => esc_html__( 'Border Type', 'inpulse-core' ),
                'selector' => '{{WRAPPER}} .wgl-infobox_button',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'button_shadow',
                'selectors' =>  '{{WRAPPER}} .wgl-infobox_button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
            )
        );

        $this->add_control(
            'button_background_hover',
            array(
                'label' => esc_html__( 'Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-infobox_button:hover' => 'background: {{VALUE}};'
                ),
            )
        );

        $this->add_control(
            'button_color_hover',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-infobox_button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .wgl-infobox_button.read-more-icon:empty:hover:after, {{WRAPPER}} .wgl-infobox_button.read-more-icon:empty:hover:before' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'button_border_hover',
                'label'    => esc_html__( 'Border Type', 'inpulse-core' ),
                'default' => $theme_color,
                'selector' => '{{WRAPPER}} .wgl-infobox_button:hover',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .wgl-infobox_button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {
        $atts = $this->get_settings_for_display();

       	$info_box = new WglInfoBoxes();
        echo $info_box->render($this, $atts);

    }

}