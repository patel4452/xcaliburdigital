<?php
namespace WglAddons\Controls;

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
* Wgl Elementor Custom Icon Control
*
*
* @class        Wgl_Icon
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

class Wgl_Icon extends Base_Data_Control{

    /**
     * Get radio image control type.
     *
     * Retrieve the control type, in this case `radio-image`.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Control type.
     */
    public function get_type() {
        return 'wgl-icon';
    }

    public function enqueue() {
        // Scripts
        wp_enqueue_script( 'wgl-elementor-extensions', WGL_ELEMENTOR_ADDONS_URL . 'assets/js/wgl_elementor_extenstions.js');

        // Style
        wp_enqueue_style( 'wgl-elementor-extensions', WGL_ELEMENTOR_ADDONS_URL . 'assets/css/wgl_elementor_extenstions.css');
    }

    public static function get_flaticons( ) {
        return array(
            'flaticon-left-arrow' => 'left-arrow',
            'flaticon-right-arrow' => 'right-arrow',
            'flaticon-search' => 'search',
            'flaticon-supermarket' => 'supermarket',
            'flaticon-shopping-cart' => 'shopping-cart',
            'flaticon-heart' => 'heart',
            'flaticon-quote' => 'quote',
            'flaticon-check' => 'check',
            'flaticon-pen' => 'pen',
            'flaticon-idea' => 'idea',
            'flaticon-rocket' => 'rocket',
            'flaticon-design-tool' => 'design-tool',
            'flaticon-paper-plane' => 'paper-plane',
            'flaticon-value' => 'value',
            'flaticon-files' => 'files',
            'flaticon-worldwide' => 'worldwide',
            'flaticon-award' => 'award',
            'flaticon-size' => 'size',
            'flaticon-font' => 'font',
            'flaticon-chain' => 'chain',
            'flaticon-sound-waves' => 'sound-waves',
            'flaticon-comment' => 'comment',
            'flaticon-heart-1' => 'heart-1',
            'flaticon-e-commerce-like-heart' => 'e-commerce-like-heart',
            'flaticon-eye' => 'eye',
            'flaticon-menu' => 'menu',
            'flaticon-contact' => 'contact',
            'flaticon-hierarchical-structure' => 'hierarchical-structure',
            'flaticon-headphones' => 'headphones',
            'flaticon-chart' => 'chart',
            'flaticon-filter' => 'filter',
            'flaticon-bag' => 'bag',
            'flaticon-bag-1' => 'bag-1',
            'flaticon-bag-2' => 'bag-2',
            'flaticon-star' => 'star',
            'flaticon-star-1' => 'star-1',
            'flaticon-next' => 'next',
            'flaticon-comment-1' => 'comment-1',
            'flaticon-box' => 'box',
            'flaticon-team' => 'team',
            'flaticon-question' => 'question',
            'flaticon-info' => 'info',
            'flaticon-cancel' => 'cancel',
            'flaticon-pencil-case' => 'pencil-case',
            'flaticon-idea-1' => 'idea-1',
            'flaticon-technological' => 'technological',
            'flaticon-close-button' => 'close-button',
            'flaticon-forbidden-mark' => 'forbidden-mark',
            'flaticon-shapes-and-symbols' => 'shapes-and-symbols',
            'flaticon-tick' => 'tick',
        );
    }

    /**
     * Get radio image control default settings.
     *
     *
     * @since 1.0.0
     * @access protected
     *
     * @return array Control default settings.
     */
    protected function get_default_settings() {
        return [
            'label_block' => true,
            'options' => self::get_flaticons(),
            'include' => '',
            'exclude' => '',
            'select2options' => [],
        ];
    }

    /**
     * Render radio image control output in the editor.
     *
     * Used to generate the control HTML in the editor using Underscore JS
     * template. The variables for the class are available using `data` JS
     * object.
     *
     * @since 1.0.0
     * @access public
     */
    public function content_template() {

        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <# if ( data.label ) {#>
                <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper">
                <select id="<?php echo $control_uid; ?>" class="elementor-control-icon elementor-select2" type="select2"  data-setting="{{ data.name }}" data-placeholder="<?php echo __( 'Select Icon', 'inpulse-core' ); ?>">
                    <# _.each( data.options, function( option_title, option_value ) {
                        var value = data.controlValue;
                        if ( typeof value == 'string' ) {
                            var selected = ( option_value === value ) ? 'selected' : '';
                        } else if ( null !== value ) {
                            var value = _.values( value );
                            var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
                        }
                        #>
                    <option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
                    <# } ); #>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
            <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}

?>