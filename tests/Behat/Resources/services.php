<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->defaults()
        ->public();

    // Page Objects
    $services->set(\Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\Documentation\IndexPageInterface::class, \Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\Documentation\IndexPage::class)
        ->private()
        ->parent('sylius.behat.symfony_page');

    $services->set(\Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\Documentation\ShowPageInterface::class, \Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\Documentation\ShowPage::class)
        ->private()
        ->parent('sylius.behat.symfony_page');

    $services->set(\Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\ExtendedDashboardPageInterface::class, \Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\ExtendedDashboardPage::class)
        ->private()
        ->parent('sylius.behat.page.admin.dashboard');

    // Setup Context
    $services->set('tests.threebrs_sylius_documentation.behat.context.setup.docs', \Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Context\Setup\DocumentationContext::class)
        ->public()
        ->args(['%threebrs_sylius_documentation.docs_path%'])
        ->tag('fob.context_service');

    // UI Context
    $services->set('tests.threebrs_sylius_documentation.behat.context.ui.admin.managing_documentation', \Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Context\Ui\Admin\ManagingDocumentationContext::class)
        ->public()
        ->args([
            service(\Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\Documentation\IndexPageInterface::class),
            service(\Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\Documentation\ShowPageInterface::class),
            service(\Tests\ThreeBRS\SyliusDocumentationPlugin\Behat\Page\Admin\ExtendedDashboardPageInterface::class),
            'threebrs_sylius_documentation_admin_image',
            service('behat.mink.default_session'),
            service('router'),
        ])
        ->tag('fob.context_service');
};
