<?php

/* * *************************************************************
 * Date         Author      Purpose
 *
 * $Header: $
 * ************************************************************* */

class People_model extends CI_Model
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
	
	function get_works($id, $role_id = 1)
	{
		$result = array();
		return $result;		
	}
	
	function get_pseudonyms($id, $role_id = 1)
	{
		$result = array();
		return $result;		
	}
	
}

