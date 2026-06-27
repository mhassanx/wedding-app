const copyButton = document.getElementById("copy-link");

const downloadButton = document.getElementById("download-pdf");

const whatsappButton = document.getElementById("whatsapp-share");

/* ==========================================
   Countdown Timer
========================================== */

function initCountdown() {
    const countdown = document.getElementById("countdown");

    if (!countdown) {
        return;
    }

    const target = Date.parse(countdown.dataset.target);

    if (Number.isNaN(target)) {
        return;
    }

    const daysElement = document.getElementById("cd-days");

    const hoursElement = document.getElementById("cd-hours");

    const minutesElement = document.getElementById("cd-mins");

    const secondsElement = document.getElementById("cd-secs");

    if (!daysElement || !hoursElement || !minutesElement || !secondsElement) {
        return;
    }

    function updateCountdown(days, hours, mins, secs) {
        daysElement.textContent = days;

        hoursElement.textContent = hours;

        minutesElement.textContent = mins;

        secondsElement.textContent = secs;
    }

    function tick() {
        const now = Date.now();

        const diff = target - now;

        if (diff <= 0) {
            updateCountdown(0, 0, 0, 0);

            return;
        }

        const days = Math.floor(diff / 86400000);

        const hours = Math.floor((diff % 86400000) / 3600000);

        const mins = Math.floor((diff % 3600000) / 60000);

        const secs = Math.floor((diff % 60000) / 1000);

        updateCountdown(days, hours, mins, secs);
    }

    tick();

    setInterval(tick, 1000);
}

/* ==========================================
   Share Buttons
========================================== */

function initShareButtons() {
    if (!copyButton || !downloadButton || !whatsappButton) {
        return;
    }

    const pageUrl = window.location.href;
    const settings = window.invitationSettings || {};
    const brideName = settings.brideName || "the couple";
    const groomName = settings.groomName || "";
    const coupleName = groomName ? `${brideName} & ${groomName}` : brideName;

    const message = `You're invited to ${coupleName}'s wedding! ` + pageUrl;

    whatsappButton.href = "https://wa.me/?text=" + encodeURIComponent(message);

    copyButton.addEventListener("click", function () {
        const btn = copyButton;
        const original = btn.textContent;

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard
                .writeText(pageUrl)
                .then(function () {
                    btn.textContent = "Link copied!";

                    setTimeout(function () {
                        btn.textContent = original;
                    }, 2000);
                })
                .catch(function () {
                    btn.textContent = "Copy failed";

                    setTimeout(function () {
                        btn.textContent = original;
                    }, 2000);
                });
        } else {
            btn.textContent = "Copy unavailable";

            setTimeout(function () {
                btn.textContent = original;
            }, 2000);
        }
    });

    downloadButton.addEventListener("click", function () {
        window.print();
    });
}

/* ==========================================
   Gallery Slider
========================================== */

function initGallery() {
    const gallery = document.querySelector(".weddingSwiper");

    if (!gallery || typeof Swiper === "undefined") {
        return;
    }

    new Swiper(gallery, {
        effect: "fade",

        fadeEffect: {
            crossFade: true,
        },

        loop: true,

        speed: 1200,

        autoplay: {
            delay: 4500,

            disableOnInteraction: false,

            pauseOnMouseEnter: true,
        },

        keyboard: {
            enabled: true,

            onlyInViewport: true,
        },

        navigation: {
            nextEl: ".swiper-button-next",

            prevEl: ".swiper-button-prev",
        },

        pagination: {
            el: ".swiper-pagination",

            clickable: true,
        },
    });
}

/* ==========================================
   Gallery Lightbox
========================================== */

function initLightbox() {
    if (typeof Fancybox === "undefined") {
        return;
    }

    Fancybox.bind("[data-fancybox='gallery']", {
        animated: true,

        dragToClose: true,

        Toolbar: {
            display: ["zoom", "fullscreen", "close"],
        },
    });
}

function initApp() {
    initCountdown();
    initShareButtons();
    initGallery();
    initLightbox();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initApp);
} else {
    initApp();
}
