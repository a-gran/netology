<?php
require 'core.php';
if (empty($_SESSION)) {
		header('Location: ./register.php');
} else {
		session_destroy();
		header('Location: ./register.php');
}