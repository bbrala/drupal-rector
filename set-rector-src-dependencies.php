<?php
if (!isset($argv[1]) || !in_array($argv[1], ['show', 'set'], true)) {
    echo "Usage: php set-rector-dev-dependencies.php [show|set]" . PHP_EOL;
    exit(1);
}
$action = $argv[1];

if (!file_exists(__DIR__ . '/vendor/composer/installed.php')) {
    echo "Please run composer install before running this script" . PHP_EOL;
    exit(1);
}

// These packages we need to pin to the same version as Rector
$packagedToPin = [
    "rector/rector-doctrine",
    "rector/rector-downgrade-php",
    "rector/rector-phpunit",
    "rector/rector-symfony",
];

// Get installed packages
$installed = require __DIR__ . '/vendor/composer/installed.php';

// Get installed Rector version
$rectorVersion = $installed['versions']['rector/rector-src']['pretty_version'];

// Get packages installed by Rector in this version
$rectorSourceJson = file_get_contents("https://raw.githubusercontent.com/rectorphp/rector/$rectorVersion/vendor/composer/installed.json");
$rectorSourcePackages = json_decode($rectorSourceJson, true);
$packages = array_filter($rectorSourcePackages['packages'], function (array $package) use ($packagedToPin) {
    return in_array($package['name'], $packagedToPin, true);
});

// Translate the package information into a format that can be used by composer require
$pinnedPackages = [];
foreach ($packages as $package) {
    $pinnedPackages[$package['name']] = $package['version'] . '#' . $package['source']['reference'];
}


if($action === 'show') {
    echo "Version $rectorVersion of Rector requires the following packages to be pinned:" . PHP_EOL;
    foreach ($pinnedPackages as $package => $version) {
        $installedVersion = $installed['versions'][$package]['version'];
        $installedReference = $installed['versions'][$package]['reference'];
        if ($version === $installedVersion . '#' . $installedReference) {
            echo "$package:$version (already installed)" . PHP_EOL;
            continue;
        }

        echo "$package:$version" . PHP_EOL;
    }
}

if ($action === 'set') {
    $composerJson = json_decode(file_get_contents(__DIR__ . '/composer.json'), true);
    $composerJson['require-dev'] = array_merge($composerJson['require-dev'], $pinnedPackages);
    file_put_contents(__DIR__ . '/composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

    echo "Updated composer.json, please run composer update to load the correct dependencies." . PHP_EOL;
}
