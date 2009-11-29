<div class="box">
<?php $coreRoot = end(explode('/', CORE_ROOT)); ?>

<div id="status">
	<h2>Current Status:</h2>
	<table>
		<tr>
			<td style="padding:20px;"><a href="<?php echo get_url('maintenance/switchStatus/'); ?><?php if($settings['maintenanceMode'] == 'off') { echo 'on'; } else { echo 'off'; } ?>"><img src="<?php echo URL_PUBLIC . $coreRoot . '/plugins/maintenance/images/' . $settings['maintenanceMode'] . '.png'; ?>" alt="<?php echo strtoupper($settings['maintenanceMode']); ?>" /></a></td>
			<td style="padding:20px;"><small>Maintenance mode is:<br /></small><?php echo strtoupper($settings['maintenanceMode']); ?></td>
		</tr>
	</table>
</div>

<p class="button"><a href="<?php echo get_url('maintenance/access'); ?>"><img src="<?php echo URL_PUBLIC . $coreRoot . '/plugins/maintenance/images/access.png'; ?>" align="middle" alt="Access" /> Access List</a></p>
<p class="button"><a href="<?php echo get_url('maintenance/modes'); ?>"><img src="<?php echo URL_PUBLIC . $coreRoot . '/plugins/maintenance/images/modes.png'; ?>" align="middle" alt="Modes" /> Modes</a></p>
<p class="button"><a href="<?php echo get_url('maintenance/settings'); ?>"><img src="<?php echo URL_PUBLIC . $coreRoot . '/plugins/maintenance/images/settings.png'; ?>" align="middle" alt="Settings" /> Settings</a></p>
</div>