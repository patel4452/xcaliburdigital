<?php
namespace WglAddons\Widgets;

use WglAddons\Includes\Wgl_Loop_Settings;
use WglAddons\Includes\Wgl_Carousel_Settings;
use WglAddons\Templates\WglTeam;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Wgl_Team extends Widget_Base {
    
    public function get_name() {
        return 'wgl-team';
    }

    public function get_title() {
        return esc_html__('Wgl Team', 'inpulse-core' );
    }

    public function get_icon() {
        return 'wgl-team';
    }

    public function get_categories() {
        return [ 'wgl-extensions' ];
    }

    // Adding the controls fields for the premium title
    // This will controls the animation, colors and background, dimensions etc
    protected function _register_controls() {
        $theme_color = esc_attr(\InPulse_Theme_Helper::get_option('theme-custom-color'));
        $theme_color_secondary = esc_attr(\InPulse_Theme_Helper::get_option('theme-secondary-color'));
        $header_font = \InPulse_Theme_Helper::get_option('header-font');

        /* Start General Settings Section */
        $this->start_controls_section('wgl_team_section',
            array(
                'label'         => esc_html__('Team Posts Settings', 'inpulse-core'),
            )
        );   

        $this->add_control('posts_per_line',
            array(
                'label'             => esc_html__('Columns in Row', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    '1'          => esc_html__('1', 'inpulse-core'),
                    '2'          => esc_html__('2', 'inpulse-core'),
                    '3'          => esc_html__('3', 'inpulse-core'),
                    '4'          => esc_html__('4', 'inpulse-core'),
                    '5'          => esc_html__('5', 'inpulse-core'),
                ],
                'default'           => '3',
            )
        );          

        $this->add_control('info_align',
            array(
                'label'             => esc_html__('Team Info Alignment', 'inpulse-core'),
                'type'              => Controls_Manager::SELECT,
                'options'           => [
                    'left'          => esc_html__('Left', 'inpulse-core'),
                    'center'        => esc_html__('Center', 'inpulse-core'),
                    'right'         => esc_html__('Right', 'inpulse-core'),
                ],
                'default'           => 'left',
            )
        ); 

        $this->add_control('grayscale_anim',
            array(
                'label'        => esc_html__('Add Grayscale Animation','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );           

        $this->add_control('info_anim',
            array(
                'label'        => esc_html__('Add Info Fade Animation','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->add_control('single_link_wrapper',
            array(
                'label'        => esc_html__('Add Link for Image','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );        

        $this->add_control('single_link_heading',
            array(
                'label'        => esc_html__('Add Link for Heading','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
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

        $this->add_control('hide_title',
            array(
                'label'        => esc_html__('Hide Title','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );         

        $this->add_control('hide_department',
            array(
                'label'        => esc_html__('Hide Department','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );         

        $this->add_control('hide_counter',
            array(
                'label'        => esc_html__('Hide Counter','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );             

        $this->add_control('hide_soc_icons',
            array(
                'label'        => esc_html__('Hide Social Icons','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        );         

        $this->add_control('hide_content',
            array(
                'label'        => esc_html__('Hide Content','inpulse-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );         

        $this->add_control('letter_count',
            array(
                'label'       => esc_html__('Content Letters Count', 'inpulse-core'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => '100',
                'min'         => 1,
                'step'        => 1,
                'condition'     => [
                    'hide_content!'  => 'yes',
                ]
            )
        ); 
        
        
        $this->end_controls_section();      

        Wgl_Carousel_Settings::options($this);

        /*-----------------------------------------------------------------------------------*/
        /*  Build Query Section 
        /*-----------------------------------------------------------------------------------*/

        Wgl_Loop_Settings::init( $this, array('post_type' => 'team', 'hide_cats' => true,
                    'hide_tags' => true) );

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'item_style_section',
            [
                'label' => esc_html__( 'Items Style', 'inpulse-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_gap',
            [
                'label' => esc_html__( 'Gap Items', 'inpulse-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'left' => 15,
                    'right' => 15,
                    'bottom' => 55,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wgl_module_team .team-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wgl_module_team .team-items_wrap' => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}}; margin-bottom: -{{BOTTOM}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
           
        $this->start_controls_section(
            'background_style_section',
            array(
                'label' => esc_html__( 'Overlay', 'inpulse-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'bg_color_type',
            array(
                'label' => esc_html__('Customize Backgrounds','inpulse-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'On', 'inpulse-core' ),
                'label_off' => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->start_controls_tabs( 'background_color_tabs' );

        $this->start_controls_tab(
            'custom_background_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
                'condition' => [ 'bg_color_type' => 'yes' ],
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'background_color',
                'label' => esc_html__( 'Background Idle', 'inpulse-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wgl_module_team .team-image:before',
                'condition' => [ 'bg_color_type' => 'yes' ],
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_background_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
                'condition' => [ 'bg_color_type' => 'yes' ],
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name' => 'background_hover_color',
                'label' => esc_html__( 'Background Hover', 'inpulse-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .wgl_module_team .team-image:after',
                'condition' => [ 'bg_color_type' => 'yes' ],
            )
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();  

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
                'name' => 'title_team_headings',
                'selector' => '{{WRAPPER}} .team-title',
            )
        );

        $this->add_control(
            'custom_title_color',
            array(
                'label'        => esc_html__('Customize Colors','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->start_controls_tabs( 'title_color_tabs' );

        $this->start_controls_tab(
            'custom_title_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
                'condition'     => [ 
                    'custom_title_color'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'title_color',
            array( 
                'label' => esc_html__( 'Title Idle', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font['color'],
                'selectors' => array(
                    '{{WRAPPER}} .team-title' => 'color: {{VALUE}}',
                ),
                'condition'     => [ 
                    'custom_title_color'   => 'yes',
                ],
            )
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
                'condition'     => [ 
                    'custom_title_color'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'title_hover_color',
            array( 
                'label' => esc_html__( 'Title Hover', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => esc_attr($theme_color),
                'selectors' => array(
                    '{{WRAPPER}} .team-title:hover' => 'color: {{VALUE}}',
                ),
                'condition'     => [ 
                    'custom_title_color'   => 'yes',
                ],
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();          

        $this->start_controls_section(
            'department_style_section',
            array(
                'label'     => esc_html__( 'Meta Info', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'custom_depart_color',
            array(
                'label'        => esc_html__('Customize Color','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->add_control(
            'depart_color',
            array( 
                'label' => esc_html__( 'Meta Color', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $theme_color,
                'selectors' => array(
                    '{{WRAPPER}} .team-department, {{WRAPPER}} .wgl_module_team .team-meta_info .team-counter' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wgl_module_team .team-meta_info .line' => 'background: {{VALUE}}',
                ),
                'condition'     => [ 
                    'custom_depart_color'   => 'yes',
                ],
            )
        );

        $this->end_controls_section();       

        $this->start_controls_section(
            'soc_icons_style_section',
            array(
                'label'     => esc_html__( 'Social Icons', 'inpulse-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'custom_soc_color',
            array(
                'label'        => esc_html__('Customize Colors','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->start_controls_tabs( 'soc_color_tabs' );

        $this->start_controls_tab(
            'custom_soc_color_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
                'condition'     => [ 
                    'custom_soc_color'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'soc_color',
            array( 
                'label' => esc_html__( 'Icon Idle', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => $header_font['color'],
                'selectors' => array(
                    '{{WRAPPER}} .team-item_info .team-info_icons .team-icon a' => 'color: {{VALUE}}',
                ),
                'condition'     => [ 
                    'custom_soc_color'   => 'yes',
                ],
            )
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_soc_color_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
                'condition'     => [ 
                    'custom_soc_color'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'soc_hover_color',
            array( 
                'label' => esc_html__( 'Icon Hover', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#909aa3',
                'selectors' => array(
                    '{{WRAPPER}} .team-item_info .team-info_icons .team-icon a:hover' => 'color: {{VALUE}}',
                ),
                'condition'     => [ 
                    'custom_soc_color'   => 'yes',
                ],
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'custom_soc_bg_color',
            array(
                'label'        => esc_html__('Customize Backgrounds','inpulse-core' ),
                
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'On', 'inpulse-core' ),
                'label_off'    => esc_html__( 'Off', 'inpulse-core' ),
                'return_value' => 'yes',
            )
        ); 

        $this->start_controls_tabs( 'soc_background_tabs' );

        $this->start_controls_tab(
            'custom_soc_bg_normal',
            array(
                'label' => esc_html__( 'Normal' , 'inpulse-core' ),
                'condition'     => [ 
                    'custom_soc_bg_color'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'soc_bg_color',
            array( 
                'label' => esc_html__( 'Background Idle', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f3f3f3',
                'selectors' => array(
                    '{{WRAPPER}} .team-item_info .team-info_icons .team-icon a' => 'background: {{VALUE}}',
                ),
                'condition'     => [ 
                    'custom_soc_bg_color'   => 'yes',
                ],
            )
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_soc_bg_hover',
            array(
                'label' => esc_html__( 'Hover' , 'inpulse-core' ),
                'condition'     => [ 
                    'custom_soc_bg_color'   => 'yes',
                ],
            )
        );

        $this->add_control(
            'soc_bg_hover_color',
            array( 
                'label' => esc_html__( 'Background Hover', 'inpulse-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#f3f3f3',
                'selectors' => array(
                    '{{WRAPPER}} .team-item_info .team-info_icons .team-icon:hover a' => 'background: {{VALUE}}',
                ),
                'condition'     => [ 
                    'custom_soc_bg_color'   => 'yes',
                ],
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section(); 


    }

    protected function render() {
        $atts = $this->get_settings_for_display();

        $team = new WglTeam();
        echo $team->render($atts);

    }
    
}