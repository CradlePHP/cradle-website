<?php //-->
return array (
  'singular' => 'Page',
  'plural' => 'Pages',
  'name' => 'page',
  'group' => 'Website',
  'icon' => 'fas fa-newspaper',
  'detail' => 'Manages general pages for the website',
  'fields' => 
  array (
    0 => 
    array (
      'label' => 'Image',
      'name' => 'image',
      'field' => 
      array (
        'type' => 'image',
      ),
      'list' => 
      array (
        'format' => 'image',
        'parameters' => 
        array (
          0 => '0',
          1 => '50',
        ),
      ),
      'detail' => 
      array (
        'format' => 'image',
        'parameters' => 
        array (
          0 => '100%',
          1 => '0',
        ),
      ),
      'default' => '',
    ),
    1 => 
    array (
      'label' => 'Title',
      'name' => 'title',
      'field' => 
      array (
        'type' => 'text',
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Title is required',
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
    ),
    2 => 
    array (
      'label' => 'Path',
      'name' => 'path',
      'field' => 
      array (
        'type' => 'slug',
        'attributes' => 
        array (
          'data-source' => 'input[name=page_title]',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'unique',
          'message' => 'Should be unique',
        ),
        1 => 
        array (
          'method' => 'regexp',
          'parameters' => '#^((/)|(admin/)|(rest/)|(dev/)||(dialog/))#is',
          'message' => 'Cannot use a reserved starting path',
        ),
      ),
      'list' => 
      array (
        'format' => 'custom',
        'parameters' => '<a href="/{{page_path}}" target="_blank">{{page_path}}</a>',
      ),
      'detail' => 
      array (
        'format' => 'custom',
        'parameters' => '<a href="/{{page_path}}" target="_blank">{{page_path}}</a>',
      ),
      'default' => '',
      'sortable' => '1',
    ),
    3 => 
    array (
      'label' => 'Summary',
      'name' => 'summary',
      'field' => 
      array (
        'type' => 'textarea',
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Summary is required',
        ),
        1 => 
        array (
          'method' => 'char_lte',
          'parameters' => '160',
          'message' => 'Should be less than 160 characters',
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
    ),
    4 => 
    array (
      'label' => 'Tags',
      'name' => 'tags',
      'field' => 
      array (
        'type' => 'tag',
      ),
      'list' => 
      array (
        'format' => 'tag',
      ),
      'detail' => 
      array (
        'format' => 'tag',
      ),
      'default' => '',
    ),
    5 => 
    array (
      'label' => 'Event',
      'name' => 'event',
      'field' => 
      array (
        'type' => 'text',
        'attributes' => 
        array (
          'placeholder' => 'eg. system-model-search',
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
    ),
    6 => 
    array (
      'label' => 'Parameters',
      'name' => 'parameters',
      'field' => 
      array (
        'type' => 'rawjson',
        'attributes' => 
        array (
          'rows' => '5',
        ),
      ),
      'list' => 
      array (
        'format' => 'hide',
      ),
      'detail' => 
      array (
        'format' => 'jsonpretty',
      ),
      'default' => '',
    ),
    7 => 
    array (
      'label' => 'Layout',
      'name' => 'layout',
      'field' => 
      array (
        'type' => 'text',
        'attributes' => 
        array (
          'placeholder' => 'eg. www',
        ),
      ),
      'list' => 
      array (
        'format' => 'lower',
      ),
      'detail' => 
      array (
        'format' => 'lower',
      ),
      'default' => '',
      'filterable' => '1',
    ),
    8 => 
    array (
      'label' => 'Content Type',
      'name' => 'content_type',
      'field' => 
      array (
        'type' => 'text',
        'attributes' => 
        array (
          'placeholder' => 'eg. text/html',
        ),
      ),
      'list' => 
      array (
        'format' => 'lower',
      ),
      'detail' => 
      array (
        'format' => 'lower',
      ),
      'default' => 'text/html',
      'filterable' => '1',
    ),
    9 => 
    array (
      'label' => 'Template',
      'name' => 'template',
      'field' => 
      array (
        'type' => 'code',
        'attributes' => 
        array (
          'rows' => '25',
          'data-mode' => 'handlebars',
        ),
      ),
      'list' => 
      array (
        'format' => 'hide',
      ),
      'detail' => 
      array (
        'format' => 'none',
      ),
      'default' => '',
    ),
    10 => 
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
    ),
    11 => 
    array (
      'label' => 'Created',
      'name' => 'created',
      'field' => 
      array (
        'type' => 'created',
      ),
      'list' => 
      array (
        'format' => 'date',
        'parameters' => 'F d, Y g:iA',
      ),
      'detail' => 
      array (
        'format' => 'date',
        'parameters' => 'F d, Y g:iA',
      ),
      'default' => 'NOW()',
      'sortable' => '1',
    ),
    12 => 
    array (
      'label' => 'Updated',
      'name' => 'updated',
      'field' => 
      array (
        'type' => 'updated',
      ),
      'list' => 
      array (
        'format' => 'date',
        'parameters' => 'F d, Y g:iA',
      ),
      'detail' => 
      array (
        'format' => 'date',
        'parameters' => 'F d, Y g:iA',
      ),
      'default' => 'NOW()',
      'sortable' => '1',
    ),
  ),
  'suggestion' => '{{page_title}}',
);