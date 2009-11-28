<?php

Plugin::setInfos(array(
	'id'			=>	'maintenance',
	'title'			=>	'Maintenance',
	'description'   =>	'Prevent unauthorised access to a site during development and maintenance sessions.',
	'license'		=>	'MIT',
	'author'		=>	'Andrew Waters at band-x',
	'website'		=>	'http://www.band-x.org/',
	'update_url'	=>	'http://www.band-x.org/update.xml',
	'version'		=>	'1.0.0',
    'type'			=>	'both'
));

Plugin::addController('maintenance', 'Maintenance', 'administrator,developer', TRUE);
include('MaintenanceClass.php');
Observer::observe('page_requested', 'maintenance_check');
Behavior::add('Maintenance', '');

Dispatcher::addRoute(array(

	'/maintenance'					=>	'/plugin/maintenance/index',
	'/maintenance/'					=>	'/plugin/maintenance/index',
	'/maintenance/access'			=>	'/plugin/maintenance/access',
	'/maintenance/access/'			=>	'/plugin/maintenance/access',
	'/maintenance/settings'			=>	'/plugin/maintenance/settings',
	'/maintenance/settings/'		=>	'/plugin/maintenance/settings',

));

function maintenance_check($uri) {
	$settings = Plugin::getAllSettings('maintenance');
	if($settings['maintenanceMode'] == 'on') {
		$ip = $_SERVER['REMOTE_ADDR'];
		Observer::notify('maintenance_page_requested', $uri);
		if($settings['maintenanceBackdoorStatus'] == 'on' && isset($_GET['backdoorkey']) && ($_GET['backdoorkey'] == $settings['maintenanceBackdoorKey'])) {}
		elseif(Maintenance::isAllowed($ip) == FALSE) {
			$uriSlug = trim($uri, '/');
			$maintenancePage = Maintenance::getMaintenanceURI();
			if($uriSlug != $maintenancePage) {
				Observer::notify('maintenance_page_displayed', $uri);
				Maintenance::displayMaintenancePage($uri, $settings);
			}			
		}
	}
}