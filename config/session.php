<?php

session_start();

$loggedUsername = $_SESSION['username']  ?? 'Guest';
$loggedId = $_SESSION['id']  ?? 0;
