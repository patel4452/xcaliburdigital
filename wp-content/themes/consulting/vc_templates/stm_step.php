<?php

$heading = '';
$date_format = (!empty($atts['stm_date_format'])) ? $atts['stm_date_format'] : 'Y-m-d';
$time_format = (!empty($atts['stm_time_format'])) ? $atts['stm_time_format'] : 'H:i';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

?>

<div class="item">
    <div class="step_title"><?php echo esc_html( $stm_step_title ); ?></div>
    <div class="step_description"><?php echo esc_html( $stm_step_content ); ?></div>
</div>
