<?php

namespace SkySliders\Modules\Minimal;

use SkySliders\Base\Module_Base;

class Module extends Module_Base {

	public function __construct() {
		parent::__construct();
	}

	public function get_name() {
		return 'minimal';
	}

	public function get_widgets() {
		return [
			'Minimal',
		];
	}
}
