$(function () {
    $.extend($.fn.pickadate.defaults, {
        monthsFull: ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'],
        monthsShort: ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'],
        weekdaysFull: ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'],
        today: 'сегодня',
        clear: 'удалить',
        close: 'x',
        firstDay: 1,
        format: 'dd-mm-yyyy',
        formatSubmit: 'dd-mm-yyyy'
    })
});
