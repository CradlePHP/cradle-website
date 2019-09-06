<?php //-->
/**
 * This file is part of a Custom Package.
 */

use Cradle\Storm\SqlFactory;

use Cradle\Package\System\Schema;
use Cradle\Package\System\Exception;

use Cradle\Http\Request;
use Cradle\Http\Response;

/**
 * $ cradle package install cradlephp/cradle-website
 * $ cradle package install cradlephp/cradle-website 1.0.0
 * $ cradle cradlephp/cradle-website install
 * $ cradle cradlephp/cradle-website install 1.0.0
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-install', function ($request, $response) {
    //custom name of this package
    $name = 'cradlephp/cradle-website';

    //get the current version
    $current = $this->package('global')->config('packages', $name);

    // if version is set
    if (is_array($current) && isset($current['version'])) {
        // get the current version
        $current = $current['version'];
    } else {
        $current = null;
    }

    //if it's already installed
    if ($current) {
        $message = sprintf('%s is already installed', $name);
        return $response->setError(true, $message);
    }

    // install package
    $version = $this->package('cradlephp/cradle-website')->install('0.0.0');

    // update the config
    $this->package('global')->config('packages', $name, [
        'version' => $version,
        'active' => true
    ]);

    $response->setResults('version', $version);
});

/**
 * $ cradle package update cradlephp/cradle-website
 * $ cradle package update cradlephp/cradle-website 1.0.0
 * $ cradle cradlephp/cradle-website update
 * $ cradle cradlephp/cradle-website update 1.0.0
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-update', function ($request, $response) {
    //custom name of this package
    $name = 'cradlephp/cradle-website';

    //get the current version
    $current = $this->package('global')->config('packages', $name);

    // if version is set
    if (is_array($current) && isset($current['version'])) {
        // get the current version
        $current = $current['version'];
    } else {
        $current = null;
    }

    //if it's not installed
    if (!$current) {
        $message = sprintf('%s is not installed', $name);
        return $response->setError(true, $message);
    }

    // get available version
    $version = $this->package($name)->version();

    //if available < current
    if (version_compare($version, $current, '<')) {
        $message = sprintf('%s < %s', $version, $current);
        $response->setResults('logs', 'cradlephp/cradle-website', $version, [
            [
                'type' => 'error',
                'message' => $message
            ]
        ]);

        return $response->setError(true, $message);
    //if available = current
    } else if (version_compare($version, $current, '=')) {
        $message = sprintf('%s = %s', $version, $current);
        $response->setResults('logs', 'cradlephp/cradle-website', $version, [
            [
                'type' => 'error',
                'message' => $message
            ]
        ]);

        return;
    }

    // update package
    $version = $this->package('cradlephp/cradle-website')->install($current);

    // update the config
    $this->package('global')->config('packages', $name, [
        'version' => $version,
        'active' => true
    ]);

    $response->setResults('version', $version);
});

/**
 * $ cradle package remove cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website remove
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-remove', function ($request, $response) {
    //custom name of this package
    $name = 'cradlephp/cradle-website';

    // if it's not installed
    if (!$this->package('global')->config('packages', $name)) {
        $message = sprintf('%s is not installed', $name);
        return $response->setError(true, $message);
    }

    //setup result counters
    $errors = [];

    // processed data
    $processed = [];

    //scan through each file
    foreach (scandir(__DIR__ . '/schema') as $file) {
        //if it's not a php file
        if(substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/schema/%s', __DIR__, $file);

        //if no name
        if (!isset($data['name'])
            || $data['name'] === 'profile'
            || $data['name'] === 'auth'
        ) {
            //skip
            continue;
        }

        //----------------------------//
        // 1. Prepare Data
        $request->setStage('schema', $data['name']);

        //----------------------------//
        // 2. Process Request
        $this->trigger('system-schema-remove', $request, $response);

        //----------------------------//
        // 3. Interpret Results
        if ($response->isError()) {
            //collect all the errors
            $errors[$data['name']] = $response->getMessage();
            continue;
        }

        $processed[] = $data['name'];
    }

    if (!empty($errors)) {
        $response->set('json', 'validation', $errors);
    }

    // get package config
    $packages = $this->package('global')->config('packages');

    // remove package from config
    if (isset($packages[$name])) {
        unset($packages[$name]);
    }

    // update package config
    $this->package('global')->config('packages', $packages);

    $response->setResults('schemas', $processed);
});

/**
 * $ cradle elastic flush cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website elastic-flush
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-elastic-flush', function ($request, $response) {
    $processed = $errors = [];
    //scan through each file
    foreach (scandir(__DIR__ . '/schema') as $file) {
        //if it's not a php file
        if(substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/schema/%s', __DIR__, $file);

        // if name is not set
        if (!isset($data['name'])
            || $data['name'] === 'profile'
            || $data['name'] === 'auth'
        ) {
            // skip
            continue;
        }

        // set parameters
        $request->setStage('name', $data['name']);
        // trigger global schema flush
        $this->trigger('system-schema-flush-elastic', $request, $response);
        // intercept error
        if ($response->isError()) {
            //collect all the errors
            $errors[$data['name']] = $response->getMessage();
            continue;
        }


        $processed[] = $data['name'];
    }

    if (!empty($errors)) {
        $response->set('json', 'validation', $errors);
    }

    // set response
    $response->setResults('schema', $processed);
});

/**
 * $ cradle elastic map cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website elastic-map
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-elastic-map', function ($request, $response) {
    $processed = $errors = [];
    //scan through each file
    foreach (scandir(__DIR__ . '/schema') as $file) {
        //if it's not a php file
        if(substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/schema/%s', __DIR__, $file);
        // if name is not set
        if (!isset($data['name'])
            || $data['name'] === 'profile'
            || $data['name'] === 'auth'
        ) {
            // skip
            continue;
        }

        // set parameters
        $request->setStage('name', $data['name']);
        // trigger global schema flush
        $this->trigger('system-schema-map-elastic', $request, $response);

        // intercept error
        if ($response->isError()) {
            //collect all the errors
            $errors[$data['name']] = $response->getMessage();
            continue;
        }

        $processed[] = $data['name'];
    }

    // set response error
    if (!empty ($errors)) {
        $response->set('json', 'validation', $errors);
    }

    $response->setResults('schema', $processed);
});

/**
 * $ cradle elastic populate cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website elastic-populate
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-elastic-populate', function ($request, $response) {
    $processed = $errors = [];
    //scan through each file
    foreach (scandir(__DIR__ . '/schema') as $file) {
        //if it's not a php file
        if(substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/schema/%s', __DIR__, $file);
        // if name is not set
        if (!isset($data['name'])
            || $data['name'] === 'profile'
            || $data['name'] === 'auth'
        ) {
            // skip
            continue;
        }

        // set parameters
        $request->setStage('name', $data['name']);
        // trigger global schema flush
        $this->trigger('system-schema-populate-elastic', $request, $response);
        // intercept error
        if ($response->isError()) {
            $errors[$data['name']] = $response->getMessage();
            continue;
        }

        $processed[] = $data['name'];

    }

    // set response error
    if (!empty($errors)) {
        $response->set('json', 'validation', $errors);
    }

    // set response
    $response->setResults('schema', 'website');
});

/**
 * $ cradle redis flush cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website redis-flush
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-redis-flush', function ($request, $response) {

});

/**
 * $ cradle redis populate cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website redis-populate
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-redis-populate', function ($request, $response) {

});

/**
 * $ cradle sql build cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website sql-build
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-sql-build', function ($request, $response) {
    //load up the database
    $pdo = $this->package('global')->service('sql-main');
    $database = SqlFactory::load($pdo);

    //setup result counters
    $errors = [];
    $processed = [];

    //scan through each file
    foreach (scandir(__DIR__ . '/schema') as $file) {
        //if it's not a php file
        if(substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/schema/%s', __DIR__, $file);

        //if no name
        if (!isset($data['name'])) {
            //skip
            continue;
        }

        try {
            $schema = Schema::i($data['name']);
        } catch(Exception $e) {
            continue;
        }

        //remove primary table
        $database->query(sprintf('DROP TABLE IF EXISTS `%s`', $schema->getName()));

        //loop through relations
        foreach ($schema->getRelations() as $table => $relation) {
            //remove relation table
            $database->query(sprintf('DROP TABLE IF EXISTS `%s`', $table));
        }

        //now build it back up
        //set the data
        $request->setStage($schema->get());

        //----------------------------//
        // 1. Prepare Data
        //if detail has no value make it null
        if ($request->hasStage('detail')
            && !$request->getStage('detail')
        ) {
            $request->setStage('detail', null);
        }

        //if fields has no value make it an array
        if ($request->hasStage('fields')
            && !$request->getStage('fields')
        ) {
            $request->setStage('fields', []);
        }

        //if validation has no value make it an array
        if ($request->hasStage('validation')
            && !$request->getStage('validation')
        ) {
            $request->setStage('validation', []);
        }

        //----------------------------//
        // 2. Process Request
        //now trigger
        $this->trigger('system-schema-update', $request, $response);

        //----------------------------//
        // 3. Interpret Results
        //if the event returned an error
        if ($response->isError()) {
            //collect all the errors
            $errors[$data['name']] = $response->getValidation();
            continue;
        }

        $processed[] = $data['name'];
    }

    if (!empty($errors)) {
        $response->set('json', 'validation', $errors);
    }

    $response->setResults(['schemas' => $processed]);
});

/**
 * $ cradle sql flush cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website sql-flush
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-sql-flush', function ($request, $response) {
    //load up the database
    $pdo = $this->package('global')->service('sql-main');
    $database = SqlFactory::load($pdo);

    //setup result counters
    $errors = [];
    $processed = [];

    //scan through each file
    foreach (scandir(__DIR__ . '/schema') as $file) {
        //if it's not a php file
        if(substr($file, -4) !== '.php') {
            //skip
            continue;
        }

        //get the schema data
        $data = include sprintf('%s/schema/%s', __DIR__, $file);

        //if no name
        if (!isset($data['name'])) {
            //skip
            continue;
        }

        try {
            $schema = Schema::i($data['name']);
        } catch(Exception $e) {
            continue;
        }

        //remove primary table
        $database->query(sprintf('TRUNCATE `%s`', $schema->getName()));

        //loop through relations
        foreach ($schema->getRelations() as $table => $relation) {
            //remove relation table
            $database->query(sprintf('TRUNCATE `%s`', $table));
        }

        $processed[] = $data['name'];
    }

    $response->setResults('schemas', $processed);
});

/**
 * $ cradle sql populate cradlephp/cradle-website
 * $ cradle cradlephp/cradle-website sql-populate
 *
 * @param Request $request
 * @param Response $response
 */
