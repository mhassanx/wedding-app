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

function initGiftCopyButtons() {
    document.querySelectorAll(".gift-copy-btn").forEach(function (button) {
        button.addEventListener("click", function () {
            const value = button.dataset.copyValue || "";
            const original = button.textContent;

            if (!value) {
                return;
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard
                    .writeText(value)
                    .then(function () {
                        button.textContent = "Copied";

                        setTimeout(function () {
                            button.textContent = original;
                        }, 2000);
                    })
                    .catch(function () {
                        button.textContent = "Copy failed";

                        setTimeout(function () {
                            button.textContent = original;
                        }, 2000);
                    });
            } else {
                button.textContent = "Copy unavailable";

                setTimeout(function () {
                    button.textContent = original;
                }, 2000);
            }
        });
    });
}

/* ==========================================
   Opening Card Animation
========================================== */

function initOpeningAnimation() {
    const overlay = document.getElementById("opening-overlay");
    const card = document.getElementById("opening-card");

    if (!overlay || !card) {
        document.body.classList.remove("invitation-locked");
        document.body.classList.add("invitation-revealed");
        return;
    }

    const settings = window.invitationSettings || {};
    const storageKey = settings.inviteCode
        ? "invitation_opened_" + settings.inviteCode
        : "invitation_opened_general";

    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches;

    function revealInvitation(skipAnimation) {
        if (skipAnimation || prefersReducedMotion) {
            overlay.classList.add("is-hidden");
            document.body.classList.remove("invitation-locked");
            document.body.classList.add("invitation-revealed");
            overlay.setAttribute("aria-hidden", "true");
            return;
        }

        card.classList.add("is-opening");

        setTimeout(function () {
            overlay.classList.add("is-hidden");
            document.body.classList.remove("invitation-locked");
            document.body.classList.add("invitation-revealed");
            overlay.setAttribute("aria-hidden", "true");
        }, 4800);
    }

    if (sessionStorage.getItem(storageKey) === "1") {
        revealInvitation(true);
        return;
    }

    function handleOpen() {
        if (card.classList.contains("is-opening")) {
            return;
        }

        card.classList.add("is-opening");
        sessionStorage.setItem(storageKey, "1");

        setTimeout(function () {
            overlay.classList.add("is-hidden");
            document.body.classList.remove("invitation-locked");
            document.body.classList.add("invitation-revealed");
            overlay.setAttribute("aria-hidden", "true");
        }, 4800);
    }

    card.addEventListener("click", handleOpen);

    card.addEventListener("keydown", function (event) {
        if (event.key === "Enter" || event.key === " ") {
            event.preventDefault();
            handleOpen();
        }
    });
}

function initApp() {
    initOpeningAnimation();
    initCountdown();
    initShareButtons();
    initGallery();
    initLightbox();
    initGiftCopyButtons();
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initApp);
} else {
    initApp();
}
