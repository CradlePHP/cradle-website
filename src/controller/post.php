<?php //-->

/**
 * Sets up the data amd SEO for a post detail
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/post/detail/:post_slug', function($request, $response) use (&$global) {
    //firgure out the redirect
    $global = $this->package('global');
    $redirect = $global->config('settings', 'home');
    if ($request->hasStage('redirect_uri')) {
        $redirect = $request->getStage('redirect_uri');
    }

    //setup the data needed for getting the post
    $payload = $this->makePayload();
    $payload['request']->setStage('schema', 'post');

    //get the post
    $this->trigger(
        'system-model-detail',
        $payload['request'],
        $payload['response']
    );

    //if there's an error, redirect
    if ($payload['response']->isError()) {
        $global->flash($payload['response']->getMessage(), 'error');
        return $global->redirect($redirect);
    }

    //get the sub results
    $results = $payload['response']->getResults();

    //if the post is not approved
    if ($results['post_status'] !== 'approved') {
        //redirect out
        $global->flash('Post is still in draft.', 'error');
        return $global->redirect($redirect);
    }

    //if the post is not published yet
    if (!$results['post_published']
        || time() < strtotime($results['post_published'])
    ) {
        //redirect out
        $global->flash('Post is not published yet.', 'error');
        return $global->redirect($redirect);
    }

    //set the results to the global response
    $response->setResults('post', $results);

    //Soft set the SEO
    $response
        ->setPage('title', $results['post_title'])
        ->setPage('class', 'page-post');

    if ($results['post_summary']) {
        $response->addMeta('description', $results['post_summary']);
    }

    if (!empty($results['post_tags'])) {
        $response->addMeta('keywords', implode(',', $results['post_tags']));
    }

    if ($results['post_banner']) {
        $response->addMeta('image', $results['post_banner']);
    }

    //the page object should handle the rest
});

/**
 * Sets up the data amd SEO for a post category detail
 *
 * @param Request $request
 * @param Response $response
 */
$this->get('/post/category/:category_slug', function($request, $response) use (&$global) {
    //firgure out the redirect
    $global = $this->package('global');
    $redirect = $global->config('settings', 'home');
    if ($request->hasStage('redirect_uri')) {
        $redirect = $request->getStage('redirect_uri');
    }

    //setup the data needed for getting the post
    $payload = $this->makePayload();
    $payload['request']->setStage('schema', 'category');

    //get the post
    $this->trigger(
        'system-model-detail',
        $payload['request'],
        $payload['response']
    );

    //if there's an error, redirect
    if ($payload['response']->isError()) {
        $global->flash($payload['response']->getMessage(), 'error');
        return $global->redirect($redirect);
    }

    //get the sub results
    $results = $payload['response']->getResults();

    $response->setPage('title', $results['category_title']);

    if ($results['category_summary']) {
        $response->addMeta('description', $results['category_summary']);
    }

    if (!empty($results['category_tags'])) {
        $response->addMeta('keywords', implode(',', $results['category_tags']));
    }

    if ($results['category_banner']) {
        $response->addMeta('image', $results['category_banner']);
    }

    //the page object should handle the rest
});

/**
 * Process Add Comment
 *
 * @param Request $request
 * @param Response $response
 */
$this->post('/post/detail/:post_slug', function($request, $response) {
    //get the slug
    $postSlug = $request->getStage('post_slug');
    //setup the routing path
    $route = sprintf('/post/detail/%s', $postSlug);

    //make sure this is a valid post
    $request->setStage('schema', 'post');
    $this->trigger('system-model-detail', $request, $response);

    //if there's an error
    if ($response->isError()) {
        $response->setError(true, $response->getMessage());
        return $this->routeTo('get', $route, $request, $response);
    }

    //get the post id
    $postId = $response->getResults('post_id');

    //get the session profile id
    $profileId = $request->getSession('me', 'profile_id');

    if (!$profileId) {
        if (!$request->hasPost('profile_name')) {
            $response->setError(true, 'Must be logged in to comment.');
            // go back to GET /article/:article_id route
            return $this->routeTo('get', $route, $request, $response);
        }

        $payload = $this->makePayload();
        $payload['request']->setStage('schema', 'profile');

        $profile = $this->method(
            'system-model-create',
            $payload['request'],
            $payload['response']
        );

        if ($payload['response']->isError()) {
            $response->setError(true, $payload['response']->getMessage());
            return $this->routeTo('get', $route, $request, $response);
        }

        $profileId = $profile['profile_id'];
    }

    //create the comment
    $request
        ->setStage('schema', 'comment')
        ->setStage('profile_id', $profileId);

    $this->trigger('system-model-create', $request, $response);

    //if there was an error creating the comment
    if ($response->isError()) {
        // go back to GET /article/:article_id route
        return $this->routeTo('get', $route, $request, $response);
    }

    //get the comment id
    $commentId = $response->getResults('comment_id');

    //link the article to the comment
    $request
        ->setStage('schema1', 'post')
        ->setStage('schema2', 'comment')
        ->setStage('post_id', $postId)
        ->setStage('comment_id', $commentId);

    $this->trigger('system-relation-link', $request, $response);

    //if there was an error linking the article to the comment
    if ($response->isError()) {
        // go back to GET /article/:article_id route
        return $this->routeTo('get', $route, $request, $response);
    }

    //it was good
    //get the global package
    $global = $this->package('global');
    //add a happy message
    $global->flash('Comment Added', 'success');
    //redirect to /article/:article_id
    $global->redirect($route);
});
