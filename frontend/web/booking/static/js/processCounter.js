/**
 * Created by Sevastianov on 16.09.14.
 */
(function ($) {

    function ProcessCounter(process_id) {

        if (!process_id)
            throw Error('Incorrect initialization process counter');

        this.process_id = process_id;
        this.thread_id = Math.random().toString().split('.')[1];

        $(window).on('beforeunload', $.proxy(this.kill, this));

        this.update();
    }

    ProcessCounter.prototype.update = function () {

        if (!this.process_id) return;

        var key = 'ServioBooking_' + this.process_id,
            counters = Cookies.getJSON(key) || {},
            currtime = (new Date).getTime() / 1000;

        counters[this.thread_id] = currtime;
        for (var thread_id in counters)
            if (counters.hasOwnProperty(thread_id) && counters[thread_id] < currtime - 4)
                delete counters[thread_id];

        Cookies.set(key, counters);
        setTimeout($.proxy(this.update, this), 2000);
    };

    ProcessCounter.prototype.kill = function () {

        if (!this.process_id) return;

        var key = 'ServioBooking_' + this.process_id, counters = Cookies.get(key);
        this.process_id = null;

        delete counters[this.thread_id];

        for (var thread_id in counters)
            if (counters.hasOwnProperty(thread_id)) return;

        Cookies.delete(key);
    };

    $.newProcess = function (id, process) {

        if (process instanceof ProcessCounter) {

            if (process.process_id == id) return process;
            process.kill();
        }
        return new ProcessCounter(id);
    };

})(jQuery);
