<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beard extends Admin_Controller {

	public function index()
	{
	}

     public function getCampaigns()
    {
        $crud = $this->generate_crud('beard_campaigns');
        $crud->columns('id','campaign_name','bg_color','status','added_on');
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
		'gif|jpeg|jpg|png');
        $crud->set_field_upload('img_url', 'assets/uploads/being_beard/campaigns');
        $crud->callback_column('bg_color',array($this,'renderColor'));
        $crud->callback_add_field('path',array($this,'CampaignPath'));
        $crud->callback_edit_field('path',array($this,'CampaignPath')); 
        $this->mPageTitle = 'Beard Campaigns';
		$this->render_crud();
    }
    function CampaignPath($value){
            $value = 'assets/uploads/being_beard/campaigns/';
            $return = '<input type="text" name="path" value="'.$value.'" /> ';
            return $return;
        }
    public function showImage($value, $row) { 
        
        return "<img src='$row->path$row->img_url' width=100 >";
        }
    function renderColor($value,$row){
        $color_code = $row->bg_color;
        $site_url = $this->config->site_url();
        $value = $site_url.'assets/uploads/being_beard/campaigns/';
        return "<div style='background-color:$color_code;margin:auto;text-align:center;'><img src=$value$row->img_url width=50;height:50 style='margin:auto'; ></div>";
        }
}
