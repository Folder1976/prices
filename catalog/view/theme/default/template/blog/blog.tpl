<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
    <div class="blog blog_post">
    
    <?php if($main_thumb && $blogsetting_post_thumb){ ?>
    <div class="main_thumb"><img src="<?php echo $blogsetting_post_thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    
	<h1><?php echo $heading_title; ?></h1>
	<div class="blog_stats">
	<?php if($post_author_status){ ?><span><i class="fa fa-user"></i><b class="text"><?php echo $text_posted_by; ?></b> <b class="hl"><?php echo $author; ?></b></span><?php } ?>
	<?php if($post_date_added_status){ ?><span><i class="fa fa-clock-o"></i><b class="text"><?php echo $text_posted_on; ?></b> <b class="hl"><?php echo $date_added_full; ?></b></span><?php } ?>
	<?php if($post_page_view_status){ ?><span><i class="fa fa-eye"></i><b class="text"><?php echo $text_read; ?></b> <b class="hl"><?php echo $new_read_counter_value; ?></b></span><?php } ?>
	<?php if($post_comments_count_status){ ?><span><i class="fa fa-comments"></i><b class="text"><?php echo $text_comments; ?>:</b> <b class="hl"><?php echo $comment_total; ?></b></span><?php } ?>
	</div>
    
    <div class="main_description">
	<?php echo $description; ?>
    </div>
    
    <?php if ($tags) { ?>
	<p class="tags">
    <?php echo $text_tags; ?>
	<?php for ($i = 0; $i < count($tags); $i++) { ?>
	<?php if ($i < (count($tags) - 1)) { ?>
	<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>, 
	<?php } else { ?>
	<a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
	<?php } ?>
	<?php } ?>
	</p>
	<?php } ?>
	
	<div class="share">
    <?php if($share_status){ ?>
	<div class="addthis_toolbox addthis_default_style">
	<a class="addthis_button_facebook"><i class="fa fa-facebook"></i></a>
    <a class="addthis_button_twitter"><i class="fa fa-twitter"></i></a>
    <a class="addthis_button_google_plusone_share"><i class="fa fa-google-plus"></i></a>
	<a class="addthis_button_compact"><i class="fa fa-navicon"></i></a>
	</div>
	<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js"></script>
	<?php } ?>
    </div>
	
    <!-- Related Products -->
    <?php if ($products) { ?>
      <h3><i class="fa fa-list"></i><?php echo $text_related_products; ?></h3>
       <div class="blog_grid_holder blog_products column-<?php echo $rel_prod_per_row; ?>">
        <?php foreach ($products as $product) { ?>
          <div class="blog_item blog_product">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
              <a class="name" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
              <?php if ($product['rating']) { ?>
              <div class="rating">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                <?php if ($product['rating'] < $i) { ?>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                <?php } else { ?>
                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                <?php } ?>
                <?php } ?>
              </div>
              <?php } ?>
              <?php if ($product['price']) { ?>
              <p class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                <?php } ?>
                <?php if ($product['tax']) { ?>
                <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                <?php } ?>
              </p>
              <?php } ?>
            
            <?php if ((float)VERSION >= 2.1) { ?>
<a class="btn btn-primary" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><?php echo $button_cart; ?></a>
            <?php } else { ?>
<a class="btn btn-primary" onclick="cart.add('<?php echo $product['product_id']; ?>');"><?php echo $button_cart; ?></a>
            <?php } ?>
            
          </div>
        <?php } ?>
      </div>
      <?php } ?>
	 <!-- Related Products End -->
     
     
     
     <?php if ($related_blogs) { ?>
		<h3><i class="fa fa-list"></i><?php echo $text_related_blog; ?></h3>
		<div class="blog_grid_holder related column-<?php echo $rel_per_row; ?>">
            <?php foreach ($related_blogs as $blog) { ?>
            <div class="blog_item">
                <div class="summary">
                <h2 class="blog_title"><a href="<?php echo $blog['href']; ?>"><?php echo $blog['title']; ?></a></h2>
                <div class="blog_stats">
                <?php if($author_status){ ?><span><i class="fa fa-user"></i><b class="text"><?php echo $text_posted_by; ?></b> <b class="hl"><?php echo $blog['author']; ?></b></span><?php } ?>
                <?php if($date_added_status){ ?><span><i class="fa fa-clock-o"><b class="text"></i><?php echo $text_posted_on; ?></b> <b class="hl"><?php echo $blog['date_added_full']; ?></b></span><?php } ?>
				<?php if($page_view_status){ ?><span><i class="fa fa-eye"></i><b class="text"><?php echo $text_read; ?></b> <b class="hl"><?php echo $blog['count_read']; ?></b></span><?php } ?>
				<?php if($comments_count_status){ ?><span><i class="fa fa-comments"><b class="text"></i><?php echo $text_comments; ?></b> <b class="hl"><?php echo $blog['comment_total']; ?></b></span><?php } ?>
                </div>
                <?php if(($blog['image']) && ($rel_thumb_status)){ ?>
                <div class="image">
				<a href="<?php echo $blog['href']; ?>"><img src="<?php echo $blog['image']; ?>" alt="<?php echo $blog['title']; ?>" title="<?php echo $blog['title']; ?>" /></a>
                </div>
				<?php } ?>
				<p><?php echo $blog['short_description']; ?></p>
                <p><a href="<?php echo $blog['href']; ?>"><?php echo $text_read_more; ?> <i class="fa fa-long-arrow-right"></i></a></p>
                </div>
               </div>
			<?php } ?>            
		</div>
	<?php } ?>
	 <!-- Related Blog End -->
	 
     <!-- Comment Area start -->
  		<?php if($allow_comment){ ?>
        <h3><i class="fa fa-comments"></i><?php echo $text_comments; ?></h3>
              <form id="comment_form">
                <div id="comment"></div>
                <h3><i class="fa fa-pencil"></i><?php echo $text_write_comment; ?></h3>
                <div class="row">
				<div class="form-group col-sm-6 required">
                <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                <input type="text" name="name" value="" id="input-name" class="form-control" />
                </div>
                <div class="form-group col-sm-6 required">
                <label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
                <input type="text" name="email" value="" id="input-email" class="form-control" />
                </div>
                </div>
                
                <div class="row">
                <div class="form-group col-sm-12 required">
                <label class="control-label" for="input-review"><?php echo $entry_comment; ?></label>
                <textarea name="comment" rows="5" id="input-comment" class="form-control"></textarea>
                </div>
                </div>
                
                
                <div class="row">
                <div class="col-sm-12">
                  <div class="form-group required">
                  <label class="control-label" for="input-captcha_comment"><?php echo $entry_captcha; ?></label>
                    <div class="input-group">
                    <span class="input-group-addon captcha_wrap" style="background:#ffffff;padding:0 10px;"><img src="index.php?route=blog/blog/captcha" alt="" id="captcha_comment" /></span>
                    <input type="text" name="captcha_comment" value="" id="input-captcha_comment" class="form-control" />
                    </div>
                  </div>
                </div>
                </div>
                
                <div class="row">
                <div class="form-group col-sm-12 text-right">
                <button type="button" id="button-comment" class="btn btn-primary"><?php echo $button_send; ?></button>
                </div>
                </div>
                
                </div>
				</form>
      <?php } ?>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--

$('#comment').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();
	$("html,body").animate({scrollTop:(($("#comment").offset().top)-50)},500);
    $('#comment').fadeOut(50);

    $('#comment').load(this.href);

    $('#comment').fadeIn(500);
	
});

$('#comment').load('index.php?route=blog/blog/comment&blog_id=<?php echo $blog_id; ?>');
//--></script>

<script type="text/javascript"><!--

$('#button-comment').on('click', function() {
	$.ajax({
		url: 'index.php?route=blog/blog/write&blog_id=<?php echo $blog_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#comment_form").serialize(),
		
		complete: function() {
			$('#button-comment').button('reset');
			$('#captcha_comment').attr('src', 'index.php?route=blog/blog/captcha#'+new Date().getTime());
			$('input[name=\'captcha_comment\']').val('');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
			
			if (json['error']) {
				$('#comment').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}
			
			if (json['success']) {
				$('#comment').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('input[name=\'name\']').val('');
				$('input[name=\'email\']').val('');
				$('textarea[name=\'comment\']').val('');
				$('input[name=\'captcha_comment\']').val('');
			}
		}
	});
});    

</script>
<?php echo $footer; ?> 