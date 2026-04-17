const MOBILE_BREAKPOINT = 900;

const initHeaderSidebar = (): void => {
    const header = document.querySelector<HTMLElement>('.header');
    if (header === null) {
        return;
    }

    const toggleButton = header.querySelector<HTMLButtonElement>('[data-sidebar-toggle]');
    const closeButton = header.querySelector<HTMLButtonElement>('[data-sidebar-close]');
    const sidebar = header.querySelector<HTMLElement>('[data-sidebar]');
    const overlay = header.querySelector<HTMLElement>('[data-sidebar-overlay]');

    if (toggleButton === null || closeButton === null || sidebar === null || overlay === null) {
        return;
    }

    const navigationLinks = sidebar.querySelectorAll<HTMLAnchorElement>('a');

    const setSidebarOpenState = (isOpen: boolean): void => {
        const shouldOpen = isOpen && window.matchMedia(`(max-width: ${MOBILE_BREAKPOINT}px)`).matches;

        header.classList.toggle('header--sidebar-open', shouldOpen);
        document.body.classList.toggle('header-sidebar-open', shouldOpen);
        toggleButton.setAttribute('aria-expanded', String(shouldOpen));
        sidebar.setAttribute('aria-hidden', String(!shouldOpen));
    };

    const closeSidebar = (): void => setSidebarOpenState(false);

    toggleButton.addEventListener('click', () => {
        const isOpen = header.classList.contains('header--sidebar-open');
        setSidebarOpenState(!isOpen);
    });

    closeButton.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    navigationLinks.forEach((link) => {
        link.addEventListener('click', closeSidebar);
    });

    document.addEventListener('keydown', (event: KeyboardEvent) => {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > MOBILE_BREAKPOINT) {
            closeSidebar();
        }
    });
};

initHeaderSidebar();
