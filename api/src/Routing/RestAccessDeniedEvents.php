<?php

namespace Drupal\api\Routing;

use Drupal\Core\Routing\RouteMatch;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Subscriber for REST API Error Message setup for unauthorized users.
 */
class RestAccessDeniedEvents implements EventSubscriberInterface {

  /**
   * Set message for 403 (Forbidden) on access denied exceptions.
   *
   * @param \Symfony\Component\HttpKernel\Event\ExceptionEvent $event
   *   The Exception Event.
   */
  public function accessdeniedmsg(ExceptionEvent $event) {
    $exception = $event->getThrowable();
    $route_name = RouteMatch::createFromRequest($event->getRequest())->getRouteName();
    if ($exception instanceof AccessDeniedHttpException) {
      $route_names = [
        'api.create_user',
      ];
      $route_name = RouteMatch::createFromRequest($event->getRequest())->getRouteName();
      if (!empty($route_name) && in_array($route_name, $route_names)) {
        $response = new JsonResponse(
          [
            'status' => 'false',
            'code' => JsonResponse::HTTP_FORBIDDEN,
            'Message' => "Access Denied.Please authenticate with user having Manager role.",
          ], JsonResponse::HTTP_FORBIDDEN);
        $event->setResponse($response);
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::EXCEPTION][] = ['accessdeniedmsg'];
    return $events;
  }

}
