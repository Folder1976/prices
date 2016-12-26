<?php
/*
$text_write_to_us = 'Написать нам';
$text_customer_service = 'Клиентская служба онлайн';
$email = 'mail@plazamilano.com';
*/
?>

<?php echo $header; ?>

<main role="main" class="l-main_customer_service">
    <div class="l-customer_service">
        <div class="l-customer_service-top">

            <div class="html-slot-container b-slot--customer-service-top">
                <div class="b-customer_service-sub_header" style="padding-left:31%">
                    <div class="b-customer_service-sub_header-sub_title">
                        <div class="b-customer_service-sub_header-right">
                            <div class="b-customer_service-sub_header-title"><?php echo $text_write_to_us; ?></div>
                            <div class="b-customer_service-sub_header-sub_title"><?php echo $text_customer_service; ?></div>
                            <a class="b-customer_service-sub_header-link" href="index.php?route=information/contact"><?php echo $email; ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="b-customer_service_navigation-mob-button js-toggler"
                 data-slide=".js-l-customer_service-left"
                 data-toggle-class="h-minimized-customer_service-left"
                 data-toggle-elem-class="h-toggled"></div>
            <div class="l-customer_service-left js-l-customer_service-left h-minimized-customer_service-left">
                <div class="b-customer_service_navigation">
                    <?php echo $leftmenu; ?>
                </div>
            </div>

            <div class="l-customer_service-right">

                <div class="l-customer_service_content lang-ru">
                    <div class="b-content_asset b-content_asset--faqs content-asset">
                        <div class="content row">

                            <h1><?php echo $heading_title; ?></h1>
                            <?php echo $description; ?>

                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
</main>

<?php echo $footer; ?>
