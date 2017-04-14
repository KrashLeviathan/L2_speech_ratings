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
