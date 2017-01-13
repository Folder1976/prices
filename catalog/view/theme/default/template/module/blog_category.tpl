<div class="blog-module blog-category">
<h3><?php echo $heading_title_category; ?></h3>
<?php if (!empty($categories)) { ?>
<ul class="list-unstyled">
<?php foreach ($categories as $category_1) { ?>
   <?php if ($category_1['category_1_id'] == $category_1_id) { ?>
     <li class="open active"><a href="<?php echo $category_1['href']; ?>" ><?php echo $category_1['name']; ?></a>
      <?php } else { ?>
      <li><a href="<?php echo $category_1['href']; ?>" ><?php echo $category_1['name']; ?></a> 
      <?php } ?>
      <?php if ($category_1['children']) { ?>
      <div class="sign"><i class="fa fa-plus"></i><span class="fa fa-minus"></i></div>
      <ul>
      <?php foreach ($category_1['children'] as $category_2) { ?>
      <li class="open active"><a href="<?php echo $category_2['href']; ?>"> <i class="fa fa-long-arrow-right"></i><?php echo $category_2['name']; ?></a></li>
      <?php } ?>
      </ul>
      <?php } ?>
    </li>
    <?php } ?>
</ul>
<?php } ?>
</div>
<script>        
	$('.blog-category li').bind().click(function(e) {
	$(this).toggleClass("open").find('>ul').stop(true, true).slideToggle(500)
	.end().siblings().find('>ul').slideUp().parent().removeClass("open");
	e.stopPropagation();
	});
	$('.blog-category li a').click(function(e) {
	e.stopPropagation();
	});
</script>