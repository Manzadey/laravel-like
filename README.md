# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/manzadey/laravel-like.svg?style=flat-square)](https://packagist.org/packages/manzadey/laravel-like)
[![Total Downloads](https://img.shields.io/packagist/dt/manzadey/laravel-like.svg?style=flat-square)](https://packagist.org/packages/manzadey/laravel-like)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package implements the likes/dislikes system in the laravel framework.

## Index

- [Installation](#installation)
- [Models](#models)
- [Usage](#usage)

## Installation

You can install the package via composer:

1) Install the package via Composer
```bash
composer require manzadey/laravel-like
```

2) Publish the database from the command line:

```shell
php artisan vendor:publish --provider="Manzadey\LaravelLike\LikeServiceProvider"
```

3) Migrate the database from the command line:

```shell
php artisan migrate
```

## Models

Your User model should import the `Likeability` trait, `LikeabilityContract` implements interface and use it, that trait allows the user to like the models.
(see an example below):

```php
use Manzadey\LaravelLike\Traits\Likeability;
use Manzadey\LaravelLike\Contracts\LikeabilityContract;

class User extends Authenticatable implements LikeabilityContract;
{
	use Likeability;
}
```

Your models should import the `Likeable` trait, `LikeableContract` implements interface and use it, that trait has the methods that you'll use to allow the model be likeable.
In all the examples I will use the Post model as the model that is 'Likeable', that's for example proposes only.
(see an example below):

```php
use Manzadey\LaravelLike\Traits\Likeable;
use Manzadey\LaravelLike\Contracts\LikeableContract;

class Post extends Model implements LikeableContract
{
    use Likeable;
}
```

That's it ... your model is now **"likeable"**!
Now the User can favorite models that have the favoriteable trait.

## Usage

### A standard set of methods for working with the package:

```php
$article = \App\Models\Article::first();
$user = \App\Models\User::first();

$article->like($user); // Add the current model to like of the specified user
$article->dislike($user); // Add the current model to dislike of the specified user
$article->toggleLike($user); // The switch of the likes of the specified user
$article->removeLikeable($user); // Delete the current module from the likes of the specified user
$article->isLike($user); // Check the current model whether it is a likes of the specified user
$article->isDislike($user); // Check the current model whether it is a likes of the specified user
```
*You can also use these methods as a `Likeability' model.*

### Checking the model for the presence of likes/dislikes of a particular user

```php
$article = \App\Models\Article::first();
$user = \App\Models\User::first();

$article->isLike($user);
$article->isDislike($user);
```

*You can also use these methods as a `Likeability' model.*

### Check the current model, whether it is marked with a like/dislike

```php
$article = \App\Models\Article::first();

$article->isLikes();
$article->isDislikes();
```

### Returns a collection of users who have liked/disliked this model

```php
$article = \App\Models\Article::first();
$user = \App\Models\User::first();

$article->likeBy();
$article->dislikeBy();
```

### We get a collection of models marked with a like/dislike

```php
$article = \App\Models\Article::first();
$user = \App\Models\User::first();

$user->getLike();
$user->getDisike();

// With usage models
$user->getLike([\App\Models\Article::class]);
$user->getDisike([\App\Models\Article::class]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email andrey.manzadey@gmail.com instead of using the issue tracker.

## Credits

-   [Andrey Manzadey](https://github.com/manzadey)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
