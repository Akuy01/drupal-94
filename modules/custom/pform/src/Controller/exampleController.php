<?php

namespace Drupal\pform\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

class exampleController extends ControllerBase {

    public function content() {
        $header = [
          'Nombre',
          'Identificación',
          'Fecha de nacimiento',
          'Cargo',
          'Estado',
          'Acciones',
        ];
    
        $query = \Drupal::database()->select('example_users', 'e');
        $query->fields('e', ['nombre', 'identificacion', 'fecha_nacimiento', 'cargo', 'estado']);
        $result = $query->execute()->fetchAll();
    
        $rows = [];
        foreach ($result as $row) {
          $edit_link = Url::fromRoute('nombremodulo.edit', ['id' => $row->identificacion]);
          $delete_link = Url::fromRoute('nombremodulo.delete', ['id' => $row->identificacion]);
          $actions = EntityInterface::link('Editar',$edit_link) . ' | ' . \Drupal::l('Eliminar', $delete_link);
          $rows[] = [
            $row->nombre,
            $row->identificacion,
            $row->fecha_nacimiento,
            $row->cargo,
            $row->estado ? 'Activo' : 'Inactivo',
            //$actions,
          ];
        }

        $build = [
          '#type' => 'table',
          '#header' => $header,
          '#rows' => $rows,
          '#empty' => $this->t('No se encontraron registros.'),
          '#attributes' => [
            'class' => ['table', 'table-striped', 'table-bordered'],
          ],
        ];

        return [
            'table' => $build,
          ];
      }

}