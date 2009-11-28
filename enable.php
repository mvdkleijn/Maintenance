<?php

	$time = time();

	global $__CMS_CONN__;
	$sql = "	INSERT INTO `".TABLE_PREFIX."plugin_settings` (`plugin_id`,`name`,`value`)
				VALUES
					('maintenance', 'maintenanceMode', 'off'),
					('maintenance', 'maintenanceView', 'static'),
					('maintenance', 'maintenanceBackdoorStatus', 'off'),
					('maintenance', 'maintenanceBackdoorKey', '$time'),
					('maintenance', 'maintenanceRedirectURL', 'http://www.google.co.uk');";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

    $createAllowedTable = "
    	CREATE TABLE `".TABLE_PREFIX."maintenance_allowed` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`ip` varchar(20) DEFAULT NULL,
			`name` varchar(64) DEFAULT NULL,
			`notes` varchar(512) DEFAULT NULL,
			`enabled` enum('yes','no') DEFAULT NULL,
			PRIMARY KEY (`id`)
		)";
    $stmt = $__CMS_CONN__->prepare($createAllowedTable);
    $stmt->execute();

    $createPageContent = "
    	CREATE TABLE `".TABLE_PREFIX."maintenance_page` (
			`content` varchar(4096) DEFAULT NULL
		)";
    $stmt = $__CMS_CONN__->prepare($createPageContent);
    $stmt->execute();

	exit();