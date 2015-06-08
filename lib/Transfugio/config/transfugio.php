<?php return [
  'itemsPerPage' => 100,
  'rootURL' => 'api/v1/',

  'transformers' => [
    'enabled' => true,

    'serializer' => 'EFrane\Transfugio\Transformers\SanitizedDataArraySerializer',

    'namespace' => 'App\Handlers\Transformers',
    'classPattern' => '[:modelName]Transformer',

    'formatHelpers' => [
      'email' => 'EFrane\Transfugio\Transformers\Formatter\EMailURI',
      'date'  => 'EFrane\Transfugio\Transformers\Formatter\DateISO8601',
    ]
  ],

  'http' => [
    'format' => 'json_accept',
    'enableCORS' => true,
  ]
];
