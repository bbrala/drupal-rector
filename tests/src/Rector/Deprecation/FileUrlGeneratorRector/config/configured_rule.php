<?php declare(strict_types=1);

use DrupalRector\Rector\Deprecation\FileUrlGenerator;
use Rector\Config\RectorConfig;

return static function (RectorConfig $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(FileUrlGenerator\FileCreateUrlRector::class);
    $services->set(FileUrlGenerator\FileUrlTransformRelativeRector::class);
    $services->set(FileUrlGenerator\FromUriRector::class);

    $parameters = $containerConfigurator->parameters();
    $parameters->set('drupal_rector_notices_as_comments', true);
};
