function onClickConsent() {
    $.ajax({
        url: '/instructions/consent.php',
        type: 'post',
        dataType: 'json',
        data: '',
        success: function (data) {
            if (data.success) {
                var container = $('#consent-btn-container');
                container.children().remove();
                container.append('<p class="text-center well" style="font-size: 1.5em;">Thank you for your participation!</p>');
            } else {
                console.log(data);
                displayAlert(data.errmsg, true);
            }
        }
    });
}
