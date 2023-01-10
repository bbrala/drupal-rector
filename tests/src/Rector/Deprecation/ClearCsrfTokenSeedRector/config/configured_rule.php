<?php declare(strict_types=1);

use DrupalRector\Rector\Deprecation\ClearCsrfTokenSeed;
use Rector\Config\RectorConfig;

return static function (RectorConfig $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ClearCsrfTokenSeed::class)
        ->configure([
            'drupal_rector_notices_as_comments' => '%drupal_rector_notices_as_comments%',
        ]);

    $parameters = $containerConfigurator->parameters();
    $parameters->set('drupal_rector_notices_as_comments', true);
};
