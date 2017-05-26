function Alert(text, title, isok) {

    jQuery("#alert").html(text).dialog({modal: true, title: title, width: '475px', height: '165px'});
}

function checkDates(date1, date2, hotel) {

    if (!date1 || !date2) return true;

    date1 = new Date(date1.substr(6,4), parseInt(date1.substr(4,2))-1, date1.substr(0,2));
    date2 = new Date(date2.substr(6,4), parseInt(date2.substr(4,2))-1, date2.substr(0,2));
    var hotel = typeof hotel === 'undefined' ? 18 : hotel;//parseInt($(form).find('select[name="hotel"]').val()),
	
	//date1 = new Date($(form).find('input[name="date_in"]').datepicker( "getDate" )),
        //date2 = new Date($(form).find('input[name="date_out"]').datepicker( "getDate" )),
	stay = (date2 - date1) / (24*60*60000),

	year = date1.getFullYear(),
        mon = date1.getMonth() + 1,
        day = date1.getDate(),
        
	data = { 18: { 2015: { 6: { 26:3, 27:3, 28:3, 29:3 }, 8: { 21:3, 22:3, 23:3, 24:3 }}}},
        
        message = { en: ['Minimum stay requirement', 'NOTE!\n\n For %DATE1% to %DATE2% minimum stay is %MINSTAY%.'],
                    ru: ['Минимальный период проживания', 'ВНИМАНИЕ!\n\n С %DATE1% по %DATE2% минимальное количество ночей проживания: %MINSTAY%.'],
                    ua: ['Мінімальний період проживання', 'УВАГА!\n\n З %DATE1% по %DATE2% мінімальна кількість ночей проживання: %MINSTAY%.']};


    if (!data[hotel] || !data[hotel][year] || !data[hotel][year][mon] || !data[hotel][year][mon][day] || data[hotel][year][mon][day] <= stay) return true;

    var minstay = data[hotel][year][mon][day],
        ymon = year+'-'+('0'+mon).substr(-2)+'-', days = Object.keys(data[hotel][year][mon]),
        from = ymon + ('0'+days[0]).substr(-2), till = ymon + ('0'+days[days.length-1]).substr(-2)
        lang = document.location.pathname.substr(1, 2), tmpl = !message[lang] ? message.ru : message[lang],
        text = tmpl[1].replace('%DATE1%', from).replace('%DATE2%', till).replace('%MINSTAY%', minstay), title =  tmpl[0];

    //if (typeof jAlert === 'undefined')
	 alert(title + '\n\n' + text);
    //else jAlert(text, null, title);
    return false;
}
