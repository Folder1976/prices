<?php echo $header; ?>

<main class="l-blog g-container">
  
  <div class="l-main_account__header">
    <!-- Хлебные крошки. START -->
    <div class="b-breadcrumb">
    <?php $count = 0; ?>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <?php if ($count == 0) { ?>
        <a href="<?php echo $breadcrumb['href']; ?>" title=""><span class="ic-home"></span><?php echo $breadcrumb['text']; ?></a>
      <?php } else { ?>
        <span>&nbsp;>&nbsp;</span><a href="<?php echo $breadcrumb['href']; ?>" title="<?php echo $breadcrumb['text']; ?>"><?php echo $breadcrumb['text']; ?></a>
      <?php } ?>
    <?php $count++;} ?>
    </div>
    <!-- Хлебные крошки. END -->
  </div>

  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
      <div class="blog">
		<h1><?php echo $heading_title; ?></h1>
  		
        <?php if ($blog_category_description) { ?>
		<div class="main_description">
		<?php echo $blog_category_description; ?>
		</div>
		<?php } ?>
        
  	<?php if($blogs){ ?>
		<div class="blog_grid_holder column-<?php echo $list_columns; ?>">
            
            <?php foreach ($blogs as $blog) { ?>
				<div class="blog_item">
                
                <div class="summary">
                <h2 class="blog_title"><a href="<?php echo $blog['href']; ?>"><?php echo $blog['title']; ?></a></h2>
                <div class="blog_stats">
                <?php if($author_status){ ?><span><i class="fa fa-user"></i><b class="text"><?php echo $text_posted_by; ?></b> <b class="hl"><?php echo $blog['author']; ?></b></span><?php } ?>
                <?php if($date_added_status){ ?><span><i class="fa fa-clock-o"></i><b class="text"><?php echo $text_posted_on; ?></b> <b class="hl"><?php echo $blog['date_added_full']; ?></b></span><?php } ?>
				<?php if($page_view_status){ ?><span><i class="fa fa-eye"></i><b class="text"><?php echo $text_read; ?></b> <b class="hl"><?php echo $blog['count_read']; ?></b></span><?php } ?>
				<?php if($comments_count_status){ ?><span><i class="fa fa-comments"></i><b class="text"><?php echo $text_comments; ?></b> <b class="hl"><?php echo $blog['comment_total']; ?></b></span><?php } ?>
                </div>
                <?php if($blog['image']){ ?>
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
		<div class="row">
        <div class="col-sm-6 text-left"><?php echo $results; ?></div>
        <div class="col-sm-6 text-right"><?php echo $pagination; ?></div>
      </div>
	<?php }else{ ?>
		<?php echo $text_no_results; ?>
	<?php } ?>
    </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</main>
<?php echo $footer; ?> 