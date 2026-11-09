import Alpine from 'alpinejs';

window.Alpine = Alpine;

const programTabs = document.querySelectorAll('[data-program-tab]');
const programPanels = document.querySelectorAll('[data-program-panel]');

const activateProgram = (id) => {
    programTabs.forEach((tab) => {
        const isActive = tab.dataset.programTab === id;

        tab.setAttribute('aria-selected', String(isActive));
        tab.classList.toggle('border-emerald-900', isActive);
        tab.classList.toggle('bg-emerald-900', isActive);
        tab.classList.toggle('text-cream-50', isActive);
        tab.classList.toggle('shadow-md', isActive);
        tab.classList.toggle('border-emerald-900/10', !isActive);
        tab.classList.toggle('bg-white/70', !isActive);
        tab.classList.toggle('text-emerald-950', !isActive);
    });

    programPanels.forEach((panel) => {
        panel.classList.toggle('hidden', panel.dataset.programPanel !== id);
    });
};

programTabs.forEach((tab) => {
    tab.addEventListener('click', () => activateProgram(tab.dataset.programTab));
});

const navLinks = Array.from(document.querySelectorAll('[data-nav-link]'));

const hashFromHref = (href) => {
    if (!href) {
        return null;
    }

    try {
        const hash = new URL(href, window.location.origin).hash;

        return hash && hash !== '#' ? hash : null;
    } catch {
        return null;
    }
};

if (navLinks.length > 0 && 'IntersectionObserver' in window) {
    const observedSections = navLinks
        .map((link) => {
            const hash = hashFromHref(link.getAttribute('href'));

            return hash ? document.getElementById(hash.slice(1)) : null;
        })
        .filter((section) => section instanceof HTMLElement);

    if (observedSections.length > 0) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    navLinks.forEach((link) => {
                        const isActive = hashFromHref(link.getAttribute('href')) === `#${entry.target.id}`;
                        link.classList.toggle('is-active', isActive);
                    });
                });
            },
            { rootMargin: '-45% 0px -50% 0px', threshold: 0 },
        );

        observedSections.forEach((section) => observer.observe(section));
    }
}

Alpine.start();
