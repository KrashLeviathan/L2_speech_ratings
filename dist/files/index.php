<?php @include '../_includes/pageSetup.php'; ?>

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
                <div id="files" class="files"></div>
            </div>
        </div>
    </div>
</div>


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
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '/files/upload_handler';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('<p/>').text(file.name).appendTo('#files');
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>

</body>
</html>
