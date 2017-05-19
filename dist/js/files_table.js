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
    $.ajax({
        url: '/files/get_files.php',
        type: 'post',
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                onSuccess(data);
            } else {
                $('#file-table-body').children().remove();
                console.log(data);
                displayAlert(data.errmsg, true);
            }
        }
    });
}

function deleteFiles(fileList) {
    $.ajax({
        url: '/files/delete_files.php',
        type: 'post',
        dataType: 'json',
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(fileList),
        success: function (data) {
            if (data.success) {
                fetchFiles();
                displayAlert("The files were deleted successfully.", false, 5000);
            } else {
                console.log(data);
                displayAlert(data.errmsg, true);
            }
        }
    });
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
