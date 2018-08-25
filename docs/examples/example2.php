<?php

/**
 * PHPIDS
 * Requirements: PHP5, SimpleXML
 *
 * Copyright (c) 2010 PHPIDS group (https://phpids.org)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 2 of the license.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

require_once __DIR__.'/../../vendor/autoload.php';

use IDS\Init;
use IDS\Monitor;

/**
 * This is a slightly more realistic example of an application, but not much.
 */

if (!session_id()) session_start();

// Define an impact threshold.
$impact_threshold = 10;

$ids = new Monitor(Init::init(dirname(__FILE__) . '/Config.ini.php'));
$result = $ids->run(array(
        'GET' => $_GET,
        'POST' => $_POST,
        'COOKIE' => $_COOKIE
));

// die() if impact is greater then the threshold.
if (!$result->isEmpty() && $result->getImpact() > $impact_threshold) {
    die("<h2>An atempted attack was detected.</h2>");
}

/**
 * Dummy application follows.
 */
?>
<html lang = "en">
<head>
    <title>Example Application</title>
</head>
<body>
    <h2>Login Form</h2>
    <div>
        <?php
        $msg = '';

        if (isset($_POST['login']) && !empty($_POST['username']) &&
            !empty($_POST['password'])) {
               if ($_POST['username'] == 'example' &&
                   $_POST['password'] == 'example123') {
                   $msg = 'You have successfully logged in.';
               } else {
                   $msg = 'Incorrect username/password.';
               }
        }
        ?>
    </div>
    <form action = "#" method = "post">
        <h4><?php echo $msg; ?></h4>
        <input type = "text"
           name = "username"
           required autofocus></br>
        <input type = "password"
           name = "password" required></br>
        <button type = "submit"
           name = "login">Login</button>
     </form>
   </body>
</html>
