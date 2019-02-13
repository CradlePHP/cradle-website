<?php //-->

use Cradle\Package\System\Schema;

return function($request, $response) {
    //prevent starting session in cli mode
    if (php_sapi_name() === 'cli') {
        return;
    }

    //----------------------------//
    // 1. Load all the Pages
    //create another request payload
    $payload = $this->makePayload(false);
    //set schema and filter
    $payload['request']->setStage('schema', 'page');

    //get page based on path
    $pages = $this->method('system-model-search', $payload['request']);

    foreach ($pages['rows'] as $page) {
        $route = '/' . trim($page['page_path']);

        //----------------------------//
        // 2. Set SEO Meta Data
        //make sure this is the first route
        $this->get($route, function($request, $response) use ($page) {
            $response->setPage('title', $page['page_title']);

            if ($page['page_summary']) {
                $response->addMeta('description', $page['page_summary']);
            }

            if (!empty($page['page_tags'])) {
                $response->addMeta('keywords', implode(',', $page['page_tags']));
            }

            if ($page['page_image']) {
                $response->addMeta('image', $page['page_image']);
            }
        }, 100);

        //----------------------------//
        // 3. Load the Page Content
        //make sure this is the last route
        $this->get($route, function($request, $response) use ($page) {
            //if there is already content
            if ($response->hasContent()) {
                //do nothing else
                return;
            }

            //trigger page event
            if (trim($page['page_event'])) {
                //make a payload
                $payload = $this->makePayload();
                if ($page['page_parameters']) {
                    $payload['request']->setStage($page['page_parameters']);
                }

                $this->trigger(
                    $page['page_event'],
                    $payload['request'],
                    $payload['response']
                );

                if ($payload['response']->isError()) {
                    $response->setFlash($payload['response']->getMessage(), 'error');
                    $page['errors'] = $payload['response']->getValidation();
                }

                if ($payload['response']->hasResults()) {
                    $page['results'] = $payload['response']->getResults();
                }
            }

            $handlebars = $this->package('global')->handlebars();

            //if there's a template
            if (trim($page['page_template'])) {
                //prepare page content
                $data = ['page' => $page];

                if ($request->hasStage()) {
                    $data = array_merge($data, $request->getStage());
                }

                if ($response->hasResults()) {
                    $data = array_merge($data, $response->getResults());
                }

                if (trim($page['page_content_type'])) {
                    $response->addHeader('Content-Type', $page['page_content_type']);
                }

                //set page body
                $template = $handlebars->compile($page['page_template']);
                $response->setContent($template($data));
            }

            if (!trim($page['page_layout'])) {
                return;
            }

            $this->trigger($page['page_layout'] . '-render-page', $request, $response);
        }, -100);
    }
};
