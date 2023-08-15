import Vue from "vue";
import moment from 'moment'

Vue.filter('formatDate' , function(value) {
    if (value) {
        let date_string = moment(String(value)).format("DD-M-YYYY");

        let split = date_string.split('-');

        let month = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];

        return split[0] + ' ' + month[split[1] - 1]  + ' ' + split[2];
    }
});

Vue.filter('formatMonth' , function(value) {
    if (value) {
        let date_string = moment(String(value)).format("M-YYYY");

        let split = date_string.split('-');

        let month = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];

        return month[split[0] - 1]  + ' ' + split[1];
    }
});

Vue.filter("formatDateTime", function (value) {
    var data_month = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];
    if (
        value == "" ||
        value == "0000-00-00 00:00:00" ||
        value == "01/01/1970 07:00:00" ||
        value == null
    ) {
        return "-";
    }
    var date = new Date(value);
    var day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
    var month = data_month[date.getMonth()];
    var year = date.getFullYear();
    var H = date.getHours();
    var M = date.getMinutes();
    var S = date.getSeconds();

    return (
        day +
        " " +
        month +
        " " +
        year +
        " - " +
        H +
        ":" +
        (date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes())
    );
});