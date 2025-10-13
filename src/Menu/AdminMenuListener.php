<?php

declare(strict_types=1);

namespace ThreeBRS\SyliusDocumentationPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class AdminMenuListener implements EventSubscriberInterface
{
    public function __construct(
        private TranslatorInterface $translator,
        private string $documentationIndexRoute = 'threebrs_sylius_documentation_admin_index',
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.menu.admin.main' => 'addDocumentationMenuItem',
        ];
    }

    public function addDocumentationMenuItem(MenuBuilderEvent $event): void
    {
        $event->getMenu()
            ->addChild('threebrs_documentation_plugin', [
                'route' => $this->documentationIndexRoute,
            ])
            ->setLabel($this->translator->trans('threebrs_documentation_plugin.ui.admin.documentation.menu_title'))
            ->setLabelAttribute('icon', 'tabler:book');
    }
}
