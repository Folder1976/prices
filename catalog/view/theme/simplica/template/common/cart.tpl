
  <div class="b-mini_cart-flyout js-mini_cart-flyout">

  <?php if ($products || $vouchers) { ?>
    <div class="b-mini_cart-flyout_header">
        <span class="b-mini_cart-flyout_title js-cart-total" data-loading-text="<?php echo $text_loading; ?>"><?php echo $text_items; ?></span>
    </div>

    <div class="b-mini_cart-left">
      <div class="b-mini_cart-flyout_products b-owl_carousel js-owl_carousel">

<!-- Список товаров корзины. START -->
      <?php foreach ($products as $product) { ?>
        <div class="l-mini_cart-product">
          <div class="l-mini_cart-remove">
            <a href="javascript:void(0)" onclick="cart.remove('<?php echo $product["cart_id"]; ?>');">x</a>
          </div>
          <div class="l-mini_cart-image">
            <?php if ($product['thumb']) { ?>
            <img class="b-product_image b-mini_cart-image" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>">
            <?php } ?>
          </div>
          <div class="l-mini_cart-product_info">
            <div class="b-mini_cart-product_name">
              <a class="b-mini_cart-product_name-link" href="/<?php echo $language_href; ?><?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            </div>
            <div class="b-mini_cart-product_pricing">
              <div class="b-mini_cart-product_pricing-qty">
                <span class="label">Кол-во:</span>
                <span class="value"><?php echo $product['quantity']; ?></span>
              </div>
              <span class="b-mini_cart-product_pricing-price"><?php echo $product['total']; ?></span>
            </div>
          </div>
        </div>
      <?php } ?>
<!-- Список товаров корзины. END -->

      </div>
    </div>


    <div class="b-mini_cart-right">
      <h6 class="b-mini_cart-summary_title"><?php echo $text_shopping_cart; ?></h6>
      <div class="b-mini_cart-bottom_area l-mini_cart-totals">
        <div class="b-mini_cart-qty_container">
          <span class="b-mini_cart-subtotal_title"><?php echo $text_qtn; ?></span>
          <span class="b-mini_cart-subtotal_qty" id="b-mini_cart-subtotal_qty"><?php echo $text_totals; ?></span>
        </div>
        
        <div class="b-mini_cart-subtotal l-mini_cart-totals_subtotals">
          <span class="b-mini_cart-subtotal_label label"><?php echo $text_total; ?></span>
          <span class="b-mini_cart-subtotal_value value" id="b-mini_cart-subtotal_value value"><?php echo $summ; ?></span>
        </div>
        
        <div class="b-mini_cart-checkout_btn_wrapper l-mini_cart-totals_button">
          <a class="b-mini_cart-checkout_btn b-mini_cart-totals_button" href="<?php echo $cart; ?>" title="<?php echo $text_cart; ?>"><?php echo $text_cart; ?></a>
        </div>
      </div>

      <div class="b-mini_cart-content_slot b-mini_cart-totals_slot">
      </div>
    </div>

  <?php } else { ?>
    <span class="b-mini_cart-flyout_empty_cart""><?php echo $text_empty; ?></span>
  <?php } ?>



<script>
// owlCarousel для корзины в шапке. START
$('.js-owl_carousel').owlCarousel({
    items: 4,
    animateIn: 'fadeIn',
    animateOut: 'fadeOut',
    loop: false,
    nav: true,
    pagination: false,
    navigation: false,
    navContainerClass: 'b-owl_carousel-nav_controls',
    itemElement: 'div class="b-owl_carousel-item"',
    navClass: ['b-owl_carousel-nav_prev','b-owl_carousel-nav_next'],
    responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1008: { items: 3 },
        1195: { items: 4 }
    }
});
// owlCarousel для корзины в шапке. END
</script>


</div>


