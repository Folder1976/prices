

<?php if ($comments) { ?>

<?php foreach ($comments as $comment) { ?>
<div class="blog_comment">
<p><b><?php echo $comment['name']; ?></b> - <?php echo $comment['date_added']; ?></p>
<p><?php echo $comment['comment']; ?></p>
</div>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="blog_comment">
<p><?php echo $text_no_comment; ?></p>
</div>
<?php } ?>
