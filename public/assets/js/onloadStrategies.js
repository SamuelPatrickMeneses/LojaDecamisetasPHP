import productFrom from "./product.js";
var dataCorelate = {};
function loadDataCorelate() {
    let div = $('div.data-corelate');
    if (div.length === 1) {
        dataCorelate = JSON.parse(div.text());
    }
}


$(() => {
    $('input.timezoneOfset').val(
        new Date().getTimezoneOffset() / 60
    );
    loadDataCorelate();
    productFrom(dataCorelate);
    $('.carousel').carousel('pause');
})
