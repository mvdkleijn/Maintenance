<?php if(!defined('IN_CMS')) { exit(); } ?>

<h1>Viewing Access for <?php echo $allowed->name; ?></h1>

<form method="post" action="<?php echo get_url('maintenance/edit'); ?>">
	<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
		<input type="hidden" name="id" value="<?php echo $allowed->id; ?>" />
		<tr>
			<td class="label">IP Address</td>
			<td class="field"><input type="text" class="textbox" name="ip" value="<?php echo $allowed->ip; ?>" /></td>
			<td class="help"></td>
		</tr>
		<tr>
			<td class="label">Name</td>
			<td class="field"><input type="text" class="textbox" name="name" value="<?php echo $allowed->name; ?>" /></td>
			<td class="help">A shortname for this IP</td>
		</tr>
		<tr>
			<td class="label">Notes</td>
			<td class="field"><textarea name="notes" style="height:75px"><?php echo $allowed->notes; ?></textarea></td>
			<td class="help">Room for notes</td>
		</tr>
		<tr>
			<td class="label">Status</td>
			<td class="field">
				<input type="radio" name="enabled" value="yes" <?php if($allowed->enabled == 'yes') echo 'checked="checked" '; ?> /> Enabled<br />
				<input type="radio" name="enabled" value="no" <?php if($allowed->enabled == 'no') echo 'checked="checked" '; ?>/> Disabled
			</td>
			<td class="help">Should we enable this IP address straight away?</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="2"><input type="submit" value="Edit this IP address" /></td>
		</tr>
	</table>
</form>