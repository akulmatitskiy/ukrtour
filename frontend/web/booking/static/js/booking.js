
    Twig.extendFunction("_", function (section, key, arg) {

        if (typeof arg === 'undefined') {

            arg = '';
        }
        else {

            if (typeof arg === 'Array') {

                var args = arg;
                arg = '';
                for (var a in args) arg += (!arg ? '' : ', ') + a.toString();
            }
        }
        return key + (!arg ? '' : '(' + arg + ')');
    });
