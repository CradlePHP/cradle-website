<?php //-->
require_once __DIR__ . '/package/events.php';
require_once __DIR__ . '/src/events.php';
require_once __DIR__ . '/src/controller/page.php';
require_once __DIR__ . '/src/controller/post.php';
require_once __DIR__ . '/src/controller/profile.php';

$this
    ->preprocess(include __DIR__ . '/src/bootstrap/template.php')
    ->preprocess(include __DIR__ . '/src/bootstrap/block.php')
    ->preprocess(include __DIR__ . '/src/bootstrap/page.php');
