<?php //-->

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
