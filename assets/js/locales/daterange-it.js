/*!
 * @copyright Copyright &copy; Marco Migozzi, 2014
 *
 * italian language translation configuration for DateRangePicker widget.
 * 
 * Author: Marco Migozzi
 * Copyright: 2014, Marco Migozzi
 * https://github.com/torvaldz
  */

 /**
 * Set moment i18n configuration
 */
moment.lang('it', {
    months : "gennaio_febraio_marzo_aprile_maggio_giugno_luglio_agosto_settembre_ottobre_novembre_dicembre".split("_"),
    monthsShort : "gen._feb._mar._apr._mag._giu._lug._ago._set._ott._nov._dic.".split("_"),
    weekdays : "domenica_lunedì_martedì_mercoledì_giovedì_venerdì_sabato".split("_"),
    weekdaysShort : "dom._lun._mar._mer._gio._ven._sab.".split("_"),
    weekdaysMin : "Do_Lu_Ma_Me_Gi_Ve_Sa".split("_"),
    longDateFormat : {
        LT : "HH:mm",
        L : "DD/MM/YYYY",
        LL : "D MMMM YYYY",
        LLL : "D MMMM YYYY LT",
        LLLL : "dddd D MMMM YYYY LT"
    },
    calendar : {
        sameDay: "[Oggi alle] LT",
        nextDay: '[Domani alle] LT',
        nextWeek: 'dddd [alle] LT',
        lastDay: '[Ieri alle] LT',
        lastWeek: 'dddd [scorso alle] LT',
        sameElse: 'L'
    },
    relativeTime : {
        future : "entro %s",
        past : "%s fa",
        s : "qualche secondo",
        m : "un minuto",
        mm : "%d minuti",
        h : "un ora",
        hh : "%d ore",
        d : "un giorno",
        dd : "%d giorni",
        M : "un mese",
        MM : "%d mesi",
        y : "un anno",
        yy : "%d anni"
    },
    ordinal : function (number) {
        return '';
    },
    week : {
        dow : 1, // Monday is the first day of the week.
        doy : 4  // The week that contains Jan 4th is the first week of the year.
    }
});

/**
 * Set variable name `dpr_locale_<lang>`
 */
var dpr_locale_it = {
    applyLabel: 'applica',
    cancelLabel: 'annulla',
    fromLabel: 'Da',
    toLabel: 'A',
    weekLabel: 'Sett.',
    customRangeLabel: 'Range personalizzato',
    daysOfWeek: moment()._lang._weekdaysMin.slice(),
    monthNames: moment()._lang._monthsShort.slice(),
    firstDay: 1
};
