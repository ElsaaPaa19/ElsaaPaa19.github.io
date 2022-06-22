<?php

namespace App\Modules\Auth\Controllers;

use App\Controllers\BaseController;
use App\Modules\Auth\Models\LoginModel;

class Auth extends BaseController
{
	public function login()
	{
		if ($this->session->logged_in == true && $this->session->role == 1) {
			return redirect()->to('/dashboard');
		}
		if ($this->session->logged_in == true && $this->session->role == 2) {
			return redirect()->to('/dashboard');
		}

		return view('App\Modules\Auth\Views/login');
	}

	public function register()
	{
		if ($this->session->logged_in == true && $this->session->role == 1) {
			return redirect()->to('/dashboard');
		}
		if ($this->session->logged_in == true && $this->session->role == 2) {
			return redirect()->to('/dashboard');
		}

		return view('App\Modules\Auth\Views/register');
	}

	public function verifyEmail()
	{
		$input = $this->request->getVar();

		$rules = [
			'email' => [
				'rules'  => 'required',
				'errors' => []
			],
			'token' => [
				'rules'  => 'required',
				'errors' => []
			],
		];

		if (!$this->validate($rules)) {
			return redirect()->to(base_url());
		}

		$user_model = new LoginModel();
		$user = $user_model->where(['email' => $input['email'], 'token' => $input['token']])->first();
		$user_data = [
			'active' => 1,
		];
		$user_model->update($user['user_id'], $user_data);
		return redirect()->to(base_url());
	}

	public function passwordReset()
	{
		if (isset($this->session->username)) return redirect()->to(base_url('dashboard'));
		return view('App\Modules\Auth\Views\password/reset');
	}

	public function passwordChange()
	{
		if (isset($this->session->username)) return redirect()->to(base_url('dashboard'));
		$rules = [
			'email' => [
				'rules'  => 'required',
				'errors' => []
			],
			'token' => [
				'rules'  => 'required',
				'errors' => []
			],
		];
		if (!$this->validate($rules)) {
			return redirect()->to(base_url());
		}
		$data = $this->request->getVar();
		return view('App\Modules\Auth\Views\password/change', $data);
	}

	public function logout()
	{
		$this->session->destroy();
		$this->session->setFlashdata('success', 'Berhasil Logout');
		return redirect()->to('/login');
	}
}
