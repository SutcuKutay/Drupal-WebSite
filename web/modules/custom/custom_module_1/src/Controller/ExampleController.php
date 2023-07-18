<?php

namespace Drupal\custom_module_1\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines HelloController class.
 */
class ExampleController extends ControllerBase {

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function example() {
    $user = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($user);
    $ad = $currentUser->field_user_name->value;
    $surname = $currentUser->field_user_surname->value;

    return [
      '#type' => 'markup',
      '#attached' => [
        'library' => [
          'custom_module_1/my-css',
        ],
      ],
    ];
  }

}