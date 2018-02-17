<?php

return [
  /*
  |--------------------------------------------------------------------------
  | API Version
  |--------------------------------------------------------------------------
  |
  | This value is the version of your api. This value is used when
  | there's no specified version on the routes, so it will take this as the
  | default, or current
   */

   'version' => [
     'app' => '1',
     'desktop' => '2'
   ],

   /*
   |--------------------------------------------------------------------------
   | API Default
   |--------------------------------------------------------------------------
   |
   |
    */

   'default' => 'app',

   /*
   |--------------------------------------------------------------------------
   | Resorces homepath
   |--------------------------------------------------------------------------
   |
   | This value is the base folder where your resources are stored.
   |
    */

    'resources_path' => 'Juampi92\APIResources\Tests\Fixtures\Resources',

    /*
    |--------------------------------------------------------------------------
    | Resorces
    |--------------------------------------------------------------------------
    |
    | Here is the folder that has versionated resources. If you store them
    | in the root, leave this empty ''
     */

    'resources' => [
      'app' => 'App',
      'desktop' => 'Api'
    ]

 ];
