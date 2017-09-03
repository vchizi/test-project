<?php

namespace System\Routing\EventListeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RouterListener
 * @package System\Routing\EventListener
 */
class RouterListener implements EventSubscriberInterface
{
    protected const PATH_INFO_PATTERN = '/\/(\w+)\/(\w+)\/(\w+)/';

    /**
     * @param GetResponseEvent $event
     * @throws NotFoundHttpException
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->attributes->has('_controller')) {
            // routing is already done
            return;
        }

        //parse path info
        if (preg_match(self::PATH_INFO_PATTERN, $request->getPathInfo(), $matches) === 1) {
            list($url, $bundle, $controller, $action) = $matches;

            $bundle = ucfirst($bundle) . 'Bundle';
            $controller = ucfirst($controller) . 'Controller';
            $action = $action . 'Action';

            $fqcn = $bundle . '\\Controller' . '\\' . $controller;

            //check controller and action exists and executable
            if (class_exists($fqcn) && method_exists(new $fqcn, $action) && is_callable(array($fqcn, $action))) {
                $request->attributes->add([
                    '_controller' => $fqcn . '::' . $action,
                ]);

                return;
            }
        }

        $message = sprintf('No route found for "%s %s"', $request->getMethod(), $request->getPathInfo());
        if ($referer = $request->headers->get('referer')) {
            $message .= sprintf(' (from "%s")', $referer);
        }

        throw new NotFoundHttpException($message);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 100]]
        ];
    }
}