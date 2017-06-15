<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Contact;
use App\Libs\Csrf;

class ContactController extends Controller
{

	protected $_errors = [];
	protected $_rules = [
		'name' => 'required|string',
		'email' => 'required|string|email',
		'gender' => 'required',
		'title' => 'required|string',
		'content' => 'required|string'
	];
	protected $_error_messages = [
		'required' => ':key is required.',
		'string' => ':key is not string.',
		'email' => ':key is invalid email address.',
	];

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
		$post = $this->post();
		if ($this->method === self::REQUEST_POST && Csrf::checkToken($post['token'])) {
			unset($post['token']);
			if ($this->validate($post)) {
				$this->store($post);
			}
		}

		$errors = $this->_errors;
		return $this->view('contacts/create.twig', compact('post', 'errors'));
	}

	/**
	 *
	 * @return type
	 */
	public function edit()
	{
		$get = $this->get();
		$contact = Contact::factory(Contact::class)
				->find_one($get['id']);

		$post = $this->post();
		if ($this->method === self::REQUEST_POST && Csrf::checkToken($post['token'])) {
			unset($post['token']);
			if ($this->validate($post)) {
				$this->update($get['id'], $post);
			}
		}

		$errors = $this->_errors;
		$data = compact('contact', 'post', 'errors');
		return $this->view('contacts/edit.twig', $data);
	}

	/**
	 *
	 * @param type $data
	 * @return boolean
	 */
	protected function validate($data)
	{
		$validations = self::getValidations();

		foreach ($this->_rules as $key => $rules_string) {
			$rules = explode('|', $rules_string);
			foreach ($rules as $rule) {
				$option = ['options' => $validations[$rule]];
				$valid = filter_var($data[$key], FILTER_CALLBACK, $option);
				if (!$valid) {
					$msg = $this->_error_messages[$rule];
					$this->_errors[$key] = str_replace(':key', ucfirst($key), $msg);
					break;
				}
			}
		}

		return empty($this->_errors);
	}

	/**
	 *
	 * @return type
	 */
	protected static function getValidations()
	{
		return [
			'required' => function($val) {
				return !empty($val);
			},
			'string' => function($val) {
				return is_string($val);
			},
			'email' => function($val) {
				return filter_var($val, FILTER_VALIDATE_EMAIL) ? true : false;
			},
		];
	}

	/**
	 *
	 * @param type $data
	 */
	protected function store($data)
	{
		$contact = Contact::factory(Contact::class)->create();
		$contact->set($data)->save();
		return $this->redirect('/');
	}

	/**
	 *
	 * @param type $id
	 */
	protected function update($id, $data)
	{
		$contact = Contact::factory(Contact::class)
				->find_one($id);
		$contact->set($data)->save();
		return $this->redirect('/');
	}

}
