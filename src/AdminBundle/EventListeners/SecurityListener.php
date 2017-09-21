<?php

namespace AdminBundle\EventListeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class SecurityListener
 * @package AdminBundle\EventListeners
 */
class SecurityListener implements EventSubscriberInterface
{
    protected const BUNDLE_PATTERN = '/^AdminBundle/';

    protected const HEADER = 'admin';

    protected const HEADER_VALUE = 'test';

    /**
     * @param FilterControllerEvent $event
     * @return void
     * @throws AccessDeniedHttpException
     */
    public function onKernelController(FilterControllerEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->attributes->has('_controller')) {
            return;
        }

        //check headers only for AdminBundle
        $controller = $request->attributes->get('_controller');
        if (preg_match(self::BUNDLE_PATTERN, $controller) !== 1) {
            return;
        }

        //deny access if headers doesn't have valid key and value
        if (!$request->headers->has(self::HEADER) || $request->headers->get(self::HEADER) !== self::HEADER_VALUE) {
            throw new AccessDeniedHttpException();
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => 'onKernelController'];
    }
}