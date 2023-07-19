<?php

/**
 * @file
 * Contains Drupal\edit_profile_module\Form\CustomModuleForm.
 */

namespace Drupal\edit_profile_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class EditForm extends FormBase {
    
    public function getFormId() {
        return 'edit_profile_module_config_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        // $user = \Drupal::currentUser()->id();
        $uid = \Drupal::routeMatch()->getParameter('uid');
        $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($uid);

        $name = $currentUser->field_user_name->value;
        $surname = $currentUser->field_user_surname->value;

        $form['isim'] = [
            '#type' => 'textfield',
            '#title' => $this->t('isim'),
            '#required' => TRUE, // bu alanı zorunlu yapar
            '#default_value' => $name,
        ];

        $form['soyad'] = [
            '#type' => 'textfield',
            '#title' => $this->t('soyad'),
            '#required' => TRUE, // bu alanı zorunlu yapar
            '#default_value' => $surname,
        ];

        $form['submit'] =  [
            '#type' => 'submit',
            '#value' => $this->t('submit'),
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state) {
        $isim = $form_state->getValue('isim');
        if ($isim == '') {
            $form_state->setErrorByName('isim', $this->t('İsim alanı boş bırakılamaz!'));
        }
        $soyad = $form_state->getValue('soyad');
        if ($soyad == '') {
            $form_state->setErrorByName('soyad', $this->t('Soyad alanı boş bırakılamaz!'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $uid = \Drupal::routeMatch()->getParameter('uid');
        $isim = $form_state->getValue('isim');
        $soyad = $form_state->getValue('soyad');
        // $userID = \Drupal::currentUser()->id();
        $currentUser = \Drupal::entityTypeManager()->getStorage('user')->load($uid);
        // $currentUser->set('Ad', $isim);
        // $currentUser->set('Soyad', $soyad);
        $currentUser->field_user_name->value = $isim;
        $currentUser->field_user_surname->value = $soyad;
        $currentUser->save();
        $this->messenger()
        ->addStatus($this->t('Profil başarıyla değiştirildi.'));
    }
}