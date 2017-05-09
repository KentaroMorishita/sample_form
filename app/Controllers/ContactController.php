<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{

	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *
	 * @return type
	 */
	public function index()
	{
		$contacts = Contact::factory(Contact::class)->find_many();
		return $this->view('contacts/index.twig', compact('contacts'));
	}

	/**
	 *
	 * @return type
	 */
	public function show()
	{
		$get = $this->get();

		$contact = Contact::factory(Contact::class)
				->find_one($get['id']);

		return $this->view('contacts/show.twig', compact('contact'));
	}

	/**
	 *
	 * @return type
	 */
	public function create()
	{
		if ($this->method === self::REQUEST_POST) {
			$post = $this->post();
			if ($this->validate($post)) {
				$this->store($post);
			}
		}

		return $this->view('contacts/create.twig');
	}

	/**
	 *
	 * @return type
	 */
	public function edit()
	{
		$contact = Contact::factory(Contact::class)
				->find_one($this->get['id']);

		return $this->view('contacts/edit.twig', compact('contact'));
	}

	/**
	 *
	 * @param type $data
	 * @return boolean
	 */
	protected function validate($data)
	{
		// TODO validation
		return true;
	}

	/**
	 *
	 * @param type $data
	 */
	protected function store($data)
	{
		$contact = Contact::factory(Contact::class)->create();
		$contact->set($data)->save();
		return $this->redirect('contact', 'index');
	}

	/**
	 *
	 * @param type $id
	 */
	protected function update($id)
	{

	}

}
