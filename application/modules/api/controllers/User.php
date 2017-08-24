<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Demo Controller with Swagger annotations
 * Reference: https://github.com/zircote/swagger-php/
 */

/**
 * [IMPORTANT] 
 * 	To allow API access without API Key ("X-API-KEY" from HTTP Header), 
 * 	remember to add routes from /application/modules/api/config/rest.php like this:
 * 		$config['auth_override_class_method']['dummy']['*'] = 'none';
 */
class User extends API_Controller {

	/**
	 * @SWG\Post(
	 * 	path="/user/create",
	 * 	tags={"user"},
	 * 	summary="Create User",
	 * @SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description="User info",
	 * 		required=true,
	 * 		@SWG\Schema(ref="#/definitions/UserSignUp")
	 * 	),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Create User",
	 * 	)
	 * )
	 */
	public function create_post()
	{		
			$this->load->model('User_model');
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
			$data = json_decode(file_get_contents('php://input'), true);
			$username = $data['username'];
			$email = $data['email'];
			$password = $data['password'];
			$identity = empty($username) ? $email : $username;
			$additional_data = array(
				'first_name'	=> $data['first_name'],
			);
			}
			else{
			$data = elements(array('username','email','password','first_name','last_name'), $this->post());
			// passed validation
			$username = $data['username'];
			$email = $data['email'];
			$password = $data['password'];
			$identity = empty($username) ? $email : $username;
			$additional_data = array(
				'first_name'	=> $data['first_name'],
			);
			}
			
			$check_user = $this->User_model->checkUser($data);
			if($check_user == 'user_exists'){
				$result['status'] = "false";
				$result['message'] = "user already exist";
				$this->response($result);
			}
			else{
			$result['status'] = "true";
			$result['message'] = "account created successfully";
			$user_id = $this->ion_auth->register($identity, $password, $email, $additional_data, $groups = array());
			$this->response($result);
			}
						
			
	}

	/**
	 * @SWG\Post(
	 * 	path="/user/login",
	 * 	tags={"user"},
	 * 	summary="Login User",
	 * @SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description="User Credentials",
	 * 		required=true,
	 * 		@SWG\Schema(ref="#/definitions/UserLogin")
	 * 	),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Login User",
	 * 	)
	 * )
	 */
	public function login_post(){

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
			$data = json_decode(file_get_contents('php://input'), true);
			$identity =$data['identity'];
			$password =$data['password'];
		}
    	else{
			$identity =$this->post('identity');
			$password =$this->post('password');	
		}
		//$this->load->model('User_model');
			if ($this->ion_auth->login($identity, $password, $remember=FALSE))
			{
				// login succeed
				$response['id']=$this->ion_auth->user()->row()->id;
				$response['email']=$this->ion_auth->user()->row()->email;
				$response['username']=$this->ion_auth->user()->row()->username;
				$response['first_name']=$this->ion_auth->user()->row()->first_name;	
				$response['last_login']=$this->ion_auth->user()->row()->last_login;
				$response['status'] = 'true';
				$response['msg'] = $this->ion_auth->messages();
			}
			else
			{
				// login failed
				$response['status'] = 'false';
				$response['msg'] = $this->ion_auth->errors();
			}
			$this->response($response);

	}

	
}