<?php
declare(strict_types = 1);

use Composer\Semver\VersionParser;

// Bypass standard composer API because of collision with libraries bundled inside phpstan.phar
$installed = require __DIR__ . '/../../vendor/composer/installed.php';
$versionParser = new VersionParser();
$isInstalled = function (string $packageName, string $versionConstraint) use ($versionParser, $installed): bool {
    $constraint = $versionParser->parseConstraints($versionConstraint);
    $installedVersion = $installed['versions'][$packageName]['pretty_version']; // @phpstan-ignore offsetAccess.nonOffsetAccessible,offsetAccess.nonOffsetAccessible,offsetAccess.nonOffsetAccessible
    assert(is_string($installedVersion));
    $provided = $versionParser->parseConstraints($installedVersion);
    return $provided->matches($constraint);
};


$config = ['parameters' => ['ignoreErrors' => []]];

if (! $isInstalled('nette/utils', '>=3.2.5') && ! $isInstalled('nette/utils', 'dev-master')) {
    // unsupported generics template in nette/utils
    $config['parameters']['ignoreErrors'][] = [
        'message' => '~^Method Nepada\\\\MetaControl\\\\MetaControl::(getMetadata|getProperty|getPragma)\\(\\) should return string\\|null but returns mixed\\.~',
        'path' => __DIR__ . '/../../src/MetaControl/MetaControl.php',
    ];
}

return $config;
