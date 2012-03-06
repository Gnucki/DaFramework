<?php

require_once 'cst.php';
require_once INC_SBALISE;
require_once INC_CSSELEMENTAMI;

$cssElem = new CssElementAmi('Amis');
echo $cssElem->BuildHTML();

?>