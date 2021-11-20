<?php
require_once 'core.php';

if (isset($_COOKIE['ban'])) {
    location('ban.php');
}

if (!isAuthorized() && !isQuest()) {
    location('../admin.php');
}
logout();