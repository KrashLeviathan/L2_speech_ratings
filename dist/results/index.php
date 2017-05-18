<?php
// Keeps unauthorized users out in the checkSession.php script
$adminOnlyPage = true;
@include '../_includes/pageSetup.php';
?>

<div class="container">

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <h1>Results</h1>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <div class="row">
            <div class="col-lg-12">
                <button id="generate-results-btn" type="button" class="btn btn-primary center-block l2sr-mbot-sm">
                    Generate Survey Results as CSV
                </button>
                <div id="results-file" class="l2sr-mbot-sm"></div>
                <button id="generate-demographics-btn" type="button" class="btn btn-primary center-block l2sr-mbot-sm">
                    Generate Demographics as CSV
                </button>
                <div id="demographics-file" class="l2sr-mbot-sm"></div>
                <button id="generate-completions-btn" type="button" class="btn btn-primary center-block l2sr-mbot-sm">
                    Generate User Survey Completions as CSV
                </button>
                <div id="completions-file" class="l2sr-mbot-sm"></div>
                <p class="font-italic">In future iterations, this page could show results at a glance to look at the
                    status of one or more surveys before downloading.</p>
            </div>
        </div>
    </div>
</div>
<script src="/js/results.js" type="text/javascript"></script>

</body>
</html>
