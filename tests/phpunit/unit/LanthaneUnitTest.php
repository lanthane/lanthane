<?php
namespace Lanthane\Tests;

use Lanthane\Application;

abstract class LanthaneUnitTest extends \PHPUnit_Framework_TestCase
{
    public function getApp()
    {
        $app = new Application();

        return $app;
    }
}