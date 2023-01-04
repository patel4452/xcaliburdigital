<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Icons;
use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglButton;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wgl_Button extends Widget_Base {
    
    public function get_name() {
        return 'wgl-button';
    }

    public function get_title() {
        return esc_html__('Wgl Button', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-button';
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    public static function get_button_sizes() {
		return [
			// 'xs' => esc_html__( 'Extra Small', 'inpulse-core' ),
			'sm' => esc_html__( 'Small', 'inpulse-core' ),
			'md' => esc_html__( 'Medium', 'inpulse-core' ),
			'lg' => esc_html__( 'Large', 'inpulse-core' ),
			'xl' => esc_html__( 'Extra Large', 'inpulse-core' ),
		];
	}

    protected function _register_controls() {
        $theme_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-custom-color'));
        $second_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-secondary-color'));
        $third_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-third-color'));
        $header_font_color = esc_attr(\InPulse_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\InPulse_Theme_Helper::get_option('main-font')['color']);

        /* Start General Settings Section */
        $this->start_controls_section('wgl_button_section',
            array(
                'label'         => esc_html__('Button Settings', 'inpulse-core'),
            )
        );

		$this->add_control(
			'text',
			[
				'label' => esc_html__( 'Text', 'inpulse-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Click here', 'inpulse-core' ),
				'placeholder' => esc_html__( 'Click here', 'inpulse-core' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'inpulse-core' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'inpulse-core' ),
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'inpulse-core' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'inpulse-core' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => '',
			]
		);

		$this->add_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'inpulse-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lg',
				'options' => self::get_button_sizes(),
				'style_transfer' => true,
			]
        );

		$this->add_control(
			'button_css_id',
			[
				'label' => esc_html__( 'Button ID', 'inpulse-core' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => '',
				'title' => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'inpulse-core' ),
				'label_block' => false,
				'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'inpulse-core' ),
				'separator' => 'before',

			]
		);

        /*End General Settings Section*/
        $this->end_controls_section();  
        
        $output['icon_align'] = array(
            'label' => esc_html__( 'Icon Position', 'inpulse-core' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'left',
            'options' => [
                'left' => esc_html__( 'Before', 'inpulse-core' ),
                'right' => esc_html__( 'After', 'inpulse-core' ),
            ],
            'condition' => [
                'icon_type!' => '',
            ],
        );

        $output['icon_indent'] = array(
            'label' => esc_html__( 'Icon Spacing', 'inpulse-core' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => '10',
            ],
            'condition' => [
                'icon_type!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-align-icon-right .elementor-button-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .elementor-button .elementor-align-icon-left .elementor-button-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
            ],
        );

        Wgl_Icons::init( $this, array( 'label' => esc_html__('Button ', 'inpulse-core'), 'output' => $output,'section' => true, 'prefix' => '' ) ); 

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Button', 'inpulse-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        
		$this->add_control(
			'hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'inpulse-core' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'inpulse-core' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'inpulse-core' ),
				'type' => Controls_Manager::COLOR,
                'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'inpulse-core' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
                ],
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'inpulse-core' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => esc_html__( 'Text Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label' => esc_html__( 'Background Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'inpulse-core' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'border_border!' => '',
				],
                'default' => $theme_color,
				'selectors' => [
					'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'selector' => '{{WRAPPER}} .elementor-button',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
                'default'       => [
                    'top'   => 0,
                    'right' => 0,
                    'bottom'=> 0,
                    'left'  => 0,
                    'unit'  => 'px',
                ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .elementor-button',
			]
		);

		$this->add_responsive_control(
			'text_padding',
			[
				'label' => esc_html__( 'Padding', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

        $this->end_controls_section();     
        
        $this->start_controls_section(
			'icon_section_style',
			[
				'label' => esc_html__( 'Icon', 'inpulse-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Margin', 'inpulse-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style_icon' );

		$this->start_controls_tab(
			'tab_button_normal_icon',
			[
				'label' => esc_html__( 'Normal', 'inpulse-core' ),
			]
		);

		$this->add_control(
			'color_icon',
			[
				'label' => esc_html__( 'Icon Color', 'inpulse-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => $header_font_color,
				'selectors' => [
					'{{WRAPPER}} .elementor-button .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover_icon',
			[
				'label' => esc_html__( 'Hover', 'inpulse-core' ),
			]
		);

		$this->add_control(
			'hover_color_icon',
			[
				'label' => esc_html__( 'Icon Color', 'inpulse-core' ),
				'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .elementor-button:hover .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_tab();

        $this->end_controls_tabs();
        
        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Font Size', 'inpulse-core' ),
                'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
                'range' => [
                    'px' => [
                        'max' => 90,
                    ],
                ],
                'size_units' => [ 'px', 'em', 'rem', 'vw' ],
                'condition' => [
                    'icon_type' => 'font',
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => '13',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-button .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

	}
	
	protected function render() {
        $settings = $this->get_settings_for_display();
    
		echo Wgl_Button::init_button($this, $settings);
    }

	public static function init_button($self, $settings)
	{

		$self->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$self->add_render_attribute( 'button', 'class', 'elementor-button-link' );

			$self->add_link_attributes('button', $settings['link']);
		}

		$self->add_render_attribute( 'button', 'class', 'wgl-button elementor-button' );
		$self->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['button_css_id'] ) ) {
			$self->add_render_attribute( 'button', 'id', $settings['button_css_id'] );
		}

		if ( ! empty( $settings['size'] ) ) {
			$self->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['size'] );
		}

		if ( isset($settings['hover_animation']) ) {
			$self->add_render_attribute( 'button', 'class', 'elementor-animation-' . $settings['hover_animation'] );
		}

		$settings_icon_align = isset($settings['icon_align']) ? $settings['icon_align'] : '';

		$self->add_render_attribute( [
			'content-wrapper' => [
				'class' => [
					'elementor-button-content-wrapper',
					'elementor-align-icon-' . $settings_icon_align,
				]
			],
			'wrapper' => [
				'class' => 'elementor-button-icon',
			],
			'text' => [
				'class' => 'elementor-button-text',
			],
		] );

		?>
		<div <?php echo $self->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $self->get_render_attribute_string( 'button' ); ?>><?php
			if ( !empty($settings['text']) || !empty($settings['icon_type']) ){?>
				<span <?php echo $self->get_render_attribute_string( 'content-wrapper' ); ?>>
					<?php if ( ! empty( $settings['icon_type'] ) ) : 
						$icons = new Wgl_Icons;
						$button_icon_out = $icons->build($self, $settings, array());
						echo \InPulse_Theme_Helper::render_html($button_icon_out);
					endif; ?>
					<span <?php echo $self->get_render_attribute_string( 'text' ); ?>><?php echo $settings['text']; ?></span>
				</span><?php
			}
			?></a>
		</div>
		<?php

    }
}