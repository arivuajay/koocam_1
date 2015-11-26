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
    'gig/<slug:[a-zA-Z0-9-]+>/' => 'site/gig/view',
    'category/<slug:[a-zA-Z0-9-]+>/' => 'site/gigcategory/view',
    'page/<slug:[a-zA-Z0-9-]+>/' => 'site/cms/view',
    'profile/<slug:[a-zA-Z0-9-]+>/' => 'site/user/profile',
);
