<?php

Plugin::setInfos(array(
	'id'			=>	'maintenance',
	'title'			=>	'Maintenance',
	'description'   =>	'Prevent unauthorised access to a site during development and maintenance sessions.',
	'license'		=>	'MIT',
	'author'		=>	'Andrew Waters',
	'website'		=>	'http://www.band-x.org/',
	'update_url'	=>	'http://www.band-x.org/update.xml',
	'version'		=>	'1.0.1',
    'type'			=>	'both'
));

Plugin::addController('maintenance', 'Maintenance', 'administrator,developer,editor', TRUE);
include('MaintenanceClass.php');

Observer::observe('dispatch_route_found', 'maintenance_check');
Observer::observe('page_requested', 'maintenance_check');

Behavior::add('Maintenance', '');

Dispatcher::addRoute(array(

	'/maintenance'							=>	'/plugin/maintenance/index',
	'/maintenance/'							=>	'/plugin/maintenance/index',
	'/maintenance/add'						=>	'/plugin/maintenance/add',
	'/maintenance/edit'						=>	'/plugin/maintenance/edit',
	'/maintenance/view/:num'				=>	'/plugin/maintenance/view/$1',
	'/maintenance/delete/:num'				=>	'/plugin/maintenance/delete/$1',
	'/maintenance/access'					=>	'/plugin/maintenance/access',
	'/maintenance/access/'					=>	'/plugin/maintenance/access',
	'/maintenance/access/update/:num/:any'	=>	'/plugin/maintenance/access/update?id=$1&target=$2',
	'/maintenance/settings'					=>	'/plugin/maintenance/settings',
	'/maintenance/settings/'				=>	'/plugin/maintenance/settings',
	'/maintenance/settings/update'			=>	'/plugin/maintenance/settings/update',
	'/maintenance/settings/update/'			=>	'/plugin/maintenance/settings/update',
	'/maintenance/switchStatus/:any'		=>	'/plugin/maintenance/switchStatus/$1'

));

function maintenance_check($uri=NULL) {
	$settings = Plugin::getAllSettings('maintenance');
	if($settings['maintenanceMode'] == 'on') {
		$ip = $_SERVER['REMOTE_ADDR'];
		Observer::notify('maintenance_page_requested', $uri);
		if($settings['maintenanceBackdoorStatus'] == 'on' && isset($_GET['backdoorkey']) && ($_GET['backdoorkey'] == $settings['maintenanceBackdoorKey'])) {}
		elseif(Maintenance::isAllowed($ip) == FALSE) {
			$uriSlug = trim($uri, '/');
			$maintenancePage = Maintenance::getMaintenanceURI();
			if($uriSlug != $maintenancePage || !isset($maintenancePage)) {
				Observer::notify('maintenance_page_displayed', $uri);
				Maintenance::displayMaintenancePage($uri, $settings);
			}			
		}
	}
}