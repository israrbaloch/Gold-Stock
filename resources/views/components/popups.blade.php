<style>
    <style>@import url('https://fonts.googleapis.com/css2?family=Tienne:wght@400;700;900&display=swap');

    .modal-content {
        border-radius: 0px !important
    }

    .modal-title {
        text-align: center;
        font-weight: 700;
        font-family: times;
        font-size: x-large;
    }

    .modal-sub-title,
    .timer-text {
        text-align: center;
        font-weight: 400;
        font-family: times;
        margin-top: 20px;
        font-size: larger;
    }

    .timer {
        text-align: center;
        font-weight: 700;
        font-family: times;
        font-size: 30px;
        margin-top: 20px;
        color: #FF0000;
    }

    .btn-group {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .btn-base {
        background-color: #FFD700;
        color: #000;
        border-radius: 5px;
        margin: 0 10px;
    }

    .btn-base:hover {
        background-color: transparent;
        border: 1px solid #FFD700;
    }

    .modal-body {
        display: grid;
        place-items: center;
    }

    .background {
        position: absolute;
        top: 0;
        left: 0;
        height: 300px;
        width: 100%;
        background-color: #333;
        clip-path: ellipse(75% 100% at 50% 0%);
        z-index: 0;
    }

    .modal-title-image,
    .modal-title,
    .modal-sub-title,
    .btn-group {
        position: relative;
        z-index: 1;
        text-align: center;
        /* optional, for centered content */
    }

    .modal-body {
        position: relative;
        overflow: hidden;
        padding: 100px 55px 100px;
        /* space to see curve */
    }

    .feedback-form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .feedback-form textarea {
        width: 100%;
        height: 100px;
        border-radius: 5px;
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 20px;
        font-family: "Tienne", serif;
    }

    .feedback-form input {
        width: 100%;
        height: auto;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-top: 20px;
        font-family: "Tienne", serif;
        padding: 10px;
    }

    .fa-star {
        color: #E1E1E1;
    }

    .horizontal-modal {
        top: 130px;
        width: 800px;
        margin: 0 25%;
    }

    .horizontal-modal .modal-content {
        width: 160%;
        height: 350px;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .main-body {
        display: flex;
        height: 100%;
        width: 100%;
    }

    .modal-left {
        width: 40%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-left img {
        max-width: 100%;
        height: auto;
    }

    .modal-right {
        width: 60%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0 20px;
        text-align: center;
    }

    .progress {
        height: 7px;
        border-radius: 10px;
        background-color: #E6E6E6;
        width: 100%;
    }

    .progress-bar {
        width: 70%;
        background-color: #28a745;
        border-radius: 10px;
    }
</style>


<!-- Black Friday Modal -->
<div class="modal fade" id="BlackFriday" tabindex="-1" aria-labelledby="BlackFridayLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" style="padding: 100px 0px 0px;">
                <p class="modal-title">🔥 Black Friday Mega Sale! 🔥</p>
                <p class="modal-sub-title">Up to 50% OFF – Limited-time only!</p>
                <p class="timer-text">
                    Hurry, sale ends in:
                </p>
                <p class="timer">02:59</p>
                <div class="btn-group">
                    <button type="button" class="btn btn-base">Shop Now</button>
                    <button type="button" class="btn btn-base">Remind Me Later</button>
                </div>
                <hr>
                <img src="{{ asset('img/popus/seasonal.png') }}" alt="seasonal sale image" class="img-fluid"
                    style="width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>

<Script>
    // $(document).ready(function() {
    // });

    // Timer countdown
    // Set countdown for 2 hours from now
    var countdownDate = new Date().getTime() + 2 * 60 * 60 * 1000;

    // Show modal only once
    $('#BlackFriday').modal('show');

    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countdownDate - now;

        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.querySelector('.timer').innerHTML = hours + ":" + minutes + ":" + seconds;

        if (distance < 0) {
            clearInterval(x);
            document.querySelector('.timer').innerHTML = "EXPIRED";
        }
    }, 7000);
</Script>
