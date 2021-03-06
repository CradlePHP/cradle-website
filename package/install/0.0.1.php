<?php //-->

use Cradle\Package\System\Schema;

cradle(function() {
    //setup result counters
    $logs = [];
    $processed = [];

    //scan through each file
    foreach (scandir(__DIR__ . '/../schema') as $file) {
        //if it's not a php file
        if (substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/../schema/%s', __DIR__, $file);

        //if no name
        if (!isset($data['name'])) {
            //skip
            continue;
        }

        //setup a new RnR
        $payload = $this->makePayload();

        //set the data
        $payload['request']->setStage($data);

        //----------------------------//
        // 1. Prepare Data
        //if detail has no value make it null
        if ($payload['request']->hasStage('detail')
            && !$payload['request']->getStage('detail')
        ) {
            $payload['request']->setStage('detail', null);
        }

        //if fields has no value make it an array
        if ($payload['request']->hasStage('fields')
            && !$payload['request']->getStage('fields')
        ) {
            $payload['request']->setStage('fields', []);
        }

        //if validation has no value make it an array
        if ($payload['request']->hasStage('validation')
            && !$payload['request']->getStage('validation')
        ) {
            $payload['request']->setStage('validation', []);
        }

        $logs[] = [
            'type' => 'info',
            'message' => sprintf('Creating %s schema', $data['name'])
        ];

        //----------------------------//
        // 2. Process Request
        $event = 'system-schema-create';
        if ($data['name'] === 'profile' || $data['name'] === 'auth') {
            $event = 'system-schema-update';
        }

        //now trigger
        $this->trigger($event, $payload['request'], $payload['response']);

        //----------------------------//
        // 3. Interpret Results
        //if the event does not have an error
        if (!$payload['response']->isError()) {
            $processed[] = $data['name'];
            continue;
        }

        $errors = $payload['response']->getValidation();
        foreach($errors as $key => $message) {
            if ($message !== 'Schema already exists') {
                $message = sprintf('Schema %s already exists', $data['name']);
            }

            $logs[] = ['type' => 'error', 'message' => $message];
        }

        if ($this->getRequest()->hasStage('skip-sql')) {
            $this->getResponse()->setError(true);
            continue;
        }

        $logs[] = [
            'type' => 'info',
            'message' => sprintf('Creating %s table in SQL', $data['name'])
        ];

        $exists = Schema::i($data['name'])
            ->service('sql')
            ->getResource()
            ->getTables($data['name']);

        if ($exists) {
            if ($event === 'system-schema-create') {
                $logs[] = [
                    'type' => 'error',
                    'message' => sprintf('Table %s already exists in SQL', $data['name'])
                ];
            } else {
                Schema::i($data['name'])->service('sql')->update();
            }

            continue;
        }

        Schema::i($data['name'])->service('sql')->create();
    }

    $response = $this->getResponse();
    $schemas = $response->getResults('schemas');

    if (!is_array($schemas)) {
        $schemas = [];
    }

    $schemas = array_merge($schemas, $processed);

    $response
        ->setResults('logs', 'cradlephp/cradle-website', '0.0.1', $logs)
        ->setResults('schemas', $schemas);
});
