<?php

require_once 'core.php';

$captcha = generateCode();

$cookie = md5($captcha);
$_SESSION['captcha'] = $cookie;

imgCode($captcha);

