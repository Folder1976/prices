		<?php if ($reviews) { ?>
		<?php foreach ($reviews as $review) { ?>
		<div class="mr-review">
			<div><div class="mr-list-rating"><?php echo $review['stars']; ?></div>
			<div class="mr-list-date"><?php echo date("F d, Y",strtotime($review['date_added'])); ?></div></div>
			<div class="mr-list-title"><?php echo $review['title']; ?></div>
					    
			<div class="mr-table">
				<div class="mr-row">
					<div class="mr-cell mr-list-main"  >
						<div class="mr-list-author"><b><?php echo $review['author']; ?></b><?php if(count($review['ays'])>0)echo", "; ?><i>
						    <?php $ii=0;foreach ($review['ays'] as $ay) {
							$e=explode(',',$ay['values']);
					  		echo $ay['name']." ".$e[$ay["value"]];
						 	if($ii++<count($review['ays'])-1) echo ", ";
					    } ?></i></div>
					    <div class="mr-list-text"><?php echo $review['text']; ?></div>
					    <div class="popup-gallery">
					        <?php foreach ($review['images'] as $im) {
					  			echo' <a class="mfp-image"  href="image/'.$im['big'].'"><img src="'.$im['small'].'" width="75" height="75" /></a>';
					      		
					   		 } 
					   		 if($review['videourl']){
					   		 	echo' <a class="mfp-iframe" href="'.$review['videourl'].'" title="'.$review['videotitle'].'"><img src="'.$path.'/image/mr/videoicon.png" width="75" height="75" /></a>';
					      		
					   		 }
					   		 ?>
					   		 	
					    </div>
					</div>
					<div class="mr-cell mr-list-options" >
						<div class="mr-table">
							<?php foreach ($review['options'] as $option) {
								$e=explode(',',$option['values']);
								$pos=$e[$option["value"]];
								$length=count(explode(',',$option['values']));
								echo '<div class="mr-row">';
					  			echo '<div class="mr-cell mr-list-optioncaption middle" >'.$option['name'].'</div>';
								echo '<div class="mr-cell" ><div style="position:relative;"><span class="mr-min">'.$option["min"].'</span><span class="mr-max" style="right:0px;position:absolute;">'.$option["max"].'</span></div><div class="mr-list-optionback">';
								 for($ii=0;$ii<$length;$ii++) echo '<div style="width:'.(100/$length).'%;left:'.((int)$ii*100/$length).'%;" class="mr-list-optionhandleempty"></div>'; 
								 echo'<div style="width:'.(100/$length).'%;left:'.((int)$option["value"]*100/$length).'%;" class="mr-list-optionhandle"></div></div></div>';
					  			echo '</div>';
						 	
					    	} ?>
							
						</div>
					</div>
				</div>
			</div>
			<div class="mr-list-vote" for="<? echo $review['review_id'];?>"><a class="mr-upvote <? if($review['vote']==0)echo "mr-vote-disabled";if($review['vote']==1)echo "mr-vote-active";?>"><img src="<? echo $path;?>/image/mr/upvote.png"><span><? echo $review['upvotes'];?></span></a><a class="mr-downvote <? if($review['vote']==1)echo "mr-vote-disabled";if($review['vote']==0)echo "mr-vote-active";?>"><img src="<? echo $path;?>/image/mr/downvote.png"><span><? echo $review['downvotes'];?></a></span></div>
		</div>
		<?php } } ?>
		

	