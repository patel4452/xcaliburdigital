<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$theme = stm_get_theme_info();
$theme_name = $theme['name'];

$other_themes = consulting_other_themes();
$theme_name = STM_ITEM_NAME;
unset($other_themes->themes->$theme_name);
?>

<div class="wrap about-wrap stm-admin-wrap  stm-admin-other-themes">
	<?php stm_get_admin_tabs('other_themes'); ?>

    <div class="other-themes__wrap_box">
        <?php foreach($other_themes->themes as $theme): ?>
        <div class="other-themes__box">
            <div class="other-themes__theme">
                <div class="other-themes__screen">
                    <a href="<?php echo wp_kses_post($theme->themeforest_url); ?>?ref=stylemixthemes" target="_blank">
                        <img src="<?php echo wp_kses_post($theme->preview); ?>" alt="<?php echo wp_kses_post($theme->name); ?>" />
                    </a>
                </div>
                <div class="other-themes__content">
                    <div class="other-themes__title">
                        <a href="<?php echo wp_kses_post($theme->themeforest_url); ?>?ref=stylemixthemes" target="_blank"><?php echo wp_kses_post($theme->name); ?></a>
                        <div class="other-themes__author">
                            <i><?php _e( 'by', 'consulting' ); ?></i> <a href="<?php echo wp_kses_post($theme->author_url); ?>" target="_blank"><?php echo wp_kses_post($theme->author); ?></a>
                        </div>
                    </div>
                    <div class="other-themes__price">
                        <?php echo wp_kses_post($theme->price); ?>
                    </div>
                </div>
                <div class="other-themes__buttons">
                    <div class="other-themes__sales">
                        <?php echo wp_kses_post($theme->sales); ?> <?php _e( 'Sales', 'consulting' ); ?>
                    </div>
                    <a href="<?php echo wp_kses_post($theme->live_site); ?>" class="btn_preview" target="_blank"><?php _e( 'Preview', 'consulting' ); ?></a>
                    <a href="<?php echo wp_kses_post($theme->themeforest_url); ?>?ref=stylemixthemes&license=regular&open_purchase_for_item_id=<?php echo intval($theme->id); ?>&purchasable=source" class="btn_purchase" target="_blank">
                        <svg fill="currentColor" height="1em" width="1em" viewBox="0 0 16 16" style="vertical-align:middle"><g><path d="M 0.009 1.349 C 0.009 1.753 0.347 2.086 0.765 2.086 C 0.765 2.086 0.766 2.086 0.767 2.086 L 0.767 2.09 L 2.289 2.09 L 5.029 7.698 L 4.001 9.507 C 3.88 9.714 3.812 9.958 3.812 10.217 C 3.812 11.028 4.496 11.694 5.335 11.694 L 14.469 11.694 L 14.469 11.694 C 14.886 11.693 15.227 11.36 15.227 10.957 C 15.227 10.552 14.886 10.221 14.469 10.219 L 14.469 10.217 L 5.653 10.217 C 5.547 10.217 5.463 10.135 5.463 10.031 L 5.487 9.943 L 6.171 8.738 L 11.842 8.738 C 12.415 8.738 12.917 8.436 13.175 7.978 L 15.901 3.183 C 15.96 3.08 15.991 2.954 15.991 2.828 C 15.991 2.422 15.65 2.09 15.23 2.09 L 3.972 2.09 L 3.481 1.077 L 3.466 1.043 C 3.343 0.79 3.084 0.612 2.778 0.612 C 2.777 0.612 0.765 0.612 0.765 0.612 C 0.347 0.612 0.009 0.943 0.009 1.349 Z M 3.819 13.911 C 3.819 14.724 4.496 15.389 5.335 15.389 C 6.171 15.389 6.857 14.724 6.857 13.911 C 6.857 13.097 6.171 12.434 5.335 12.434 C 4.496 12.434 3.819 13.097 3.819 13.911 Z M 11.431 13.911 C 11.431 14.724 12.11 15.389 12.946 15.389 C 13.784 15.389 14.469 14.724 14.469 13.911 C 14.469 13.097 13.784 12.434 12.946 12.434 C 12.11 12.434 11.431 13.097 11.431 13.911 Z"></path></g></svg>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>