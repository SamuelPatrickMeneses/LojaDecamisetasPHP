$(() => {
    $('input.timezoneOfset').val(
        new Date().getTimezoneOffset() / 60
    );
})
