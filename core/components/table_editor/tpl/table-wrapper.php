<link rel="stylesheet" href="/assets/components/table_editor/css/style.css">

<script src="/assets/components/table_editor/js/jquery.js"></script>
<script src="/assets/components/table_editor/js/script.js"></script>

<div class="table-editor-wrapper">
    <h1>Редактор тренингов</h1>
    <table class="js-table-editor-table">
        <tr>
            <th>Тренинг</th>
            <th>Место проведения</th>
            <th>Дата начала и окончания</th>
            <th>Время начала и окончания</th>
            <th>Активен</th>
            <th></th>
        </tr>
        <tbody class="js-table-body">
            <?=$inner?>
        </tbody>
        <tr class="js-table-row add-new" data-id="<?=$id?>">
            <td>
                <select name="training_id">
                    <?php foreach ($trainings as $item): ?>
                        <?php $selected = ($item['id'] == $training_id) ? 'selected'  : ''; ?>
                        <option value="<?=$item['id']?>" <?=$selected?>><?=$item['title']?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <input type="text" name="location">
            </td>
            <td>
                <input type="date" name="date_begin"><br>
                <input type="date" name="date_end">
            </td>
            <td>
                <input type="time" name="time_begin"><br>
                <input type="time" name="time_end">
            </td>
            <td>
                <label><input type="checkbox" name="active"> Активен </label>
            </td>
            <td>
                <span class="button button--save js-add-button">Добавить</span>
                <div class="processing-indicator"></div>
            </td>
        </tr>
    </table>
</div>