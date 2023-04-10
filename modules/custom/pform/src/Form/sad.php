<?php

namespace Drupal\pform\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ExampleForm extends FormBase {

   /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'my_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nombre'),
      '#required' => TRUE,
      '#pattern' => '[a-zA-Z]+',
      '#description' => $this->t('Este campo es requerido y solo acepta caracteres alfanuméricos.'),
    ];

    $form['identification'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Identificación'),
      '#required' => TRUE,
      '#pattern' => '[0-9]+',
      '#description' => $this->t('Este campo es requerido y solo acepta números.'),
    ];

    $form['birthdate'] = [
      '#type' => 'date',
      '#title' => $this->t('Fecha de nacimiento'),
    ];

    $form['position'] = [
      '#type' => 'select',
      '#title' => $this->t('Cargo'),
      '#options' => [
        'administrador' => $this->t('Administrador'),
        'webmaster' => $this->t('Webmaster'),
        'diseñador' => $this->t('Diseñador'),
      ],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enviar'),
      '#button_type' => 'primary',
    ];

    $form['#prefix'] = '<div class="row">';
    $form['#suffix'] = '</div>';
    $form['name']['#prefix'] = '<div class="col-md-6">';
    $form['name']['#suffix'] = '</div>';
    $form['identification']['#prefix'] = '<div class="col-md-6">';
    $form['identification']['#suffix'] = '</div>';
    $form['birthdate']['#prefix'] = '<div class="col-md-6">';
    $form['birthdate']['#suffix'] = '</div>';
    $form['position']['#prefix'] = '<div class="col-md-6">';
    $form['position']['#suffix'] = '</div>';
    $form['submit']['#prefix'] = '<div class="form-actions">';
    $form['submit']['#suffix'] = '</div>';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $connection = \Drupal::database();
    $nombre = $form_state->getValue('nombre');
    $identificacion = $form_state->getValue('identificacion');
    $fecha_nacimiento = $form_state->getValue('fecha_nacimiento');
    $cargo = $form_state->getValue('cargo');
    $estado = ($cargo == 'Administrador') ? 1 : 0;
    $connection->insert('example_users')
      ->fields([
        'nombre' => $nombre,
        'identificacion' => $identificacion,
        'fecha_nacimiento' => $fecha_nacimiento,
        'cargo' => $cargo,
        'estado' => $estado,
      ])
      ->execute();

      \Drupal::messenger()->addMessage($this->t('Los datos han sido guardados.'), 'status', TRUE);
  }

}