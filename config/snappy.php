<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => base_path("resources/files/wkhtmltopdf-linux-amd64"),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
