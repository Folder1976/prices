                    <div class="b-customer_service_navigation-section  b-customer_service_navigation-section--first ">
                        <div class="b-customer_service_navigation-category">
                            <ul class="b-customer_service_navigation-list">
                                 
                                <?php if ( isset($informations) && $informations ) { ?>
                                <?php foreach ($informations as $information) { ?>
                                <li class="b-customer_service_navigation-list-li ">
                                    <a class="b-customer_service_navigation-link" href="<?php echo $language_href.$information['keyword']; ?>" title="<?php echo $information['title']; ?>"><?php echo $information['title']; ?></a>
                                    <div class="b-customer_service_navigation-description">
                                    </div>
                                </li>
                                <?php } ?>
                                <?php } ?>

                                <li class="b-customer_service_navigation-list-li ">
                                    <a class="b-customer_service_navigation-link" href="/<?php echo $language_href; ?>contact_us"><?php echo $text_contact; ?></a></h6>
                                    <div class="b-customer_service_navigation-description">
                                    </div>
                                </li>
                     
                            </ul>
                        </div>
                    </div>
