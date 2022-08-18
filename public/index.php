<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

$_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
