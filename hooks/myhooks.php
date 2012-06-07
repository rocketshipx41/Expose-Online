<?php
function prettyurls() {
    if (is_array($_GET) && count($_GET) == 1 && trim(key($_GET), '/') != '') {
        $newkey = str_replace('-','_',key($_GET));
        $_GET[$newkey] = $_GET[key($_GET)];
        unset($_GET[key($_GET)]);
    }
    if (isset($_SERVER['PATH_INFO'])) $_SERVER['PATH_INFO'] = str_replace('-','_',$_SERVER['PATH_INFO']);
    if (isset($_SERVER['QUERY_STRING'])) $_SERVER['QUERY_STRING'] = str_replace('-','_',$_SERVER['QUERY_STRING']);
    if (isset($_SERVER['ORIG_PATH_INFO'])) $_SERVER['ORIG_PATH_INFO'] = str_replace('-','_',$_SERVER['ORIG_PATH_INFO']);
    if (isset($_SERVER['REQUEST_URI'])) $_SERVER['REQUEST_URI'] = str_replace('-','_',$_SERVER['REQUEST_URI']);
}  
