<?php

namespace HH\IceCreamBundle\EventListener;

use HH\IceCreamBundle\Service\IceCreamService;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class IceCreamListener
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function onTerminate(PostResponseEvent $event)
    {
        /** @var Request $request */
        $request = $event->getRequest();
        $device = $request->get('deviceId');
        if ($device !== 'iceCream_1') {
            return;
        }
        $IceCreamService = $this->getIceCreamService();
        $type = $request->get('type');
        $IceCreamService->processIceCream($request, $type, $device);
    }

    /**
     * @return IceCreamService
     */
    private function getIceCreamService()
    {
        return $this->container->get('hh_ice_cream.ice_cream_service');
    }
}
