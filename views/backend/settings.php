<h1>Maintenance Settings</h1>

<form method="post" action="<?php echo get_url('maintenance/settings/update'); ?>">

<table class="fieldset" cellpadding="0" cellspacing="0" border="0">

	<tr>
		<td class="help" colspan="3">
			<h3>Status</h3>
		</td>
	</tr>
	<tr>
		<td class="label">Maintenance Status:</td>
		<td class="field">
			<input type="radio" name="maintenanceMode" <?php if($settings['maintenanceMode'] == 'on') echo 'checked="checked" '; ?>value="on" /> On<br />
			<input type="radio" name="maintenanceMode" <?php if($settings['maintenanceMode'] == 'off') echo 'checked="checked" '; ?>value="off" />	Off
		</td>
		<td class="help">Should Maintenance Mode be On or Off?<br /><strong>By Selecting "On" you will take the site offline!</strong></td>
	</tr>
	<tr>
		<td class="help" colspan="3">
			<h3>Mode</h3>
		</td>
	</tr>
	<tr>
		<td class="label">Maintenance Mode:</td>
		<td class="field">
			<input type="radio" name="maintenanceView" <?php if($settings['maintenanceView'] == 'static') echo 'checked="checked" '; ?>value="static" /> Custom HTML<br />
			<input type="radio" name="maintenanceView" <?php if($settings['maintenanceView'] == 'internal') echo 'checked="checked" '; ?>value="internal" /> Internal Redirect<br />
			<input type="radio" name="maintenanceView" <?php if($settings['maintenanceView'] == 'redirect') echo 'checked="checked" '; ?>value="redirect" /> External Redirect
		</td>
		<td class="help">If you select <strong>Internal Redirect</strong>, please create/edit a Maintenance Page and select <strong>"Maintenance"</strong> from the <strong>Page Types</strong></td>
	</tr>
	<tr>
		<td class="label">External URL</td>
		<td class="field">
			<input type="text" class="textbox" name="maintenanceRedirectURL" value="<?php echo $settings['maintenanceRedirectURL']; ?>" />
		</td>
		<td class="help">Visitors will be redirected to this web page if you selected <strong>External Redirect</strong> above</td>
	</tr>
	<tr>
		<td class="label">Custom HTML:</td>
		<td class="field" colspan="2">
			<textarea name="customHTML"><?php echo $customHTML; ?></textarea>
		</td>
	</tr>
	<tr>
		<td class="help" colspan="3">
			<h3>Backdoor Access</h3>
		</td>
	</tr>
	<tr>
		<td class="label">Status:</td>
		<td class="field">
			<input type="radio" name="maintenanceBackdoorStatus" <?php if($settings['maintenanceBackdoorStatus'] == 'on') echo 'checked="checked" '; ?>value="on" /> On<br />
			<input type="radio" name="maintenanceBackdoorStatus" <?php if($settings['maintenanceBackdoorStatus'] == 'off') echo 'checked="checked" '; ?>value="off" />	Off
		</td>
		<td class="help">You can enable / disable the backdoor here</td>
	</tr>
	<tr>
		<td class="label">Backdoor Key:</td>
		<td class="field"><input type="text" class="textbox" name="maintenanceBackdoorKey" value="<?php echo $settings['maintenanceBackdoorKey']; ?>" /></td>
		<td class="help">Your access key to the site</td>
	</tr>
	<tr>
		<td class="help" colspan="3">
		</td>
	</tr>
	<tr>
		<td class="label"></td>
		<td class="field" colspan="2"><input type="submit" value="Update your Settings" /></td>
	</tr>

</table>

</form>