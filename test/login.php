<?php
/**
 * Project template-backend-package
 * Created by PhpStorm
 * User: tienhm <tienhm@beetsoft.com.vn>
 * Copyright: tienhm <tienhm@beetsoft.com.vn>
 * Date: 02/07/2022
 * Time: 00:19
 */
require_once __DIR__ . '/../vendor/autoload.php';
$config = [
    'DATABASE' => [
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'username'  => 'root',
        'password'  => '1234qazx',
        'database'  => 'bapi',
        'port'      => 3306,
        'prefix'    => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
    ],
    'OPTIONS'  => [
        'showSignature'         => true,
        'debugStatus'           => true,
        'debugLevel'            => 'error',
        'loggerPath'            => __DIR__ . '/../tmp/logs/',
        // Cache
        'cachePath'             => __DIR__ . '/../tmp/cache/',
        'cacheTtl'              => 3600,
        'cacheDriver'           => 'files',
        'cacheFileDefaultChmod' => 0777,
        'cacheSecurityKey'      => 'BACKEND-SERVICE',
    ]
];

use tienhm\Backend\Auth\Http\WebServiceAccount;

$inputData = [
    'user' => 'tienhm',
    'password'       => 123456
];

$api = new WebServiceAccount($config['OPTIONS']);
$api->setSdkConfig($config);
$api->setInputData($inputData)
    ->login();

echo "<pre>";
print_r($api->getResponse());
echo "</pre>";