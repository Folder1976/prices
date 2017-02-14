<ul class="b-customer-service-navigation__list">

  <?php if ( isset($informations) && $informations ) { ?>
  <?php foreach ($informations as $information) { ?>
  <li class="b-customer-service-navigation__list-li">
      <a class="b-customer-service-navigation__link <?php if ($_GET['_route_'] == $information['keyword']) echo 'active'; ?>"
         href="<?php echo $language_href.$information['keyword']; ?>"
         title="<?php echo $information['title']; ?>"><?php echo $information['title']; ?></a>
  </li>
  <?php } ?>
  <?php } ?>

  <li class="b-customer-service-navigation__list-li">
      <a class="b-customer-service-navigation__link <?php if ($_GET['_route_'] == 'contact_us') echo 'active'; ?>"
         href="/<?php echo $language_href; ?>contact_us"><?php echo $text_contact; ?></a></h6>
  </li>

</ul>
