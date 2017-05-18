<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;
@include '../_includes/pageSetup.php';
?>

<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Files</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p>Click the button below or drag-and-drop files to begin uploading.</p>

                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-primary fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Select files...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" multiple>
                </span>
                <br>
                <br>
                <!-- The global progress bar -->
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <!-- The container for the uploaded files -->
                <h3>Upload Results</h3>
                <div id="files" class="l2sr-file-uploads"></div>
            </div>
        </div>
        <div class="row l2sr-mtop-sm">
            <div class="col-lg-12 l2sr-mbot-sm">
                <h3>File Management</h3>
                <button id="delete-files-btn" type="button" class="btn btn-danger l2sr-mtop-sm">Delete Checked Files
                </button>
            </div>
            <div class="col-lg-12 table-responsive">
                <table class="table table-hover table-striped l2sr-table">
                    <thead class="font-weight-bold">
                    <tr>
                        <th>Filename</th>
                        <th>Duration</th>
                        <th>Upload Date</th>
                        <th>Error Tokens</th>
                        <th class="text-center">
                            <button id="select-all" class="btn btn-xs btn-primary">Check All</button>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="file-table-body">
                    <tr>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                        <td>Loading</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="/js/files_table.js" type="text/javascript"></script>

<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/js/jQuery-File-Upload/vendor/jquery.ui.widget.js" defer></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/js/jQuery-File-Upload/jquery.iframe-transport.js" defer></script>
<!-- The basic File Upload plugin -->
<script src="/js/jQuery-File-Upload/jquery.fileupload.js" defer></script>
<!-- The File Upload processing plugin -->
<script src="/js/jQuery-File-Upload/jquery.fileupload-process.js" defer></script>
<!-- The File Upload validation plugin -->
<script src="/js/jQuery-File-Upload/jquery.fileupload-validate.js" defer></script>

<script defer>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '/files/upload_handler';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(wav)$/i,
            maxFileSize: 10000000, // 10 MB
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadstop', function (e, data) {
            fetchFiles();
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
</body>
</html>
