# Api Resources
[![Latest Version](https://img.shields.io/github/release/juampi92/api-resources.svg?style=flat-square)](https://github.com/juampi92/api-resources/releases)
[![Build Status](https://img.shields.io/travis/juampi92/api-resources/master.svg?style=flat-square)](https://travis-ci.org/juampi92/api-resources)
[![Total Downloads](https://img.shields.io/packagist/dt/juampi92/api-resources.svg?style=flat-square)](https://packagist.org/packages/juampi92/api-resources)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Manage your resources maintaining API versioning. With a simple middleware separate routes by api version, and smart instanciate [Http\Resources](https://laravel.com/docs/5.5/eloquent-resources) based on this version.

Add the middleware `'api.v:2'` on your api/v2 group.

And then `api_resource('App\User')->make($user)` is the same as `new App\Http\Resources\App\v2\User($user)`, but version free.

```bash
App\Http\Resources\
  |- App\
    |- v1\
      |- User.php
    |- v2\
      |- Rank.php
      |- User.php
```

### The idea behing this

A while back I faced this API versioning problem, so I wrote this [medium post](https://medium.com/@juampi92/api-versioning-using-laravels-resources-b1687a6d2c22) with my solution and this package reflects this.

## Installation

You can install this package via composer using:

```bash
composer require juampi92/api-resources
```

The package will automatically register itself.

### Config

To publish the config file to `config/api.php` run:

```bash
php artisan vendor:publish --provider="Juampi92\APIResources\APIResourcesServiceProvider"
```

This will publish a file `api.php` in your config directory with the following content:
```php
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
```

### Middleware

Install this middleware on your `Http/Kernel.php` under the `$routeMiddleware`

```php
  protected $routeMiddleware = [
    ...
    'api.v'           => \Juampi92\APIResources\Middleware\APIversion::class,
    ...
  ];
```

## Configure correctly

For this package to work, you need to understand how it requires resources.

If we have the following config:
```php
[
  'version' => '2',
  'resources_path' => 'App\Http\Resources',
  'resources' => 'Api'
]
```

This means that if you include the `Api\User` resource, it will instantiate `App\Http\Resources\Api\v2\User`.

`Api` works for sub organizing your structure, but you can put your Resources versionate folders in the root, like this:

```php
[
  'version' => '2',
  'resources_path' => 'App\Http\Resources',
  'resources' => ''
]
```

Now if we include `User`, it will instantiate `App\Http\Resources\v2\User`.

### Fallback

When you use a version that is **NOT** the latest, if you try to include a Resource that's **NOT** defined inside that version's directory, this will automatically fallback in the **LATEST** version.

This way you don't have to duplicate new resources on previous versions.

## Usage

### Middleware

When you group your API routes, you should now apply the middleware `api.v` into the group like this:

```php
// App v1 API
Route::group([
    'middleware' => ['app', 'api.v:1'],
    'prefix'     => 'api/v1',
], function ($router) {
    require base_path('routes/app_api.v1.php');
});

// App v2 API
Route::group([
    'middleware' => ['app', 'api.v:2'],
    'prefix'     => 'api/v2',
], function ($router) {
    require base_path('routes/app_api.v2.php');
});
```

That way, if you use the Facade, you can check the current version by doing `APIResource::getVersion()` and will return the version specified on the middleware.


### Facade

There are many ways to create resources. You can use the Facade accessor:

```php
use Juampi92\APIResources\Facades\APIResource;

class SomethingController extends Controller {
    ...

    public function show(Something $model)
    {
      return APIResource::resolve('App\Something')->make($model);
    }
}
```

### Global helper

```php
class SomethingController extends Controller {
    ...

    public function show(Something $model)
    {
      return api_resource('App\Something')->make($model);
    }
}
```

### Collections

Instead of `make`, use `collection` for arrays, just like Laravel's documentation.

```php
class SomethingController extends Controller {
    ...

    public function index()
    {
      $models = Something::all();
      return api_resource('App\Something')->collection($models);
    }
}
```

## Nested resources

To take advantage of the **fallback** functionality, it's recomended to use `api_resource` inside the resources. This way you preserve the right version, or the latest if it's not defined.

```php
class Post extends Resource {
    public function toArray($request)
    {
      return [
        'title' => $this->title,
          ...
        'user' => api_resource('App\User')->make($this->user);
      ];
    }
}
```

## Multiple APIs

There might be the case where you have more than one API living on the same project, but using diferent versions. This app supports that.
First, the `config/api.php`

```php
return [
  'default' => 'api',
  'version' => [
    'api'     => '2',
    'desktop' => '3'
  ],
  'resources_path' => 'App\Http\Resources'
  // Or one path each
  'resources_path' => [
    'api'     => 'App\Http\Resources',
    'desktop' => 'Vendorname\ExternalPackage\Resources'
  ],
  'resources' => [
    'api'     => 'Api',
    'desktop' => ''
  ],
];
```

Then, you need to configure the **middleware**. Instead of using `api.v:1`, you now have to specify the name: `api.v:3,desktop`.

Then the rest works as explained before.


## Testing

Run the tests with:
```bash
vendor/bin/phpunit
```

## Credits

- [Juan Pablo Barreto](https://github.com/juampi92)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
