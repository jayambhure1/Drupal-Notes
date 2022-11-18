<?php

namespace Drupal\cmacgm_api\Controller;

use Drupal\cmacgm_api\Service\CreateUserService;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller routines for cmacgm_api routes.
 */
class APIController extends ControllerBase {

  /**
   * The CreateUser service.
   *
   * @var Drupal\cmacgm_api\Service\CreateUserService
   */
  protected $createUserService;

  /**
   * The node user storage.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypemanager;

  /**
   * The node user storage.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $userEntity;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Class constructor.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager,
        DateFormatterInterface $date_formatter,
        CreateUserService $create_user_service,
    ) {
    $this->entityTypemanager = $entity_type_manager;
    $this->userStorage = $this->entityTypemanager->getStorage('user');
    $this->dateFormatter = $date_formatter;
    $this->createUserService = $create_user_service;
  }

  /**
   * {@inheritdoc}
   */

  /**
   * Load the service required to construct this class.
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('entity_type.manager'),
          $container->get('date.formatter'),
          $container->get('cmacgm_api.create_user'),
      );
  }

  /**
   * CreateUser() function used for create user API.
   */
  public function createUser(Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
      $response = $this->createUserService->createUserAction($request);
    }
    else {
      $response['status'] = 'false';
      $response['message'] = 'Content-Type not Matched';
    }
    return new JsonResponse($response);
  }


}
