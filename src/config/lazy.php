<?php
return
    ['placeholders' => [
        'default' => 'images/placeholder.png',
        'classes' => [
            'product' => 'images/product-placeholder.png',
            'photo' => 'images/photo-placeholder.png',
        ]
    ],
        //basic or ajax
        'method' => 'ajax',
        'controller' => 'samjoyce777\lazy\ImageController@ajax'
    ];