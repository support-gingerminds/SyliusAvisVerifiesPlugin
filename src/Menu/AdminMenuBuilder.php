<?php

declare(strict_types=1);

namespace Ikuzo\SyliusAvisVerifiesPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuBuilder
{
    public function addItems(MenuBuilderEvent $event): void
    {
        /** @var ItemInterface $menu */
        $menu = $event->getMenu()->getChild('marketing');

        $menu
            ->addChild('ikuzo_channel_review', ['route' => 'ikuzo_avis_verifies_admin_channel_review_index'])
            ->setLabel('ikuzo_avis_verifies.menu.channel_review.label')
            ->setLabelAttribute('icon', 'newspaper')
        ;
    }
}
