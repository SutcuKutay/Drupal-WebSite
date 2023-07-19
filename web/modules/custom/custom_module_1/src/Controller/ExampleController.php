<?php

namespace Drupal\custom_module_1\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;

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

  public function access() {
    $userID = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($userID);
    $userDepartment = $currentUser->field_user_department->getValue();
    //Bölümü Bilgisayar Mühendisliği olanlar id 10
    foreach ($userDepartment as $key => $value) {
      if ($value['target_id'] == 10) {
        return AccessResult::allowed();
      }
    }
    return AccessResult::forbidden();
  }

  public function access2() {
    $userID = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($userID);
    //$userDepartment = $currentUser->field_user_department->getValue();
    //Bölümü Bilgisayar Mühendisliği olanlar id 10
    // foreach ($userDepartment as $key => $value) {
    //   $taxonomy = \Drupal::entityTypeManager()->getStorage('taxonomy-term')->load($value['target_id']);
    //   dd($taxonomy);
    //   if ($value['target_id'] == 10) {
    //     return AccessResult::allowed();
    //   }
    // }
    $department = $currentUser->get('field_user_department')->referencedEntities();
    dd($department);
    return AccessResult::forbidden();
  }

  public function access3() {
    $userID = \Drupal::currentUser()->id();
    $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($userID);
    $department = $currentUser->get('field_user_department')->referencedEntities();
    foreach ($department as $key => $value) {
      $basvuru = $value->field_department_basvuru->value;
      if ($basvuru == 1) {
        return AccessResult::allowed();
      }
    }
    return AccessResult::forbidden();
  }

}