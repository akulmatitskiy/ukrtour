/**
 * Created by Sevastianov on 03.09.14.
 */
(function($){
    var translate = {
        'Close dialog': 'Закрыть сообщение'
        , 'Need to correct the following errors' : 'Необходимо исправить следующие ошибки'
        , 'Error 400': 'Ошибка проверки данных'
        , 'Error 404': 'Сервер не ответил на запрос'
        , 'Error 500': 'Ошибка сервера'
        , 'Error code {0}. Please don`t panic!' : 'Ошибка {0}. Без паники!'
        , 'Unknown error, please stand by...' : 'Неизвестная ошибка'

        , 'Waiting for a response from the server. Please stay online...' : 'Обмен данными с сервером. Пожалуйста оставайтесь на линии...'
    };

    if ( typeof window._servio != 'undefined' ) {
        window._servio.translate = translate;
    } else {
        $(document).one('servioReady', function(event, servio){
            servio.translate = translate;
            $(document).trigger('servioTranslateReady', 'ru');
        });
    }

})(jQuery);
