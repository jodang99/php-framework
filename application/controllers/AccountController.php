<?php
class AccountController extends Controller
{
	public function signupAction() {
		return $this->render(array(
				'_token'=>$this->generatesCsrfToken('account/signup'),
		));
	}
	
	public function registerAction()
	{
		if (!$this->request->isPost())
		{
			$this->forward404();
		}
		$token = $this->request->getPost('_token');
		if (!$this->checkCsrfToken('account/signup',$token))
		{
			return $this->redirect('/account/signup');
		}
		
		$user_name = $this->request->getPost('user_name');
		$password = $this->request->getPost('password');
		
		$errors = array();
		
		if (!strlen($user_name)){
			$errors[] = 'input user id please!!!';
		} else if (!preg_match('/^\w{3,20}$/', $user_name)){
			$errors[] = '3 - 20 character please!!!';
		} else if (!$this->db_manager->get('User')->isUniqueUserName($user_name)){
			$errors[]='input uniqe user id';
		}
		
		if (!strlen($password)){
			$errors[] = 'input password please';
		} else if (4 > strlen($password) || strlen($password) < 30){
			$errors[] = 'password is 4 ~ 30 length';
		}
		
		if (count($errors) === 0){
			$this->db_manager->get('User')->insert($user_name,$password);
			$this->session->setAuthenticated(true);
			
			$user=$this->db_manager->get('User')->fetchByUserName($user_name);
			$this->session->set('User',$user);
			
			return $this->redirect('/');
		}
		return $this->render(array(
				'user_name' => $user_name,
				'password'  => $password,
				'errors'    => $errors,
				'_token'    => $this->genetateCsrfToken('account/signup'),
		),'signup');
	}
}
?>