<?php

class Maintenance {

	const MAINTENANCE_ALLOWED	=	"maintenance_allowed";
	const MAINTENANCE_PAGE		=	"maintenance_page";

	function executeSql($sql) {
		global $__CMS_CONN__;
		$stmt = $__CMS_CONN__->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function getAllowed() {
		$sql = "SELECT * FROM ".TABLE_PREFIX.self::MAINTENANCE_ALLOWED."";
		return self::executeSql($sql);
	}

	public function isAllowed($ip) {
		$sql = "SELECT * FROM ".TABLE_PREFIX.self::MAINTENANCE_ALLOWED." WHERE ip='$ip' AND enabled='yes'";
		$result = self::executeSql($sql);
		$resultCount = (count($result));
		if($resultCount == 0) return FALSE;
		if($resultCount >= 1) return TRUE;
	}

	function displayMaintenancePage($uri, $settings) {
		if($settings['maintenanceView'] == 'static') self::displayContent();
		if($settings['maintenanceView'] == 'redirect') header('Location: '.$settings['maintenanceRedirectURL'].'');
		if($settings['maintenanceView'] == 'internal') self::internalPageReferral();
		exit();
	}

	private function displayContent() {
		$sql = "SELECT * FROM ".TABLE_PREFIX.self::MAINTENANCE_PAGE." WHERE id='1'";
		$result = self::executeSql($sql);
		echo $result[0]['value'];
	}

	public function retrieveContent() {
		$sql = "SELECT * FROM ".TABLE_PREFIX.self::MAINTENANCE_PAGE." WHERE id='1'";
		$result = self::executeSql($sql);
		return $result[0]['value'];
	}

	private function internalPageReferral() {
		$result = self::getMaintenanceURI();
		$urlMiddle = '';
		if(USE_MOD_REWRITE == FALSE) $urlMiddle = '?';
		header('Location: ' . URL_PUBLIC . $urlMiddle . $result . '');
	}

	public function getMaintenanceURI() {
		$sql = "SELECT * FROM ".TABLE_PREFIX."page WHERE behavior_id='Maintenance'";
		$maintenancePage = self::executeSql($sql);
		return $maintenancePage[0]['slug'];
	}

	public function switchStatus($newStatus) {
		global $__CMS_CONN__;
		$sql = "UPDATE ".TABLE_PREFIX."plugin_settings
				SET value='$newStatus'
				WHERE plugin_id='maintenance'
				AND name = 'maintenanceMode'
				";
		self::executeSql($sql);
		return $newStatus;
	}

	public function updateSettings($_POST) {
		foreach($_POST as $key=>$value) {
			if($key != 'customHTML') {
				$sql = "UPDATE ".TABLE_PREFIX."plugin_settings
						SET value='$value'
						WHERE plugin_id='maintenance'
						AND name = '$key'";
				self::executeSql($sql);
			}
			elseif($key == 'customHTML') {
				$sql = "UPDATE ".TABLE_PREFIX."maintenance_page
						SET value='$value'
						WHERE id='1'";
				self::executeSql($sql);
			}
		}
	}

}