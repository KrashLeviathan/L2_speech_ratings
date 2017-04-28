document.addEventListener("DOMContentLoaded", function () {
    // Add listener to the select all button
    $('#select-all').click(function () {
        $("[type='checkbox']").attr("checked", true);
    });

    // Add listener to the delete checked button
    $('#delete-files-btn').click(function () {
        var filesToDelete = [];
        $("[type='checkbox']").each(function () {
            if (this.checked) {
                filesToDelete.push(this.dataset.filename);
            }
        });
        deleteFiles(filesToDelete);
    });

    // Get files from the database to populate the table
    fetchFiles();
});

function fetchFiles() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/files/get_files.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        var responseJson = JSON.parse(xhr.response);
        if (responseJson.success) {
            onSuccess(responseJson);
        } else {
            $('#file-table-body').children().remove();
            console.log(responseJson);
            displayAlert(responseJson.errmsg, true);
        }
    };
    xhr.send('');
}

function deleteFiles(fileList) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/files/delete_files.php');
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        var responseJson = JSON.parse(xhr.response);
        if (responseJson.success) {
            fetchFiles();
            displayAlert("The files were deleted successfully.", false, 5000);
        } else {
            console.log(responseJson);
            displayAlert(responseJson.errmsg, true);
        }
    };
    xhr.send(JSON.stringify(fileList));
}

function getMinSec(msTime) {
    var totalSeconds = msTime / 1000;
    var min = Math.floor(totalSeconds / 60);
    var sec = Math.floor(totalSeconds % 60);
    return min.toString() + " : " + ((sec < 10) ? "0" + sec : sec);
}

function onSuccess(json) {
    var fileTableBody = $('#file-table-body');
    fileTableBody.children().remove();

    for (var fileIndex in json.files) {
        var filename = json.files[fileIndex][1];
        var duration = json.files[fileIndex][2];
        var dateUploaded = json.files[fileIndex][3];
        var errorTokens = json.files[fileIndex][4];
        fileTableBody.append('<tr><td><a href="/file_storage/audio_samples/' + filename + '" target="_blank">'
            + filename + '</a></td><td>' + getMinSec(duration) + '</td><td>' + dateUploaded
            + '</td><td>' + errorTokens + '</td><td class="text-center"><input type="checkbox" data-filename="'
            + filename + '"></td></tr>')
    }
}
