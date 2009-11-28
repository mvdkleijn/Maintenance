<?php

class MaintenanceController extends PluginController {

	public function __construct() {
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/maintenance/views/backend/sidebar'));
	}

	public function index() {
		$this->display('maintenance/views/backend/index');
	}

	public function access() {
		$this->display('maintenance/views/backend/access');
	}

}