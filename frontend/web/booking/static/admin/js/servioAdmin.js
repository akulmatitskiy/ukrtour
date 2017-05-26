/**
 * Created by Sevastianov on 29.10.14.
 */

// Helper: Assets Loader
var ServioLoadAsset = {
    script : function(id, src, onload){
        var js, fjs = document.getElementsByTagName('script')[0];
        if (!document.getElementById(id)) {
            js = document.createElement('script');
            js.id = id;
            js.src = src;
            if ( typeof onload == 'function' ) {$(js).on('load', onload);}
            fjs.parentNode.insertBefore(js, fjs);
        }
        return js;
    },

    style : function(id, href, onload){
        var css, fcss = document.getElementsByTagName('link')[0];
        if (!document.getElementById(id)){
            css = document.createElement('link');
            css.id = id;
            css.href = href;
            css.rel = 'stylesheet';
            if ( typeof onload == 'function' ) {$(css).on('load', onload);}
            fcss.parentNode.insertBefore(css, fcss);
        }
        return css;
    }
};

(function($){
    $(document).ready(function(){
        // Assets directory
        window.SERVIO_STATIC_URL = (function(scripts){
            for ( var i in scripts ) {
                if ( scripts.hasOwnProperty(i) && /admin\/js\/servioAdmin.js/.test(scripts[i].src) ) {
                    return scripts[i].src.substr(0, scripts[i].src.length - 'admin/js/servioAdmin.js'.length)
                }
            }

            return '/';
        })(document.getElementsByTagName('script'));

        // Initialization TB.tooltips
        $('body').tooltip({selector: "[data-toggle*=tooltip]",container: "body"});

        // Initialization wysihtml5
        var textAreas = $('.wysiwyg');
        if ( textAreas.length > 0 ) {
            ServioLoadAsset.style('bootstrap3-wysihtml5', SERVIO_STATIC_URL + 'admin/css/bootstrap3-wysihtml5.min.css', function(){
                ServioLoadAsset.script('bootstrap3-wysihtml5.all', SERVIO_STATIC_URL + 'admin/js/bootstrap3-wysihtml5.all.min.js', function(){
                    ServioLoadAsset.script('bootstrap-wysihtml5.ru-RU', SERVIO_STATIC_URL + 'admin/js/bootstrap-wysihtml5.ru-RU.js', function(){
                        textAreas.wysihtml5({locale:'ru-RU',toolbar:{html:true,fa:true}});
                    });
                });
            });
        }

        // Button.js plugin: change .btn color active radio button
        $('.btn-toggle').on('click', '.btn', function(e) {
            e.stopImmediatePropagation();
            $(this).button('toggle');

            $(e.delegateTarget).find('.btn').each(function(i, btn){
                var el = $(btn);
                if ( el.hasClass('active') ) {
                    el.addClass('btn-' + (el.data('btn-active') || 'primary'));
                } else {
                    el.removeClass('btn-' + (el.data('btn-active') || 'primary'));
                }
            });
        });

        //
        var switchEditable = function(){
            var el = $(this);
            $(el.data('target') || el.parent())
                .toggleClass('switched')
                .find('.switchedEnable').each(function(){
                    var e = $(this);
                    (e.attr('disabled')?e.removeAttr('disabled'):e.attr('disabled', true));
                });
        };
        $('html')
            .on('click', '.btn[data-toggle*="switchEditable"]', switchEditable)
            .on('dblclick', '[data-toggle*="switchEditable"]', switchEditable);

    });
})(jQuery);
