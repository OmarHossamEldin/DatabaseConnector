# Prerequisites

Before you begin, ensure that you have PHP 8+ and Composer installed on your system.

## Installation

1. require package to your project:

    ```bash
    composer require reneknox/database-connector
    ```

## Code example

```php
<?php

use Reneknox\DatabaseConnector\Database;

require_once __DIR__ . '/vendor/autoload.php';

$database = new Database(
    dbHost: 'databaseServer',
    dbName: 'databaseName',
    username: 'username',
    password: 'password'
);

$database->connect()->query(
    query: "select id,name from example where email=:email",
    params: [
        'email' => 'example@gmail.com'
    ]);

$database->find(); // to fetch one result
$database->get(); // to fetch all result
```