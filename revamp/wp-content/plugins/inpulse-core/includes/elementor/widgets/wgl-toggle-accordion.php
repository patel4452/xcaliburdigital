<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Elementor_Helper;
use WglAddons\Templates\WglToggleAccordion;
use Elementor\Frontend;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wgl_Toggle_Accordion extends Widget_Base {

    public function get_name() {
        return 'wgl-toggle-accordion';
    }

    public function get_title() {
        return esc_html__('Wgl Toggle/Accordion', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-toggle-accordion';
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
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
        $this->start_controls_section('wgl_accordion_section',
            array(
                'label'         => esc_html__('General', 'inpulse-core'),
            )
        );

        $this->add_control('acc_type',
            array(
                'label'             => esc_html__('Type', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'default' => 'accordion',
                'options' => [
                    'accordion' => esc_html__('Accordion', 'inpulse-core'),
                    'toggle' => esc_html__('Toggle', 'inpulse-core'),
                ],
            )
        );

        $this->add_control('enable_acc_icon',
            array(
                'label'             => esc_html__('Icon', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'default' => 'def',
                'options' => [
                    'none' => esc_html__('None', 'inpulse-core'),
                    'def' => esc_html__('Default', 'inpulse-core'),
                    'pluse' => esc_html__('Pluse', 'inpulse-core'),
                    'custom' => esc_html__('Custom', 'inpulse-core'),
                ],
            )
        );

        $this->add_control('acc_icon',
            array(
                'label'             => esc_html__('Toggle Icon', 'inpulse-core'),
                'type'              => Controls_Manager::ICON,
                'default' => 'fa fa-angle-right',
                'include' => [
                    'fa fa-plus',
                    'fa fa-long-arrow-right',
                    'fa fa-chevron-right',
                    'fa fa-chevron-circle-right',
                    'fa fa-arrow-right',
                    'fa fa-arrow-circle-right',
                    'fa fa-angle-right',
                    'fa fa-angle-double-right',
                ],
                'condition' => [
                    'enable_acc_icon' => 'custom',
                ],
            )
        );

        $this->add_responsive_control(
			'acc_margin',
			[
				'label' => esc_html__( 'Margin', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        /*End General Settings Section*/
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Content Section(Title Section)
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'content_section',
            array(
                'label'     => esc_html__( 'Content', 'inpulse-core' ),
            )
        );

        $this->add_responsive_control(
			'acc_tab_panel_margin',
			[
				'label' => esc_html__( 'Tab Panel Margin', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 22,
                    'left' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $repeater = new Repeater();
        $repeater->add_control(
			'acc_tab_title',
			[
                'label' => esc_html__('Tab Title', 'inpulse-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Tab Title', 'inpulse-core'),
                'dynamic' => ['active' => true],
			]
        );
        $repeater->add_control(
			'acc_tab_title_pref',
			[
                'label' => esc_html__('Title Prefix', 'inpulse-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('1.', 'inpulse-core'),
			]
        );
        $repeater->add_control(
			'acc_tab_def_active',
			[
                'label' => esc_html__('Active as Default', 'inpulse-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'return_value' => 'yes',
			]
        );
        $repeater->add_control(
			'acc_content_type',
			[
                'label' => esc_html__('Content Type', 'inpulse-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => esc_html__('Content', 'inpulse-core'),
                    'template' => esc_html__('Saved Templates', 'inpulse-core'),
                ],
                'default' => 'content',
			]
        );
        $repeater->add_control(
			'acc_content_templates',
			[
                'label' => esc_html__('Choose Template', 'inpulse-core'),
                'type' => Controls_Manager::SELECT,
                'options' => Wgl_Elementor_Helper::get_instance()->get_elementor_templates(),
                'condition' => [
                    'acc_content_type' => 'template',
                ],
			]
        );
        $repeater->add_control(
			'acc_content',
			[
                'label' => esc_html__('Tab Content', 'inpulse-core'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'inpulse-core'),
                'dynamic' => ['active' => true],
                'condition' => [
                    'acc_content_type' => 'content',
                ],
			]
        );

        $this->add_control(
            'acc_tab',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    ['acc_tab_title' => esc_html__('Tab Title 1', 'inpulse-core'),
                    'acc_tab_def_active' => 'yes'],
                    ['acc_tab_title' => esc_html__('Tab Title 2', 'inpulse-core')],
                    ['acc_tab_title' => esc_html__('Tab Title 3', 'inpulse-core')],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{acc_tab_title}}',
            ]
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Title Section)
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'acc_title_style',
            array(
                'label'     => esc_html__( 'Title', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'acc_title_typo',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                ],
                'selector' => '{{WRAPPER}} .wgl-accordion_title',
            )
        );

        $this->add_control(
			'acc_title_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'inpulse-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'h4',
			]
		);

        $this->add_responsive_control(
			'acc_title_padding',
			[
				'label' => esc_html__( 'Padding', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 22,
                    'left' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'acc_title_margin',
			[
				'label' => esc_html__( 'Margin', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );
        /* Tabs */
        $this->start_controls_tabs('acc_header_tabs');
        /* Normal */
        $this->start_controls_tab('acc_header_normal', ['label' => esc_html__('Normal', 'inpulse-core')]);

        $this->add_control(
            'acc_title_color',
            array(
                'label' => esc_html__( 'Title Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'acc_title_bg_color',
            array(
                'label' => esc_html__( 'Title Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header' => 'background-color: {{VALUE}};',
                ),
            )
        );

		$this->add_control(
			'acc_title_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_title_border',
				'selector' => '{{WRAPPER}} .wgl-accordion_header',
			]
		);

        $this->end_controls_tab();
        /* End Normal Tab */
        /* Hover */
        $this->start_controls_tab('acc_header_hover', ['label' => esc_html__('Hover', 'inpulse-core')]);

        $this->add_control(
            'acc_title_color_hover',
            array(
                'label' => esc_html__( 'Title Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'acc_title_bg_color_hover',
            array(
                'label' => esc_html__( 'Title Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

		$this->add_control(
			'acc_title_border_radius_hover',
			[
				'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_header:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_title_border_hover',
				'selector' => '{{WRAPPER}} .wgl-accordion_header:hover',
			]
		);

        $this->end_controls_tab();
        /* End Hover Tab */
        /* Active */
        $this->start_controls_tab('acc_header_active', ['label' => esc_html__('Active', 'inpulse-core')]);

        $this->add_control(
            'acc_title_color_active',
            array(
                'label' => esc_html__( 'Title Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header.active' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'acc_title_bg_color_active',
            array(
                'label' => esc_html__( 'Title Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header.active' => 'background-color: {{VALUE}};',
                ),
            )
        );

		$this->add_control(
			'acc_title_border_radius_active',
			[
				'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_title_border_active',
				'selector' => '{{WRAPPER}} .wgl-accordion_header.active',
			]
		);

        $this->end_controls_tab();
        /* End Active Tab */
        $this->end_controls_tabs();
        /* End Tabs */
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Title Prefix Section)
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'acc_title_pref_style',
            array(
                'label'     => esc_html__( 'Title Prefix', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'acc_title_pref_typo',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_family' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_family']],
                    'font_weight' => ['default' => \Wgl_Addons_Elementor::$typography_1['font_weight']],
                ],
                'selector' => '{{WRAPPER}} .wgl-accordion_title .wgl-accordion_title-prefix',
            )
        );

        /* Tabs */
        $this->start_controls_tabs('acc_header_pref_tabs');
        /* Normal */
        $this->start_controls_tab('acc_header_pref_normal', ['label' => esc_html__('Normal', 'inpulse-core')]);

        $this->add_control(
            'acc_titlepref_color',
            array(
                'label' => esc_html__( 'Title Prefix Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header .wgl-accordion_title-prefix' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();
        /* End Normal Tab */
        /* Hover */
        $this->start_controls_tab('acc_header_pref_hover', ['label' => esc_html__('Hover', 'inpulse-core')]);

        $this->add_control(
            'acc_titlepref_color_hover',
            array(
                'label' => esc_html__( 'Title Prefix Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_title-prefix' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();
        /* End Hover Tab */
        /* Active */
        $this->start_controls_tab('acc_header_pref_active', ['label' => esc_html__('Active', 'inpulse-core')]);

        $this->add_control(
            'acc_titlepref_color_active',
            array(
                'label' => esc_html__( 'Title Prefix Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header.active .wgl-accordion_title-prefix' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();
        /* End Active Tab */
        $this->end_controls_tabs();
        /* End Tabs */
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Icon Section)
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'icon_style_section',
            array(
                'label'     => esc_html__( 'Icon', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'acc_icon_size',
            [
                'label' => esc_html__('Icon Size', 'inpulse-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 24,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl-accordion_icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_acc_icon' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
			'acc_icon_padding',
			[
				'label' => esc_html__( 'Padding', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'acc_icon_margin',
			[
				'label' => esc_html__( 'Margin', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_control(
			'acc_icon_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        /* Tabs */
        $this->start_controls_tabs('acc_icon_tabs');
        /* Normal */
        $this->start_controls_tab('acc_icon_normal', ['label' => esc_html__('Normal', 'inpulse-core')]);

        $this->add_control(
            'acc_icon_color',
            array(
                'label' => esc_html__( 'Icon Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_icon:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .icon-pluse .wgl-accordion_icon:before,{{WRAPPER}} .icon-pluse .wgl-accordion_icon:after' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'acc_icon_bg_color',
            array(
                'label' => esc_html__( 'Icon Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_icon' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();
        /* End Normal Tab */
        /* Hover */
        $this->start_controls_tab('acc_icon_hover', ['label' => esc_html__('Hover', 'inpulse-core')]);

        $this->add_control(
            'acc_icon_color_hover',
            array(
                'label' => esc_html__( 'Icon Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_icon:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .icon-pluse .wgl-accordion_header:hover .wgl-accordion_icon:before, {{WRAPPER}} .icon-pluse .wgl-accordion_header:hover .wgl-accordion_icon:after' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'acc_icon_bg_color_hover',
            array(
                'label' => esc_html__( 'Icon Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header:hover .wgl-accordion_icon' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();
        /* End Hover Tab */
        /* Active */
        $this->start_controls_tab('acc_icon_active', ['label' => esc_html__('Active', 'inpulse-core')]);

        $this->add_control(
            'acc_icon_color_active',
            array(
                'label' => esc_html__( 'Icon Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header.active .wgl-accordion_icon:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .icon-pluse .wgl-accordion_header.active .wgl-accordion_icon:before, {{WRAPPER}} .icon-pluse .wgl-accordion_header.active .wgl-accordion_icon:after' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'acc_icon_bg_color_active',
            array(
                'label' => esc_html__( 'Icon Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_header.active .wgl-accordion_icon' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();
        /* End Active Tab */
        $this->end_controls_tabs();

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section(Content Section)
        /*-----------------------------------------------------------------------------------*/
        $this->start_controls_section(
            'acc_content_style',
            array(
                'label'     => esc_html__( 'Content', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name' => 'acc_content_typo',
                'selector' => '{{WRAPPER}} .wgl-accordion_content',
            )
        );

        $this->add_responsive_control(
			'acc_content_padding',
			[
				'label' => esc_html__( 'Padding', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 22,
                    'right' => 50,
                    'bottom' => 5,
                    'left' => 0,
                    'isLinked' => false
                ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'acc_content_margin',
			[
				'label' => esc_html__( 'Margin', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_control(
            'acc_content_color',
            array(
                'label' => esc_html__( 'Content Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_content' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'acc_content_bg_color',
            array(
                'label' => esc_html__( 'Content Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .wgl-accordion_content' => 'background-color: {{VALUE}};',
                ),
            )
        );

		$this->add_control(
			'acc_content_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wgl-accordion_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'acc_content_border',
				'selector' => '{{WRAPPER}} .wgl-accordion_content',
			]
		);

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $id_int = substr($this->get_id_int(), 0, 3);

        $this->add_render_attribute( 'accordion', [
			'class' => [
                'wgl-accordion',
                'icon-'.$settings['enable_acc_icon'],
            ],
			'id' => 'wgl-accordion-'.esc_attr($this->get_id()),
			'data-type' => $settings['acc_type'],
        ] );

        ?>
        <div <?php echo $this->get_render_attribute_string( 'accordion' ); ?>>

            <?php
            foreach ( $settings['acc_tab'] as $index => $item ) :

                $tab_count = $index + 1;

				$tab_title_key = $this->get_repeater_setting_key( 'acc_tab_title', 'acc_tab', $index );

                $this->add_render_attribute( $tab_title_key, [
					'id' => 'wgl-accordion_header-' . $id_int . $tab_count,
					'class' => [ 'wgl-accordion_header' ],
                    'data-default' => $item['acc_tab_def_active'],
				] );

                ?>
                <div class="wgl-accordion_panel">
                    <<?php echo $settings['acc_title_tag']; ?> <?php echo $this->get_render_attribute_string( $tab_title_key ); ?>>
                        <span class="wgl-accordion_title"><?php
                            if (!empty($item['acc_tab_title_pref'])) {?>
                                <span class="wgl-accordion_title-prefix"><?php echo $item['acc_tab_title_pref'] ?></span><?php
                            }
                            echo $item['acc_tab_title'] ?></span>
                        <?php if ($settings['enable_acc_icon'] != 'none'): ?><i class="wgl-accordion_icon <?php echo $settings['acc_icon'] ?>"></i><?php endif;?>
                    </<?php echo $settings['acc_title_tag']; ?>>
                    <div class="wgl-accordion_content"><?php
                        if ($item['acc_content_type'] == 'content') {
                            echo do_shortcode($item['acc_content']);
                        } else if($item['acc_content_type'] == 'template'){
                            $id = $item['acc_content_templates'];
                            $wgl_frontend = new Frontend;
                            echo $wgl_frontend->get_builder_content_for_display( $id, true );
                        }
                    ?></div>
                </div>
            <?php endforeach;?>

        </div>
        <?php

    }

}