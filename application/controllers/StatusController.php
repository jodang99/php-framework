<?php
class StatusController extends Controller
{
	protected $auth_action = array('index', 'post');
	
	public function indexAction() {
		$user = $this->session->get('user');
		$statuses = $this->db_manager->get('Status')
		->fetchAllPersonalArchivesByUserId($user['id']);
		
		return $this->render(array(
				'statuses' => $statuses,
				'body' => '',
				'_token' => $this->generateCsrfToken('status/post'),
		));	
	}
	
	public function postAction(){
		if (!$this->request->isPost()){
			$this->forward404();
		}
		$token = $this->request->getPost('_token');
		if (!$this->checkCsrfToken('status/post', $token)){
			return $this->redirect('/');
		}
		
		$body = $this->request->getPost('body');
		$errors = array();
		
		if (!strlen($body)){
			$errors[] ='input something!!';
		} else if (mb_strlen($body) > 200){
			$errors[] = 'input something under 200 string';
		}
		
		if (count($errors) === 0){
			$user = $this->session->get('user');
			$this->db_manager->get('Status')->insert($user['id'], $body);
			
			return $this->redirect('/');
		}
		
		$user = $this->session->get('user');
		$statuses = $this->db_manager->get('Status')->fetchAllPersionalArchivesByUserId($user['id']);
		
		return $this->render(array(
				'errors'=>$erros,
				'body'  =>$body,
				'statuses' =>$statuses,
				'_token' =>$this->generateCsrfToken('status/post'),
				),'index'
			);
	}
	
	public function userAction($params){
		$user = $this->db_manager->get('User')->fetchByUserName($params['user_name']);
		if (!$user){
			$this->forward404();
		}
		
		$statuses = $this->db_manager->get('Status')->fetchAllByUserId($user['id']);
		
		// follow or not here
		$following = null;
		if ($this->session->isAuthenticated()){
			$my = $this->session->get('user');
			if ($my['id'] !== $user['id']) {
				$following = $this->db_manager->get('Following')->isFollowing($my['id'], $user['id']);
			}
		}
		
		return $this->render(array(
				'user' => $user, 
				'statuses'=>$statuses,
				'following' => $following,
				'_token' => $this->generateCsrfToken('account/follow'),
		));
	}
	
	public function showAction($parmas){
		$status = $this->db_manager->get('Status')->fetchByIdAndUserName($params['id'], $parmas['user_name']);
		
		if (!$status){
			$this->forward404();
		}
		
		return $this->render(array('status'=>$status));
	}
}
?>