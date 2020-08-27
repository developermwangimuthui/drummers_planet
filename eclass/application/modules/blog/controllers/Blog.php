<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Blog extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('session'));
		$this->load->library(array('ion_auth','form_validation'));
		
		// SEO
		$seo = get_seo( 'dynamicpage' );
		$this->data['pagetitle'] = '';
		$this->data['meta_description'] = '';
		$this->data['meta_keywords'] = '';
		if( ! empty( $seo ) ) {
			$this->data['pagetitle'] = $seo['seo_title'];
			$this->data['meta_description'] = $seo['seo_description'];
			$this->data['meta_keywords'] = $seo['seo_keywords'];
		}
	}
	/*** Displays the Index Page**/
	function index()
	{
		$this->data['activemenu'] 	= "blog";		
		$this->data['content'] 		= 'index';
		$this->_render_page('template/site/site-template', $this->data);
	}
	
	function single()
	{
		$this->data['activemenu'] 	= "blog";		
		$this->data['content'] 		= 'single';
		$this->_render_page('template/site/site-template', $this->data);
	}

	function pages($slug = "")
	{
		$slug = str_replace('_', '-', $slug);

		if(empty($slug)) {

			redirect('/');
		}

		$this->load->model('base_model');
		$page_info= $this->base_model->get_page_by_title_content($slug);

		if(empty($page_info))
			redirect('/');

		$this->data['page_info'] 	= $page_info;
		$this->data['pagetitle'] 	= (!empty($page_info)) ? $page_info[0]->name : $this->data['pagetitle'];
		$this->data['meta_description'] = (!empty($page_info)) ? $page_info[0]->meta_description : $this->data['meta_description'];
		$this->data['meta_keywords'] = (!empty($page_info)) ? $page_info[0]->seo_keywords : $this->data['meta_keywords'];
		$this->data['content'] 		= 'page_content';

		$this->_render_page('template/site/site-template', $this->data);
	
	}

}
?>