<?php

	if(!defined('IN_CMS')) { exit(); }

	global $__CMS_CONN__;
	$sql = "	UPDATE ".TABLE_PREFIX."plugin_settings
				SET	`value`='off'
				WHERE plugin_id='maintenance' AND name='maintenanceMode'";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

	exit();