var audioPlayer;
var pageTimerComplete = false;
var reachedEndOfClip = false;
var buttonAttached = false;

document.addEventListener("DOMContentLoaded", function () {
    // Attach form submission handler
    $('#survey-form').submit(function (event) {
        event.preventDefault();
        if (!pageTimerComplete || !reachedEndOfClip || !buttonAttached) {
            return;
        }
        $.ajax({
            url: '/survey/in_progress/submit_rating_event.php',
            type: 'post',
            dataType: 'json',
            data: $('#survey-form').serialize(),
            success: function (data) {
                if (data.success) {
                    location.reload();
                } else {
                    console.log(data);
                    displayAlert(data.errmsg, true);
                }
            }
        });
    });

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
        .append('<input type="submit" class="btn btn-primary center-block" form="survey-form" style="margin-bottom:4em;">');
    window.scrollTo(0, document.body.scrollHeight);
}
