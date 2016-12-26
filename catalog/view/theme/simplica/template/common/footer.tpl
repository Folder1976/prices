<?php
            /*
            $currency_text = "Валюта";
            $country_language_text = 'Валюта&amp;Язык:';
            $text_select_currency = 'Валюта';
            */
            $text_selected_currency = $currencies[$_SESSION['default']['currency']]['title'];
            
             
            if($_SERVER['REQUEST_URI'] == '/'){
                $curr_href = 'index.php?currency=';
            }else{
                if(strpos($_SERVER['REQUEST_URI'],'?') !== false){
                    $curr_href =  $_SERVER['REQUEST_URI'].'&currency=';
                }else{
                    $curr_href =  $_SERVER['REQUEST_URI'].'?currency=';
                } 
            }

?>

<?php if ( isset($_GET['route']) AND 
           ( $_GET['route'] == 'checkout/cart' OR 
             $_GET['route'] == 'checkout/checkout' 
           )
         ) { ?>
<footer class="l-footer_checkout">
    <div class="b-copyright_footer">COPYRIGHT © PLAZAMILANO 2016 - ONLINE CLOTHES SHOP. All rights reserved</div>
</footer>
<?php } else { ?>

<footer class="l-footer js-footer_container" id="footer" role="contentinfo">
    <div class="l-footer_navigation">
        <div class="b-footer_navigation_list">
            <div class="b-footer_navigation_list-item">
                <div class="b-content_asset b-content_asset--mobile-footer-top-menu content-asset">
                    <ul class="b-mobile_footer_menu">
                        <?php if ($informations) { ?>
                        <?php foreach ($informations as $information) { ?>
                        <li class="b-mobile_footer_menu-item">
                            <a href="<?php echo $language_href.$information['href']; ?>" class="b-mobile_footer_menu-link"><?php echo $information['title']; ?></a>
                        </li>
                        <?php } ?>
                        <?php } ?>
                        <!--li class="b-mobile_footer_menu-item">
                            <a class="b-mobile_footer_menu-link" href="/<?php echo $language_href; ?>contact_us"><?php echo $text_contact; ?></a>
                        </li>
                        <li class="b-mobile_footer_menu-item">
                            <a class="b-mobile_footer_menu-link" href="/<?php echo $language_href; ?>brands"><?php echo $text_manufacturer; ?></a>
                        </li>
                        <li class="b-mobile_footer_menu-item">
                            <a class="b-mobile_footer_menu-link" href="/<?php echo $language_href; ?>account"><?php echo $text_account; ?></a>
                        </li>
                        <li class="b-mobile_footer_menu-item">
                            <a class="b-mobile_footer_menu-link" href="/<?php echo $language_href; ?>order"><?php echo $text_order; ?></a>
                        </li>
                        <li class="b-mobile_footer_menu-item">
                            <a class="b-mobile_footer_menu-link" href="/<?php echo $language_href; ?>wishlist"><?php echo $text_wishlist; ?></a>
                        </li>
                        <li class="b-mobile_footer_menu-item">
                            <a class="b-mobile_footer_menu-link" href="/<?php echo $language_href; ?>newsletter"><?php echo $text_newsletter; ?></a>
                        </li-->
                    </ul>
                </div>
            </div>

<!-- 
            <div class="b-footer_navigation_list-item">
                <div class="b-content_asset b-content_asset--mobile-footer-misc-links content-asset">
                    <ul class="b-mobile_misc_menu">

                    </ul>
                </div>
            </div>

 -->

            <div class="b-footer_navigation_list-item">
                <div class="b-language_selector">
                    <span class="js_fancybox">
                        <div><?php echo $country_language_text; ?></div><?php echo $text_selected_currency; ?> / <?php echo $languages[$language_code]['name'];?> (<?php echo $text_change; ?>)
                    </span>
                    <span class="h-hidden">
                        <div class="b-language_selector-flyout js-country_language_selector">

                            <div class="b-language_selector-country">
                                <p class="b-language_selector-country_title"><?php echo $currency_text; ?></p>

                                <ul class="b-language_selector-country_list">
                                    <?php foreach ($currencies as $index => $currency) { ?>
                                    <li class="b-language_selector-country_item">
                                        <a class="b-language_selector-country_link" href="<?php echo $curr_href.$index; ?>"><?php echo $currency['symbol_left'].' '.$currency['symbol_right'].' '.$currency['title']; ?></a>
                                    </li>
                                    <?php } ?>
                                  </ul>
                            </div>

                            <div class="b-language_selector-language">
                                <p class="b-language_selector-language_title"><?php echo $text_select_language; ?></p>

                                <ul class="b-language_selector-language_list">
                                    <?php foreach ($languages as $lang) { ?>
                                    <li class="b-language_selector-language_item">
                                        <?php $html = '/'.$lang['code'].'/'.$url_no_lang; ?>
                                        <a class="b-language_selector-language_link <?php if ($lang['code'] == $language_code) echo 'b-language_selector-language_item--selected';?>" href="<?php echo str_replace('//','/',$html);?>"><?php echo $lang['name'];?> (<?php echo $lang['code'];?>)</a>
                                    </li>
                                    <?php } ?>
                                </ul>

                            </div>

                        </div>
                    </span>
                </div>
            </div>

            <!--div class="b-footer_navigation_list-item">
                <div class="b-content_asset b-content_asset--mobile-footer-social-icons content-asset">
                    <ul class="b-mobile_social_menu">
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-facebook" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-twitter" href="/" target="_blank"></a>
                            </li>    
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-instagram" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-pinterest" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-youtube" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-linkedin" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-tumblr" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-youko" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-googleplus" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-odnoklassniki" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-livejournal" href="/" target="_blank"></a>
                            </li>
                            <li class="b-mobile_social_menu-item">
                                <a class="b-mobile_social_menu-link b-mobile_social_menu-weibo" href="/" target="_blank"></a>
                            </li>
                    </ul>
                </div>
            </div-->

            <div class="b-footer_navigation_list-item">
                <div class="b-content_asset b-content_asset--mobile-footer-copyright content-asset">
                    <p>
                        <span style="text-transform:uppercase;">COPYRIGHT © PLAZAMILANO 2016 - ONLINE CLOTHES SHOP. All rights reserved</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="l-footer_top">
        <div class="l-footer_top-locale">
            <div class="l-footer_top-country">
                <div class="l-footer_top-locale-labels">
                    <?php echo $text_select_currency; ?>:
                </div>
                <div class="l-footer_top-locale-selectors">
                    <span class="b-language_selector-current_language"><?php echo $text_selected_currency; ?></span> <span class="l-footer_top-locale-selectors-change js-toggler"
                                data-close-element=".country-selector-close"
                                data-slide=".js-footer_min_country_selector"
                                data-toggle-class="h-minimized"
                                data-toggle-closeonesc="yes"
                                data-toggle-closeonoutsideclick="yes" data-toggle-elem-class="h-toggled">(<?php echo $text_change; ?>)</span>
                    <div class="b-language_selector-flyout js-footer_min_country_selector js-toggler-slide h-minimized">
                        <div class="b-language_selector-container">
                            <div class="b-language_selector-language">
                                <h3><?php echo $text_select_currency; ?></h3>
                                <p class="b-language_selector-country_title"><?php echo $text_selected_currency; ?></p>
                                <ul class="b-language_selector-country_list">
                                        <?php //echo $currency; ?>
                                    <?php foreach ($currencies as $index => $currency) { ?>
                                    <li class="b-language_selector-country_item <?php if($index == $_SESSION['default']['currency']){?>b-language_selector-language_item--selected<?php } ?>">
                                        <a class="b-language_selector-country_link" href="<?php echo $curr_href.$index; ?>"><?php echo $currency['symbol_left'].' '.$currency['symbol_right'].' '.$currency['title']; ?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="l-close country-selector-close"></div>
                    </div>
                </div>
            </div>
            <div class="l-footer_top-language">
                <div class="l-footer_top-locale-labels">
                    <?php echo $text_language; ?>:
                </div>
                <div class="l-footer_top-locale-selectors">
                    <div class="b-language_selector">
                        <span><?php echo $languages[$language_code]['name'];?></span> <span class="b-language_selector-change js-toggler"
                                    data-close-element=".lang-selector-close"
                                    data-slide=".js-footer_min_language_selector"
                                    data-toggle-class="h-minimized"
                                    data-toggle-closeonesc="yes"
                                    data-toggle-closeonoutsideclick="yes" data-toggle-elem-class="h-toggled">(<?php echo $text_change; ?>)</span>
                        <div class="b-language_selector-flyout js-footer_min_language_selector js-toggler-slide h-minimized">
                            <div class="b-language_selector-container">
                                <div class="b-language_selector-language">
                                    <h3><?php echo $text_select_language; ?></h3>
                                    <ul class="b-language_selector-language_list">
                                        <?php foreach ($languages as $lang) { ?>
                                        <li class="b-language_selector-language_item">
                                            <?php $html = '/'.$lang['code'].'/'.$url_no_lang; ?>
                                            <a class="b-language_selector-language_link <?php if ($lang['code'] == $language_code) echo 'b-language_selector-language_item--selected';?>" href="<?php echo str_replace('//','/',$html);?>"><?php echo $lang['name'];?> (<?php echo $lang['code'];?>)</a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="l-close lang-selector-close"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="l-footer_top-newsletter">
        </div>
    </div>

    <div class="l-footer_bottom-navigation">
        <ul class="l-footer_bottom-navigation_list">
            <li style="list-style: none; display: inline">
                <div class="b-content_asset b-content_asset--footer-misc-links content-asset">
                    <ul class="b-footer_bottom-navigation_list">
                        <li class="b-footer_bottom-navigation_item top-category">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link"
                            href="/<?php echo $language_href; ?>customer-care"><?php echo $text_customer_care; ?></a></h6>
                        </li>
                        <?php if ($informations) { ?>
                        <?php foreach ($informations as $information) { ?>
                        <li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="<?php echo $language_href.$information['href']; ?>"><?php echo $information['title']; ?></a></h6>
                        </li>
                        <?php } ?>
                        <?php } ?>

                        <li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="/<?php echo $language_href; ?>contact_us"><?php echo $text_contact; ?></a></h6>
                        </li>
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="<?php echo $language_href.$return; ?>"><?php echo $text_return; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="<?php echo $language_href.$sitemap; ?>"><?php echo $text_sitemap; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="/<?php echo $language_href; ?>brands"><?php echo $text_manufacturer; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="<?php echo $language_href.$voucher; ?>"><?php echo $text_voucher; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="<?php echo $language_href.$affiliate; ?>"><?php echo $text_affiliate; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="<?php echo $language_href.$special; ?>"><?php echo $text_special; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="/<?php echo $language_href; ?>account"><?php echo $text_account; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="/<?php echo $language_href; ?>order"><?php echo $text_order; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="/<?php echo $language_href; ?>wishlist"><?php echo $text_wishlist; ?></a></h6>
                        </li-->
                        <!--li class="b-footer_bottom-navigation_item subcategory">
                            <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="/<?php echo $language_href; ?>newsletter"><?php echo $text_newsletter; ?></a></h6>
                        </li-->
                    </ul>
                </div>
            </li>
            <?php if ( isset($categories) ) {  ?>
            <?php foreach ($categories as $category) { ?>
            <li class="l-footer_bottom-navigation_list-item">
                <ul class="b-footer_bottom-navigation_list">
                    <li class="b-footer_bottom-navigation_item top-category">
                        <h6 class="b-footer_bottom-navigation_title"><span class="b-footer_bottom-navigation_link"><?php echo $category['name']; ?></span></h6>
                    </li>
                    <?php foreach ($category['children'] as $child2) { ?>
                    <li class="b-footer_bottom-navigation_item subcategory">
                        <h6 class="b-footer_bottom-navigation_title"><a class="b-footer_bottom-navigation_link" href="/<?php echo $language_href.$child2['href']; ?>" rel="nofollow"><?php echo $child2['name']; ?></a></h6>
                    </li>
                    <?php } ?>
                </ul>
            </li>
            <?php } ?>
            <?php } ?>
        </ul>
    </div>


    <div class="l-footer-copyright_soc">
        <div class="l-footer-copyright_soc-content">
            <div class="l-footer-mini">
                <div class="b-content_asset b-content_asset--mini-footer content-asset">
                    <p><span style="text-transform:uppercase;">COPYRIGHT © PLAZAMILANO 2016 - ONLINE CLOTHES SHOP. All rights reserved</span></p>
                </div><!-- End content-asset mini-footer -->
            </div>
            <div class="l-social-links">
                <div class="b-content_asset b-content_asset--footer-social-icons content-asset">
                  #social key
                </div><!-- End content-asset footer-social-icons -->
            </div>
        </div>
    </div>
</footer>

<div class="l-scroll_to_top">
    <div class="b-scroll_to_top js-scroll_to_top h-opaque"></div>
</div>

<?php } ?>



<link href="/catalog/view/theme/simplica/stylesheet/owl.carousel.css" rel="stylesheet">
<script src="catalog/view/theme/simplica/js/develop.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
    $('.js_fancybox').on('click', function(){
        var c = $('.js-country_language_selector');

        $.fancybox.open({
            content: c,
            type: 'html',
            padding: 0,
            margin: 0,
            wrapCSS: 'b-country_language-popup',
            tpl: {
                closeBtn : '<span class="fancybox-close"></span>'
            }
        });
    });
});
</script>


</body></html>