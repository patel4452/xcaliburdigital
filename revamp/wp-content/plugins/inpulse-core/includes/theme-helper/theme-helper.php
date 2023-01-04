<?php
class WglThemeHelper{

    protected static $instance = null;

    /**
     * @var \WP_Post
     */
    private $post_id;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    } 

    private function __construct () {
        $this->post_id = get_the_ID();
    }

    public function render_post_share ($show_share) {
        $img_url = wp_get_attachment_image_src(get_post_thumbnail_id($this->post_id), 'single-post-thumbnail')[0] ?? '';

        if ($show_share == "1" || $show_share == "yes") :
        ?>
            <!-- post share block -->
            <div class="share_social-wpapper">					
                <a class="share_link share_twitter" target="_blank" href="<?php echo esc_url('https://twitter.com/intent/tweet?text='. get_the_title() .'&amp;url='. get_permalink()); ?>">
                    <div class="share_link-block">
                        <span class="fa fa-twitter"></span>
                        <span class="share_link-title"><?php echo esc_html__('Twitter', 'inpulse-core');?></span>                    
                    </div>
                </a>
                <a class="share_link share_facebook" target="_blank" href="<?php echo  esc_url('https://www.facebook.com/share.php?u='. get_permalink()); ?>">
                    <div class="share_link-block">
                        <span class="fa fa-facebook"></span>
                        <span class="share_link-title"><?php echo esc_html__('Facebook', 'inpulse-core');?></span>
                    </div>
                </a>
                <?php 
                    if (strlen($img_url) > 0) {
                        echo '<a class="share_link share_pinterest" target="_blank" href="'. esc_url('https://pinterest.com/pin/create/button/?url='. get_permalink() .'&media='. $img_url) .'"><div class="share_link-block"><span class="fa fa-pinterest-p"></span><span class="share_link-title">'. esc_html__('Pinterest', 'inpulse-core').'</span></div></a>';
                    }
                ?>
                <a class="share_link share_linkedin" href="<?php echo esc_url('http://www.linkedin.com/shareArticle?mini=true&url='.substr(urlencode( get_permalink() ),0,1024));?>&title=<?php echo esc_attr(substr(urlencode(html_entity_decode(get_the_title())),0,200));?>" target="_blank" >
                    <div class="share_link-block">
                        <span class="fa fa-linkedin"></span>
                        <span class="share_link-title"><?php echo esc_html__('Linkedin', 'inpulse-core');?></span>
                    </div>
                </a>
            </div>
            <!-- //post share block -->
        <?php
        endif;
    }

    public function render_post_list_share(){
        ?>
        <div class="share_post-container">
            <a href="#"></a>
            <div class="share_social-wpapper">
                <ul>
                    <li>
                        <a class="share_post share_twitter" target="_blank" href="<?php echo esc_url('https://twitter.com/intent/tweet?text='. get_the_title() .'&amp;url='. get_permalink()); ?>">
                            <span class="fa fa-twitter"></span>
                        </a>                
                    </li>
                    <li>
                        <a class="share_post share_facebook" target="_blank" href="<?php echo  esc_url('https://www.facebook.com/share.php?u='. get_permalink()); ?>">
                            <span class="fa fa-facebook"></span>
                        </a>            
                    </li> 
                    <?php
                    $img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail')[0] ?? '';
                    if (strlen($img_url) > 0) {
                        echo '<li>';
                        echo '<a class="share_post share_pinterest" target="_blank" href="'. esc_url('https://pinterest.com/pin/create/button/?url='. get_permalink() .'&media='. $img_url) .'"><span class="fa fa-pinterest"></span></a>';
                        echo '</li>';
                    }
                    ?>
                    <li>
                        <a class="share_post share_linkedin" target="_blank" href="<?php echo esc_url('http://www.linkedin.com/shareArticle?mini=true&url='.substr(urlencode( get_permalink() ),0,1024));?>&title=<?php echo esc_attr(substr(urlencode(html_entity_decode(get_the_title())),0,200));?>">
                            <span class="fa fa-linkedin"></span>
                        </a>                                    
                    </li>
                </ul>
            </div>
        </div>	    
        <?php
    }

    public static function render_social_shares(){
        $description = esc_html__('Socials', 'inpulse-core');

        $facebook    = InPulse_Theme_Helper::options_compare('soc_icon_facebook', 'mb_customize_soc_shares', 'on');
        $twitter     =  InPulse_Theme_Helper::options_compare('soc_icon_twitter', 'mb_customize_soc_shares', 'on');
        $linkedin    = InPulse_Theme_Helper::options_compare('soc_icon_linkedin', 'mb_customize_soc_shares', 'on');
        $pinterest   = InPulse_Theme_Helper::options_compare('soc_icon_pinterest', 'mb_customize_soc_shares', 'on');
        $tumblr      = InPulse_Theme_Helper::options_compare('soc_icon_tumblr', 'mb_customize_soc_shares', 'on');

        $fixed   = InPulse_Theme_Helper::options_compare('soc_icon_position', 'mb_customize_soc_shares', 'on');
        $offset = InPulse_Theme_Helper::get_option('soc_icon_offset');
        if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
            $mb_social_shares = rwmb_meta('mb_customize_soc_shares');
        
            if ($mb_social_shares == 'on') {
                $offset = array();
                $offset['margin-bottom'] = rwmb_meta('mb_soc_icon_offset');
            }
        }   

        $share = InPulse_Theme_Helper::options_compare('soc_icon_style', 'mb_customize_soc_shares', 'on');
        $share_class = !empty($share) ? " ".$share.'_style' : ' standard_style';
        $share_class .= !empty($fixed) ? " fixed" : '';

        $units = !empty($fixed) ? "%" : 'px';
        $style = '';
        $style .=  isset($offset['margin-bottom']) && $offset['margin-bottom'] !== '' ? ' top:'.(int)$offset['margin-bottom'].$units.';' : '';                

        ?>
        <section class="wgl-social-share_pages<?php echo esc_attr($share_class);?>"<?php
            echo !empty($style) ? ' style="'.$style.'"' : ''
        ?>>
            <div class="share_social-wpapper">
                <?php
                    if($share == 'hovered'):
                ?>
                    <div class="share_social-desc">
                        <div class="share_social-title">
                        <?php
                            echo apply_filters('inpulse_desc_socials', $description);
                        ?>                                
                        </div>
                        <div class="share_social-icon-plus"></div>
                    </div>
                <?php
                    endif;
                ?>
                <ul>
                    <?php
                    if(!empty($twitter)):
                    ?>
                        <li>
                            <a class="share_page share_twitter" target="_blank" href="<?php echo esc_url('https://twitter.com/intent/tweet?text='. get_the_title() .'&amp;url='. get_permalink()); ?>"><span class="fa fa-twitter"></span></a>                
                        </li>
                    <?php
                    endif;
                    ?>

                    <?php
                    if(!empty($facebook)):
                    ?>
                    <li>
                        <a class="share_page share_facebook" target="_blank" href="<?php echo  esc_url('https://www.facebook.com/share.php?u='. get_permalink()); ?>"><span class="fa fa-facebook"></span></a>            
                    </li>

                    <?php
                    endif;
                    ?>  

                    <?php
                    if(!empty($share_pinterest)):
                    ?>     
                    <?php
                    $img_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'single-post-thumbnail')[0] ?? '';
                    if (strlen($img_url) > 0) {
                        echo '<li>';
                        echo '<a class="share_page share_pinterest" target="_blank" href="'. esc_url('https://pinterest.com/pin/create/button/?url='. get_permalink() .'&media='. $img_url) .'"><span class="fa fa-pinterest"></span></a>';
                        echo '</li>';
                    }
                    ?>
                    <?php
                    endif;
                    ?>  


                    <?php
                    if(!empty($linkedin)):
                    ?>
                    <li>
                        <a class="share_page share_linkedin" target="_blank" href="<?php echo esc_url('http://www.linkedin.com/shareArticle?mini=true&url='.substr(urlencode( get_permalink() ),0,1024));?>&title=<?php echo esc_attr(substr(urlencode(html_entity_decode(get_the_title())),0,200));?>"><span class="fa fa-linkedin"></span></a>                                    
                    </li>
                    <?php
                    endif;
                    ?>                         

                    <?php
                    if(!empty($tumblr)):
                    ?>
                    <li>
                        <a class="share_page share_tumblr" target="_blank" href="<?php echo esc_url( 'http://www.tumblr.com/share/link?url=' . urlencode(get_permalink()). '&amp;name=' . urlencode(get_the_title()) .'&amp;description='.urlencode(get_the_excerpt()) );?>"><span class="fa fa-tumblr"></span></a>                                    
                    </li>
                    <?php
                    endif;

                    $custom_share = InPulse_Theme_Helper::get_option('add_custom_share');
                    if(isset($custom_share) && !empty($custom_share)){
                        for ($i = 1; $i <= 10; $i++) {
                            ${'custom_share_'.$i} = InPulse_Theme_Helper::get_option('select_custom_share_text-'.$i);
                            ${'custom_share_icons'.$i} = InPulse_Theme_Helper::get_option('select_custom_share_icons-'.$i);
                            
                            if (!empty(${'custom_share_'.$i})) {
                                ?>
                                <li>
                                    <a class="share_page" target="_blank" href="<?php echo esc_url( ${'custom_share_'.$i} );?>"><span class="<?php echo esc_attr(${'custom_share_icons'.$i});?>"></span></a>                                    
                                </li>
                                <?php                                   
                            }
                        }
                    }
                    ?> 
                </ul>
            </div>                
        </section>
        <?php
    }
    
}

function wgl_theme_helper() {
	return WglThemeHelper::instance();
}
?>