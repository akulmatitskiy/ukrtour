/**
 * Created by Sevastianov on 03.09.14.
 */
(function($){
    var translate = {
        'Close dialog': 'Close message'
        , 'Need to correct the following errors' : 'Need to correct following errors:'
        , 'Error 400': 'Checking data error'
        , 'Error 404': 'Server responce error'
        , 'Error 500': 'Server error'
        , 'Error code {0}. Please don`t panic!' : 'Error {0}. Don`t panic!'
        , 'Unknown error, please stand by...' : 'Unknown error'

        , 'Waiting for a response from the server. Please stay online...' : 'Waiting for a response from the server. Please stay online...'
    };

    if ( typeof window._servio != 'undefined' ) {
        window._servio.translate = translate;
    } else {
        $(document).one('servioReady', function(event, servio){
            servio.translate = translate;
            $(document).trigger('servioTranslateReady', 'en');
        });
    }

})(jQuery);
