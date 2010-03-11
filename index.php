<?php

/**
 * Maintenance Plugin <http://www.band-x.org/projects/maintenance>
 * Copyright (C) 2010, band-x Media Limited <info@band-x.org>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of
 * this software and associated documentation files (the "Software"), to deal in
 * the Software without restriction, including without limitation the rights to
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
 * the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 * 
 * All copyright notices and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * 
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

/**
 * @package Maintenance
 *
 * @author Andrew Waters <andrew@band-x.org>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/MIT MIT License
 * @copyright band-x Media Limited, 2009 - 2010
 */


if(!defined('IN_CMS')) { exit(); }

Plugin::setInfos(array(
	'id'			=>	'maintenance',
	'title'			=>	'Maintenance',
	'description'   =>	'Prevent unauthorised access to a site during development and maintenance sessions.',
	'license'		=>	'MIT',
	'author'		=>	'Andrew Waters',
	'website'		=>	'http://www.band-x.org/',
	'update_url'	=>	'http://www.band-x.org/update.xml',
	'version'		=>	'1.1.0',
    'type'			=>	'both'
));

Plugin::addController('maintenance', 'Maintenance', 'administrator,developer,editor', TRUE);

include('models/AccessControl.php');
include('models/MaintenancePage.php');

Observer::observe('dispatch_route_found', 'maintenance_check');
Observer::observe('page_requested', 'maintenance_check');

Behavior::add('Maintenance', '');

if(defined('CMS_BACKEND')) {
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
}

function maintenance_check($uri=NULL) {
	$settings = Plugin::getAllSettings('maintenance');
	if($settings['maintenanceMode'] == 'on') {
		$ip = $_SERVER['REMOTE_ADDR'];
		Observer::notify('maintenance_page_requested', $uri);
		if($settings['maintenanceBackdoorStatus'] == 'on' && isset($_GET['backdoorkey']) && ($_GET['backdoorkey'] == $settings['maintenanceBackdoorKey'])) {
			Observer::notify('maintenance_page_bypassed', $ip, $uri);
		}
		elseif(MaintenanceAccessControl::isAllowed($ip) == FALSE) {
			$uriSlug = trim($uri, '/');
			$maintenancePage = MaintenancePage::getMaintenanceURI();
			if($uriSlug != $maintenancePage || !isset($maintenancePage)) {
				Observer::notify('maintenance_page_displayed', $uri);
				MaintenanceController::displayMaintenancePage($uri, $settings);
			}			
		} else {
			Observer::notify('maintenance_page_bypassed', $ip, $uri);
		}
	}
}