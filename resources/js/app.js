import './bootstrap';
// window.Livewire = require("../../public/vendor/livewire/livewire.js");
window.lastEmit = 0;
document.addEventListener("DOMContentLoaded", function(event) {
    setInterval(countdownTimers, 1000);
    countdownTimers();

});
function countdownTimers() {
    const elements = document.getElementsByClassName('countdown');

    for(const elementId in elements) {
        if(false === elements.hasOwnProperty(elementId)) {
            continue;
        }

        const element = elements[elementId];
        const countdownTarget = element.attributes.getNamedItem('data-countdown-to');
        if(null === countdownTarget) {
            continue;
        }

        const timeLeft = countdownTarget.value - (new Date().getTime() / 1000);

        if(timeLeft <= 0) {
            if( (new Date().getTime() - window.lastEmit) > 10000) {
                Livewire.emit('timerExpired');
                window.lastEmit = new Date().getTime();
            }

            element.textContent = '00:00:00';
            continue;
        }

        let hoursLeft = Math.round(timeLeft / 3600 % 24);
        if(hoursLeft >= 48) {
            hoursLeft = Math.floor(timeLeft / (3600 * 24)) + ' days'
        }
        else {
            hoursLeft += ':'
        }
        element.textContent = hoursLeft + [
            Math.round((timeLeft / 60) % 60).toString().padStart(2, '0'),
            Math.round(timeLeft % 60).toString().padStart(2, '0'),
        ].join(':');
    }
}
