<?php
namespace Lanthane\Tests;

use Lanthane\Config;

class ConfigurationTest extends LanthaneUnitTest
{

    /**
     * @cover Lanthane\Config::__construct
     */
    public function testInitConfig()
    {
        $app = $this->getApp();

        $config = new Config($app);

        $this->assertInstanceOf('Lanthane\Config', $config);

        return $config;
    }

    /**
     * @cover Lanthane\Config::set
     * @cover Lanthane\Config::toArray
     *
     * @return \Lanthane\Config;
     */
    public function testSet()
    {
        $app = $this->getApp();

        $config = new Config($app);

        $configArray = $config->toArray();
        $this->assertTrue(is_array($configArray));
        $this->assertEmpty($configArray);

        $config->set('key1', 'value1');

        $config->set('config/test1', 'value1');
        $config->set('config/test2', 'value2');
        $config->set('config/test3/test1', 'value1');

        $config->set('array', ['key1' => 'value1', 'key2' => 'value2']);
        $config->set('array2', ['key1' => ['key2' => ['key3' => 'value3']]]);

        $configArray = $config->toArray();
        $this->assertTrue(is_array($configArray));
        $this->assertNotEmpty($configArray);
        $this->assertArrayHasKey('key1', $configArray);
        $this->assertArrayHasKey('config', $configArray);
        $this->assertArrayHasKey('array', $configArray);
        $this->assertArrayHasKey('array2', $configArray);

        return $config;
    }

    /**
     * @param \Lanthane\Config $config
     *
     * @depends testSet
     * @cover   Lanthane\Config::get
     */
    public function testGet(\Lanthane\Config $config)
    {
        $this->assertEquals('value1', $config->get('key1'));

        $this->assertEquals('value1', $config->get('config/test1'));
        $this->assertEquals('value2', $config->get('config/test2'));

        $this->assertEquals('value1', $config->get('array/key1'));
        $this->assertEquals('value2', $config->get('array/key2'));

        $this->assertEquals('value3', $config->get('array2/key1/key2/key3'));

        // Test non-existent config
        $this->assertNull($config->get('non-existent'));
        $this->assertNotFalse($config->get('non-existent'));
        $this->assertFalse($config->get('non-existent', false));
    }
}
