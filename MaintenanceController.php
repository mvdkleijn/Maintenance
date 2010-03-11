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
 * @package Maintenance Controller
 * @subpackage controllers
 *
 * @author Andrew Waters <andrew@band-x.org>
 * @version 1.1.0
 * @license http://creativecommons.org/licenses/MIT MIT License
 * @copyright band-x Media Limited, 2009 - 2010
 */

/**
 * Class MaintenancePage
 *
 * @since Maintenance version 1.0.0
 */


if(!defined('IN_CMS')) { exit(); }

class MaintenanceController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$settings = Plugin::getAllSettings('maintenance');
		$this->assignToLayout('sidebar', new View('../../plugins/maintenance/views/backend/sidebar', array('settings' => $settings)));
	}

	public function index() {
		redirect(get_url('maintenance/access'));
	}

	function displayMaintenancePage($uri, $settings) {
		switch($settings['maintenanceView']) {
			case 'static':		echo MaintenancePage::retrieveContent();
								break;
			case 'redirect':	header('Location: '.$settings['maintenanceRedirectURL'].'');
								break;
			case 'internal':	MaintenancePage::internalPageReferral();
								break;
		}
		exit();
	}

	public function access($page=NULL) {
		if($page) {
			$parts = array_reverse(explode('/', $_SERVER['REQUEST_URI']));
			MaintenanceAccessControl::updateIpAccess($parts[1], $parts[0]);
			Flash::set('success', __('Your access list has been updated'));
			redirect(get_url('maintenance/access'));
		}
		$allowed = MaintenanceAccessControl::getAllowed();
		$this->display('maintenance/views/backend/access', array('allowed' => $allowed));
	}

	public function add() {
		MaintenanceAccessControl::addAccess($_POST);
		Flash::set('success', __('Your access list has been updated'));
		redirect(get_url('maintenance/access'));
	}

	public function edit() {
		MaintenanceAccessControl::editAccess($_POST);
		Flash::set('success', __('Your access list has been updated'));
		redirect(get_url('maintenance/access'));
	}

	public function view($id) {
		$allowed = MaintenanceAccessControl::getAllowed($id);
		$this->display('maintenance/views/backend/view', array('allowed' => $allowed[0]));
	}

	public function delete($id) {
		MaintenanceAccessControl::deleteAccess($id);
		Flash::set('success', __('Your access list has been updated'));
		redirect(get_url('maintenance/access'));
	}

	public function settings($page=NULL) {
		if($page) {
			MaintenancePage::updateSettings($_POST);
			Flash::set('success', __('Your settings have been updated'));
			redirect(get_url('maintenance/settings'));
		}
		else {
			$customHTML = MaintenancePage::retrieveContent();
			$settings = Plugin::getAllSettings('maintenance');
			$this->display('maintenance/views/backend/settings', array('settings' => $settings, 'customHTML' => $customHTML));
		}
	}

	public function documentation() {
		$settings = Plugin::getAllSettings('maintenance');
		$this->display('maintenance/views/backend/documentation', array('settings' => $settings));
	}

	public function switchStatus($newStatus) {
		MaintenanceAccessControl::switchStatus($newStatus);
		Flash::set('success', __('Maintenance Mode is now <strong>' . strtoupper($newStatus) . '</strong>'));
		redirect(get_url('maintenance/settings'));
	}

}