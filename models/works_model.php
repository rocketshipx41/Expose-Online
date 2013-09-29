<?php

/* * *************************************************************
 * Date         Author      Purpose
 *
 * $Header: $
 * ************************************************************* */

class Works_model extends CI_Model
{
	public $trace = '';
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function get_list($params = array())
	{
		$result = array();
		return $result;
	}
	
	function get_details($id)
	{
		$result = array();
		return $result;
	}
	
	function get_list_by_pseudonym($id)
	{
		//
	}
	
	function get_excerpt_list()
	{
		//
	}
	
	function get_excerpt($id)
	{
		//
	}
	
}
