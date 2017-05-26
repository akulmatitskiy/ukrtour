/**
 * Created by Andrej on 27.08.14.
 */
(function ($) {
    /**
     * Servio
     * @constructor
     */
    function Servio() {

        this.domBaseElement = $('#servioBooking')
        if (this.domBaseElement.length == 0) this.domBaseElement.length = $(document);
        if (this.domBaseElement.length == 0) throw new Error('Undefined base dom element');

        this.translate = {};

        // Sidebar element
        //this.form = this.domBaseElement.find('#servio-search-form').first();

        this.data = {};

        // Ajax response dom element
        this.searchResult = this.domBaseElement.find('#servioBookingContent').first();

        this.groupSelectRoom = null;

        this.setupEventsListeners();

        //var tt = $('#servioHotelId');
        //if (tt.length) tt.tooltip({ position: {my: "left+15 center", at: "right center"} });

        if (window.history && history.pushState) {

            $(window).on('popstate', $.proxy(
                function (e) {

                    console.log(e);
                    e.preventDefault();
                    this.sendRequest('GET', (history.location || document.location).href);
                },
                this));
        }

        // Single search process on every open tab/window
        var searchHash = (/[\\?&]searchHash=([^&#]*)/.exec(location.search));
        this.currentProcess = searchHash && searchHash.length > 1
            ? $.newProcess(decodeURIComponent(searchHash[1].replace(/\+/g, " ")), this.currentProcess)
            : null;

        this.triggerReadyEvent();
    }

    /**
     * Translate message
     * @returns {XML|string|void}
     * @private
     */
    Servio.prototype._ = function () {

        if (arguments.length == 0) throw Error('Incorrect call translate method');

        var args = Array.prototype.slice.call(arguments), message = args.shift();
        if (typeof this.translate != 'undefined' && this.translate.hasOwnProperty(message)) message = this.translate[message];
        return message.replace(/{(\d+)}/g, function (match, number) { return typeof args[number] != 'undefined' ? args[number] : match; });
    };

    /**
     * Setup event listeners for all servio elements
     */
    Servio.prototype.setupEventsListeners = function () {

        //$(window).on('resize', $.proxy(this.calculateSearchRoomsListSize, this));

        //$('#servioSearchRoomsList .panel-collapse.collapse').on('show.bs.collapse hidden.bs.collapse', $.proxy(this.calculateSearchRoomsListSize, this));

        // Select room
        this.searchResult.on('click', 'button.servio-room-select.servio-button-right', $.proxy(this.selectRoomHandler, this));

        // Ajax forms
        this.domBaseElement
            .on('submit', $.proxy(this.formSubmitHandler, this))
            .on('click', 'a[data-ajax-link]', $.proxy(this.linkClickHandler, this))
            .on('click', 'a.servio-contract-select', $.proxy(this.contractSelectHandler, this));

        // Change contract condition
        this.domBaseElement.on('change', '#contractId', function (event) {

            var el = $(event.currentTarget);

            var payTypes = el.find(":selected").data('paytypes');
            payTypes = (payTypes ? payTypes.split('|') : [100, 200, 300]);

            $('[name=search\\[payType\\]]').each(function (i, radio) {

                var el = $(radio);
                if ($.inArray(el.val(), payTypes) >= 0) {
                    el.removeAttr('disabled');
                }
                else {
                    el.attr('disabled', 'disabled').prop("checked", false);
                }
            });
        });

        // Transfer
        this.domBaseElement.on('change', '#transferForm select[data-toggle="transfer-place"]',
            function (event) {

                var el = $(event.currentTarget),
                    selectedPlace = el.val(),
                    transferType = el.parents('#transferForm').find('[name="Transfer[type]"]').val();

                el.parents('#transferForm').find('[data-transfer-place]').each(function (i, el) {

                    el = $(el);
                    if (el.data('transfer-place') == selectedPlace) {

                        el.show().removeAttr('disabled');
                        el.find('option').each(function (e, el) {

                            el = $(el);
                            if (el.data(transferType)) {
                                el.removeAttr('disabled');
                            }
                            else {
                                el.attr('disabled', true);
                            }
                        });
                        el.trigger('change');
                    }
                    else {
                        el.hide().attr('disabled', true);
                    }
                });
            });

        this.domBaseElement.on('change', '#transferForm', function (event) {

            var form = $(this),
                submit = form.find('[type="submit"]');

            var seats = form.find('[name="Transfer[seats]"]').val(),
                type = form.find('[name="Transfer[type]"]').val(),
                place = form.find('[data-toggle="transfer-place"]').val();

            var transfer = form.find('[data-transfer-place=' + place + '] option:selected');

            var cost = transfer.data(type);
            if (cost) {

                var count = Math.max(1, Math.ceil(seats / transfer.data('seats')));
                if (count > 1) cost = count + ' x ' + cost;

                form.find('#transferCost').html(cost);
                submit.removeAttr('disabled');
            }
            else {

                submit.attr('disabled', true);
            }
        });

        $(document).one('servioTranslateReady', function (event, lang) {

            // Set related datepickers
            var inputDateArrival = $('#servioDateArrival');
            var inputDateDeparture = $('#servioDateDeparture');

            inputDateDeparture.datetimepicker({
                dayOfWeekStart: 1,
                closeOnDateSelect: true,
                format: 'd.m.Y H:i',
                lang: lang,
                minDate: '0'
            });

            inputDateArrival.datetimepicker({
                dayOfWeekStart: 1,
                closeOnDateSelect: true,
                format: 'd.m.Y H:i',
                minDate: '0',
                lang: lang,
                onChangeDateTime: function (a, input) {

                    var arrivalDate = new Date(input.val().replace(/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})/, '$2/$1/$3'));
                    var departureDate = new Date(inputDateDeparture.val().replace(/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})/, '$2/$1/$3'));
                    var newDepartureDate = new Date(arrivalDate.getTime() + 79200000);

                    inputDateDeparture.datetimepicker({
                        dayOfWeekStart: 1,
                        closeOnDateSelect: true,
                        format: 'd.m.Y H:i',
                        lang: lang,
                        minDate: newDepartureDate
                    });
                    if (arrivalDate >= departureDate) {

                        inputDateDeparture.val(
                            ('0' +  newDepartureDate.getDate().toString()).substr(-2) + '.' +
                            ('0' + (newDepartureDate.getMonth() + 1).toString()).substr(-2) + '.' + newDepartureDate.getFullYear() + ' ' +
                            ('0' +  newDepartureDate.getHours()).toString().substr(-2) + ':' +
                            ('0' +  newDepartureDate.getMinutes()).toString().substr(-2)
                        );
                    }
                }
            });
        });
    };

    /**
     * Change size of room list
     */
    Servio.prototype.calculateSearchRoomsListSize = function () {

        /*var control = $('#servioSearchRoomsList', this.searchResult);
        if (control.length) {

            var control_height = control.height(), visible = $('.collapse.in', control),
                visible_body = $('.panel-body', visible), visible_body_offset = visible_body.offset(),
                visible_height = 0, calc_height = control_height - visible_body_offset;

            visible.each(function() { visible_height += $(this).height(); });
            if (visible_height > control_height) visible.height(calc_height);

            //visible.each(function() { $(this).height(visible_height - ); });
         }*/

        /*var servioSearchRoomsList = this.searchResult.find('#servioSearchRoomsList');
        if (servioSearchRoomsList) {

            var formHeight = this.form.height();
            var listHeight = servioSearchRoomsList.height();

            var minHeight = formHeight - (this.searchResult.height() - listHeight);

            servioSearchRoomsList.css('height',
                Math.max(300, minHeight, ($(window).height() - ( $('html').height() - listHeight))) + 'px');
            servioSearchRoomsList.accordion("refresh");
        }*/
    };

    Servio.prototype.selectRoomHandler = function (event) {

        var btn = $(event.currentTarget),
            room_id = btn.data('room-id'),
            group_id = btn.data('room-group'),
            room = $('#group' + group_id + '-room' + room_id);

        //var groupList = $('.room-group[data-room-group=' + group_id + ']'),
        //    tabs = $('#servioSearchTabs'), rooms_panel = $('#servioSearchRoomsList'), tabs_panel = $('#servioSearchRooms');

        var curr_head = $('#groupPage' + group_id).removeClass('panel-default panel-primary').addClass('panel-success');
        var curr_body = $('.panel-collapse.collapse', curr_head);
        if (curr_body.length) curr_body.collapse('hide');

        $('#groupSpan' + group_id).html(room.data('room-title') + ' ' + room.data('room-price'));
        $('#groupRoom' + group_id).val(room_id);

        //this.groupSelectRoom.filter('[name = "selectedRoom\\[' + group_id + '\\]" ]').val(room_id);

        //var tabs_height = tabs.height();


        /*var change = tabs.height() - tabs_height;
        if (change) {

            tabs_panel.height(tabs_panel.height() + change);
            o = rooms_panel.offset();
            o.top += change;
            rooms_panel.offset(o);
        }*/

        //if ($('[name ^= "selectedRoom"][value="0"]').length == 0) $('#btnNext').removeAttr('disabled');

        var togo = $('.servio-page.panel.panel-default');
        if (togo.length) {

            var next_head = $(togo[0]);
            next_head.addClass('panel-primary');

            var next_body = $('.panel-collapse.collapse', next_head);
            if (next_body.length) next_body.collapse('show');
        }
        return !togo.length;//this.groupSelectRoom.length == 1;
    };

    /**
     * @param event
     * @returns {boolean}
     */
    Servio.prototype.linkClickHandler = function (event) {

        var link = $(event.target);
        this.sendRequest('GET', link.attr('href'), {}, link);

        return false;
    };

    /**
     * @param event
     * @returns {boolean}
     */
    Servio.prototype.formSubmitHandler = function (event) {

        //var message = checkDates($('#servioDateArrival').val(), $('#servioDateDeparture').val());
        //if (message) { Alert(message[0], message[1]); return false; }

        var form = $(event.target);
        var action = form.attr('action');

        if (action.indexOf(location.protocol + "//" + window.location.hostname) === 0) {

            var confirmCheckbox = form.find('input[type="checkbox"][required]');

            if (confirmCheckbox.length > 0 && !confirmCheckbox.is(':checked')) {
                confirmCheckbox.focus();
            }
            else {
                this.sendRequest(form.attr('method'), action, form.serialize(), form);
            }
            return false;
        }
    };

    Servio.prototype.contractSelectHandler = function (event) {

        //var message = checkDates($('#servioDateArrival').val(), $('#servioDateDeparture').val());
        //if (message) { Alert(message[0], message[1]); return false; }

        var link = $(event.target);
        this.sendRequest('POST', location.href, 'actualize=1&search[contractId]='+link.data('id'));
        return false;
    };

    /**
     * @param method
     * @param url
     * @param data
     * @param element
     */
    Servio.prototype.sendRequest = function (method, url, data, element) {

        var title = (typeof element != 'undefined' && element.data('loader'))
            ? element.data('loader')
            : this._('Waiting for a response from the server. Please stay online...');

        var loader = $.loaderAjax(title);
//        this.pushHistory(url, title);

        data = data || {};
        $.ajax(url, {
            method: method,
            data: data,
            dataType: 'json',
            complete: $.proxy(this.ajaxCompleteHandler, this, loader, url),
            success: $.proxy(this.ajaxSuccessHandler, this)
        });
    };

    /**
     *
     * @param response
     */
    Servio.prototype.ajaxSuccessHandler = function (response) {

        if (response.result.content) {

            this.searchResult.html(response.result.content);
        }
        else {

            //$('#ajaxLoaderSpinner').fadeOut(62).removeClass('fa-spinner').addClass('fa-flip-horizontal').fadeIn(100);

            if (response.result.redirect) {

                window.location = response.result.redirect;
                //this.sendRequest('GET', response.result.redirect);
            }
            else {

                if (response.result.handler) {

                    if (typeof this[response.result.handler] == 'function') {

                        this[response.result.handler](response);
                    }
                    else {

                        this.triggerError('Undefined response handler');
                    }
                }
            }
        }
        this.triggerReadyEvent();
    };

    Servio.prototype.ajaxCompleteHandler = function (loader, url, response, textStatus) {

        if (textStatus != 'success') {

            if (response.status == 200 && !!response.responseText) {

                document.open();
                document.write(response.responseText);
                document.close();
            }
            else {

                if (response.responseJSON && response.responseJSON.errorMessages) {
                    this.triggerError(response.responseJSON.errorMessages, response.status);
                }
                else {
                    this.triggerError(response.responseText, response.status);
                }
            }
        }
        else {

            if (response.responseJSON.result) {

                if (response.responseJSON.result.title) {
                    this.pushHistory(url, response.responseJSON.result.title);
                }
                if (response.responseJSON.result.searchHash) {
                    this.currentProcess = $.newProcess(response.responseJSON.result.searchHash, this.currentProcess);
                }
            }
        }
        this.triggerReadyEvent();

        if (loader &&
            typeof response.result.redirect === 'undefined' &&
            typeof response.responseJSON.result.redirect === 'undefined') {

            loader.close();
        }
    };

    /**
     * triggerError - created jquery dialog alert with message
     * @param errorMessage
     * @param errorCode
     * @param dialogOptions
     */
    Servio.prototype.triggerError = function (errorMessage, errorCode, dialogOptions) {

        errorCode = errorCode || false;
        dialogOptions = dialogOptions || {};

        var title = errorCode
            ? (this.translate['Error ' + errorCode]
                ? this._('Error ' + errorCode)
                : this._('Error code {0}. Please don`t panic!', errorCode))
            : this._('Unknown error, please stand by...');

        var error = $(errorMessage);
        if (typeof errorMessage == 'object') {

            error = $('<div>').css('padding', '15px 20px 0 20px');
            var addError = function(head, text) {
                error.append(
                    $('<div>', {role: 'alert'}).addClass('alert alert-danger').append([
                        $('<h4>').addClass('group-item-heading').append($.parseHTML(head)),
                        $('<p>').addClass('group-item-text').append($.parseHTML(text))
                    ])
                );
            };
            for (var idx in errorMessage) {

                var msg = errorMessage[idx],
                    doc = $('.servio-error-message', $.parseHTML(msg));
                if (doc.length) {
                    doc.each(function () {
                        var str = $(this).text().split('<pre>', 2);
                        addError($.trim(str[0]), '<pre style="word-wrap: normal">' + str[1]);
                    });
                }
                else {
                    var str = msg.split(': <pre>', 2);
                    addError($.trim(str[0]), str.length < 2 ? '' : '<pre style="word-wrap: normal">' + str[1]);
                }
            }
        }
        BootstrapDialog.show({
            title: title,
            message: error,
            size: BootstrapDialog.SIZE_WIDE,
            type: BootstrapDialog.TYPE_DANGER
        });
    };

    Servio.prototype.triggerReadyEvent = function () {

        $(document).trigger('servioReady', this);
    };

    Servio.prototype.pushHistory = function (url, title, obj) {

        document.title = title;
        if (window.history && history.pushState) {

            obj = obj || {};
            if (url != window.location.href) {
                history.pushState(obj, title, url);
            }
            else {
                history.replaceState(obj, title, url);
            }
        }
    };

    $(document).ready(function () {

        window._servio = new Servio();
    });

})(jQuery);
