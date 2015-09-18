<?php
namespace Lanthane;

use Exception;
use MongoConnectionException;
use Saxulum\DoctrineMongoDb\Silex\Provider\DoctrineMongoDbProvider;
use Silex;


class Application extends Silex\Application
{

    /**
     * Application is booted on 2 ways :
     * - first is a simple boot to get if system is multiple instance and get current instance
     * - second boot for the current instance
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        $values['lanthane_version'] = '0.0.1';

        parent::__construct($values);


        $this->register(new Provider\ConfigServiceProvider());

        $this->initializeDatabase();

        // Load configuration stored in database
    }

    /**
     * Initialize and check MongoDB database connection
     */
    protected function initializeDatabase()
    {
        $this->register(new DoctrineMongoDbProvider(), $this['config']->get('database', []));
        $this['db'] = $this['mongodb'];

        try {
            $this['mongodb']->connect();
        } catch (MongoConnectionException $e) {
            $error = "Lanthane could not connect to the configured database.\n\n";
            throw new \Exception($error);
        }
    }
}
