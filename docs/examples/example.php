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

if (!session_id()) session_start();

/**
 * It's pretty easy to get the PHPIDS running.
 */

try {
    /**
     * 1. Define what to scan.
     *
     * Please keep in mind what array_merge does and how this might interfere
     * with your variables_order settings.
     */
    $request = array(
        'GET' => $_GET,
        'POST' => $_POST,
        'COOKIE' => $_COOKIE
    );

    // Define the path to your Config.ini.php file.
    // A default version of this file is provided /lib/IDS/Config.
    $init = Init::init(dirname(__FILE__) . '/Config.ini.php');

    // You can also reset the whole configuration
    // array or merge in own data.

    // This usage doesn't overwrite already existing values:
    // $config->setConfig(array('General' => array('filter_type' => 'xml')));

    // This does, see 2nd parameter:
    // $config->setConfig(array('General' => array('filter_type' => 'xml')), true);

    // or you can access the config directly like here:
    // $init->config['General']['base_path'] = dirname(__FILE__) . '/../../lib/IDS/';

    // Disable caching for this example.
    $init->config['Caching']['caching'] = 'none';

    /**
     * 2. Initiate the PHPIDS and fetch the results
     */
    $ids = new Monitor($init);

    $result = $ids->run($request);

    /**
     * 3. That's it - now you can analyze the results:
     *
     * In the result object you will find any suspicious
     * fields of the passed array enriched with additional info
     *
     * Note: it is moreover possible to dump this information by
     * simply echoing the result object, since IDS_Report implemented
     * a __toString method.
     */
    if (!$result->isEmpty()) {
        echo $result;
    } else {
        echo '<a href="?test=%22><script>eval(window.name)</script>">No attack detected - click for an example attack</a>';
    }
} catch (\Exception $e) {
    /*
    * Something went terribly wrong.
    * Maybe the filter rules weren't found?
    */
    printf(
        'An error occured: %s',
        $e->getMessage()
    );
}
