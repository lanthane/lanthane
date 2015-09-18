<?php
namespace Lanthane\Provider;

use Lanthane\Config;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['config'] = $app->share(
            function ($app) {
                $config = new Config($app, isset($app['minimal_config']) ? $app['minimal_config'] : [] );

                return $config;
            }
        );
    }

    public function boot(Application $app)
    {
    }
}
