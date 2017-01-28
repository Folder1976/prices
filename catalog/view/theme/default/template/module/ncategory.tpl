<h3><?php echo $heading_title; ?></h3>

    <div class="list-group">
    <a class="list-group-item" href="<?php echo $headlines; ?>"><?php echo $button_headlines; ?></a>
    <?php if ($ncategories) { ?>
        <?php foreach ($ncategories as $ncategory) { ?>
          <?php if ($ncategory['ncategory_id'] == $ncategory_id) { ?>
          <a class="list-group-item active" href="<?php echo $ncategory['href']; ?>"><?php echo $ncategory['name']; ?></a>
		  <?php if ($ncategory['children']) { ?>
            <?php foreach ($ncategory['children'] as $child) { ?>
              <?php if ($child['ncategory_id'] == $child_id) { ?>
              <a class="list-group-item active" href="<?php echo $child['href']; ?>"> - <?php echo $child['name']; ?></a>
              <?php } else { ?>
              <a class="list-group-item" href="<?php echo $child['href']; ?>"> - <?php echo $child['name']; ?></a>
              <?php } ?>
            <?php } ?>
          <?php } ?>
          <?php } else { ?>
          <a class="list-group-item" href="<?php echo $ncategory['href']; ?>"><?php echo $ncategory['name']; ?></a>
          <?php } ?>
          
          <?php } ?>
        <?php } ?>	
    </div>
	<div id="artsearch">
     <h3><?php echo $head_search; ?></h3>
      <?php if ($filter_name) { ?>
      <input type="text" name="filter_artname" value="<?php echo $filter_name; ?>" class="form-control"/>
      <?php } else { ?>
      <input type="text" name="filter_artname" value="<?php echo $artkey; ?>" onclick="this.value = '';" class="form-control" />
      <?php } ?>
	  <div style="height: 8px; overflow: hidden">&nbsp;</div>
	  <input type="button" value="<?php echo $button_search; ?>" id="button-artsearch" class="btn btn-primary">
	</div>
	<div style="height: 8px; overflow: hidden">&nbsp;</div>
<script type="text/javascript"><!--
$('#artsearch input[name=\'filter_artname\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-artsearch').trigger('click');
	}
});

$('#button-artsearch').bind('click', function() {
	url = 'index.php?route=news/search';
	
	var filter_artname = $('#artsearch input[name=\'filter_artname\']').prop('value');
	
	if (filter_artname) {
		url += '&filter_artname=' + encodeURIComponent(filter_artname);
	}

	location = url;
});
//--></script> 