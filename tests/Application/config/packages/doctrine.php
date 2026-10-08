<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    // ORM 2 generates proxy classes without lazy ghost objects, PHP 8.4 reports them as deprecated; ORM 3 always uses lazy objects
    if (version_compare((string) InstalledVersions::getVersion('doctrine/orm'), '3.0.0', '<')) {
        $container->extension('doctrine', ['orm' => ['enable_lazy_ghost_objects' => true]]);
    }

    // DBAL 4 always nests transactions with savepoints
    if (version_compare((string) InstalledVersions::getVersion('doctrine/dbal'), '4.0.0', '<')) {
        $container->extension('doctrine', ['dbal' => ['use_savepoints' => true]]);
    }
};
