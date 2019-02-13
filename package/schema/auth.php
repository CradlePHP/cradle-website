<?php //-->
return array (
  'singular' => 'Authentication',
  'plural' => 'Authentications',
  'name' => 'auth',
  'group' => 'Users',
  'icon' => 'fas fa-lock',
  'detail' => 'Collection of verified users.',
  'fields' => 
  array (
    0 => 
    array (
      'label' => 'Email',
      'name' => 'slug',
      'field' => 
      array (
        'type' => 'text',
        'attributes' => 
        array (
          'placeholder' => 'Enter email',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Email is Required',
        ),
        1 => 
        array (
          'method' => 'regexp',
          'parameters' => '/^(?:(?:(?:[^@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff\\.]|\\x5c(?=[@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff]))(?:[^@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff\\.]|(?<=\\x5c)[@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff]|\\x5c(?=[@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff])|\\.(?=[^\\.])){1,62}(?:[^@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff\\.]|(?<=\\x5c)[@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff])|[^@,"\\[\\]\\x5c\\x00-\\x20\\x7f-\\xff\\.]{1,2})|"(?:[^"]|(?<=\\x5c)"){1,62}")@(?:(?!.{64})(?:[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\\.?|[a-zA-Z0-9]\\.?)+\\.(?:xn--[a-zA-Z0-9]+|[a-zA-Z]{2,6})|\\[(?:[0-1]?\\d?\\d|2[0-4]\\d|25[0-5])(?:\\.(?:[0-1]?\\d?\\d|2[0-4]\\d|25[0-5])){3}\\])$/',
          'message' => 'Must be a valid email',
        ),
        2 => 
        array (
          'method' => 'unique',
          'message' => 'Email is already taken',
        ),
      ),
      'list' => 
      array (
        'format' => 'none',
      ),
      'detail' => 
      array (
        'format' => 'none',
      ),
      'default' => '',
      'searchable' => '1',
      'filterable' => '1',
      'disable' => '1',
    ),
    1 => 
    array (
      'label' => 'Phone',
      'name' => 'phone',
      'field' => 
      array (
        'type' => 'text',
        'attributes' => 
        array (
          'placeholder' => 'eg. +1 (999) 999-9999',
        ),
      ),
      'list' => 
      array (
        'format' => 'phone',
        'parameters' => '{{auth_phone}}',
      ),
      'detail' => 
      array (
        'format' => 'phone',
        'parameters' => '{{auth_phone}}',
      ),
      'default' => '',
    ),
    2 => 
    array (
      'label' => 'Password',
      'name' => 'password',
      'field' => 
      array (
        'type' => 'password',
        'attributes' => 
        array (
          'placeholder' => 'Enter a password',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Password is Required',
        ),
      ),
      'list' => 
      array (
        'format' => 'hide',
      ),
      'detail' => 
      array (
        'format' => 'hide',
      ),
      'default' => '',
      'filterable' => '1',
      'sortable' => '1',
      'disable' => '1',
    ),
    3 => 
    array (
      'label' => 'Newsletters',
      'name' => 'newsletters',
      'field' => 
      array (
        'type' => 'checkbox',
        'attributes' => 
        array (
          'placeholder' => 'Receive newsletters',
        ),
      ),
      'list' => 
      array (
        'format' => 'yes',
      ),
      'detail' => 
      array (
        'format' => 'yes',
      ),
      'default' => '1',
      'filterable' => '1',
    ),
    4 => 
    array (
      'label' => 'Promotions',
      'name' => 'promotions',
      'field' => 
      array (
        'type' => 'checkbox',
        'attributes' => 
        array (
          'placeholder' => 'Receive promotions',
        ),
      ),
      'list' => 
      array (
        'format' => 'yes',
      ),
      'detail' => 
      array (
        'format' => 'yes',
      ),
      'default' => '1',
      'filterable' => '1',
    ),
    5 => 
    array (
      'label' => 'Notifications',
      'name' => 'notifications',
      'field' => 
      array (
        'type' => 'checkbox',
        'attributes' => 
        array (
          'placeholder' => 'Receive general updates and notifications',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'one',
          'parameters' => 
          array (
            0 => '0',
            1 => '1',
          ),
          'message' => 'Should be 0 or 1',
        ),
      ),
      'list' => 
      array (
        'format' => 'yes',
      ),
      'detail' => 
      array (
        'format' => 'yes',
      ),
      'default' => '1',
      'filterable' => '1',
    ),
    6 => 
    array (
      'label' => 'Type',
      'name' => 'type',
      'field' => 
      array (
        'type' => 'text',
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'one',
          'parameters' => 
          array (
            0 => '0',
            1 => '1',
          ),
          'message' => 'Should be 0 or 1',
        ),
      ),
      'list' => 
      array (
        'format' => 'none',
      ),
      'detail' => 
      array (
        'format' => 'none',
      ),
      'default' => '',
      'filterable' => '1',
      'sortable' => '1',
      'disable' => '1',
    ),
    7 => 
    array (
      'label' => 'Active',
      'name' => 'active',
      'field' => 
      array (
        'type' => 'active',
      ),
      'list' => 
      array (
        'format' => 'hide',
      ),
      'detail' => 
      array (
        'format' => 'hide',
      ),
      'default' => '1',
      'sortable' => '1',
      'disable' => '1',
    ),
    8 => 
    array (
      'label' => 'Created',
      'name' => 'created',
      'field' => 
      array (
        'type' => 'created',
      ),
      'list' => 
      array (
        'format' => 'none',
      ),
      'detail' => 
      array (
        'format' => 'none',
      ),
      'default' => 'NOW()',
      'sortable' => '1',
      'disable' => '1',
    ),
    9 => 
    array (
      'label' => 'Updated',
      'name' => 'updated',
      'field' => 
      array (
        'type' => 'updated',
      ),
      'list' => 
      array (
        'format' => 'none',
      ),
      'detail' => 
      array (
        'format' => 'none',
      ),
      'default' => 'NOW()',
      'sortable' => '1',
      'disable' => '1',
    ),
  ),
  'relations' => 
  array (
    0 => 
    array (
      'many' => '1',
      'name' => 'profile',
    ),
  ),
  'suggestion' => '{{auth_slug}}',
  'disable' => '1',
);