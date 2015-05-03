<?php
//phpinfo();

if(isset($_GET['x'])){
    echo '<pre>';
    print_r($_GET);
    exit;
}

require 'view/default.php';
