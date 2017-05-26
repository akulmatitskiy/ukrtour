/**
 * Created by Sevastianov on 03.09.14.
 */
(function($){
    var translate = {
        'Close dialog': 'Закрити повідомлення'
        , 'Need to correct the following errors' : 'Необхідно виправити наступні помилки'
        , 'Error 400': 'Помилка перевіри даних'
        , 'Error 404': 'Сервер не відповів на запит'
        , 'Error 500': 'Помилка сервера'
        , 'Error code {0}. Please don`t panic!' : 'Помилка {0}. Без паніки!'
        , 'Unknown error, please stand by...' : 'Невідома помилка'

        , 'Waiting for a response from the server. Please stay online...' : 'Обмін даними з сервером. Будь ласка залишайтеся на лінії...'
    };

    if ( typeof window._servio != 'undefined' ) {
        window._servio.translate = translate;
    } else {
        $(document).one('servioReady', function(event, servio){
            servio.translate = translate;
            $(document).trigger('servioTranslateReady', 'uk');
        });
    }

})(jQuery);