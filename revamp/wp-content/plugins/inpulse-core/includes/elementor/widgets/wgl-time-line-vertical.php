<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Carousel_Settings;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
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

class Wgl_Time_Line_Vertical extends Widget_Base {

    public function get_name() {
        return 'wgl-time-line-vertical';
    }

    public function get_title() {
        return esc_html__('Wgl Time Line Vertical', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-time-line-vertical';
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    public function get_script_depends() {
        return [
            'appear',
        ];
    }

    // Adding the controls fields for the premium title
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        $theme_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-custom-color'));
        $second_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-secondary-color'));
        $third_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-third-color'));
        $header_font_color = esc_attr(\InPulse_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\InPulse_Theme_Helper::get_option('main-font')['color']);

        /* Start General Settings Section */
        $this->start_controls_section('wgl_time_line_section',
            array(
                'label'         => esc_html__('General Settings', 'inpulse-core'),
            )
        );

        $this->add_control(
            'add_appear',
            array(
                'label'        => esc_html__('Add Appear Animation','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control('start_image',
            array(
                'label'         => esc_html__('Time Line Start Image', 'inpulse-core'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'def',
                'options'       => [
                    'def'           => 'Default',
                    'custom'        => 'Custom',
                    'none'          => 'None',
                ],
            )
        );

        $this->add_control('start_image_thumb',
            array(
                'label'       => esc_html__( 'Thumbnail', 'inpulse-core' ),
                'type'        => Controls_Manager::MEDIA,
                'condition'   =>[
                    'start_image' => 'custom'
                ]
            )
        );

        $this->add_responsive_control(
            'start_image_margin',
            array(
                'label' => esc_html__( 'Image Margin', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .time_line-start_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'   =>[
                    'start_image' => 'custom'
                ]
            )
        );

        $this->add_control(
            'line_color',
            array(
                'label' => esc_html__( 'Line Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-timeline-vertical' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /* Start General Settings Section */
        $this->start_controls_section('content_section',
            array(
                'label'         => esc_html__('Content Settings', 'inpulse-core'),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title',
            array(
                'label'             => esc_html__('Title', 'inpulse-core'),
                'type'              => Controls_Manager::TEXTAREA,
				'default'           => esc_html__( 'This is the heading​', 'inpulse-core' ),
				'placeholder'       => esc_html__( 'This is the heading​', 'inpulse-core' ),
                'dynamic' => ['active' => true],
            )
        );

        $repeater->add_control(
            'content',
            array(
                'label' => esc_html__('Content', 'inpulse-core'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'inpulse-core'),
                'dynamic' => ['active' => true],
            )
        );

        $repeater->add_control(
            'date',
            array(
                'label'             => esc_html__('Date', 'inpulse-core'),
                'type'              => Controls_Manager::TEXT,
				'default' => '',
            )
        );

        $this->add_control(
            'items',
            array(
                'label'   => esc_html__( 'Layers', 'inpulse-core' ),
                'type'    => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default' => [
                    ['title' => esc_html__('This is the heading​', 'inpulse-core')],
                    ['title' => esc_html__('This is the heading​', 'inpulse-core')],
                ],
                'title_field' => '{{title}}',
            )
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        //Title Styles

        $this->start_controls_section(
            'title_style_section',
            array(
                'label'     => esc_html__( 'Title', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .time_line-text',
            )
        );

        $this->start_controls_tabs(
            'title_colors'
        );

        $this->start_controls_tab(
            'title_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'title_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .time_line-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'title_hover_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $third_color,
                'selectors' => array(
                    '{{WRAPPER}} .time_line-item:hover .time_line-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .time_line-item:hover .time_line-pointer:before' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Content Styles

        $this->start_controls_section(
            'content_style_section',
            array(
                'label'     => esc_html__( 'Content', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'content_typo',
                'selector' => '{{WRAPPER}} .time_line-text',
            )
        );

        $this->add_control(
            'content_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .time_line-text' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'content_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .time_line-content' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'content_border_radius',
            array(
                'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default'   => [
                    'top' => 15,
                    'right' => 15,
                    'bottom' => 15,
                    'left' => 15,
                    'unit'  => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .time_line-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            )
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'selector' => '{{WRAPPER}} .time_line-content',
			]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'content_shadow',
				'selector' => '{{WRAPPER}} .time_line-content',
			]
		);

        $this->end_controls_section();

        // Date Styles

        $this->start_controls_section(
            'date_style_section',
            array(
                'label'     => esc_html__( 'Date', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'date_typo',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                ],
                'selector' => '{{WRAPPER}} .time_line-date',
            )
        );

        $this->start_controls_tabs(
            'date_colors'
        );

        $this->start_controls_tab(
            'date_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'date_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ccd0de',
                'selectors' => array(
                    '{{WRAPPER}} .time_line-date' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'date_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'inpulse-core' ),
            ]
        );

        $this->add_control(
            'date_hover_color',
            array(
                'label' => esc_html__( 'Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $third_color,
                'selectors' => array(
                    '{{WRAPPER}} .time_line-item:hover .time_line-date' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {

        wp_enqueue_script('appear', get_template_directory_uri() . '/js/jquery.appear.js', array(), false, false);

        $settings = $this->get_settings_for_display();

        // HTML tags allowed for rendering
        $allowed_html = array(
            'a' => array(
                'href' => true,
                'title' => true,
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'span' => array(
                'class' => true,
                'style' => true,
            ),
            'p' => array(
                'class' => true,
                'style' => true,
            )
        );

        $timeline_start_image = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink x="0px" y="0px" viewBox="0 0 120.8 171.4" xml:space="preserve"><path d="M66.1,143.5c2.3,0,4.3-1.1,5.7-2.8c0.2,0,0.5,0,0.7,0c6.4,0,15.8-2.5,21.1-12.3c2.3-4.3,8.3-22.3,13.1-38.3 c0.4-1.3-0.1-2.6-1.1-3.3c6.9-23,14-49.2 15-60.7c0.6-7.2-0.9-12.7-4.4-16.5c-3.5-3.7-8.1-4.5-10.4-4.7c-0.6-1-1.7-1.7-2.9-1.7 c-0.8,0-1.4,0.3-2,0.7c-1.1-2.4-3.4-4-6.2-4C91,0,88,3,88,6.8c0,3.7,3,6.8,6.8,6.8c2.7,0,5.1-1.6,6.2-4c0.6,0.4,1.3,0.7,2,0.7 c1,0,1.9-0.4,2.5-1.1c1.6,0.1,5.2,0.7,7.9,3.5c2.7,2.9,3.8,7.3,3.3,13.3c-1,11.3-8,37.2-14.8,59.9c-1.2,0.1-2.4,0.9-2.7,2.1 c-6,19.6-11,34-12.5,36.8c-3.9,7.3-10.9,8.2-14.3,8.1c-1.2-2.1-3.5-3.5-6.2-3.5H54.5c-2.6,0-4.9,1.4-6.2,3.5 c-3.5 0-10.3-0.9-14.1-8.1c-1.5-2.8-6.5-17.1-12.5-36.8c-0.4-1.2-1.5-2.1-2.7-2.1C12.1,63,5.1,37.1,4.1,25.8 c-0.5-6,0.6-10.4,3.3-13.3c2.7-2.8,6.3-3.4,7.9-3.5c0.6,0.7,1.5,1.1,2.5,1.1c0.8,0,1.4-0.3,2-0.7c1.1,2.4,3.4,4,6.2,4 c3.7,0,6.8-3,6.8-6.8c0-3.7-3-6.8-6.8-6.8c-2.7,0-5.1,1.6-6.2,4c-0.6-0.4-1.3-0.7-2-0.7c-1.3,0-2.4,0.7-2.9,1.7 C12.7,5.2,8.1,6,4.6,9.7C1,13.5-0.5,19,0.1,26.2c1,11.4,8.1,37.7,15,60.7c-1,0.7-1.5,2-1.1,3.3c4.9,15.9,10.8,33.9,13.1,38.3 c5.3,9.8,14.8,12.3,21.1,12.3c0.2,0,0.4,0,0.6,0c1.3,1.7,3.4,2.8,5.7,2.8h1.8v27.6c2.7,0.1,5.3,0.2,8,0.3v-27.9H66.1z"/></svg>';

        $this->add_render_attribute( 'timeline-vertical', [
			'class' => [
                'wgl-timeline-vertical',
                'start-'.$settings['start_image'],
                ((bool)$settings['add_appear'] ? 'appear_anim' : ''),
            ],
        ] );

        $this->add_render_attribute( 'start_image', [
			'class' => 'start_image',
            'src' => esc_url($settings['start_image_thumb']['url']),
            'alt' => Control_Media::get_image_alt( $settings['start_image_thumb'] ),
        ] );

        ?>
        <div <?php echo $this->get_render_attribute_string( 'timeline-vertical' ); ?>>
        <div class="time_line-start_image"><?php
            if ($settings['start_image'] == 'def') {
                echo $timeline_start_image;
            }?>
        </div><?php
        if ($settings['start_image'] == 'custom') {?>
            <div class="time_line-start_image"><img <?php echo $this->get_render_attribute_string( 'start_image' ); ?> /></div><?php
        }?>
        <div class="time_line-items_wrap"><?php

        foreach ( $settings['items'] as $index => $item ) {

            $title = $this->get_repeater_setting_key( 'title', 'items' , $index );
            $this->add_render_attribute( $title, [
                'class' => [
                    'time_line-title',
                ],
            ] );

            $item_wrap = $this->get_repeater_setting_key( 'item_wrap', 'items' , $index );
            $this->add_render_attribute( $item_wrap, [
                'class' => [
                    'time_line-item',
                ],
            ] );

            ?>
            <div <?php echo $this->get_render_attribute_string( $item_wrap ); ?>>
                <div class="time_line-pointer"></div>
                <div class="time_line-curve"></div>
                <div class="time_line-content"><?php
                    if (!empty($item['content']) || !empty($item['title'])) {
                        if (!empty($item['title'])) {?>
                            <h3 <?php echo $this->get_render_attribute_string( $title ); ?>><?php echo $item['title'] ?></h3><?php
                        }
                        if (!empty($item['content'])){?>
                            <div class="time_line-text"><?php echo wp_kses( $item['content'], $allowed_html );?></div><?php
                        }
                        if (!empty($item['date'])){?>
                            <h4 class="time_line-date"><?php echo $item['date'] ?></h4><?php
                        }
                    }?>
                </div>
            </div><?php
        }?>
        </div>
        <div class="time_line-end_image"></div>
        </div><?php

    }

}