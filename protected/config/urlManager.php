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
    'faq' => array('site/default/faq', 'urlSuffix' => '.html'),
    'contactus' => array('site/default/contactus', 'urlSuffix' => '.html'),
    'howitworks' => array('site/default/howitworks', 'urlSuffix' => '.html'),
    'chat/<guid:[-\w]+>' => 'site/default/chat',
    'cam/<slug:[-\w]+>' => array('site/cam/view', 'urlSuffix' => '.html'),
    'category/<slug:[-\w]+>' => array('site/camcategory/view', 'urlSuffix' => '.html'),
    'page/<slug:[-\w]+>' => array('site/cms/view', 'urlSuffix' => '.html'),
    'profile/<slug:[-\w]+>' => array('site/user/profile', 'urlSuffix' => '.html'),
);
