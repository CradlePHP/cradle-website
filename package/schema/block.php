<?php //-->
return array (
  'singular' => 'Block',
  'plural' => 'Blocks',
  'name' => 'block',
  'group' => 'Website',
  'icon' => 'fas fa-cube',
  'detail' => 'Manages general blocks for the website',
  'fields' => 
  array (
    0 => 
    array (
      'label' => 'Name',
      'name' => 'name',
      'field' => 
      array (
        'type' => 'text',
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Name is required',
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
    1 => 
    array (
      'label' => 'Keyword',
      'name' => 'keyword',
      'field' => 
      array (
        'type' => 'slug',
        'attributes' => 
        array (
          'data-source' => 'input[name=block_name]',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Keyword is required',
        ),
        1 => 
        array (
          'method' => 'unique',
          'message' => 'Should be unique',
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
    2 => 
    array (
      'label' => 'Description',
      'name' => 'description',
      'field' => 
      array (
        'type' => 'textarea',
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
    3 => 
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
    4 => 
    array (
      'label' => 'Parameters',
      'name' => 'parameters',
      'field' => 
      array (
        'type' => 'rawjson',
        'attributes' => 
        array (
          'rows' => '15',
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
    5 => 
    array (
      'label' => 'Template',
      'name' => 'template',
      'field' => 
      array (
        'type' => 'code',
        'attributes' => 
        array (
          'rows' => '20',
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
    6 => 
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
    7 => 
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
    8 => 
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
  'suggestion' => '{{block_name}}',
);