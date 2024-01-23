<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function dd($data){
    echo '<pre>' . var_export($data, true) . '</pre>';
    die();
}
