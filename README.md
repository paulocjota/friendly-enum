<p align="center"><a href="#" target="_blank"><img src="logo.png" width="400" alt="friendly-enum"></a></p>

<p align="center">
 <a href="#about">About</a> •
 <a href="#getting-started">Getting started</a> •
 <a href="#api-reference">API Reference</a> •
 <a href="#technologies">Technologies</a> •
 <a href="#author">Author</a> •
 <a href="#license">License</a>
</p>

<br/>

## About
FriendlyEnum is a PHP trait used to handle enum fields in Laravel framework in an easy way.

#### The problem it solves
You create an enum field in the migration file with user states for example. As the system is developed you also need the values in the views, in Form Requests / validators and many other places. Now a change is needed in the system to support one more state. Good luck remembering in each place that you need to change. This package tries to solve this problem.

## Getting started

### Install the package
```bash
composer require paulocjota/friendly-enum
```

### Setting up
```php
<?php

namespace App\Models;

use Paulocjota\FriendlyEnum;// <-- 1. Import trait

class User extends Model
{
    use FriendlyEnum;// <-- 2. Make use of in desired model

    const ENUM_STATUS = [// <-- 3. Create one or more constants prefixed with "ENUM_"
        'normal' => 'normal',
        'blocked' => 'bloqueado',
        'banned' => 'banido',
    ];
}
```

### Use cases

* In migration files. Ex.:
```php
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        // ...
        $table->enum('status', User::getEnumKeys('status'));
    });
}
```
* In blade component files. Ex.:
```blade
<x-select :options="\App\Models\User::getEnum('status')" />
```
* In Form Request / Validators. Ex.:
```php
'user.status' => [
    'required',
    Rule::in(User::getEnumKeysAsString('status')),
],
```

### API Reference
| Method                                                              | Return   | Comment                                                    |
| ------------------------------------------------------------------- | :------: | :--------------------------------------------------------: |
| `getEnum(string $enum, bool $capitalize = false)`                   | array    | Get an array with key value                                |
| `getEnumKeys(string $enum)`                                         | array    | Get an array with only the keys                            |
| `getEnumKeysAsString(string $enum)`                                 | string   |  Get a string with all keys each one separated by a comma. |
| `getEnumKey(string $enum, string $value)`                           | string   | Get key as a string passing the value.                     |
| `getEnumValue(string $enum, string $key, bool $capitalize = false)` | string   | Get value as a string passing the key.                     |

## Technologies
FriendlyEnum was created with Laravel in mind. But it is pure PHP has no depency so you are free to use with whatever
tools you want.

## Author
[paulocjota](https://github.com/paulocjota)

## License
The get function is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).