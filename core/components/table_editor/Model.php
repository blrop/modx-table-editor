<?php

namespace table_editor;

class Model
{
    private static $table_name = 'trainings';
    private static $trainings_parent_id = 36;

    public static function getAllTrainings()
    {
        global $modx;

        $st = $modx->prepare("
            SELECT id, pagetitle AS title
            FROM modx_site_content
            WHERE parent = :parent
        ");
        $st->execute(['parent' => self::$trainings_parent_id]);
        return $st->fetchAll();
    }

    public static function updateRow($id, $fields)
    {
        global $modx;

        $fields = self::emptyToNull($fields);

        $st = $modx->prepare("
            UPDATE " . self::$table_name . "
            SET " . self::makeFieldsString($fields) . "
            WHERE id = :id
        ");
        return $st->execute(array_merge($fields, ['id' => $id]));
    }

    public static function getAllRows()
    {
        global $modx;

        $st = $modx->prepare("
            SELECT *
            FROM " . self::$table_name . "
            ORDER BY date_begin
        ");
        $st->execute();
        return $st->fetchAll();
    }

    public static function addRow($fields)
    {
        global $modx;

        $fields = self::emptyToNull($fields);

        $st = $modx->prepare("
            INSERT INTO " . self::$table_name . "
            SET " . self::makeFieldsString($fields)
        );
        return $st->execute($fields);
    }

    public static function deleteRow($id)
    {
        global $modx;

        $st = $modx->prepare("
            DELETE FROM " . self::$table_name . "
            WHERE id = ?
        ");
        return $st->execute([$id]);
    }

    private static function makeFieldsString($fields)
    {
        return implode(', ', array_map(function($item) {
            return $item . ' = :' . $item;
        }, array_keys($fields)));
    }

    // преобразует пустые строки в массиве в NULL-ы
    private static function emptyToNull($arr)
    {
        return array_map(function($item) {
            if ($item == '') {
                return NULL;
            } else {
                return $item;
            }
        }, $arr);
    }
}