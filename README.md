![Hood](hood-core.png)
# Hood-Core
The standalone core of Hood Framework, the PHP Framework for good aim archers and agile rogues.

You can import this library with any framework and use it's features as you want!

## Installation
`composer require laraantunes/hood-core`

## You'll need to configure the paths for Hood's configuration:

```php
use Hood\Config\Config;

Config::setPaths([
    'CONFIG_PATH' => __DIR__.DIRECTORY_SEPARATOR,
    'HOME_PATH' => __DIR__.DIRECTORY_SEPARATOR,
]);

```

Now you can use all the Hood's features, as ORM, Query Builder and Routing library. 