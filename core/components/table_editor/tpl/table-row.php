<tr class="js-table-row" data-id="<?=$id?>">
    <td>
        <select name="training_id">
            <?php foreach ($trainings as $item): ?>
                <?php $selected = ($item['id'] == $training_id) ? 'selected'  : ''; ?>
                <option value="<?=$item['id']?>" <?=$selected?>><?=$item['title']?></option>
            <?php endforeach; ?>
        </select>
    </td>
    <td>
        <input type="text" name="location" value="<?=$location?>">
    </td>
    <td>
        <input type="date" name="date_begin" value="<?=$date_begin?>"><br>
        <input type="date" name="date_end" value="<?=$date_end?>">
    </td>
    <td>
        <input type="time" name="time_begin" value="<?=$time_begin?>"><br>
        <input type="time" name="time_end" value="<?=$time_end?>">
    </td>
    <td>
        <?php $checked = $active ? 'checked'  : ''; ?>
        <label><input type="checkbox" name="active" <?=$checked?>> Активен </label>
    </td>
    <td>
        <span class="button button--save js-save-button" style="display: none;">Сохранить</span>
        <span class="button button--delete js-delete-button">Удалить</span>
        <div class="processing-indicator"></div>
    </td>
</tr>