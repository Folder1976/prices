<?php echo $header; ?>

<main role="main" class="l-brand_page">
  <div class="b-brand_page-header">
    <div class="l-search_result-options">
      <!-- Хлебные крошки. START -->
      <div class="l-breadcrumb">
        <ul class="b-product_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
            <?php $count = 0; ?>
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <li class="b-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" <?php if ($count == 0) { echo ' style="display: none;"';} ?>>
                    <a  class="b-breadcrumb-link js-breadcrumb_refinement-link" href="<?php echo $breadcrumb['href']; ?>" itemprop="item" title="<?php echo $breadcrumb['text']; ?>"><span itemprop="name"><?php echo $breadcrumb['text']; ?></span></a>
                    <meta content="<?php echo $count++; ?>">
                </li>
            <?php } ?>
        </ul>
      </div>
      <!-- Хлебные крошки. END -->

      <!-- Отображение списка товарово (Список/Сетка). START -->
      <div class="b-filter_view-header b-change_view">
        <ul class="b-change_view-list">
          <li class="b-change_view-item"><span class="b-change_view-type b-change_view-type_four js-four-columns b-change_view-type-active" data-grid-class="m-four-columns"></span></li>
          <li class="b-change_view-item"><span class="b-change_view-type b-change_view-type_two js-two-columns" data-grid-class="m-two-columns"></span></li>
        </ul>
      </div>
      <!-- Отображение списка товарово (Список/Сетка). END -->

    </div>
  </div>



  <div class="l-brand_content">
            <div class="l-search_result-content m-four-columns">
                <div class="b-list_item_page js-list_item_page" >
                    <div class="l-product_tiles">

                         <?php foreach ($products as $product) { ?>
                        <div class="b-product_tile b-product_tile--1" data-product-name="<?php echo $product['name']; ?>">
                            <div class="b-product-hover_box js-product-hover_box">
                                <a class="b-product_image-wrapper" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>">
                                <img alt="<?php echo $product['name']; ?>" class="js-producttile_image b-product_image" src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" data-altimage="<?php echo $product['thumb_second']; ?>" >
                                </a>

                                <div class="b-productile_hover">
                                    <div class="b-productile_hover-inner">
                                        <div class="b-productile_hover-middle_box">
                                            <div class="b-productile_hover-middle_box_inner">
                                                <div class="b-product_variations--plp">
                                                    <div class="b-variation">
                                                        <ul class="b-variation-list">
                                                            <li class="b-variation-item b-variation-item--size">
                                                                <div class="b-variation-dropdown">
                                                                    <div class="b-variation-value Size">
                                                                        <div class="b-variation-title">
                                                                            <?php echo $text_select_size; ?>
                                                                        </div>
                                                                        <div class="b-variation-size_chart_link" data-href="/<?php echo $language_href; ?>">
                                                                            <span><?php echo $text_size_help; ?></span>
                                                                        </div>
                                                                        <ul class="b-swatches_size">
                                                                            <?php if ( count($product['size']) < 2 ) { ?>
                                                                                <li class="b-swatches_size-item emptyswatch"><?php echo $text_onesize; ?></li>
                                                                            <?php } else { ?>
                                                                            <?php    foreach ( $product['size'] as $size ) { ?>

                                                                                <li class="b-swatches_size-item emptyswatch">
                                                                                    <a class="jb-swatches_size-link" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>?size=<?php echo $size['size_id']?>" title="<?php echo $size['size_name']?>"><?php echo $size['size_name']?></span></a>
                                                                                </li>

                                                                            <?php } // end foreach ?>
                                                                            <?php } // end if ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="b-variation-item">
                                                                <div class="b-variation-dropdown">
                                                                    <div class="b-variation-value color">
                                                                        <span class="b-variation-title">цвет</span> <span>Черный</span>
                                                                        <ul class="b-swatches_color">
                                                                            <li class="b-swatches_color-item b-swatches_color-item-selected">
                                                                                <a class="b-swatches_color-link-selected b-swatches_color-link" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" style="background-color: #000000;" title="Черный"></a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!--span class="b-quickview">Быстрая покупка</span>
                                                <span class="b-add_to_wishlist b-product_tile-add_to_wishlist" data-href="/ru/wishlist-add?pid=F61D5TFMME1S8031&amp;source=search">В список желаний</span-->
                                            </div>
                                            <a class="b-product_name product_name" href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="b-product_name product_name" href="<?php echo $product['href']; ?>" title="<?php echo $product['name']; ?>"><?php echo $product['name']; ?></a>


                            <div class="b-product_price" style="">
                                <h4 class="b-product_price-standard" style=""><?php echo $product['price']; ?></h4>
                            </div>

                            <div class="b-stars" id="pr_snippet_category_eb4a072633fc70c126cf01c646">
                                <script type="text/javascript">
                                //if (typeof POWERREVIEWS != "undefined") { 
                                //POWERREVIEWS.display.snippet({write : function(content) { jQuery('#pr_snippet_category_eb4a072633fc70c126cf01c646').append(content); }}, 
                                //{
                                //pr_page_id : 'F61D5TFMME1S8031', 
                                //pr_snippet_min_reviews : '0'
                                //}
                                //)
                                //}
                                </script>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

  </div>



</main>




<?php
//header("Content-Type: text/html; charset=UTF-8");
//echo "<pre>";  print_r(var_dump( get_defined_vars() )); echo "</pre>";
//echo "<style> pre header {display: none;}</style>";
?>


<?php echo $footer; ?>