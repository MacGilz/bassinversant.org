<?php

$plugin->panel->add([
    'type'   => 'panel',
    'as'     => 'modalLogin',
    'title'  => 'Modal Login',
    'slug'   => 'configureModalLogin'
], 'AdminController@index');


/*$plugin->panel->add([
    'type'   => 'subpanel',
    'parent' => 'mainPanel',
    'as'     => 'configure',
    'title'  => 'Configure',
    'slug'   => 'myplugin-configure'
], 'AdminController@configure');*/
?>
