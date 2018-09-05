<?php
$plugin->route->post([
    'as'   => 'userAjaxLogin',
    'uri' =>'userAjax'
], 'UserController@ajaxLogin');

/*$plugin->route->get([
    'as'   => 'modalLogin',
], 'AdminController@index');*/

$plugin->route->get([
    'as'   => 'userShowProfile',
    'uri' =>'user'
], 'UserController@showProfile');

$plugin->route->post([
    'as'     => 'ajaxCall',
    'uri'  => 'ajaxCall'
], 'AdminController@g_plupload_action');

$plugin->route->post([
    'as'     => 'updateOption',
    'uri'  => 'updateOption'
], 'AdminController@update_option');

$plugin->route->get([
    'as'   => 'ajaxTemplateOptions',
    'uri' =>'ajaxTemplateOptions'
], 'AdminController@ajaxTemplateOptions');


?>