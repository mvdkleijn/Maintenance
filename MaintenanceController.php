<?php

/**
* Maintenance Controller
* 
* @license		MIT
* @author		Andrew Waters
* @link			http://www.band-x.org
* @email		andrew@band-x.org
* 
* @file			MaintenanceClass.php
* @version		1.0
* @date			29/12/2009
* 
* Copyright (c) 2009
*/

class MaintenanceController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$settings = Plugin::getAllSettings('maintenance');
		$this->assignToLayout('sidebar', new View('../../plugins/maintenance/views/backend/sidebar', array('settings' => $settings)));
	}

	public function index() {
		redirect(get_url('maintenance/access'));
	}

	public function documentation() {
		$settings = Plugin::getAllSettings('maintenance');
		$this->display('maintenance/views/backend/documentation', array('settings' => $settings));
	}

	public function access($page=NULL) {
		if($page) {
			$parts = explode('/', $_SERVER['REQUEST_URI']);
			Maintenance::updateIpAccess($parts[6],$parts[7]);
			Flash::set('success', __('Your access list has been updated'));
			redirect(get_url('maintenance/access'));
		}
		$allowed = Maintenance::getAllowed();
		$this->display('maintenance/views/backend/access', array('allowed' => $allowed));
	}

	public function add() {
		Maintenance::addAccess($_POST);
		Flash::set('success', __('Your access list has been updated'));
		redirect(get_url('maintenance/access'));
	}

	public function edit() {
		Maintenance::editAccess($_POST);
		Flash::set('success', __('Your access list has been updated'));
		redirect(get_url('maintenance/access'));
	}

	public function view($id) {
		$allowed = Maintenance::getAllowed($id);
		$this->display('maintenance/views/backend/view', array('allowed' => $allowed));
	}

	public function delete($id) {
		Maintenance::deleteAccess($id);
		Flash::set('success', __('Your access list has been updated'));
		redirect(get_url('maintenance/access'));
	}

	public function settings($page=NULL) {
		if($page) {
			Maintenance::updateSettings($_POST);
			Flash::set('success', __('Your settings have been updated'));
			redirect(get_url('maintenance/settings'));
		}
		else {
			$customHTML = Maintenance::retrieveContent();
			$settings = Plugin::getAllSettings('maintenance');
			$this->display('maintenance/views/backend/settings', array('settings' => $settings, 'customHTML' => $customHTML));
		}
	}

	public function switchStatus($newStatus) {
		$maintenanceUpdate = Maintenance::switchStatus($newStatus);
		Flash::set('success', __('Maintenance is now ' . strtoupper($maintenanceUpdate) . ''));
		redirect(get_url('maintenance/settings'));
	}

}