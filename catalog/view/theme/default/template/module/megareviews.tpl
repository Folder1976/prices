<?php ini_set('display_errors',0);
error_reporting(0); ?>
<?php if($settings['mr_status']){ ?>
<div id="megareviews_box">
	<a id="megareviews"></a>
	<div id="mr_total">
		<?php if($reviewsinfo['count']>0){ ?>
		<div class="mr-rating-stars">
		<?php echo $reviewsinfo['stars'];?>
		</div>
		<div class="mr-rating-number"><?php echo $reviewsinfo['rating'];?></div>
		<div class="mr-reviews-count"><span><?php echo $reviewsinfo['count'].'</span> '.$text_reviewssuffix;?></div>
		<?php if($reviewsinfo['recommend']!=-1){?><div class="mr-reviews-recommend"><?php echo $reviewsinfo['recommend'].$text_recommendsuffix;?></div><?php }?>
		<div class="mr-reviews-options">
			<?php foreach ($options as $option) {
								$pos=$reviewsinfo['options'][$option['option_id']];
								if(!$pos)continue;
								$length=count(explode(',',$option['values']));
								echo '<div class="mr-reviews-option"><div class="mr-table"><div class="mr-row">';
					  			echo '<div class="mr-cell mr-list-optioncaption middle" >'.$option['name'].'</div>';
								echo '<div class="mr-cell" ><div style="position:relative;"> <span class="mr-min">'.$option["min"].'</span><span class="mr-max">'.$option["max"].'</span></div><div class="mr-list-optionback">';
								 for($ii=0;$ii<$length;$ii++) echo '<div style="width:'.(100/$length).'%;left:'.((int)$ii*100/$length).'%;" class="mr-list-optionhandleempty"></div>'; 
								 echo'<div style="width:'.(100/$length).'%;left:'.($pos*100/$length).'%;" class="mr-list-optionhandle"></div></div></div>';
					  			echo '</div></div></div>';
						 	
					    	} ?>
		</div>
		<?php }else{?>
				<div class="mr-reviews-count"><?php echo $text_haveyoursay;?></div>
			<div class="mr-reviews-recommend"><?echo $text_bethefirst;?></div>
		<?php }?>
		<a class="mr-addbutton"><?php echo $text_addreview;?></a>
	</div>
	<?php if ($reviews) { ?>
		<div id="mr-sorts">
			<?php if ($settings['sortnewest']) echo'<a target="#" class="mr-sort" sort="r.date_added|DESC">'.$text_sortnewest.'</a>'; ?>
			<?php if ($settings['sorthelpful']) echo'<a target="#" class="mr-sort" sort="r.upvotes|DESC">'.$text_sorthelpful.'</a>'; ?>
			<?php if ($settings['sorthighest']) echo'<a target="#" class="mr-sort" sort="r.rating|DESC">'.$text_sorthighest.'</a>'; ?>
			<?php if ($settings['sortlowest']) echo'<a target="#" class="mr-sort" sort="r.rating|ASC">'.$text_sortlowest.'</a>'; ?>
			
		</div>		
	<?php }?>
	<div id="mr-list">
		<?php if ($reviews) { ?>
		<?php foreach ($reviews as $review) { ?>
		<div class="mr-review">
			<div><div class="mr-list-rating"><?php echo $review['stars']; ?></div>
			<div class="mr-list-date"><?php echo date("F d, Y",strtotime($review['date_added'])); ?></div></div>
			<div class="mr-list-title"><?php echo $review['title']; ?></div>
					    
			<div class="mr-table">
				<div class="mr-row">
					<div class="mr-cell mr-list-main">
						<div class="mr-list-author"><b><?php echo $review['author'];$ii=0; ?></b><?php if(count($review['ays'])>0)echo", "; ?><i>
						    <?php $ii=0; foreach ($review['ays'] as $ay) {
					  		$e=explode(',',$ay['values']);
							echo $ay['name']." ".$e[$ay["value"]];
						 	if($ii<count($review['ays'])-1) echo ", ";$ii++;
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
			<div class="mr-list-vote" for="<?php echo $review['review_id'];?>"><a class="mr-upvote <?php if($review['vote']==0)echo "mr-vote-disabled";if($review['vote']==1)echo "mr-vote-active";?>"><img src="<?php echo $path;?>/image/mr/upvote.png"><span><?php echo $review['upvotes'];?></span></a><a class="mr-downvote <?php if($review['vote']==1)echo "mr-vote-disabled";if($review['vote']==0)echo "mr-vote-active";?>"><img src="<?php echo $path;?>/image/mr/downvote.png"><span><?php echo $review['downvotes'];?></a></span></div>
			<div class="mr-list-recommend"><?php if($review['recommend']==1) echo $text_recommends; else if($review['recommend']==0) echo $text_doesnotrecommend; ?></div>
		</div>
		<?php } } ?>
		
	</div>
	<div id="mr-pagination"></div>
	<?php if ($reviews) { ?><a class="mr-addbutton"><?php echo $text_addreview;?></a><?php } ?>
	<div id="mr_new" style="height:0;overflow:hidden;">
		<div class="mr-message-wrapper"></div>
		<form  method="post" action="<?php echo $addLink ?>" id="addreviewform" enctype="multipart/form-data">
		<div class="mr-bigheader"><?php echo $text_submitheader;?></div> 
		<div class="mr-table">
			<div class="mr-row">
				<div class="mr-cell mr-rate" >
				<input type="hidden" name="product_id" value="<?php echo $product_id;?>">
					<div class="mr-mediumheader"><?php echo $text_rate;?></div> 
					<div id="mr_options" class="mr-table">
						<?php if($settings['rating']>0){ ?>
						<div class="mr-row">
							<?php echo'<div class="mr-cell middle mr-optcaption" id="opt-name">'.$text_overall;if($settings['rating']==2) echo"<span class='mr-required'>*</span>";echo'</div>';
							echo'<div class="mr-cell"><div id="rating"></div><div class="mr-error-wrapper" for="rating"></div></div>';
							echo'<div id="opt-selection" class="mr-cell middle"></div>';
							
							?>
						</div>
						<?php }?>
						<?
						if($settings['displayoptions']){ 
						foreach($options as $option){	
							echo'<div class="mr-row" opt-id="'.$option["option_id"].'">';
							echo'<div class="mr-cell middle mr-optcaption" id="opt-name">'.$option["name"].'</div>';
							echo'<div class="mr-cell mr-slidercell"><div style="position:relative;"><span class="mr-min">'.$option["min"].'</span><span class="mr-max" style="right:0px;position:absolute;">'.$option["max"].'</span></div><div class="optslider"></div></div>';
							echo'<div id="opt-selection" class="mr-cell bottom mr-optselection">'.$text_novalue.'</div>';
							echo'</div>';
						} }?>
						<?php if($settings['recommend']>0){ ?>
						<div class="mr-row"><div class="mr-cell mr-optcaption"><?php echo $text_recommend;if($settings['recommend']==2) echo"<span class='mr-required'>*</span>";?></div><div class="mr-cell middle"><input type="radio" name="recommend" value="1"> <?php echo $text_yes;?>    <input type="radio" name="recommend" value="0"> <?php echo $text_no;?><div class="mr-error-wrapper" for="recommend"></div></div></div>
						<?php }?>
					</div>
					
				</div>
				
				<div class="mr-cell mr-aboutyou" >
					
					<div class="mr-mediumheader"><?php echo $text_ay;?></div> 
					<div id="mr_ays" class="mr-table">
						<?php if($settings['nickname']>0){ ?>
						<div class="mr-row"><div class="mr-cell mr-aycaption"><?php echo $text_nickname; if($settings['nickname']==2) echo"<span class='mr-required'>*</span>";?></div><div class="mr-cell"><input type="text" name="author" value=""><div class="mr-error-wrapper" for="author"></div></div></div>
						<?php }?>
						<?php if($settings['displayaboutyou'])
							 foreach($ays as $ay){	
								echo'<div class="mr-row" ay-id="'.$ay["ay_id"].'">';
								echo'<div class="mr-cell mr-aycaption" id="ay-name">'.$ay["name"].'</div>';
								echo'<div class="mr-cell">';
								$values=explode(",",$ay['values']);
								$ind=0;
								foreach($values as $value){
									echo'<input type="radio" name="ay['.$ay["ay_id"].']" value="'.$ind++.'"><label> '.$value.'</label><br/>';
								}
							echo'</div>';
							
							echo'</div>';
						 } ?>
					</div>
					
				</div>
				
			</div>
		</div>	
			<!--Review section-->
		<div class="mr-mediumheader"><?php echo $text_yourreview;?></div> 
		<div class="mr-table">	
			<div class="mr-row">
				<div class="mr-cell mr-text">					
					<div class="mr-table">
						<?php if($settings['title']>0){ ?>
						<div class="mr-row"><div class="mr-cell top mr-optcaption"><?php echo $text_reviewtitle; if($settings['title']==2) echo"<span class='mr-required'>*</span>";?></div><div class="mr-cell"><input type="text" name="title" value=""><div class="mr-error-wrapper" for="title"></div>
							<?php if( $settings['titlehint']!=''){ echo "<p class='mr-hint'>".htmlspecialchars_decode(stripslashes($settings['titlehint']))."</p>"; } ?>
						</div></div><?php }?>
						<?php if($settings['text']>0){ ?>
						<div class="mr-row"><div class="mr-cell top mr-optcaption"><?php echo $text_reviewtext;if($settings['text']==2) echo"<span class='mr-required'>*</span>";?></div><div class="mr-cell"><textarea name="text" ></textarea><div class="mr-error-wrapper" for="text"></div>
							<?php if( $settings['texthint']!=''){ echo "<p class='mr-hint'>".htmlspecialchars_decode(stripslashes($settings['texthint']))."</p>"; } ?>
						</div></div><?php }?>
					</div>
				</div>
				<div class="mr-cell mr-tips top" >
					<?php if($settings['displaytexttips'] ){ ?>
					<div class="mr-tipstext">
						<?php if( $settings['texttips']){ echo "<b>".$text_texttips."</b><br/>".htmlspecialchars_decode(stripslashes($settings['texttips'])); } ?>
					</div>
					<?php }?>
				</div>
			</div>
		</div>	
			<!-- end review text-->
				
		<!-- Upload section -->
		<?php if($settings['video'] || $settings['photo']){ ?>
		<div class="mr-mediumheader"><?php echo $text_share;?></div> 
		<div class="mr-table">	
			<div class="mr-row">
				<div class="mr-cell mr-upload">
					<input type="hidden" id="path" value="<?php echo $path;?>">
								
					<div class="mr-table">
					<?php if( $settings['photo']){ ?>
						<div class="mr-row"><div class="mr-cell top mr-upcaption"><?php echo $text_selectimages;?></div><div class="mr-cell"><div id="filediv" class="filemain"><input name="file[]" type="file" id="file"/><label for="file" onclick class="filebtn">UPLOAD FILE</label><br/></div><?php if( $settings['displayimagehint']){ echo "<p class='mr-hint'>".htmlspecialchars_decode(stripslashes($settings['imagehint']))."</p>"; } ?></div></div>
						<div class="mr-row"><div class="mr-cell top mr-upcaption"><?php echo $text_videourl;?></div><div class="mr-cell"><input type="text" name="videourl" value=""><?php if( $settings['displayvideohint']){ echo "<p class='mr-hint'>".htmlspecialchars_decode(stripslashes($settings['videohint']))."</p>"; } ?></div></div>
					<?php } ?>
						<?php if($settings['video'] ){ ?>
						<div class="mr-row"><div class="mr-cell top mr-upcaption"><?php echo $text_videotitle;?></div><div class="mr-cell"><input type="text" name="videotitle" value=""><?php if( $settings['displaycaptionhint']){ echo "<p class='mr-hint'>".htmlspecialchars_decode(stripslashes($settings['captionhint']))."</p>"; } ?></div></div>
					<?php } ?>	
					</div>
				</div>
				
				<div class="mr-cell mr-tips top" >
					<?php if($settings['displayvideotips'] || $settings['displayimagetips']){ ?>
					<div class="mr-tipstext">
						<?php if( $settings['displayimagetips']){ echo "<b>".$text_imagetips."</b><br/>".htmlspecialchars_decode(stripslashes($settings['imagetips'])); } ?>
						<?php if( $settings['displayvideotips']){ echo "<b>".$text_videotips."</b><br/>".htmlspecialchars_decode(stripslashes($settings['videotips'])); } ?>
					</div>
					<?php }?>
				</div>
				
			</div>
		</div>	
		<?php } ?>
		<?php if($settings['captcha']){ ?>
		<div class="mr-cell" >
		    <b><?php echo $text_captcha; ?></b><br />
            <input type="text" name="captcha" value="" />
            <div class="mr-error-wrapper" for="captcha"></div>
            <br />
            <img src="index.php?route=tool/captcha" alt="" id="captcha" /><br />
        </div>
		<?php } ?>
		<div class="mr-bigheader"><button class="mr-submit"><?php echo $text_addreview;?></button></div>
		
		</form>
		
	</div>
</div>

<script>

	$(document).ready(function(){
				
			(new MegaReviews()).init({
				'optionsLink'					:  '<?php echo $link["module/megareviews/ajaxOptions"]; ?>',
				'validateLink'					:  '<?php echo $link["module/megareviews/ajaxValidate"]; ?>',
				'submitLink'					:  '<?php echo $link["module/megareviews/ajaxAddReview"]; ?>',
				'loadLink'					:  '<?php echo $link["module/megareviews/ajaxgetReviews"]; ?>',
				'voteLink'					:  '<?php echo $link["module/megareviews/ajaxVote"]; ?>',
				'box'						:	'#megareviews_box',
				'pages'						:	<?php echo ceil($reviewsinfo['count']/$settings['perpage']);?>,
				'perpage'						:	<?php echo $settings['perpage'];?>,
				'minwidth'						:	<?php echo $settings['minwidth'];?>,
				'maxsize'						:	<?php echo $settings['maxsize'];?>,
				'maxnumber'						:	<?php echo $settings['maxnumber'];?>,
				'publish'						:	<?php echo $settings['approve'];?>,
				'counter'						:	'<?php echo $settings['displaytextcounter'];?>',
				'textcount'						:	<?php echo $settings['textcount'];?>,
				'product_id'						:	<?php echo $product_id;?>
			});
	});
</script>
<?php } ?>