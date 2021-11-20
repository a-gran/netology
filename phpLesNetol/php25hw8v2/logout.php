<?php
require_once 'core.php';
if (!isAuthorized())
{
    location('index');
}
logout();