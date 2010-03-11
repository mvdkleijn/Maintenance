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
 * @subpackage models
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

class MaintenancePage extends Record {

	const TABLE_NAME = "maintenance_page";

	public $id;
	public $value;

	private function displayContent() {
		$content = Record::findByIdFrom('MaintenancePage', 1);
		echo $content->value;
	}

	public function retrieveContent() {
		$content = Record::findByIdFrom('MaintenancePage', 1);
		return $content->value;
	}

	public function internalPageReferral() {
		$maintenancePageSlug = self::getMaintenanceURI();
		header('Location: ' . BASE_URL . $maintenancePageSlug);
		$maintenancePageSlug = self::getMaintenanceURI();
		header('Location: ' . BASE_URL . $maintenancePageSlug);
	}

	public function getMaintenanceURI() {
		$page = Record::findOneFrom('Page', "behavior_id='Maintenance'");
		return $page->slug;
	}

	public function updateSettings($_POST) {
		foreach($_POST as $key=>$value) {
			if($key != 'customHTML') {
				$value = filter_var($value, FILTER_SANITIZE_STRING);
				Plugin::setAllSettings(array($key => $value), 'maintenance');
			}
			elseif($key == 'customHTML') {
				Record::update('MaintenancePage', array('value' => $value), "id='1'");
			}
		}
	}

}