<?php

if (getenv('RENDER') === 'true') {

    // Running on Render → use Aiven
    require_once __DIR__ . '/database.production.php';

} else {

    // Running locally → use local MySQL
    require_once __DIR__ . '/database.local.php';

}