<?php

class MaintenanceController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$settings = Plugin::getAllSettings('maintenance');
		$this->assignToLayout('sidebar', new View('../../plugins/maintenance/views/backend/sidebar', array('settings' => $settings)));
	}

	public function index() {
		$this->display('maintenance/views/backend/index');
	}

	public function access() {
		$this->display('maintenance/views/backend/access');
	}

	public function switchStatus($newStatus) {
		$maintenanceUpdate = Maintenance::switchStatus($newStatus);
		Flash::set('success', __('Maintenance is now ' . strtoupper($maintenanceUpdate) . ''));
		redirect(get_url('maintenance'));
	}

}