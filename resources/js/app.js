import Alpine from 'alpinejs';

window.Alpine = Alpine;

const programTabLists = Array.from(document.querySelectorAll('[data-program-tablist]'));
const programTabs = Array.from(document.querySelectorAll('[data-program-tab]'));
const programPanels = Array.from(document.querySelectorAll('[data-program-panel]'));

const desktopProgramQuery = window.matchMedia('(min-width: 1024px)');

const syncProgramOrientation = () => {
    const orientation = desktopProgramQuery.matches ? 'vertical' : 'horizontal';

    programTabLists.forEach((tablist) => {
        tablist.setAttribute('aria-orientation', orientation);
    });
};

syncProgramOrientation();
desktopProgramQuery.addEventListener('change', syncProgramOrientation);

const activateProgram = (id) => {
    programTabs.forEach((tab) => {
        const isActive = tab.dataset.programTab === id;

        tab.setAttribute('aria-selected', String(isActive));
        tab.tabIndex = isActive ? 0 : -1;
    });

    programPanels.forEach((panel) => {
        panel.classList.toggle('hidden', panel.dataset.programPanel !== id);
    });
};

programTabs.forEach((tab, index) => {
    tab.addEventListener('click', () => activateProgram(tab.dataset.programTab));

    tab.addEventListener('keydown', (event) => {
        const lastIndex = programTabs.length - 1;
        let nextIndex;

        switch (event.key) {
            case 'ArrowRight':
            case 'ArrowDown':
                nextIndex = index === lastIndex ? 0 : index + 1;
                break;
            case 'ArrowLeft':
            case 'ArrowUp':
                nextIndex = index === 0 ? lastIndex : index - 1;
                break;
            case 'Home':
                nextIndex = 0;
                break;
            case 'End':
                nextIndex = lastIndex;
                break;
            default:
                return;
        }

        event.preventDefault();

        const nextTab = programTabs[nextIndex];

        activateProgram(nextTab.dataset.programTab);
        nextTab.focus();
    });
});

const initialProgramTab = programTabs.find((tab) => tab.getAttribute('aria-selected') === 'true') ?? programTabs[0];

if (initialProgramTab) {
    activateProgram(initialProgramTab.dataset.programTab);
}

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
