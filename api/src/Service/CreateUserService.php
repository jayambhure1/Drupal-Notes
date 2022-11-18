<?php

namespace Drupal\api\Service;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Service for createUser API.
 */
class CreateUserService {

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
   *
   * @param Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $date_formatter
   *   The date formatter service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, DateFormatterInterface $date_formatter) {
    $this->entityTypemanager = $entity_type_manager;
    $this->userStorage = $this->entityTypemanager->getStorage('user');
    $this->dateFormatter = $date_formatter;
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
      $container->get('date.formatter')
    );
  }

  /**
   * CreateUserAction() function used for creating user action.
   */
  public function createUserAction($request) {

    $created_user = $failed_user = [];
    $users = Json::decode($request->getContent());

    // Validate and Create user.
    foreach ($users as $user) {

      // Check field validation and creating user.
      $validation_error = $this->validationField($user);
      if ($validation_error) {
        $failed_user[] =
          [
            "message" => $validation_error,
          ];
      }
      else {
        $created_user[] = $this->processcreateuser($user);
      }
    }

    // Createuser API response.
    $response['success'] =
      [
        "message" => "Users created successfully.",
        "count" => count($created_user),
        "ccgid" => $created_user,
      ];

    $response['failure'] =
      [
        "message" => "Failed to create users.",
        "count" => count($failed_user),
        "data" => $failed_user,
      ];

    return $response;
  }

  /**
   * Processcreateuser() function used for creating user in drupal.
   */
  public function processcreateuser($user) {

    // Find username from mail.
    $username = strstr($user['mail'], '@', TRUE);
    $user_details =
      [
        'field_ccgid' => $user['ccgid'],
        'field_first_name' => $user['firstname'],
        'field_last_name' => $user['lastname'],
        'mail' => $user['mail'],
        'name' => $username,
      ];

    // Validate status and roles field.
    $user_details['status'] = (isset($user['status'])) ? $user['status'] : "0";

    // Validate Role using privilege.
    $privilege = strtolower(trim($user["privilege"]));
    switch ($privilege) {
      case 'admin':
        $user_details['roles'] = ['global_admin'];
        break;

      default:
        $user_details['roles'] = ['authenticated'];
        break;
    }

    // Create User Action using user_details array.
    $create_action = $this->userStorage->create($user_details);
    $create_action->save();

    // Find latest user uid.
    $uid = $create_action->id();

    // Gets creted user details.
    $created_user = $this->userStorage->load($uid);
    return $created_user->field_ccgid->value;
  }

  /**
   * ValidationField(): Validate all required fields.
   */
  public function validationField($user) {
    if ($this->missingField($user)) {
      return $this->missingField($user);
    }
    elseif ($this->requiredFields($user)) {
      return $this->requiredFields($user);
    }
    else {
      return "";
    }
  }

  /**
   * MissingField() : Check all required fields.
   */
  public function missingField($user) {
    $missing_fields = [];
    $user_required_fields = ['firstname', 'lastname', 'mail'];
    foreach ($user_required_fields as $key) {
      if (!array_key_exists($key, $user)) {
        $missing_fields[] = $key;
      }
    }
    if (count($missing_fields) > 0) {
      return "Missing Required Fields : " . implode(",", $missing_fields);
    }
  }

  /**
   * RequiredFields() : Validate fields and user.
   */
  public function requiredFields($user) {


    // Email Validation.
    if (!empty($user['mail'])) {
      $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
      if (empty($user["mail"]) || !preg_match($pattern, $user['mail'])) {
        return "mail field Empty or Not Valid";
      }
      else {
        if ($this->userStorage->loadByProperties(['mail' => $user['mail']])) {
          return 'Mail Address Already Registered ';
        }
      }
    }

   
    }
  }

}
