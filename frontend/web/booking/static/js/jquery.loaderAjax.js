(function ($) {

    function LoaderAjax(messageText) {

        this.messageBox =
            $('<div class="ajaxLoaderMessage"><h2 class="text-center"><i id="ajaxLoaderSpinner" class="fa fa-spinner fa-spin"></i></h2><!--img src="/booking/static/img/ajax-loader.gif"/--></div>');
        this.modal = $('<div class="ajaxLoader"></div>');
        this.text = $('<p></p>');

        this.text.prependTo(this.messageBox);

        if (messageText) this.open(messageText);
    }

    LoaderAjax.prototype.open = function (messageText) {

        this.close();
        this.text.text(messageText);

        $('body').append(this.modal).append(this.messageBox);

        return this;
    };

    LoaderAjax.prototype.close = function () {

        this.messageBox.detach();
        this.modal.detach();
    };

    $.loaderAjax = function (messageText) {

        return new LoaderAjax(messageText);
    };

}(jQuery));
