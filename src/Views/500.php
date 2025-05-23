<div class="container">
    <div class="error">ERROR<br></div>
    <div class="number">500</div>
    <div class="message">
        <span class="textData" data-to-animate='[" Looks like you messed it al" , " We are sorr" , " Clearly something is broken! We will fix it soon."]'>Ooops!! </span>
    </div>
    <div class="smiley">
        <span id="leftArm">¯\_</span>
        <span id="face">(ツ)</span>
        <span id="rightArm">_/¯</span>
    </div>
</div>

<style>@import url('https://fonts.googleapis.com/css?family=Comfortaa');
    @import url('https://fonts.googleapis.com/css?family=Abril+Fatface');
    @import url('https://fonts.googleapis.com/css?family=Anonymous+Pro');

    html, body {
        margin: 0;
        font-family: Comfortaa;
        font-size: 5vmin;
        background-color: #020402;
    }
    .error {
        position: relative;
        width: 100%;
        height: 13vh;
        text-align: center;
        font-size: 12vmin;
        font-family: Abril Fatface;
        color: #A76D60;
    }
    .number {
        position: relative;
        width: 100%;
        height: 30vmin;
        text-align: center;
        font-size: 22vmin;
        font-family: Abril Fatface;
        color: #601700;
    }
    .smiley {
        margin-top: 5vh;
        margin-bottom: 5vh;
        width: 100%;
        text-align: center;
        font-size: 8vmin;
    }
    .message {
        position: relative;
        width: 80%;
        height: 20vh;
        padding-left: 20vw;
        padding-right: 20vw;
        color: #00A676;
        font-family: Anonymous Pro;
    }
    .textData {
        position: relative;
        width: 100%;
        border-right: solid 2px grey;
        animation: blink forwards 0.65s infinite;
        -webkit-animation: blink forwards 0.65s infinite;
    }
    #leftArm, #rightArm, #face {
        display: inline-block;
        transform: rotate(0deg);
        color: #00A676;
    }
    #face {
        color: #00A676;
    }
    @keyframes blink {
        0% {
            border-right: solid 2px rgba(105,105,105,1);
        }
        33% {
            border-right: solid 2px rgba(105,105,105,1);
        }
        34% {
            border-right: solid 2px rgba(105,105,105,0);
        }
        66% {
            border-right: solid 2px rgba(105,105,105,0);
        }
        67% {
            border-right: solid 2px rgba(105,105,105,1);
        }
        100% {
            border-right: solid 2px rgba(105,105,105,1);
        }
    }
    @keyframes leftarm{
        10%{
            transform: rotate(-20deg);
        }

        30%{
            transform: rotate(-20deg);
        }

        50%{
            transform: rotate(0deg);
        }
    }

    @keyframes rightarm{
        10%{
            transform: rotate(20deg);
        }

        30%{
            transform: rotate(20deg);
        }

        50%{
            transform: rotate(0deg);
        }
    }</style>