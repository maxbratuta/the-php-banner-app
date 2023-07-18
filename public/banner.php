<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DTO\Visitor;
use App\Infrastructure\Database;
use App\Models\Banner;

try {
    $database = Database::createFromConfigFile(__DIR__ . '/../config/database.json');
    $visitor = Visitor::createFromGlobals();

    (new Banner($database))->trackVisit($visitor);
} catch (Throwable $e) {
    error_log($e->getMessage() . PHP_EOL . $e->getTraceAsString());
}

$imageFile = __DIR__ . '/../assets/images/banner.png';

header('Content-Type: image/png');
header('Content-Length: ' . filesize($imageFile));
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

readfile($imageFile);