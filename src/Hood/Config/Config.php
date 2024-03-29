<?php

namespace Hood\Config;

use \Dotenv\Dotenv;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Config
 * @package Hood\Config
 */
class Config
{
    /**
     * Type "app"
     */
    const APP = 'app';

    /**
     * Type "env"
     */
    const ENV = 'env';

    /**
     * Type "database"
     */
    const DATABASE = 'database';

    /**
     * Type "params"
     * @todo get the params on Config object
     */
    const PARAMS = 'params';

    /**
     * @var array
     */
    protected $appConfig;

    /**
     * @var array
     */
    protected $envConfig;

    /**
     * @var array
     */
    protected $databaseConfig;

    /**
     * @var self
     */
    protected static $singleton;

    /**
     * The Application's Config Path
     * @var string
     */
    public static $CONFIG_PATH;
    /**
     * The Application's Home Path
     * @var string
     */
    public static $HOME_PATH;

    /**
     * Config constructor.
     */
    public function __construct()
    {
        if (file_exists(self::$CONFIG_PATH . 'app.yml')) {
            $this->appConfig = Yaml::parseFile(self::$CONFIG_PATH . 'app.yml');
        }

        $file = null;
        if (file_exists(self::$HOME_PATH . '.env.local')) {
            $file = '.env.local';
        } elseif (file_exists(self::$HOME_PATH . '.env')) {
            $file = '.env';
        }

        if (!empty($file)) {
            Dotenv::create(self::$HOME_PATH, $file)->load();
        }

        $this->envConfig = $_ENV;

        if (file_exists(self::$CONFIG_PATH . 'database.yml')) {
            $this->databaseConfig = Yaml::parseFile(self::$CONFIG_PATH . 'database.yml');
        }
    }

    /**
     * Sets the Hood's paths.
     * @param array $paths Must be an array with two keys: CONFIG_PATH and HOME_PATH
     * HOME_PATH is used to define the location for .env file. CONFIG_PATH is used to define
     * where are app.yml and database.yml
     * @return void
     */
    public static function setPaths(array $paths)
    {
        self::$CONFIG_PATH = $paths['CONFIG_PATH'];
        self::$HOME_PATH = $paths['HOME_PATH'];
    }

    /**
     * Gets the \Hood\Config singleton
     * @return Config
     */
    public static function config()
    {
        if (empty(static::$singleton)) {
            static::$singleton = new self;
        }
        return static::$singleton;
    }

    /**
     * Starts the Hood configuration
     * @return Config
     */
    public static function start()
    {
        return self::config();
    }

    /**
     * gets an app configuration
     * @param $key
     * @return mixed|null
     */
    public function app($key)
    {
        return (!empty($this->appConfig[$key])) ? $this->appConfig[$key] : null;
    }

    /**
     * Gets an env configuration
     * @param $key
     * @return mixed|null
     */
    public function env($key)
    {
        return (!empty($this->envConfig[$key])) ? $this->envConfig[$key] : null;
    }

    /**
     * Gets an database configuration
     * @param $key
     * @return mixed|null
     */
    public function database($key)
    {
        return (!empty($this->databaseConfig[$key])) ? $this->databaseConfig[$key] : null;
    }

    /**
     * Gets a configuration based on singleton
     * @param string $type "app", "env" or "database'
     * @param string $key
     * @return mixed
     */
    public static function get(string $type, string $key)
    {
        return self::config()->$type($key);
    }
}
