<style>
    /* body {
    margin: 0;
    padding: 0;
    overflow: hidden;
    height: 100vh;
    background: linear-gradient(to bottom, #000428, #004e92);
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: Arial, sans-serif;
} */

.snowflakes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    pointer-events: none;
}

.snowflake {
    position: absolute;
    top: -10vh;
    color: white;
    font-size: 1em;
    font-family: Arial, sans-serif;
    user-select: none;
    z-index: 1000;
    animation: fall 10s linear infinite, sway 3s ease-in-out infinite;
}

@keyframes fall {
    0% {
        top: -10vh;
        opacity: 1;
    }
    100% {
        top: 100vh;
        opacity: 0.5;
    }
}

@keyframes sway {
    0%, 100% {
        transform: translateX(0);
    }
    50% {
        transform: translateX(20px);
    }
}

.snowflake:nth-child(odd) {
    animation-duration: 12s;
    animation-name: fall, sway;
    animation-timing-function: linear, ease-in-out;
    animation-iteration-count: infinite, infinite;
}

.snowflake:nth-child(even) {
    animation-duration: 8s;
    animation-name: fall, sway;
    animation-timing-function: linear, ease-in-out;
    animation-iteration-count: infinite, infinite;
}

.snowflake:nth-child(1) {
    left: 10%;
    font-size: 2em;
    animation-delay: 0s, 1s;
}

.snowflake:nth-child(2) {
    left: 20%;
    font-size: 1.5em;
    animation-delay: 2s, 0.5s;
}

.snowflake:nth-child(3) {
    left: 30%;
    font-size: 2.5em;
    animation-delay: 4s, 2s;
}

.snowflake:nth-child(4) {
    left: 40%;
    font-size: 2em;
    animation-delay: 1s, 0s;
}

.snowflake:nth-child(5) {
    left: 50%;
    font-size: 1.5em;
    animation-delay: 3s, 1.5s;
}

.snowflake:nth-child(6) {
    left: 60%;
    font-size: 2.5em;
    animation-delay: 5s, 0.5s;
}

.snowflake:nth-child(7) {
    left: 70%;
    font-size: 2em;
    animation-delay: 0s, 1.5s;
}

.snowflake:nth-child(8) {
    left: 80%;
    font-size: 1.5em;
    animation-delay: 2s, 0s;
}

.snowflake:nth-child(9) {
    left: 90%;
    font-size: 2em;
    animation-delay: 4s, 1s;
}

.snowflake:nth-child(10) {
    left: 95%;
    font-size: 1.5em;
    animation-delay: 6s, 0.5s;
}

</style>
<div class="row" style="background: linear-gradient(to bottom, #000428, #004e92);">
    <div class="col-md-12">
        <div class="text-center">
            <h1 style="font-size: 15em; min-height:480px">
                <div id="jam" style="color: white;"></div>
                <small>
                <?php $hari=date('l'); echo hari($hari); ?>, <?php echo date('d F Y') ?>
                </small>
            </h1>
        </div>
    </div>
</div>
<div class="snowflakes" aria-hidden="true">
        <div class="snowflake">❅</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
        <div class="snowflake">❄</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❅</div>
        <div class="snowflake">❆</div>
    </div>