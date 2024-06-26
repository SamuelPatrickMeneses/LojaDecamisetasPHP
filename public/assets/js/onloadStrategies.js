import productFrom from "./product.js";
import formMask from "./formMasks.js";
var dataCorelate = {};

function loadDataCorelate() {
    let div = $('div.data-corelate');
    if (div.length === 1) {
        dataCorelate = JSON.parse(div.text());
    }
}

function closeAlerts() {
    setTimeout(() => {
        $(".alert").alert('close')
    },5000)
}


$(() => {
    $('input.timezoneOfset').val(
        new Date().getTimezoneOffset() / 60
    );
    formMask();
    loadDataCorelate();
    productFrom(dataCorelate);
    closeAlerts();
    $('.carousel').carousel('pause');
})
