<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$content = str_replace('[stm_step', '[stm_step stm_button="' . $link . '" ', $content);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

if (!empty($link)) {
    $link = vc_build_link($link);
    $text = '<a href="' . esc_attr($link['url']) . '" class="vc_general vc_btn3 vc_btn3-size-lg vc_btn3-shape-rounded vc_btn3-style-outline vc_btn3-color-theme_style_2"'
        . ($link['target'] ? ' target="' . esc_attr($link['target']) . '"' : '')
        . ($link['title'] ? ' title="' . esc_attr($link['title']) . '"' : '')
        . '>' . esc_attr($link['title']) . '</a>';
}

wp_enqueue_script('owl.carousel');
wp_enqueue_style('owl.carousel');
wp_enqueue_style('steps');

$id = rand(0, 999999);
?>

<div id="<?php echo esc_attr($id); ?>" class="steps_box">
    <?php echo wpb_js_remove_wpautop($content); ?>
</div>

<?php echo consulting_filtered_output($text); ?>

<script type="text/javascript">
    (function ($) {

        $(window).load(function () {
            stm_owl_load();
        });

        function stm_owl_load() {
            var owlRtl = false;
            if ($('body').hasClass('rtl')) {
                owlRtl = true;
            }

            var fixOwl = function () {
                var $stage = $('#<?php echo esc_js($id); ?> .owl-stage'),
                    stageW = $stage.width(),
                    $el = $('#<?php echo esc_js($id); ?>').find('.owl-item'),
                    elW = 0;
                $el.each(function () {
                    var elWidth = parseFloat($(this).width());
                    var elMargins = parseFloat(($(this).css("margin-right").slice(0, -2)));
                    elW += elWidth + elMargins;
                });
                if (elW > stageW) {
                    $stage.width(elW);
                }
            };

            $('#<?php echo esc_js($id); ?>').owlCarousel({
                rtl: owlRtl,
                margin: 20,
                dots: true,
                onInitialized: fixOwl,
                onRefreshed: fixOwl,
                responsive: {
                    0: {
                        items: 1,
                        dots: false
                    },
                    550: {
                        items: 1,
                        dots: false
                    },
                    768: {
                        items: 2
                    },
                    1100: {
                        items: 3
                    },
                    1400: {
                        items: 3
                    }
                }
            });

        }
    })(jQuery)
</script>
