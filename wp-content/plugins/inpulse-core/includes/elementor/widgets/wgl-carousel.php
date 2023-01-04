<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Includes\Wgl_Elementor_Helper;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Frontend;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wgl_Carousel extends Widget_Base {

    public function get_name() {
        return 'wgl-carousel';
    }

    public function get_title() {
        return esc_html__('Wgl Carousel', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-carousel';
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
        $self = new REPEATER();

        $this->start_controls_section('wgl_carousel_section',
            array(
                'label'         => esc_html__( 'Carousel Settings' , 'inpulse-core' )
            )
        );

        $self->add_control('content',
            [
                'label'         => esc_html__( 'Content', 'inpulse-core' ),
                'type'          => Controls_Manager::SELECT2,
                'options'       => Wgl_Elementor_Helper::get_instance()->get_elementor_templates(),
            ]
        );

        $this->add_control('content_repeater',
            [
                'label'         => esc_html__('Templates', 'inpulse-core'),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $self->get_controls(),
                'description'   => esc_html__( 'Slider content is a template which you can choose from Elementor library. Each template will be a slider content', 'inpulse-core' ),
                'title_field'   => 'Template: {{{ content }}}'
            ]
        );


        $this->add_control('slide_to_show',
            array(
                'label'             => esc_html__('Columns Amount', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    '1'          => esc_html__('1', 'inpulse-core'),
                    '2'          => esc_html__('2', 'inpulse-core'),
                    '3'          => esc_html__('3', 'inpulse-core'),
                    '4'          => esc_html__('4', 'inpulse-core'),
                    '5'          => esc_html__('5', 'inpulse-core'),
                    '6'          => esc_html__('6', 'inpulse-core'),
                ],
                'default'        => '1'
            )
        );

        $this->add_control('speed',
            array(
                'label'             => esc_html__('Animation Speed', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'default'           => '3000',
                'min'               => 1,
                'step'              => 1,
            )
        );

        $this->add_control('autoplay',
            array(
                'label'        => esc_html__('Autoplay','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control('autoplay_speed',
            array(
                'label'             => esc_html__('Autoplay Speed', 'inpulse-core'),
                'type'              => Controls_Manager::NUMBER,
                'default'           => '3000',
                'min'               => 1,
                'step'              => 1,
                'condition'         => [
                    'autoplay'      => 'yes',
                ]
            )
        );

        $this->add_control('slides_to_scroll',
            array(
                'label'        => esc_html__('Slide One Item per time','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control('infinite',
            array(
                'label'        => esc_html__('Infinite loop sliding','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control('adaptive_height',
            array(
                'label'        => esc_html__('Adaptive Height','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );

        $this->add_control('fade_animation',
            array(
                'label'        => esc_html__('Fade Animation','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'         => [
                    'slide_to_show' => '1',
                ]
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'navigation_section',
            array(
                'label'      => esc_html__('Navigation', 'inpulse-core' ),
            )
        );

        $this->add_control(
            'h_pag_controls',
            array(
                'label' => esc_html__( 'Pagination Controls', 'inpulse-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            )
        );

        $this->add_control('use_pagination',
            array(
                'label'        => esc_html__('Add Pagination control','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes'
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
                    'circle_border'      => [
                        'title'=> esc_html__( 'Empty Circle', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_circle_border.png',
                    ],
                    'square'      => [
                        'title'=> esc_html__( 'Square', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_square.png',
                    ],
                    'square_border'    => [
                        'title'=> esc_html__( 'Empty Square', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_square_border.png',
                    ],
                    'line'      => [
                        'title'=> esc_html__( 'Line', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_line.png',
                    ],
                    'line_circle'      => [
                        'title'=> esc_html__( 'Line - Circle', 'inpulse-core' ),
                        'image' => WGL_ELEMENTOR_ADDONS_URL . 'assets/img/wgl_composer_addon/icons/pag_circle.png',
                    ],
                ],
                'default'       => 'circle',
                'condition'         => [
                    'use_pagination' => 'yes',
                ]
            )
        );

        $this->add_control('pag_align',
            array(
                'label'             => esc_html__('Pagination Aligning', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'left'          => esc_html__('Left', 'inpulse-core'),
                    'right'         => esc_html__('Right', 'inpulse-core'),
                    'center'        => esc_html__('Center', 'inpulse-core'),
                ],
                'default'           => 'center',
                'condition'         => [
                    'use_pagination'   => 'yes',
                ]
            )
        );

        $this->add_control('pag_offset',
            array(
                'label' => esc_html__( 'Pagination Top Offset', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .wgl-carousel .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'use_pagination'   => 'yes',
                ]
            )

        );

        $this->add_control('custom_pag_color',
            array(
                'label'        => esc_html__('Custom Pagination Color','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'         => [
                    'use_pagination'   => 'yes',
                ]
            )
        );

        $this->add_control(
            'pag_color',
            array(
                'label' => esc_html__( 'Pagination Color', 'inpulse-core' ),
                'type'  =>  Controls_Manager::COLOR,
                'default'   => $theme_color,
                'condition'         => [
                    'custom_pag_color'   => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pagination_circle .slick-dots li button' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .pagination_square .slick-dots li button' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .pagination_line .slick-dots li button:before' => 'background: {{VALUE}}'
                ],
            )
        );
        $this->add_control(
            'hr_prev_next',
            array(
                'type' => Controls_Manager::DIVIDER,
            )
        );
        $this->add_control(
            'divider_4',
            array(
                'label' => esc_html__( 'Prev/Next Buttons', 'inpulse-core' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'after',
            )
        );

        $this->add_control('use_prev_next',
            array(
                'label'        => esc_html__('Add Prev/Next buttons','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );
        $this->add_control('custom_prev_next_offset',
            array(
                'label'        => esc_html__('Custom offset','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'         => [
                    'use_prev_next'   => 'yes',
                ]
            )
        );

        $this->add_control('prev_next_offset',
            array(
                'label' => esc_html__( 'Buttons Top Offset', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors'         => [
                    '{{WRAPPER}} .wgl-carousel .slick-next' => 'top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .wgl-carousel .slick-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition'         => [
                    'use_prev_next'   => 'yes',
                ]
            )
        );

        $this->add_control('custom_prev_next_color',
            array(
                'label'        => esc_html__('Customize Colors','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'condition'         => [
                    'use_prev_next'   => 'yes',
                ]
            )
        );
        $this->add_control(
            'prev_next_color',
            array(
                'label' => esc_html__( 'Prev/Next Buttons Color', 'inpulse-core' ),
                'type'  =>  Controls_Manager::COLOR,
                'default'   => $theme_color,
                 'condition'         => [
                    'custom_prev_next_color'   => 'yes',
                ],
                'dynamic'       => [ 'active' => true ],
            )
        );

        $this->add_control(
            'prev_next_bg_color',
            array(
                'label' => esc_html__( 'Buttons Background Color', 'inpulse-core' ),
                'type'  =>  Controls_Manager::COLOR,
                'default'   => '#ffffff',
                 'condition'         => [
                    'custom_prev_next_color'   => 'yes',
                ]
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'responsive_section',
            array(
                'label'      => esc_html__('Responsive', 'inpulse-core' ),
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

        $this->end_controls_section();


    }

    protected function render() {

        $atts = $this->get_settings_for_display();
        extract($atts);

        $content = array();

        foreach( $content_repeater as $template ){
            array_push($content, $template['content']);
        }
        echo Wgl_Carousel_Settings::init($atts, $content, true);
    }

}