<?php

/**
 * @file
 * Contains Drupal\custom_module_1\Form\CustomModuleForm.
 */

namespace Drupal\custom_module_1\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class DependencyForm extends FormBase {
    
    public function getFormId() {
        return 'custom_module_1_dependency_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['#prefix'] = '<div id="ajax_form_multistep_form">';
        $form['#suffix'] = '</div>';

        $form['proje_tipi'] = [
            '#type' => 'select',
            '#title' => $this->t('Proje Tipi'),
            '#options' => array(
                0 => t('---SELECT---'),
                'APPLICATION' => t('Application'),
                'DEVELOPMENT' => t('Development'),
                'ENHANCEMENT' => t('Enhancement'),
            ),
            '#ajax' => array(
                'wrapper' => 'ajax_form_multistep_form',
                'callback' => '::ajax_form_multistep_form_ajax_callback',
                'event' => 'change',
            ),
        ];

        $form['proje_suresi'] = [
            '#type' => 'select',
            '#title' => $this->t('Proje Süresi'),
            '#options' => array(),
            '#states' => [
                'visible' => [
                  ':input[name="proje_tipi"]' => ['!value' => 0],
                ],
              ],
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {

    }

    public function ajax_form_multistep_form_ajax_callback(array &$form, FormStateInterface $form_state) {
        $proje_tipi = $form_state->getValue('proje_tipi');
        if($proje_tipi == "APPLICATION") {
            $options = array(
                t('3 ay'),
                t('6 ay'),
                t('9 ay'),
            );
        }
        else if($proje_tipi == "DEVELOPMENT") {
            $options = array(
                t('1 hafta'),
                t('2 hafta'),
                t('3 hafta'),
            );
        }
        else {
            $options = array(
                t('1 yıl'),
                t('2 yıl'),
                t('3 yıl'),
            );
        }
        $form['proje_suresi']['#options'] = $options;
        return $form;
      }
}