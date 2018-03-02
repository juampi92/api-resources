<?php

return [
  /*
  |--------------------------------------------------------------------------
  | API Version
  |--------------------------------------------------------------------------
  |
  | This value is the latest version of your api. This is used when
  | there's no specified version on the routes, so it will take this as the
  | default, or latest.
   */

   'version' => '1',

   /*
   |--------------------------------------------------------------------------
   | Resources home path
   |--------------------------------------------------------------------------
   |
   | This value is the base folder where your resources are stored.
   | When using multiple APIs, you can leave it as a string if every
   | api is in the same folder, or as an array with the APIs as keys.
    */

    'resources_path' => 'App\Http\Resources',

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Here is the folder that has versioned resources. If you store them
    | in the root of 'resources_path', leave this empty or null.
     */

    'resources' => 'App'

 ];
