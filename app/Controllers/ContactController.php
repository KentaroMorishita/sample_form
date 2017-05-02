<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Libs\DB;

class ContactController extends Controller
{

	public function index()
	{
		return $this->view('contacts/index.twig');
	}

}
