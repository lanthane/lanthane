<?php
namespace Lanthane;

use Symfony\Component\Yaml\Yaml;
use Zend\Config\Config;

define('ROOT_PATH', realpath(__DIR__ . '/..'));
require_once ROOT_PATH . '/vendor/autoload.php';

# Load minimal config
$minimalConfigPath = ROOT_PATH . '/app/config/config.yml';
if (!file_exists($minimalConfigPath)) {
    // Setup
    return new ApplicationSetup();
} else {
    $minimalConfig = Yaml::parse(file_get_contents($minimalConfigPath));
}

$app = new Application(['minimal_config' => $minimalConfig]);
return $app;