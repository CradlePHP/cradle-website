<?php //-->

use Cradle\Module\Utility\File;

/**
 * Render Profile JS
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/scripts/profile.js', function ($request, $response) {
    $response->addHeader('Content-Type', 'text/javascript');
    $response->setContent(file_get_contents(dirname(__DIR__) . '/profile.js'));
});

/**
 * Render Profile CSS
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/styles/profile.css', function ($request, $response) {
    $response->addHeader('Content-Type', 'text/css');
    $response->setContent(file_get_contents(dirname(__DIR__) . '/profile.css'));
});

/**
 * Render profile update page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/profile/update', function($request, $response) {
    $global = $this->package('global');
    //----------------------------//
    // 2. Render Template
    //set the class name
    $class = 'page-profile-update page-profile';
    //----------------------------//
    // 3. Prepare Data
    //Prepare body
    $data = ['item' => $request->getPost()];

    //determine the title
    $data['title'] = $global->translate('Update Profile');

    // add CDN
    $config = $this->package('global')->service('s3-main');
    $data['cdn_config'] = File::getS3Client($config);

    //add CSRF
    $this->trigger('csrf-load', $request, $response);
    $data['csrf'] = $response->getResults('csrf');

    //If no post
    if (!$request->hasPost('profile_name')) {
        //set default data
        $data['item'] = $request->getSession('me');
    }

    if ($response->isError()) {
        $response->setFlash($response->getMessage(), 'error');
        $data['errors'] = $response->getValidation();
    }

    //if there are file fields
    if (!empty($data['schema']['files'])) {
        //add CDN
        $config = $this->package('global')->service('s3-main');
        $data['cdn_config'] = File::getS3Client($config);
    }

    $template = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('template_root'))) {
        $template = $response->getPage('template_root');
    }

    $partials = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('partials_root'))) {
        $partials = $response->getPage('partials_root');
    }

    //render the body
    $body = $this
        ->package('cradlephp/cradle-website')
        ->template(
            'profile/update',
            $data,
            [
                'profile_fieldset',
                'profile_menu'
            ],
            $template,
            $partials
        );

    //set content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    $this->trigger('www-render-page', $request, $response);
});

/**
 * Render profile account page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/profile/account', function($request, $response) {
    $global = $this->package('global');
    //----------------------------//
    // 2. Render Template
    //set the class name
    $class = 'page-profile-account page-profile';

    //determine the title
    $data['title'] = $global->translate('Update Profile');
    
    // add CDN
    $config = $this->package('global')->service('s3-main');
    $data['cdn_config'] = File::getS3Client($config);

    //add CSRF
    $this->trigger('csrf-load', $request, $response);
    $data['csrf'] = $response->getResults('csrf');

    //If no post
    if (!$request->hasPost('profile_name')) {
        //set default data
        $data['item'] = $request->getSession('me');
    }

    if ($response->isError()) {
        $response->setFlash($response->getMessage(), 'error');
        $data['errors'] = $response->getValidation();
    }

    $template = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('template_root'))) {
        $template = $response->getPage('template_root');
    }

    $partials = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('partials_root'))) {
        $partials = $response->getPage('partials_root');
    }

        //If no post
    if (!$request->hasPost('profile_name')) {
        //set default data
        $data['item'] = $request->getSession('me');
    }

    //render the body
    $body = $this
        ->package('cradlephp/cradle-website')
        ->template(
            'profile/account',
            $data,
            [
                'profile_fieldset',
                'profile_menu'
            ],
            $template,
            $partials
        );

    //set content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    $this->trigger('www-render-page', $request, $response);
});

/**
 * Render profile address page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/profile/address', function($request, $response) {
    $global = $this->package('global');

    $profileId = $request->getSession('me', 'profile_id');

    $request
        ->setStage('schema', 'address')
        ->setStage('profile_id', $profileId);

    $this->trigger('system-model-search', $request, $response);

    $data = $request->getStage();

    if ($response->hasResults()) {
        $data = array_merge($data, $response->getResults());
    }

    //----------------------------//
    // 2. Render Template
    //set the class name
    $class = 'page-profile-address page-profile';

    //determine the title
    $data['title'] = $global->translate('Update Profile');

    $template = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('template_root'))) {
        $template = $response->getPage('template_root');
    }

    $partials = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('partials_root'))) {
        $partials = $response->getPage('partials_root');
    }

    //render the body
    $body = $this
        ->package('cradlephp/cradle-website')
        ->template(
            'profile/address',
            $data,
            'profile_menu',
            $template,
            $partials
        );

    //set content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    $this->trigger('www-render-page', $request, $response);
});

/**
 * Render profile address create page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/profile/address/create', function($request, $response) {
    $global = $this->package('global');

    //----------------------------//
    // 2. Render Template
    //set the class name
    $class = 'page-profile-address-create page-profile';

    //determine the title
    $data['title'] = $global->translate('Update Profile');

    $template = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('template_root'))) {
        $template = $response->getPage('template_root');
    }

    $partials = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('partials_root'))) {
        $partials = $response->getPage('partials_root');
    }

    //render the body
    $body = $this
        ->package('cradlephp/cradle-website')
        ->template(
            'profile/address/create',
            $data,
            [
                'profile_fieldset',
                'profile_menu'
            ],
            $template,
            $partials
        );

    //set content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    $this->trigger('www-render-page', $request, $response);
});

/**
 * Render profile address create page
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/profile/address/update/:address_id', function($request, $response) {
    $global = $this->package('global');

    //----------------------------//
    // 2. Render Template
    //set the class name
    $class = 'page-profile-address-update page-profile';

    //determine the title
    $data['title'] = $global->translate('Update Profile');

    $template = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('template_root'))) {
        $template = $response->getPage('template_root');
    }

    $partials = dirname(__DIR__) . '/template';
    if (is_dir($response->getPage('partials_root'))) {
        $partials = $response->getPage('partials_root');
    }

    //render the body
    $body = $this
        ->package('cradlephp/cradle-website')
        ->template(
            'profile/address/update',
            $data,
            [
                'profile_fieldset',
                'profile_menu'
            ],
            $template,
            $partials
        );

    //set content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //if we only want the body
    if ($request->getStage('render') === 'body') {
        return;
    }

    $this->trigger('www-render-page', $request, $response);
});


/**
 * Process the Account Page
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/profile/account', function ($request, $response) {
    //----------------------------//
    // 1. Setup Overrides
    //determine route
    $route = '/profile/account';
    if ($request->hasStage('route')) {
        $route = $request->getStage('route');
    }

    //determine redirect
    $redirect = '/profile/account';

    //----------------------------//
    // 2. Security Checks
    //need to be online
    $this->package('global')->requireLogin();

    //csrf check
    $this->trigger('csrf-validate', $request, $response);
    if ($response->isError()) {
        return $this->routeTo('get', $route, $request, $response);
    }

    //----------------------------//
    // 3. Prepare Data
    $errors =[];
    $data = ['item' => $request->getPost()];
    if (isset($data['item']['auth_password']) && empty($data['item']['auth_password'])) {
        $errors['auth_password'] = 'Cannot be empty';
    }

    if (isset($data['item']['confirm']) && empty($data['item']['confirm'])) {
        $errors['confirm'] = 'Cannot be empty';
    }

    //confirm
    if ((
        !empty($data['item']['auth_password']) || !empty($data['item']['confirm'])
        )
        && $data['item']['confirm'] !== $data['item']['auth_password']
    ) {
        $errors['confirm'] = 'Passwords do not match';
    }

    if ($errors) {
        $response->setError(true, 'Invalid Parameters');
        $response->set('json', 'validation', $errors);
        return $this->routeTo('get', $route, $request, $response);
    }
    
    //set the auth_id and profile_id
    $request->setStage('auth_id', $request->getSession('me', 'auth_id'));
    $request->setStage('schema', 'auth');
    //----------------------------//
    // 4. Process Request
    //trigger the job
    $this->trigger('system-model-update', $request, $response);

    //----------------------------//
    // 5. Interpret Results
    if ($response->isError()) {
        return $this->routeTo('get', $route, $request, $response);
    }

    //setup a new RnR
    $payload = $this->makePayload();

    //it was good
    //update the session
    $payload['request']->setStage('auth_id', $request->getSession('me', 'auth_id'));
    $payload['request']->setStage('schema', 'auth');
    $this->trigger(
        'system-model-detail', 
        $payload['request'], 
        $payload['response']
    );

    //update session me
    $request->setSession('me', $payload['response']->getResults());

    //if we dont want to redirect
    if ($redirect === 'false') {
        return;
    }

    //add a flash
    $message = $this->package('global')->translate('Update Successful');
    $this->package('global')->flash($message, 'success');

    $this->package('global')->redirect($redirect);
});

/**
 * Process the Profile Update Page
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/profile/update', function ($request, $response) {
    //----------------------------//
    // 1. Setup Overrides
    //determine route
    $route = '/profile/update';
    if ($request->hasStage('route')) {
        $route = $request->getStage('route');
    }

    //determine redirect
    $redirect = '/profile/update';

    //----------------------------//
    // 2. Security Checks
    //need to be online
    $this->package('global')->requireLogin();

    //csrf check
    $this->trigger('csrf-validate', $request, $response);
    if ($response->isError()) {
        return $this->routeTo('get', $route, $request, $response);
    }

    //----------------------------//
    // 3. Prepare Data
    //set the auth_id and profile_id
    $request->setStage('profile_id', $request->getSession('me', 'profile_id'));
    $request->setStage('schema', 'profile');

    //----------------------------//
    // 4. Process Request
    //trigger the job
    $this->trigger('system-model-update', $request, $response);cradle()->inspect($response);exit;
    //----------------------------//
    // 5. Interpret Results
    if ($response->isError()) {
        return $this->routeTo('get', $route, $request, $response);
    }

    //setup a new RnR
    $payload = $this->makePayload();

    //it was good
    //update the session
    $payload['request']->setStage('auth_id', $request->getSession('me', 'auth_id'));
    $payload['request']->setStage('schema', 'auth');
    $this->trigger(
        'system-model-detail', 
        $payload['request'], 
        $payload['response']
    );
    //update session me
    $request->setSession('me', $payload['response']->getResults());

    //if we dont want to redirect
    if ($redirect === 'false') {
        return;
    }

    //add a flash
    $message = $this->package('global')->translate('Update Successful');
    $this->package('global')->flash($message, 'success');

    $this->package('global')->redirect($redirect);
});