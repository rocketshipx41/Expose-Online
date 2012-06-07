<?php

/* * *************************************************************
 * Date         Author      Purpose
 *
 * $Header: $
 * ************************************************************* */

class Publications_model extends CI_Model
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
	
	function get_contents($id)
	{
		//
	}
	
	// as in magazines
	function get_list_by_series($params = array())
	{
		$result = array();
		return $result;
	}
	
	function update($id, $params)
	{
		// add or update
	}
	
}

