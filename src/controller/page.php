<?php //-->

/**
 * Render Page Create Page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/system/model/page/create', function ($request, $response) {
    if (!$response->hasPage('template_root')) {
        $response->setPage('template_root', dirname(__DIR__) . '/template');
    }
}, 10);

/**
 * Render Page Update Page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/admin/system/model/page/update/:page_id', function ($request, $response) {
    if (!$response->hasPage('template_root')) {
        $response->setPage('template_root', dirname(__DIR__) . '/template');
    }
}, 10);
