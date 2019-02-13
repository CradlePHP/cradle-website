<?php //-->

return function($request, $response) {
    //prevent starting session in cli mode
    if (php_sapi_name() === 'cli') {
        return;
    }

    //get all the pages
    $payload = $this->makePayload(false);
    $payload['request']->setStage('schema', 'block');
    $blocks = $this->method('system-model-search', $payload['request']);

    if (!isset($blocks['rows'])) {
        return;
    }

    //get global handlebars
    $handlebars = $this->package('global')->handlebars();
    //create helper
    $handlebars->registerHelper('block', function($keyword) {
        $cradle = cradle();
        $global = $cradle->package('global');
        $payload = $cradle->makePayload(false);
        $payload['request']
            ->setStage('schema', 'block')
            ->setStage('block_keyword', $keyword);

        $block = $cradle->method('system-model-detail', $payload['request']);

        if (!$block) {
            //no errors on production
            if ($global->config('settings', 'environment') === 'production') {
                return '';
            }

            return sprintf(
                '<div class="alert alert-danger">Block %s not found</div>',
                $keyword
            );
        }

        $payload = $cradle->makePayload();
        if (trim($block['block_event'])) {
            if ($block['block_parameters']) {
                $payload['request']->setStage($block['block_parameters']);
            }

            $cradle->trigger(
                $block['block_event'],
                $payload['request'],
                $payload['response']
            );
        }

        $data = [];
        if ($payload['request']->hasStage()) {
            $data = array_merge($data, $payload['request']->getStage());
        }

        if ($payload['response']->hasResults()) {
            $data = array_merge($data, $payload['response']->getResults());
        }

        $handlebars = $global->handlebars();
        return $handlebars->compile($block['block_template'])($data);
    });
};
