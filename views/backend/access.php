<?php if(!defined('IN_CMS')) { exit(); } ?>

<h1>Maintenance Access Control</h1>

<p>Below is a list of all IP addresses that will be allowed access to the website whilst in maintenance mode.</p>

<table class="index" cellpadding="0" cellspacing="0" border="0">

	<thead>
		<th>IP</th>
		<th>Name</th>
		<th>Access Enabled</th>
		<th>Edit</th>
	</thead>

	<tbody>
<?php

	foreach($allowed as $allow) {
		if($allow->enabled == 'yes') $target = 'no';
		if($allow->enabled == 'no') $target = 'yes';
?>
		<tr>
			<td rowspan="2"><strong><?php echo $allow->ip; ?></strong></td>
			<td<?php if($allow->notes == '') { ?> rowspan="2"<?php } ?>><strong><?php echo $allow->name; ?></strong></td>
			<td<?php if($allow->notes == '') { ?> rowspan="2"<?php } ?>><a href="<?php echo get_url('maintenance/access/update/'.$allow->id.'/'.$target.''); ?>"><img src="<?php echo PLUGINS_URI . 'maintenance/images/'.$allow->enabled.'.png'; ?>" /></a></td>
			<td rowspan="2">
				<a href="<?php echo get_url('maintenance/view/'.$allow->id.''); ?>">
					<img src="<?php echo URL_PUBLIC; ?>admin/images/file.png" height="16" /></a>
				<a href="<?php echo get_url('maintenance/delete/'.$allow->id.''); ?>" onclick="return confirm('You are about to remove access to this site during maintenance session from the IP address <?php echo $allow->ip ?>\n\nYou will also lose any associated notes and names.\n\nAre you sure you wish to do this?\n');">
					<img src="<?php echo URL_PUBLIC; ?>admin/images/icon-remove.gif" /></a>
			</td>
		</tr>
<?php if($allow->notes != '') { ?>
		<tr>
			<td colspan="2"><?php echo $allow->notes; ?></td>
		</tr>
<?php } ?>
<?php

	}
?>
	</tbody>

</table>
<p>&nbsp;</p>
<form method="post" action="<?php echo get_url('maintenance/add'); ?>">
	<hr />
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td colspan="3" class="help"><h3><img src="<?php echo URL_PUBLIC; ?>admin/images/plus.png" /> Add Access</h3></td>
		</tr>
		<tr>
			<td class="label">IP Address</td>
			<td class="field"><input type="text" class="textbox" name="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" /></td>
			<td class="help">The IP to set up (automatically your current IP)</td>
		</tr>
		<tr>
			<td class="label">Name</td>
			<td class="field"><input type="text" class="textbox" name="name" /></td>
			<td class="help">A descriptive name for this IP</td>
		</tr>
		<tr>
			<td class="label">Notes</td>
			<td class="field"><textarea name="notes" style="height:75px"></textarea></td>
			<td class="help">Any notes about this IP</td>
		</tr>
		<tr>
			<td class="label">Status</td>
			<td class="field">
				<input type="radio" name="enabled" value="yes" checked="checked" /> Enable<br />
				<input type="radio" name="enabled" value="no" /> Disable
			</td>
			<td class="help">Should we enable access from this IP?</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2"><input type="submit" value="Add this IP address" /></td>
		</tr>
	</table>
</form>