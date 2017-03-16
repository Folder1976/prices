<?php require DIR_TEMPLATE . 'module/' . $_name . '-header.tpl'; ?>

<table class="table">
	<thead>
		<tr>
			<td colspan="2"><?php echo $heading_title; ?></td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td width="200"><?php echo $entry_ext_version; ?></td>
			<td><?php echo $ext_version; ?></td>
			<td rowspan="6" width="50%" class="text-center" style="vertical-align: middle;">
				<h2><?php echo $text_need_support; ?></h2>
				<br />
				<a href="http://support.ocdemo.eu" target="_blank" class="btn btn-primary"><?php echo $text_open_ticket; ?></a>
			</td>
		</tr>
		<?php if( ! empty( $plus_version ) ) { ?>
			<tr>
				<td><?php echo $entry_plus_version; ?></td>
				<td>
					<?php echo $plus_version; ?>
					-
					<a href="<?php echo $action_rebuild_index; ?>" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-retweet"></i> <?php echo $text_rebuild_index; ?></a>
				</td>
			</tr>
		<?php } ?>
		<tr>
			<td><?php echo $entry_email; ?></td>
			<td><?php echo $ext_email; ?></td>
		</tr>
		<tr>
			<td><?php echo $entry_forum; ?></td>
			<td><a href="http://forum.ocdemo.eu" target="_blank">http://forum.ocdemo.eu</a></td>
		</tr>
		<tr>
			<td><?php echo $entry_support; ?></td>
			<td><a href="http://support.ocdemo.eu" target="_blank">http://support.ocdemo.eu</a></td>
		</tr>
		<tr>
			<td><?php echo $entry_documentation; ?></td>
			<td><a href="http://mfp.ocdemo.eu/docs" target="_blank">http://mfp.ocdemo.eu/docs</a></td>
		</tr>
	</tbody>
</table>
			
<?php require DIR_TEMPLATE . 'module/' . $_name . '-footer.tpl'; ?>