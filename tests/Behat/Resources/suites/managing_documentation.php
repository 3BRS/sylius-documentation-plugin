<?php

declare(strict_types=1);

use Behat\Config\Config;
use Behat\Config\Filter\TagFilter;
use Behat\Config\Profile;
use Behat\Config\Suite;

return (new Config())
    ->withProfile(
        (new Profile('default'))
            ->withSuite(
                (new Suite('3brs_managing_documentation'))
                    ->withContexts(
                        'sylius.behat.context.hook.doctrine_orm',
                        'sylius.behat.context.setup.channel',
                        'sylius.behat.context.setup.admin_security',
                        'tests.threebrs_sylius_documentation.behat.context.setup.docs',
                        'tests.threebrs_sylius_documentation.behat.context.ui.admin.managing_documentation',
                    )
                    ->withFilter(new TagFilter('@3brs_managing_documentation && @ui')),
            ),
    );
