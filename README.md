# Laravel 5 Lazy Image Loader

This package changes the normal HTMLBuilder package image method to output the HTML that will be formatted in a way that can be lazy loaded.

### Installation

```sh
$ composer install samjoyce777/lazy --save
```

In the config.php file you need to insert the service provider

```sh
$ \samjoyce777\lazy\LazyServiceProvider::class,
```

and then change the HTML facade to the new one, this class simply extends it so you have complete use of the other methods, it is only the image that has been overriden.

```sh
$ 'HTML' => samjoyce777\lazy\LazyFacade::class,
```

You will need to get the javascript file, this goes to the public directory at the moment. You will then need to include or concat it.

```sh
$ php artisan vendor:publish --tag=public --force
```

This will add the config file to your apps config.

```sh
$ php artisan vendor:publish --tag=config
```

Not been able to get the package routing to work properly, so copy this route into your routes file

```sh
$ \Route::get('ajax-lazy-image', ['as' => 'ajax-lazy-image', 'uses' => '\samjoyce777\lazy\ImageController@ajax']);
```

### Example Usage

Normal HTML::image will now change the src tag to the default placeholder image in the config and then change with js

```sh
  {!!HTML::image('cushion.jpg', 'cushion picture')!!}
```

Some items you may want different placeholders such as products or avatars etc, if you set a class placeholder in the config it will load that placeholder image

```sh
  {!!HTML::image('cushion.jpg', 'cushion picture', ['class' => 'product'])!!}
```

If you need to override the placeholder for a one off, you can do by setting a placeholder attribute

```sh
  {!!HTML::image('cushion.jpg', 'cushion picture', ['class' => 'product', 'placeholder' => 'images/large-placeholder.png'])!!}
```

There are two types of lazy load which are set in the config. The 'basic' will simple change all the placeholder images with the intended image. Not sure how effective on load speed this is unless you have a lot of images.
The 'ajax' method sends screen size and element size to the above route, where your controller can send an appropriate size image, in the ImageController included is an example using my Album package.

### This is still in work in progress stage.

