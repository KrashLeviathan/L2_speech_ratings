document.addEventListener("DOMContentLoaded", function () {
    // Attach results buttons
    $('#generate-results-btn').click(generateResults);
    $('#generate-demographics-btn').click(generateDemographics);
});

function generateResults() {
    $.ajax({
        url: '/results/generate_results.php',
        type: 'post',
        dataType: 'json',
        data: '',
        success: function (data) {
            if (data.success) {
                $('#results-file').append('<p>Click to download:&nbsp;&nbsp; <a href="'
                    + data.filepath + data.filename + '" download>' + data.filename + '</a></p>'
                );
            } else {
                console.log(data);
                errorAlert(data.errmsg);
            }
        }
    });
}

function generateDemographics() {
    $.ajax({
        url: '/results/generate_demographics.php',
        type: 'post',
        dataType: 'json',
        data: '',
        success: function (data) {
            if (data.success) {
                $('#demographics-file').append('<p>Click to download:&nbsp;&nbsp; <a href="'
                    + data.filepath + data.filename + '" download>' + data.filename + '</a></p>'
                );
            } else {
                console.log(data);
                errorAlert(data.errmsg);
            }
        }
    });
}

function errorAlert(msg) {
    $('body').append('<div class="alert alert-danger alert-dismissible bottom-alert" role="alert">' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span></button>' +
        '<strong>ERROR:</strong> ' + msg + '</div>');
    setTimeout(function () {
        $('.alert').remove();
    }, 30000);
}
