<?php

namespace App\Controllers;



class Auth extends BaseController
{

    public function index()
	{
		if (session()->get('isLoggedIn') == TRUE) {
			return redirect()->to(base_url('/'));
		}
		if (!$this->validate(['username'  => 'required'])) {
            return view('common/login');
		} else {
			$username 		= htmlspecialchars($this->request->getVar('username', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
			$password 		= htmlspecialchars($this->request->getVar('password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
			$user 				= $this->userModel->getUser(username: $username);
			if ($user) {
				$verify = password_verify($password, $user['password']);
				if ($verify) {
					session()->set([
						'id_user'		=> $user['id_user'],
						'isLoggedIn' 	=> TRUE
					]);
					return redirect()->to(base_url('/'));
				} else {
					session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong !</b> ');
					return redirect()->to(base_url());
				}
			} else {
				session()->setFlashdata('notif_error', '<b>Your ID or Password is Wrong!</b> ');
				return redirect()->to(base_url());
			}
		}
	}

    public function logout()
	{
		$this->session->destroy();
        set_cookie('last_logout', time());
		return redirect()->to(base_url('/'));
	}

}
