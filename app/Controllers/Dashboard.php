<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{
		$data = array_merge($this->data, [
			'title'         => 'Dashboard Page'
		]);
		return view('common/dashboard', $data);
	}
}
