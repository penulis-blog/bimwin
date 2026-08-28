    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
    <script src="assets/frontend/js/jquery-3.6.0.min.js"></script>
    <script src="assets/frontend/js/jquery-migrate-3.4.0.min.js"></script>
    <script src="assets/frontend/js/mfn.menu.js"></script>
    <script src="assets/frontend/js/jquery.plugins.js"></script>
    <script src="assets/frontend/js/jquery.jplayer.min.js"></script>
    <script src="assets/frontend/js/animations.js"></script>
    <script src="assets/frontend/js/scripts.js"></script>
    <script src="assets/frontend/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.video.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.actions.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.navigation.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.migration.min.js"></script>
    <script src="assets/frontend/rs-plugin/js/extensions/revolution.extension.parallax.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('frontend.partials.ajax')

    <script>
        var tpj = jQuery;

        var revapi1;
        tpj(document).ready(function() {
            if (tpj("#rev_slider_1_2").revolution == undefined) {
                revslider_showDoubleJqueryError("#rev_slider_1_2");
            } else {
                revapi1 = tpj("#rev_slider_1_2").show().revolution({
                    sliderType: "standard",
                    sliderLayout: "auto",
                    dottedOverlay: "none",
                    delay: 9000,
                    navigation: {
                        keyboardNavigation: "off",
                        keyboard_direction: "horizontal",
                        mouseScrollNavigation: "off",
                        onHoverStop: "on",
                        touch: {
                            touchenabled: "on",
                            swipe_threshold: 75,
                            swipe_min_touches: 50,
                            swipe_direction: "horizontal",
                            drag_block_vertical: false
                        },
                        arrows: {
                            style: "uranus",
                            enable: true,
                            hide_onmobile: true,
                            hide_under: 600,
                            hide_onleave: true,
                            hide_delay: 200,
                            hide_delay_mobile: 1200,
                            tmp: '',
                            left: {
                                h_align: "left",
                                v_align: "bottom",
                                h_offset: 30,
                                v_offset: 30
                            },
                            right: {
                                h_align: "right",
                                v_align: "bottom",
                                h_offset: 30,
                                v_offset: 30
                            }
                        }
                    },
                    responsiveLevels: [1240, 1024, 778, 480],
                    gridwidth: [1240, 1024, 778, 480],
                    gridheight: [600, 768, 960, 720],
                    lazyType: "smart",
                    parallax: {
                        type: "mouse",
                        origo: "slidercenter",
                        speed: 2000,
                        levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50],
                    },
                    shadow: 2,
                    spinner: "off",
                    stopLoop: "off",
                    stopAfterLoops: -1,
                    stopAtSlide: -1,
                    shuffle: "off",
                    autoHeight: "off",
                    hideThumbsOnMobile: "off",
                    hideSliderAtLimit: 0,
                    hideCaptionAtLimit: 0,
                    hideAllCaptionAtLilmit: 0,
                    startWithSlide: 0,
                    debugMode: false,
                    fallbacks: {
                        simplifyAll: "off",
                        nextSlideOnWindowFocus: "off",
                        disableFocusListener: "off",
                    }
                });
            }
        });
    </script>

    <script>
        //<![CDATA[
        jQuery(window).on('load', function() {
            var retina = window.devicePixelRatio > 1 ? true : false;
            if (retina) {
                var retinaEl = jQuery("#logo img");
                var retinaLogoW = retinaEl.width();
                var retinaLogoH = retinaEl.height();
                retinaEl.attr("src", "assets/frontend/images/logo1.png").width(retinaLogoW).height(
                    retinaLogoH)
            }
        });
        //]]>
    </script>
