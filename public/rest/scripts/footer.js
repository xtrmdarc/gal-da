var datetime = null;
var dateday = null;
var datedays = null;
date = null;
var update = function () {
    date = moment(new Date());
    dateday.html(date.format('dddd'));
    datedays.html(date.format('Do MMM'));
    datetime.html(date.format('h:mm A'));
};
$(function() {
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "showMethod": "slideDown",
        "positionClass": "toast-bottom-right",
        "timeOut": 7000
    };
    moment.locale('es');
    $('.DatePicker')
    .datepicker({
        format: 'dd-mm-yyyy'
    });
    $('.input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    datetime = $('#datetime');
    dateday = $('#dateday');
    datedays = $('#datedays');
    update();
    setInterval(update, 1000);
});