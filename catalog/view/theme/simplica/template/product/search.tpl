<?php echo $header; ?>

<main class="b-search">
  <!-- Хлебные крошки. START -->
  <div class="b-breadcrumb">
  <?php $count = 0; ?>
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php if ($count == 0) { ?>
      <a href="<?php echo $language_href; ?><?php echo $breadcrumb['href']; ?>" title=""><span class="ic-home"></span><?php echo $breadcrumb['text']; ?></a>
    <?php } else { ?>
      <span>&nbsp;>&nbsp;</span><a href="<?php echo $language_href; ?><?php echo $breadcrumb['href']; ?>" title="<?php echo $breadcrumb['text']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  <?php $count++;} ?>
  </div>
  <!-- Хлебные крошки. END -->

  <div class="g-container" id="content">
    <h1><?php echo $heading_title; ?></h1>

    <div class="f-group">
      <div class="f-field-wrapper">
        <div class="f-label">
          <label for="input-search"><?php echo $entry_search; ?></label>
        </div>

        <div class="f-field">
          <input type="text"
                 name="search"
                 value="<?php echo $search; ?>"
                 placeholder="<?php echo $text_keyword; ?>"
                 id="input-search"
                 class="f-input" />
        </div>

        <div class="f-field">
          <select name="category_id" class="f-select">
            <option value="0"><?php echo $text_category; ?></option>
            <?php foreach ($categories as $category_1) { ?>
            <?php if ($category_1['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_1['children'] as $category_2) { ?>
            <?php if ($category_2['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php } ?>
            <?php foreach ($category_2['children'] as $category_3) { ?>
            <?php if ($category_3['category_id'] == $category_id) { ?>
            <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </select>
        </div>

        <div class="f-field">
          <label class="checkbox-inline">
            <?php if ($sub_category) { ?>
            <input type="checkbox" name="sub_category" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="sub_category" value="1" />
            <?php } ?>
            <?php echo $text_sub_category; ?>
          </label>
        </div>

      </div>
    </div>

    <input type="button" value="<?php echo $button_search; ?>" id="button-search" class="f-button" />
    <h2><?php echo $text_search; ?></h2>


    <?php if ($products) { ?>
    <div class="g-container">
      <div class="g-col-left">

        <div class="b-filter__title">  <!-- Фильтры START -->
          <h3>Подбор по параметрам <span class="ic-arrow-down-white"></span></h3>
        </div>

        <div class="b-filter js-popup-filter">

          <?php if ( isset($categories['categories']) && count($categories['categories'])>0 ) { ?>
          <div class="b-filter-block b-filter-block_price b-filter-block_open">
            <div class="b-filter-block__title js-filter-block-toggle">Подкатегории</div>
            <div class="b-filter-block__content">

              <div class="f-group-wrap_1col">
                <?php foreach($categories['categories'] as $cat) { ?>
                <div class="f-group">
                  <a href="<?php echo $cat['href']; ?>"><?php echo $cat['name']; ?></a>
                </div>
                <?php } ?>
              </div>

            </div>
          </div>  <!-- end b-filter-block -->
          <?php } ?>

          <div class="b-filter-block b-filter-block_price b-filter-block_open">
            <div class="b-filter-block__title js-filter-block-toggle">Цена</div>
            <div class="b-filter-block__content">

            <div class="f-group-wrap_2col">
              <div class="f-group">
                <div class="f-field-wrapper">
                  <div class="f-label">
                    <span class="f-label-value">от</span>
                  </div>
                  <div class="f-field">
                    <input type="text"
                           name="price_min"
                           value=""
                           placeholder=""
                           class="f-input">
                  </div>
                </div>
              </div>

              <div class="f-group">
                <div class="f-field-wrapper">
                  <div class="f-label">
                    <span class="f-label-value">до</span>
                  </div>
                  <div class="f-field">
                    <input type="text"
                           name="price_max"
                           value=""
                           placeholder=""
                           class="f-input">
                  </div>
                </div>
              </div>

              <div class="f-group">
                <div class="f-field-wrapper">
                  <div class="f-label">
                    <span class="f-label-value">грн</span>
                  </div>
                </div>
              </div>
            </div>

            </div>
          </div>  <!-- end b-filter-block -->


          <?php if ( isset($manufacturers) AND count($manufacturers) > 0 AND is_array($manufacturers)) { ?>
          <div class="b-filter-block b-filter-block_open">
            <div class="b-filter-block__title js-filter-block-toggle"><?php echo $text_manufacturer; ?></div>
            <div class="b-filter-block__content">
              <ul class="f-group-wrap_2col"><?php // тут можно проставить классы: f-group-wrap_1col, f-group-wrap_2col, f-group-wrap_3col. ?>

              <?php foreach ($manufacturers as $attribut) { ?>

                <li class="f-group">
                  <div class="f-field-wrapper f-field-wrapper_checkbox">
                    <div class="f-field">
                      <input type="checkbox"
                             name="<?php echo 'option_'.$attribut['code'].'_value_'.$attribut['manufacturer_id']; ?>"
                             id="<?php echo 'option_'.$attribut['code'].'_value_'.$attribut['manufacturer_id']; ?>"
                             value=""
                             <?php if ( strpos($selected_attributes_alias, $attribut['code']) !== false) { echo ' checked ';} ?>
                             class="f-checkbox">
                      <div class="f-label">
                        <label for="<?php echo 'option_'.$attribut['code'].'_value_'.$attribut['manufacturer_id']; ?>">
                          <?php if ( strpos($selected_attributes_alias, $attribut['code']) !== false) { ?>
                            <a href="<?php echo str_replace($attribut['code'].'-','',$selected_attributes_alias).$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $attribut['code'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                          <?php } ?>
                          </label>
                      </div>
                    </div>
                  </div>
                </li>

              <?php } ?>
              </ul>
            </div>
          </div>  <!-- end b-filter-block -->
          <?php } ?>


          <?php if ( isset($product_attributes) AND count($product_attributes) > 0 AND is_array($manufacturers)) { ?>
          <?php foreach ($product_attributes as $prod_attr) { ?>
          <div class="b-filter-block b-filter-block_open">
            <div class="b-filter-block__title js-filter-block-toggle"><?php echo $prod_attr['attribute_group_name']; ?></div>
            <div class="b-filter-block__content">
              <ul class="f-group-wrap_2col"><?php // тут можно проставить классы: f-group-wrap_1col, f-group-wrap_2col, f-group-wrap_3col. ?>

              <?php foreach ($prod_attr['attributes'] as $attribut) { ?>

                <li class="f-group">
                  <div class="f-field-wrapper f-field-wrapper_checkbox">
                    <div class="f-field">
                      <input type="checkbox"
                             name="<?php echo 'option_'.$prod_attr['attribute_group_id'].'_value_'.$attribut['attribute_id']; ?>"
                             id="<?php echo 'option_'.$prod_attr['attribute_group_id'].'_value_'.$attribut['attribute_id']; ?>"
                             value=""
                             <?php if ( strpos($selected_attributes_alias, $attribut['attribute_id']) !== false) { echo ' checked ';} ?>
                             class="f-checkbox">
                      <div class="f-label">
                        <label for="<?php echo 'option_'.$prod_attr['attribute_group_id'].'_value_'.$attribut['attribute_id']; ?>">
                          <?php if ( strpos($selected_attributes_alias, $attribut['attribute_id']) !== false) { ?>
                            <a href="<?php echo str_replace($attribut['attribute_id'].'-','',$selected_attributes_alias).$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                          <?php } else { ?>
                            <a href="<?php echo $attribut['attribute_id'].'-'.$selected_attributes_alias.$category_alias; ?>"><?php echo $attribut['name']; ?></a>
                          <?php } ?>
                          </label>
                      </div>
                    </div>
                  </div>
                </li>

              <?php } ?>
              </ul>
            </div>
          </div>  <!-- end b-filter-block -->
          <?php } ?>
          <?php } ?>

        </div>  <!-- end b-filter -->
      </div>  <!-- end g-col-left -->
      <div class="g-col-center">

            <div class="b-products-container__sort-row">

              <div class="b-filter-header b-filter-header_mob js-open-popup-link" data-mfp-src=".js-popup-filter">
                <span class="ic-mob-filter"></span>
                <span>Фильтрация</span>
              </div>

              <div class="b-view-header">
                <div class="b-change_view__list js-change_view">
                  <span class="ic-view_list active" data-view="list"></span>
                  <span class="ic-view_grid-3" data-view="grid-3"></span>
                  <span class="ic-view_grid-4" data-view="grid-4"></span>
                </div>
              </div>

              <div class="b-count-product">3125 Найдено</div>

              <div class="b-sort-header">
                <?php echo $text_sort; ?>
                <div class="g-span-select js-span-select">
                  <span class="g-span-select__title">от дешевых к дорогим</span>
                  <ul class="g-span-select__ul g-span-select__hidden js-popup-sort">
                  <?php foreach ($sorts as $sorts) { ?>
                    <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                      <li class="active"><a href="/<?php echo ltrim($selected_attributes_alias.$category_alias,'-'); ?><?php echo substr_replace($sorts['href'],'?',0,1); ?>"><?php echo $sorts['text']; ?></a></li>
                    <?php } else { ?>
                      <li><a href="/<?php echo ltrim($selected_attributes_alias.$category_alias,'-'); ?><?php echo substr_replace($sorts['href'],'?',0,1); ?>""><?php echo $sorts['text']; ?></a></li>
                    <?php } ?>
                  <?php } ?>
                  </ul>
                </div>
              </div>

              <div class="b-sort-header b-sort-header_mob js-open-popup-link" data-mfp-src=".js-popup-sort">
                <span class="ic-mob-sotr"></span>
                <span>Сортировать</span>
              </div>

            </div>  <!-- end b-products-container__sort-row -->

            <div class="g-row">
              <div class="b-products-container">

                <div class="b-products-container__content b-products-container__content_list js-view-content">

                <?php foreach ($products as $product) { ?>
                  <div class="b-prod__wrapper">
                    <div class="b-prod">
                      <div class="b-prod__title"><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
                      <div class="b-prod__options">
                        <span class="b-prod__options-color"></span>
                        <?php if ($product['options']) { ?>
                        <ul class="b-prod__options-list">
                          <?php foreach ($product['options'] as $option) { ?>
                          <?php foreach ($option['product_option_value'] as $option_value) { ?>
                          <li class="b-prod__options-list-item"><?php echo $option_value['name']; ?></li>
                          <?php } ?>
                          <?php } ?>
                        </ul>
                        <?php } ?>
                        <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" class="g-btn b-prod__btn_buy">Купить</a>
                        <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" class="b-prod__comments-link">Отзывы (<?php echo $product['total_comments']; ?>)</a>
                      </div>
                      <div class="b-prod__photo">
                        <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>"></a>
                      </div>
                      <div class="b-prod__brand-img">
                        <a href="javascript:void(0)" class="js-business-card-href js-open-popup-link" data-shop-id="<?php echo $product['shop_id']; ?>" data-shop-name="<?php echo $product['shop_name']; ?>" data-mfp-src=".js-popup-business-card">
                          <img src="/image/<?php if ( $product['manufacturer_image'] != NULL ) { echo $product['manufacturer_image']; }else{ echo 'no_image.png';} ?>" alt="<?php echo $product['name']; ?>">
                        </a>
                      </div>
                      <div class="b-prod__links">
                        <ul>
                          <li><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><span class="ic-prod_more"></span>Подробнее</a></li>
                          <li><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><span class="ic-prod_photos"></span>Все фото (<?php echo $product['total_images']; ?>)</a></li>
                          <li><a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><span class="ic-prod_video"></span>Все видео (<?php echo count($product['videos']); ?>)</a></li>
                          <li><button type="button" data-toggle="tooltip" class="btn btn-default" title="" onclick="wishlist.add('<?php echo $product['product_id'];?>');" data-original-title="В закладки">В ЗАКЛАДКИ</button>
                   </li>
                        </ul>
                        <div class="b-prod__color">
                          <span style="background: #474747;"></span>
                        </div>
                        <a href="/<?php echo $language_href; ?><?php echo $product['href']; ?>" class="b-prod__links-more-btn">Подробнее</a>
                      </div>
                      <div class="b-prod__price-block">
                        <div class="b-price">
                          <span class="b-price__number">9999 - 20000</span> <span class="b-price__currency">грн</span>
                        </div>
                      </div>
                    </div>
                  </div>  <!-- end b-prod__wrapper -->
                <?php } ?>

                </div>  <!-- end b-products-container__content -->

                <div class="b-products-container__pagination">
                <?php echo $pagination; ?>
                </div>
              </div>
            </div>  <!-- end g-row -->

      </div>  <!-- end g-col-center -->
      <div class="g-clear"></div>
    </div>
    <?php } else { ?>
    <p><?php echo $text_empty; ?></p>
    <?php } ?>
    <?php echo $content_bottom; ?>
  </div>
</main>






<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script>
<?php echo $footer; ?>