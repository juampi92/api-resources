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
   | Resorces homepath
   |--------------------------------------------------------------------------
   |
   | This value is the base folder where your resources are stored.
   | When using multiple apis, you can leave it as a string if every
   | api is in the same folder, or as an array with the apis as keys.
    */

    'resources_path' => 'App\Http\Resources',

    /*
    |--------------------------------------------------------------------------
    | Resorces
    |--------------------------------------------------------------------------
    |
    | Here is the folder that has versionated resources. If you store them
    | in the root of 'resources_path', leave this empty or null.
     */

    'resources' => 'App'

 ];
