<?php

namespace SkySliders\Modules\Photography;

use SkySliders\Base\Module_Base;

class Module extends Module_Base {

	public function __construct() {
		parent::__construct();
	}

	public function get_name() {
		return 'photography';
	}

	public function get_widgets() {
		return [
			'Photography',
		];
	}
}
