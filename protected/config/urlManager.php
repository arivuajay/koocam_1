<?php

return array(
    'gii' => 'gii',
    'gii/<controller:\w+>' => 'gii/<controller>',
    'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
    '<controller:\w+>/<id:\d+>' => '<controller>/view',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    'login' => 'site/users/login',
    'home' => 'site/default/index',
    'gig/<slug:[-\w]+>' => array('site/gig/view', 'urlSuffix' => '.html'),
    'category/<slug:[-\w]+>' => array('site/gigcategory/view', 'urlSuffix' => '.html'),
    'page/<slug:[-\w]+>' => array('site/cms/view', 'urlSuffix' => '.html'),
    'profile/<slug:[-\w]+>' => array('site/user/profile', 'urlSuffix' => '.html'),
);
