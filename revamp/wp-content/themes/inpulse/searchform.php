<?php
/**
 * Template for displaying search forms in InPulse
 *
 * @package WordPress
 * @subpackage InPulse
 * @since 1.0
 * @version 1.0
 */

?>
<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>
<form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-form">
    <input type="text" id="<?php echo esc_attr($unique_id); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Start Typing &hellip;', 'placeholder', 'inpulse' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <input class="search-button" type="submit" value="<?php esc_attr_e('Search', 'inpulse'); ?>">
</form>