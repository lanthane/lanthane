<?php
namespace Lanthane;

use Zend\Config\Config as ZendConfig;


class Config
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Zend\Config\Config;
     */
    protected $configManager;

    public function __construct(Application $app, array $initialConfig = [])
    {
        $this->app = $app;
        $this->configManager = new ZendConfig($initialConfig, true);
    }

    /**
     * Retrive config value using path
     *
     * @param string            $path
     * @param string|array|null $default
     *
     * @return mixed
     */
    public function get($path, $default = null)
    {
        $path = explode('/', $path);

        $value = null;
        $conf = $this->configManager;

        foreach ($path as $key) {
            if (!$conf->offsetExists($key)) {
                $value = null;
                break;
            }

            $value = $conf[$key];
            $conf = $conf[$key];
        }

        if (null !== $value) {
            if ($value instanceof ZendConfig) {
                return $value->toArray();
            }

            return $value;
        }

        return $default;
    }

    /**
     * @param string $path
     * @param mixed  $value
     *
     * @return Lanthane\Config
     */
    public function set($path, $value)
    {
        $path = explode('/', trim($path, '/'));

        $conf = $this->configManager;

        $partNumber = count($path);
        $loop = 0;
        $lastLoop = false;

        foreach ($path as $key) {
            $loop++;
            $lastLoop = $loop >= $partNumber;

            if (!$conf->offsetExists($key)) {
                $conf[$key] = $lastLoop ? $value : [];
            }

            $conf = $conf[$key];
        }

        return $this;
    }

    /**
     * Load configuration form file
     *
     * @param string $filepath
     *
     * @return array
     */
    public function mergeFromFile($filepath)
    {
    }

    /**
     * Load configuration from database
     */
    public function mergeFromDb()
    {
        $db = $this->app['db'];
        $db->getCollection('configuration');
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->getConfigManager()->toArray();
    }

    /**
     * Retrieve config manager
     *
     * @return Zend\Config\Config|ZendConfig
     */
    protected function getConfigManager()
    {
        return $this->configManager;
    }
}
