<?php
declare(strict_types = 1);

use Composer\Semver\VersionParser;

// Bypass standard composer API because of collision with libraries bundled inside phpstan.phar
$installed = require __DIR__ . '/../../vendor/composer/installed.php';
$versionParser = new VersionParser();
$isInstalled = function (string $packageName, string $versionConstraint) use ($versionParser, $installed): bool {
    $constraint = $versionParser->parseConstraints($versionConstraint);
    $provided = $versionParser->parseConstraints($installed['versions'][$packageName]['pretty_version']);
    return $provided->matches($constraint);
};


$config = [];

if (! $isInstalled('nette/utils', '>=3.2.5')) {
    // unsupported generics template in nette/utils
    $config['parameters']['ignoreErrors'][] = [
        'message' => '~^Method Nepada\\\\MetaControl\\\\MetaControl::(getMetadata|getProperty|getPragma)\\(\\) should return string\\|null but returns mixed\\.~',
        'path' => '../../src/MetaControl/MetaControl.php',
    ];
}

return $config;
