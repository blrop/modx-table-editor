$(function() {
    function ajaxHandler(action, params, success) {
        $.ajax({
            url: '/assets/components/table_editor/connector.php',
            data: {
                action: action,
                params: params
            },
            method: 'post',
            success: success,
            fail: function(s) {
                console.log('Ajax request failed: ' + s);
            }
        });
    }

    // получить объект со значениями всех полей строки таблицы
    function getRowValues(tr) {
        var allFields = {};
        tr.find('input, select').each(function() {
            var $this = $(this);
            var val;
            if ($this.prop('type') == 'checkbox') {
                val = $this.prop('checked') ? '1' : '0';
            } else {
                val = $(this).val();
            }
            allFields[$this.prop('name')] = val;
        });
        return allFields;
    }
    
    // проверка на заполненность необходимых полей
    function requiredValuesOk(values) {
        return values.date_begin && values.time_begin;
    }
    
    var tableWrapper = $('.table-editor-wrapper');
    
    // ограничение высоты таблицы
    var maxHeight = $(window).height() - tableWrapper.offset().top - 50;
    if (tableWrapper.outerHeight(true) > maxHeight) {
        tableWrapper.css('max-height', maxHeight);
    }
    
    // сохранение записи
    tableWrapper.on('click', '.js-save-button', function() {
        var tr = $(this).parents('.js-table-row');
        var values = getRowValues(tr);
        if (!requiredValuesOk(values)) {
            return;
        }

        tr.addClass('js-processing');

        var saveButton = $(this);
        ajaxHandler('save', {
            id: tr.data('id'),
            values: values
        }, function() {
            tr.removeClass('js-processing');
            saveButton.hide();
        });
    });

    // удаление записи
    tableWrapper.on('click', '.js-delete-button', function() {
        var tr = $(this).parents('.js-table-row');
        tr.addClass('js-processing');
        ajaxHandler('delete', {
            id: tr.data('id')
        }, function(response) {
            tr.removeClass('js-saving');
            $('.js-table-body').html(response);
        });
    });

    // добавление записи
    tableWrapper.on('click', '.js-add-button', function() {
        var tr = $(this).parents('.js-table-row');
        var values = getRowValues(tr);
        if (!requiredValuesOk(values)) {
            return;
        }
        
        tr.addClass('js-processing');

        ajaxHandler('add', {
            values: values
        }, function(response) {
            tr.removeClass('js-processing');
            $('.js-table-body').html(response);
        });
    });
    
    // показываем кнопку созранить при изменении какого-либо поля в строке
    $('.js-table-row').find('input, select').change(function() {
        $(this).parents('.js-table-row').find('.js-save-button').show();
    });
});