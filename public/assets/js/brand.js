document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.querySelector("[data-offcanvas-toggle]");
    const closeButton = document.querySelector("[data-offcanvas-close]");
    const overlay = document.querySelector(".offcanvas-overlay");
    const menu = document.querySelector(".offcanvas-menu");
    const consentBanner = document.querySelector("[data-consent-banner]");
    const consentKey = "newsportalConsent";
    const themeToggle = document.querySelector("[data-theme-toggle]");
    const themeKey = "newsportalTheme";

    // Theme: prefer stored choice, fallback to system preference.
    const getPreferredTheme = () => {
        const stored = localStorage.getItem(themeKey);
        if (stored === "light" || stored === "dark") {
            return stored;
        }
        return window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
    };

    const applyTheme = (mode) => {
        document.body.classList.toggle("dark-mode", mode === "dark");
        if (themeToggle) {
            themeToggle.setAttribute("aria-pressed", mode === "dark");
        }
    };

    applyTheme(getPreferredTheme());

    themeToggle?.addEventListener("click", () => {
        const next = document.body.classList.contains("dark-mode") ? "light" : "dark";
        localStorage.setItem(themeKey, next);
        applyTheme(next);
    });

    const systemPref = window.matchMedia("(prefers-color-scheme: dark)");
    systemPref.addEventListener("change", (event) => {
        if (!localStorage.getItem(themeKey)) {
            applyTheme(event.matches ? "dark" : "light");
        }
    });

    if (toggleButton && overlay && menu) {
        const openMenu = () => {
            overlay.classList.add("active");
            menu.classList.add("active");
            document.body.classList.add("offcanvas-open");
        };

        const closeMenu = () => {
            overlay.classList.remove("active");
            menu.classList.remove("active");
            document.body.classList.remove("offcanvas-open");
        };

        toggleButton.addEventListener("click", openMenu);
        closeButton?.addEventListener("click", closeMenu);
        overlay.addEventListener("click", closeMenu);
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape" && overlay.classList.contains("active")) {
                closeMenu();
            }
        });
    }

    if (consentBanner) {
        const showConsent = () => {
            consentBanner.classList.add("active");
        };

        const hideConsent = () => {
            consentBanner.classList.remove("active");
        };

        const storedConsent = localStorage.getItem(consentKey);
        if (!storedConsent) {
            showConsent();
        }

        consentBanner.querySelectorAll("[data-consent-action]").forEach((button) => {
            button.addEventListener("click", () => {
                localStorage.setItem(consentKey, button.dataset.consentAction || "accepted");
                hideConsent();
            });
        });
    }

    // Ads: reveal after delay or interaction, and allow permanent dismissal.
    const adSlots = document.querySelectorAll(".ad-slot[data-ad-slot]");
    if (!adSlots.length) {
        return;
    }

    const adDismissKeyPrefix = "newsportalAdDismissed:";
    const revealDelayMs = 5000;

    const isDismissed = (slotName) => localStorage.getItem(`${adDismissKeyPrefix}${slotName}`) === "1";

    adSlots.forEach((slot) => {
        const slotName = slot.dataset.adSlot || "default";
        if (isDismissed(slotName)) {
            slot.remove();
            return;
        }

        const closeButton = slot.querySelector("[data-ad-close]");
        closeButton?.addEventListener("click", () => {
            localStorage.setItem(`${adDismissKeyPrefix}${slotName}`, "1");
            slot.remove();
        });
    });

    let revealed = false;
    const revealAds = () => {
        if (revealed) {
            return;
        }
        revealed = true;

        adSlots.forEach((slot) => {
            if (!slot.isConnected) {
                return;
            }
            const slotName = slot.dataset.adSlot || "default";
            if (isDismissed(slotName)) {
                slot.remove();
                return;
            }
            slot.classList.remove("ad-slot--hidden");
        });
    };

    window.setTimeout(revealAds, revealDelayMs);
    window.addEventListener("scroll", revealAds, { once: true, passive: true });
    window.addEventListener("click", revealAds, { once: true });
});
