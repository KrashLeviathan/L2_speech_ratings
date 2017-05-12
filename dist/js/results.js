document.addEventListener("DOMContentLoaded", function () {
    // Attach results buttons
    $('#generate-results-btn').click(generateResults);
    $('#generate-demographics-btn').click(generateDemographics);
    $('#generate-completions-btn').click(generateCompletions);
});

function generateResults() {
    $.ajax({
        url: '/results/generate_results.php',
        type: 'post',
        dataType: 'json',
        data: '',
        success: function (data) {
            if (data.success) {
                for (var fIndex in data.filenames) {
                    $('#results-file').append('<p>Click to download:&nbsp;&nbsp; <a href="'
                        + data.filepath + data.filenames[fIndex] + '" download>' + data.filenames[fIndex] + '</a></p>'
                    );
                }
            } else {
                console.log(data);
                displayAlert(data.errmsg, true);
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
            handleSingleFileData($('#demographics-file'), data);
        }
    });
}

function generateCompletions() {
    $.ajax({
        url: '/results/generate_completions.php',
        type: 'post',
        dataType: 'json',
        data: '',
        success: function (data) {
            handleSingleFileData($('#completions-file'), data);
        }
    });
}

function handleSingleFileData($fileContainer, data) {
    if (data.success) {
        $fileContainer.append('<p>Click to download:&nbsp;&nbsp; <a href="'
            + data.filepath + data.filename + '" download>' + data.filename + '</a></p>'
        );
    } else {
        console.log(data);
        displayAlert(data.errmsg, true);
    }
}
