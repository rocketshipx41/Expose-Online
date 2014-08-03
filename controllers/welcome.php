<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Academic Free License version 3.0
 * 
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

class Welcome extends MY_Controller 
{

    function __construct()
    {
	parent::__construct();
        $this->page_data['trace'] .= '>> construct welcome controller<br/>';
	
	$this->page_data['page_name'] = 'Home';
    }
	
    /**
    * Index Page for this controller.
    *
    * Maps to the following URL
    * 		http://example.com/index.php/welcome
    *	- or -  
    * 		http://example.com/index.php/welcome/index
    *	- or -
    * Since this controller is set as the default controller in 
    * config/routes.php, it's displayed at http://example.com/
    *
    * So any other public methods not prefixed with an underscore will
    * map to /index.php/welcome/<method_name>
    * @see http://codeigniter.com/user_guide/general/urls.html
    */
    public function index()
    {
        // init
        $this->page_data['carousel_list'] = array();
        $this->page_data['feature_list'] = array();
        $this->page_data['review_list'] = array();
        $this->page_data['banner_ad'] = array();
        $this->page_data['side_ad'] = array();
        
        // process
        $this->page_data['carousel_list'] = $this->cache->model('Article_model', 'get_front_page',
                array(), 1024);
        $this->page_data['feature_list'] = $this->Article_model->most_recent('features', 
                    5, 0, FALSE);
        $this->page_data['review_list'] = $this->Article_model->most_recent('reviews', 
                    5, 0, FALSE);
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');

        // display
        $this->page_data['show_columns'] = 2;
        $this->page_data['trace'] .= $this->Article_model->trace;
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->set_partial('left_column', 'left_column')
                ->build('home/home_center', $this->page_data);
    }
    
    public function login()
    {
	if ($this->tank_auth->is_logged_in()) { // logged in
	    redirect('');
	}
	else {
	    $this->page_data['page_name'] = 'Login';
	    $this->load->library('form_validation');
	    $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
			    $this->config->item('use_username', 'tank_auth'));
	    $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

	    $this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
	    $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
	    $this->form_validation->set_rules('remember', 'Remember me', 'integer');

	    // Get login for counting attempts to login
	    if ($this->config->item('login_count_attempts', 'tank_auth') AND
			    ($login = $this->input->post('login'))) {
		$login = $this->security->xss_clean($login);
	    } 
	    else {
		$login = '';
	    }

	    $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
	    $data['use_recaptcha'] = FALSE;
	    if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
		if ($data['use_recaptcha']) {
		    $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
		}
		else {
		    $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
		}
	    }
	    $data['errors'] = array();

	    if ($this->form_validation->run()) { // validation ok
		if ($this->tank_auth->login(
				$this->form_validation->set_value('login'),
				$this->form_validation->set_value('password'),
				$this->form_validation->set_value('remember'),
				$data['login_by_username'],
				$data['login_by_email'])) {								// success
			redirect('');

		} 
		else {
		    $errors = $this->tank_auth->get_error_message();
		    if (isset($errors['banned'])) { // banned user
			$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);
		    } 
		    elseif (isset($errors['not_activated'])) { // not activated user
			redirect('/auth/send_again/');
		    } 
		    else { // fail
			foreach ($errors as $k => $v) {
			    $data['errors'][$k] = $this->lang->line($v);
			}
		    }
		}
	    }
	    $data['show_captcha'] = FALSE;
	    if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
		$data['show_captcha'] = TRUE;
		if ($data['use_recaptcha']) {
		    //$data['recaptcha_html'] = $this->_create_recaptcha();
		} 
		else {
		    //$data['captcha_html'] = $this->_create_captcha();
		}
	    }
            $this->page_data['show_columns'] = 3;
	    $this->template
		    ->title($this->page_data['site_name'], $this->page_data['page_name'])
		    ->build('home/login_form', $this->page_data);
	}
    }
    
    /**
	* Logout user
	*
	* @return void
	*/
    function logout()
    {
	$this->tank_auth->logout();
	$this->session->set_flashdata('message', $this->lang->line('auth_message_logged_out'));
	redirect('');
    }

    public function about()
    {
	$this->page_data['page_name'] = lang('menu_about');
        $this->page_data['show_columns'] = 3;
        $this->page_data['menu_active'] = 'about';
        $this->page_data['banner_ad'] = $this->Ad_model->serve('top');
        $this->page_data['side_ad'] = $this->Ad_model->serve('side');
        $this->template
                ->title($this->page_data['site_name'], $this->page_data['page_name'])
                ->build('home/about', $this->page_data);
    }
    
    public function changepwd()
    {
        $this->page_data['show_ads'] = FALSE;
        if ( ! $this->tank_auth->is_logged_in() ) {								// not logged in or not activated
            redirect('/auth/login/');
        }
        else {
            $this->page_data['page_name'] = lang('menu-change-password');
	    $this->load->library('form_validation');
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');

            $data['errors'] = array();

            if ( $this->form_validation->run() ) {								// validation ok
                if ( $this->tank_auth->change_password(
                        $this->form_validation->set_value('old_password'),
                        $this->form_validation->set_value('new_password'))) {	// success
                    $this->_show_message($this->lang->line('auth_message_password_changed'));
                    redirect('');
                }
                else {														// fail
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }
                }
            }
            $this->page_data['show_columns'] = 3;
	    $this->template
		    ->title($this->page_data['site_name'], $this->page_data['page_name'])
		    ->build('auth/change_password_form', $this->page_data);
        }
    }
    
	/**
	 * Callback function. Check if CAPTCHA test is passed.
	 *
	 * @param	string
	 * @return	bool
	 */
	function _check_captcha($code)
	{
		$time = $this->session->flashdata('captcha_time');
		$word = $this->session->flashdata('captcha_word');

		list($usec, $sec) = explode(" ", microtime());
		$now = ((float)$usec + (float)$sec);

		if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
			return FALSE;

		} elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') AND
				$code != $word) OR
				strtolower($code) != strtolower($word)) {
			$this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

	/**
	 * Create reCAPTCHA JS and non-JS HTML to verify user as a human
	 *
	 * @return	string
	 */
	function _create_recaptcha()
	{
		$this->load->helper('recaptcha');

		// Add custom theme so we can get only image
		$options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

		// Get reCAPTCHA JS and non-JS HTML
		$html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

		return $options.$html;
	}

	/**
	 * Callback function. Check if reCAPTCHA test is passed.
	 *
	 * @return	bool
	 */
	function _check_recaptcha()
	{
		$this->load->helper('recaptcha');

		$resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'),
				$_SERVER['REMOTE_ADDR'],
				$_POST['recaptcha_challenge_field'],
				$_POST['recaptcha_response_field']);

		if (!$resp->is_valid) {
			$this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
			return FALSE;
		}
		return TRUE;
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */