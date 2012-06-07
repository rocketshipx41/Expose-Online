<?php

function create_unique_slug($string, $table, $field = 'slug', $key = NULL, $value = NULL)
{
    $t =& get_instance(); 

    $slug = url_title($string);
    $slug = strtolower($slug);
    $i = 0;
    $params = array ();
    $params[$field] = $slug;

    if ($key)$params["$key !="] = $value;

    while ($t->db->where($params)->get($table)->num_rows()) {
	if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
	    $slug .= '-' . ++$i;
	} 
	else {
	    $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );
	}
	$params [$field] = $slug;
    }
    return $slug;
}
	
function credit_display($credit_list, $role_id)
{
    $result = '';
    if (is_array($credit_list)) {
	foreach ($credit_list[$role_id] as $id => $item) {
	    if ($result != '') {
		$result .= ', ';
	    }
	    if (isset($item)) {
		$result .= $item;
	    }
	    else {
		$result .= '(??)';
	    }
	}
    }
    return $result;
}

function topic_display($topic_list)
{
    $result = '';
    if (is_array($topic_list)) {
	foreach ($topic_list as $item) {
	    if ($result != '') {
		$result .= ', ';
	    }
	    $result .= $item['title'];
	}
	
    }
    return $result;
}
