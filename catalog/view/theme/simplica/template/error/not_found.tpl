<?php echo $header; ?>
<?php

?>

<main class="b-error-page">
    <div class="g-container">
    <h1 class="b-error-page_title"><?php echo $heading_title; ?></h1>
        <div class="b-error-page_message">
            <div>
                <?php echo $text_error; ?>
            </div>
        </div>

<?php if ( isset($_GET['route']) AND $_GET['route'] != 'checkout/cart' ) { ?>
        <div class="b-error_page-search">
            <form class="b-error_page-form" action="/ru/search-results" method="get" novalidate="novalidate">
                <fieldset>
                <div class="b-error_page-form_row">
                    <label for="error-search" class="f-label"><?php echo $text_new_search; ?></label>
                    <input id="error-search" name="q" value="" class="f-textinput js-validate_placeholder" placeholder="<?php echo $text_new_search; ?>" type="text">
                    <button class="b-error_page-button" type="submit" value="<?php echo $text_go; ?>" name="simplesearch">
                        <?php echo $text_confirm;?>
                    </button>
                </div>
                </fieldset>
            </form>
        </div>

        <div class="b-error_page-footer">
            <div class="b-error_page-footer_asset">
                <div class="b-content_asset b-content_asset--error-service content-asset"></div><!-- End content-asset error-service -->
            </div>
            <div class="b-error_page-footer_slot"></div>
        </div>
    </div>
    
    <div class="l-secondary_content b-error_page-nav">
        <nav>
            <h1 class="h-hidden"><?php echo $text_navigation; ?></h1>
            <div class="b-error_page-secondary_navigation">
                    
                <?php echo $leftmenu; ?>

            </div>
        </nav>
    </div>
<?php } ?>
</main>

<?php echo $footer; ?>
