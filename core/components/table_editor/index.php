<?php

/*
Редактор таблиц.
Игорь Силуянов, 11.02.2017

Добавление нового поля:
    - добавить поле в таблицу БД
    - добавить поле в шаблон строки и шаблон добавления новой строки
    - всё, дальше всё должно работать (вроде бы)

Делаем поле обязательным:
    - добавить его в код функции requiredValuesOk
*/

namespace table_editor;

require 'Tpl.php';
require 'Model.php';

$tpl = new Tpl(__DIR__ . '/tpl');

$action = isset($_POST['action']) ? $_POST['action'] : '';
$action_params = isset($_POST['params']) ? $_POST['params'] : [];

function getTableBody($tpl, $trainings)
{
    $output = '';
    foreach (Model::getAllRows() as $row) {
        $output .= $tpl->render('table-row', array_merge($row, ['trainings' => $trainings]));
    }
    return $output;
}

switch ($action) {
    case 'save':
        if (!isset($action_params['id']) || !isset($action_params['values'])) {
            throw new \Exception('Not enough params for save action');
        }

        $id = $action_params['id'];
        $values = $action_params['values'];

        echo json_encode([
            'success' => Model::updateRow($id, $values)
        ]);
        break;

    case 'add':
        if (!isset($action_params['values'])) {
            throw new \Exception('Not enough params for add action');
        }

        $values = $action_params['values'];

        if (!Model::addRow($values)) {
            throw new \Exception("Could not add row");
        }

        // выводим таблицу
        $trainings = Model::getAllTrainings();
        echo getTableBody($tpl, $trainings);
        break;

    case 'delete':
        if (!isset($action_params['id'])) {
            throw new \Exception('Not enough params for delete action');
        }

        $id = $action_params['id'];

        if (!Model::deleteRow($id)) {
            throw new \Exception("Could not delete row with id = $id");
        }

        // выводим таблицу
        $trainings = Model::getAllTrainings();
        echo getTableBody($tpl, $trainings);
        break;

    default:
        $trainings = Model::getAllTrainings();
        $inner = getTableBody($tpl, $trainings);
        return $tpl->render('table-wrapper', ['inner' => $inner, 'trainings' => $trainings]);
}
