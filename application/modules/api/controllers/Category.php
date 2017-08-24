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
class Category extends API_Controller {

	/**
	 * @SWG\Get(
	 * 	path="/category/",
	 * 	tags={"category"},
	 * 	summary="List out Categories",
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Category Json",
	 * 	)
	 * )
	 */
	public function index_get()
	{  
		$this->load->model('Category_model');
		$data['trending_categories'] = $this->Category_model->getCategories();
		//$data['trending_categories']['host'] = $base_url;
		$this->response($data);
	}

	/**
	 * @SWG\Get(
	 * 	path="/category/{id}",
	 * 	tags={"category"},
	 * 	summary="Look up a Category",
	 * 	@SWG\Parameter(
	 * 		in="path",
	 * 		name="id",
	 * 		description="Category id",
	 * 		required=true,
	 * 		type="integer"
	 * 	),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Category object",
	 * 	),
	 * 	@SWG\Response(
	 * 		response="404",
	 * 		description="Invalid Category ID"
	 * 	)
	 * )
	 */
	public function id_get($id)
	{
		$cat_id = $id;
		$data = array();
		$this->load->model('Category_model');
		$data['category_detail'] = $this->Category_model->getCategory($cat_id);
		$this->response($data);
	}


	/**
	 * @SWG\Post(
	 * 	path="/category/contests",
	 * 	tags={"category"},
	 * 	summary="Get Category Contests",
	 * @SWG\Parameter(
	 * 		in="body",
	 * 		name="body",
	 * 		description="Category Id",
	 * 		required=true,
	 * 		@SWG\Schema(ref="#/definitions/CategoryContest")
	 * 	),
	 * 	@SWG\Response(
	 * 		response="200",
	 * 		description="Category Contest",
	 * 	)
	 * )
	 */
	public function contests_post()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
			$data = json_decode(file_get_contents('php://input'), true);
			$cat_id =$data['cat_id'];
		}
    	else{
			$cat_id =$this->post('cat_id');
		}
		$data = array();
		$this->load->model('Category_model');
		$data['category_contest'] = $this->Category_model->getCategoryContest($cat_id);
		$this->response($data);
	}

	
	
	
}
