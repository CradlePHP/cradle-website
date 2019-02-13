<?php //-->
return array (
  'singular' => 'Comment',
  'plural' => 'Comments',
  'name' => 'comment',
  'group' => 'Website',
  'icon' => 'fas fa-comments',
  'detail' => 'Manages comments on posts',
  'fields' => 
  array (
    0 => 
    array (
      'label' => 'Rating',
      'name' => 'rating',
      'field' => 
      array (
        'type' => 'stars',
        'attributes' => 
        array (
          'max' => '5',
          'min' => '0',
          'step' => '0.5',
          'data-max' => '5',
          'data-min' => '0',
          'data-step' => '0.5',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'regexp',
          'parameters' => '#^[0-5](\\.5)*$#is',
          'message' => 'Should be between 0 and 5',
        ),
      ),
      'list' => 
      array (
        'format' => 'stars',
      ),
      'detail' => 
      array (
        'format' => 'stars',
      ),
      'default' => '0',
      'sortable' => '1',
    ),
    1 => 
    array (
      'label' => 'Detail',
      'name' => 'detail',
      'field' => 
      array (
        'type' => 'markdown',
        'attributes' => 
        array (
          'rows' => '10',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Detail is required',
        ),
      ),
      'list' => 
      array (
        'format' => 'markdown',
      ),
      'detail' => 
      array (
        'format' => 'markdown',
      ),
      'default' => '',
      'searchable' => '1',
    ),
    2 => 
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
    3 => 
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
    4 => 
    array (
      'label' => 'Updated',
      'name' => 'updated',
      'field' => 
      array (
        'type' => 'updated',
      ),
      'list' => 
      array (
        'format' => 'hide',
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
  'relations' => 
  array (
    0 => 
    array (
      'many' => '1',
      'name' => 'profile',
    ),
    1 => 
    array (
      'many' => '2',
      'name' => 'comment',
    ),
    2 => 
    array (
      'many' => '2',
      'name' => 'file',
    ),
  ),
  'suggestion' => '{{comment_detail}}',
);