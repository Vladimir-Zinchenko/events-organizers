<?php

$dbHost = getenv('MYSQL_HOST');
$dbName = getenv('MYSQL_DATABASE');
$dbUser = getenv('MYSQL_USER');
$dbPassword = getenv('MYSQL_PASSWORD');

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=' . $dbHost . ';dbname=' . $dbName,
    'username' => $dbUser,
    'password' => $dbPassword,
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
