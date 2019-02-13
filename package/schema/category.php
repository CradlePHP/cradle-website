<?php //-->
return array (
  'singular' => 'Category',
  'plural' => 'Categories',
  'name' => 'category',
  'group' => 'Website',
  'icon' => 'fas fa-sitemap',
  'detail' => 'Generally manages categories for any objects relating to it.',
  'fields' => 
  array (
    0 => 
    array (
      'label' => 'Banner',
      'name' => 'banner',
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
      'label' => 'Slug',
      'name' => 'slug',
      'field' => 
      array (
        'type' => 'slug',
        'attributes' => 
        array (
          'data-source' => 'input[name=category_title]',
        ),
      ),
      'validation' => 
      array (
        0 => 
        array (
          'method' => 'required',
          'message' => 'Slug is required',
        ),
        1 => 
        array (
          'method' => 'unique',
          'message' => 'Should be unique',
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
      'label' => 'Detail',
      'name' => 'detail',
      'field' => 
      array (
        'type' => 'wysiwyg',
        'attributes' => 
        array (
          'rows' => '15',
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
        'format' => 'hide',
      ),
      'detail' => 
      array (
        'format' => 'html',
      ),
      'default' => '',
    ),
    5 => 
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
  'relations' => 
  array (
    0 => 
    array (
      'many' => '2',
      'name' => 'category',
    ),
  ),
  'suggestion' => '{{category_title}}',
);