<?php

return array(
    
    'defaultController' => 'Home',
    
    // Just put null value if you has enable .htaccess file
    'indexFile' => INDEX_FILE . '/',
    
    'module' => array(
        'path' => GEAR,
        'domainMapping' => array(),
    ),
    
    'vendor' => array(
        'path' => GEAR.'Vendors/'
    ),
    
    'alias' => array(
        
        'controller' => array(
            'class' => 'Profile',
            'method' => 'index'
        ),
        
        'method' => 'alias'
    ),
);