$this->on('cradlephp-cradle-website-sql-populate', function ($request, $response) {
  //load up the database
  $pdo = $this->package('global')->service('sql-main');
  //Storm ORM
  $database = SqlFactory::load($pdo);

  //setting up combining variables
  $combineFlag = 0;
  $combinedQuery = "";

  //Going through each file in fixtures
  foreach (scandir(__DIR__ . '/fixtures') as $file) {
    //if it's not an sql file
    if(substr($file, -4) !== '.sql') {
        //skip
        continue;
    }
    //put all lines of the file into an array
    $sql = file(sprintf('%s/fixtures/%s', __DIR__, $file), FILE_IGNORE_NEW_LINES);

    //to check for the final iteration for the array
    $len = count($sql);

    //working on every line that was read. i is used as a key. query is used as the value
    foreach($sql as $i=>$query) {
      //skips everything that is either empty or contains a comment
      if ($query == "" || preg_match_all("/(^--.*)/m", $query)) {
        $combineFlag = 0;
        //if combinedQuery is not empty, work on it. Empty after. If it is, don't work on it.
        if ($combinedQuery != ""){
          //combinedQuery is not empty means that it just finished combining.
          try {
            $test = $database->query($combinedQuery);
          } catch (\Exception $e){
            continue;
          }

          $combinedQuery = "";
        }
        continue;
      } else if ($query != "" && $combineFlag == 1) {
        $combinedQuery = $combinedQuery . " " . $query;
        if ($i == $len - 1){
          //last combinedQuery in the file gets worked on here. This is the very last line if it's combined.
          try {
            $test = $database->query($combinedQuery);
          } catch (\Exception $e){
            continue;
          }
        }
        continue;
      }

      if (preg_match_all("/(.*);/m", $query)) {
        if ($combineFlag == 1){ //it's the end of the query since we see ; Time to execute
          try {
           $test = $database->query($combinedQuery);
           $combineFlag = 0;
         } catch (\Exception $e){
           continue;
         }
       } else { //It's already complete even without the combine.
          try {
           $test = $database->query($query);
         } catch (\Exception $e){
           continue;
         }
       }
     } else { //we have to combine since we don't see a ;
       $combineFlag = 1; //becomes true to combine
       $combinedQuery = $query; //make it the start
       continue;
     }

    }
    //reset values for the next
    $combineFlag = 0;
    $combinedQuery = "";
  }
});
