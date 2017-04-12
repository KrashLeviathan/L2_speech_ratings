<?php

$injectedHeadElements = array('<style>
/* Show scale arrows on mobile devices */
@media (max-width: 767px) {
.xs-arrow {font-size:3em;line-height:0.5em;}
.arrow-top {margin-bottom:0.15em;}
.buffer-top {margin-top:1em;}
}
.np-scale {width:380px;margin-bottom:1em;}
audio {width:100%;}
/* Prevent download button from displaying on audio element*/
audio::-internal-media-controls-download-button {display:none;}
audio::-webkit-media-controls-enclosure {overflow:hidden;}
audio::-webkit-media-controls-panel {width: calc(100% + 30px); /* Adjust as needed */}
</style>');

@include '../../_includes/pageSetup.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // TODO: Form validation

    // TODO: Update database

    // TODO: If invalid, make them rate it again.
}

// TODO: Get a random(?) survey from DB if it just started

// TODO: Get a random(?) survey sample from DB
$audioSample = '/file_storage/3_w1_pic14.wav';

?>

<div class="container">

    <div class="page-header" style="margin-top:6em;">
        <div class="row">
            <div class="col-lg-12">
                <p>To review the instructions at any time, <a href="/instructions" target="_blank">please click here</a>.
                </p>
            </div>
        </div>
    </div>

    <div class="bs-docs-section">
        <form id="survey_form" method="post">
            <div class="row">
                <h2 class="col-lg-12 text-center">Comprehensibility</h2>
            </div>
            <div class="row text-center">
                <div class="col-sm-2 col-md-3 col-lg-4">
                    <span class="visible-xs xs-arrow arrow-top">&larr;</span>Very easy to understand
                </div>
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="btn-group center-block clearfix buffer-top np-scale" role="group"
                         aria-label="Nine-point scale" data-toggle="buttons">
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="1"
                                                           required>1</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="2">2</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="3">3</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="4">4</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="5">5</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="6">6</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="7">7</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="8">8</label>
                        <label class="btn btn-info"><input type="radio" name="comprehension" value="9">9</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 col-lg-4">
                    Very difficult to understand<span class="visible-xs xs-arrow">&rarr;</span>
                </div>
            </div>
            <div class="row">
                <h2 class="col-lg-12 text-center">Fluency</h2>
            </div>
            <div class="row text-center">
                <div class="col-sm-2 col-md-3 col-lg-4">
                    <span class="visible-xs xs-arrow arrow-top">&larr;</span>Extremely fluent
                </div>
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="btn-group center-block clearfix buffer-top np-scale" role="group"
                         aria-label="Nine-point scale" data-toggle="buttons">
                        <label class="btn btn-info"><input type="radio" name="fluency" value="1" required>1</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="2">2</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="3">3</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="4">4</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="5">5</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="6">6</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="7">7</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="8">8</label>
                        <label class="btn btn-info"><input type="radio" name="fluency" value="9">9</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 col-lg-4">
                    Extremely disfluent<span class="visible-xs xs-arrow">&rarr;</span>
                </div>
            </div>
            <div class="row">
                <h2 class="col-lg-12 text-center">Accentedness</h2>
            </div>
            <div class="row text-center">
                <div class="col-sm-2 col-md-3 col-lg-4">
                    <span class="visible-xs xs-arrow arrow-top">&larr;</span>Very strong foreign accent
                </div>
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="btn-group center-block clearfix buffer-top np-scale" role="group"
                         aria-label="Nine-point scale" data-toggle="buttons">
                        <label class="btn btn-info"><input type="radio" name="accent" value="1" required>1</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="2">2</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="3">3</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="4">4</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="5">5</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="6">6</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="7">7</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="8">8</label>
                        <label class="btn btn-info"><input type="radio" name="accent" value="9">9</label>
                    </div>
                </div>
                <div class="col-sm-2 col-md-3 col-lg-4">
                    No foreign accent whatsoever<span class="visible-xs xs-arrow">&rarr;</span>
                </div>
            </div>
        </form>
    </div>

    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <audio controls preload autoplay id="audio-player">
                    <source src="<?= $audioSample ?>" type="audio/wav">
                    Your browser does not support the audio element.
                </audio>
            </div>
        </div>
    </div>

    <div id="submit-btn-container"></div>
</div>
<script>
    var audioPlayer;
    var pageTimerComplete = false;
    var reachedEndOfClip = false;
    var buttonAttached = false;

    document.addEventListener("DOMContentLoaded", function () {
        audioPlayer = document.querySelector('#audio-player');

        // Page needs to sit
        audioPlayer.addEventListener('durationchange', function () {
            var ms = audioPlayer.duration * 1000;
            setTimeout(function () {
                pageTimerComplete = true;
                letUserContinue();
            }, ms);
        });

        audioPlayer.addEventListener('pause', function () {
            if (!reachedEndOfClip) {
                reachedEndOfClip = audioPlayer.currentTime === audioPlayer.duration;
                letUserContinue();
            }
        });

        letUserContinue();
    });

    function letUserContinue() {
        if (!pageTimerComplete || !reachedEndOfClip || buttonAttached) {
            return;
        }
        buttonAttached = true;
        $('#submit-btn-container')
            .append('<input type="submit" class="btn btn-primary center-block" form="survey_form" style="margin-bottom:4em;">');
        window.scrollTo(0, document.body.scrollHeight);
    }
</script>
</body>
</html>
