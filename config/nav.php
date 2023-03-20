<?php

return [
    'dashboard' => [
        'title' => 'Dashboard',
        'icon'=>'far fa-circle nav-icon',
        'route' =>'/dashboard'
    ],
    'categories'=>[
        'title' => 'Categories',
        'icon'=>'far fa-circle nav-icon',
        'route' =>'/dashboard/categories'
    ],
    'products'=>[
        'title' => 'Products',
        'icon'=>'far fa-circle nav-icon',
        'route' =>'/dashboard/products'
    ],
    'orders'=>[
        'title' => 'Orders',
        'icon'=>'far fa-circle nav-icon',
        'route' =>'/dashboard/orders',
        'badge' => [
            'class' => 'primary',
            'label' => 'New'
        ]
    ],
    'setting'=>[
        'title' => 'Setting',
        'icon'=>'far fa-circle nav-icon',
        'route' =>'/dashboard/setting'
    ]
]

?>