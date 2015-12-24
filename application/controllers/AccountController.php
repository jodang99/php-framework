<?php
class AccountController extends Controller
{
	protected $auth_actions = array('index', 'signout', 'following');
	
	public function signupAction() {
		return $this->render(array(
				'user_name'=>'',
				'password'=>'',
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
	
	public function indexAction(){
		$user = $this->session->get('user');
		
		$followings = $this->db_manager->get('User')->fetchAllFollowingsByUserId($user['id']);
		
		
		
		return $this->render(array(
				'user' => $user,
				'followings' => $followings,
		));
	}
	
	public function signinAction()
	{
		if ($this->session->isAuthenticated()){
			return $this->redirect('/account');
		}
		return $this->render(array(
				'user_name'=>'',
				'password'=>'',
				'_token'=>$this->generateCsrfToken('account/signin'),
		));
	}
	
	public function authenticateAction()
	{
		if ($this->session->isAuthenticated()){
			return $this->redirect('/account');
		}
		
		if (!$this->request->isPost()){
			$this->forward404();
		}
		
		$token = $this->request->getPost('_token');
		if (!$this->checkCsrfToken('account/signin', $token)){
			return $this->redirect('/account/signin');
		}
		
		$user_name = $this->request->getPost('user_name');
		$password = $this->request->getPost('password');
		
		$errors = array();
		
		if (!strlen($user_name)){
			$errors[] = 'Input User id please';
		}
		
		if (!strlen($password)){
			$errors[] = 'Input password Please';
		}
		
		if (count($errors) === 0) {
			$user_repository = $this->db_manager->get('User');
			$user = $user_repository->fetchByUserName($user_name);
		
			if (!$user || ($user['password'] !== $user_repository->hashPassword($password))){
				$errors[] = 'Do not match ID and Password';
			} else {
				$this->session->setAuthenticated(true);
				$this->session->set('user', $user);
			
				return $this->redirect('/');
			}
		}
		return $this->render(array(
				'user_name' => $user_name,
				'password' => $password,
				'errors'  => $errors,
				'_token' => $this->generateCsrfToken('account/signin'),), 'signin'
		);
	}
	
	public function signoutAction(){
		$this->session->clear();
		$this->session->setAuthenticated(false);
		
		return $this->redirect('/account/signin');
	}
	
	public function followAction(){
		if (!$this->request->isPost()){
			$this->forward404();
		}
		
		$following_name = $this->request->getPost('following_name');
		if (!following_name){
			$this->forward404();
		}
		
		$token = $this->request->getPost('_token');
		if (!$this->checkCsrfToken('account/follow', $token)){
			return $this->redirect('/user/'.$following_name);
		}
		
		$follow_user = $this->db_manager->get('User')->fetchByUserName($following_name);
		if (!$follow_user){
			$this->forward404();
		}
		
		$user = $this->session->get('user');
		
		$following_repository = $this->db_manager->get('Following');
		if ($user['id'] !== $follow_user['id']
				&& !$following_repository->isFollowing($user['id'], $follow_user['id'])){
			$following_repository->insert($user['id'], $follow_user['id']);
		}
		
		return $this->redirect('/account');
	}
}
?>