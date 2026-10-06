<?php

declare(strict_types=1);

use Composer\InstalledVersions;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// ORM 2 generates proxy classes without lazy ghost objects, PHP 8.4 reports them as deprecated; ORM 3 always uses lazy objects
return static function (ContainerConfigurator $container): void {
    if (version_compare((string) InstalledVersions::getVersion('doctrine/orm'), '3.0.0', '<')) {
        $container->extension('doctrine', ['orm' => ['enable_lazy_ghost_objects' => true]]);
    }
};
