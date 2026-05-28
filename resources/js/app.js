import './bootstrap';

// =============================================================================
// Mobile navigation toggle
// =============================================================================
(function () {
    const toggle    = document.getElementById('nav-toggle');
    const menu      = document.getElementById('mobile-menu');
    const iconOpen  = document.getElementById('icon-open');
    const iconClose = document.getElementById('icon-close');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.contains('hidden');
        menu.classList.toggle('hidden', !isOpen);
        toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        iconOpen.classList.toggle('hidden', isOpen);
        iconClose.classList.toggle('hidden', !isOpen);
    });

    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
            toggle.setAttribute('aria-expanded', 'false');
            iconOpen.classList.remove('hidden');
            iconClose.classList.add('hidden');
            toggle.focus();
        }
    });
})();

// =============================================================================
// Reveal on scroll
// =============================================================================
(function () {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) return;

    const els = document.querySelectorAll('.reveal');
    if (!els.length || !('IntersectionObserver' in window)) {
        els.forEach(el => el.classList.add('visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );

    els.forEach(el => observer.observe(el));
})();

// =============================================================================
// Multi-step contact form
// =============================================================================
(function () {
    const form = document.getElementById('inquiry-form');
    if (!form) return;

    const steps      = Array.from(form.querySelectorAll('[data-step]'));
    const btnNext    = document.getElementById('btn-next');
    const btnPrev    = document.getElementById('btn-prev');
    const btnSubmit  = document.getElementById('btn-submit');
    const totalSteps = steps.length;

    // Read the server-computed initial step (set when returning with validation errors)
    const initialStep = Math.max(1, Math.min(parseInt(form.dataset.initialStep) || 1, totalSteps));
    let currentStep   = initialStep;

    const projectTypeLabels = {
        new_website:     'Nieuwe website',
        redesign:        'Bestaande website vernieuwen',
        web_application: 'Webapplicatie / dashboard',
        app_idea:        'App idee',
        maintenance:     'Onderhoud / aanpassingen',
        other:           'Iets anders',
    };

    // -------------------------------------------------------------------------
    function goToStep(n) {
        n = Math.max(1, Math.min(n, totalSteps));

        steps.forEach(step => {
            const num = parseInt(step.dataset.step);
            step.classList.toggle('hidden', num !== n);
        });

        // Step dots
        form.querySelectorAll('[data-step-dot]').forEach(dot => {
            const num = parseInt(dot.dataset.stepDot);
            const active = num <= n;
            dot.classList.toggle('bg-slate-900', active);
            dot.classList.toggle('text-white', active);
            dot.classList.toggle('bg-stone-200', !active);
            dot.classList.toggle('text-slate-400', !active);
            dot.setAttribute('aria-current', num === n ? 'step' : 'false');
        });

        // Step lines
        form.querySelectorAll('[data-step-line]').forEach(line => {
            const num = parseInt(line.dataset.stepLine);
            line.classList.toggle('step-line-active', num < n);
            line.classList.toggle('bg-stone-200', num >= n);
        });

        // Buttons
        if (btnPrev) btnPrev.classList.toggle('invisible', n === 1);
        if (btnNext)   btnNext.classList.toggle('hidden', n === totalSteps);
        if (btnSubmit) btnSubmit.classList.toggle('hidden', n !== totalSteps);

        if (n === totalSteps) updateSummary();

        currentStep = n;
    }

    // -------------------------------------------------------------------------
    function updateSummary() {
        const ptField    = form.querySelector('[name="project_type"]');
        const nameField  = form.querySelector('[name="name"]');
        const emailField = form.querySelector('[name="email"]');

        const el = (id) => document.getElementById(id);

        if (el('summary-project-type') && ptField)
            el('summary-project-type').textContent = projectTypeLabels[ptField.value] || ptField.value || '—';
        if (el('summary-name') && nameField)
            el('summary-name').textContent = nameField.value || '—';
        if (el('summary-email') && emailField)
            el('summary-email').textContent = emailField.value || '—';
    }

    // -------------------------------------------------------------------------
    function validateCurrentStep() {
        const stepEl = steps.find(s => parseInt(s.dataset.step) === currentStep);
        if (!stepEl) return true;

        let valid = true;
        let firstInvalid = null;

        stepEl.querySelectorAll('[required]').forEach(field => {
            const isEmpty = field.type === 'checkbox' ? !field.checked : !field.value.trim();
            if (isEmpty) {
                field.classList.add('border-red-400');
                field.addEventListener('input', () => field.classList.remove('border-red-400'), { once: true });
                if (!firstInvalid) firstInvalid = field;
                valid = false;
            }
        });

        if (firstInvalid) firstInvalid.focus();
        return valid;
    }

    // -------------------------------------------------------------------------
    // "Andere taal" checkbox → show/hide the other_language input
    // -------------------------------------------------------------------------
    const otherLangWrapper = document.getElementById('other-lang-wrapper');
    const otherLangCheckbox = form.querySelector('input[data-triggers="other-lang-wrapper"]');

    if (otherLangCheckbox && otherLangWrapper) {
        otherLangCheckbox.addEventListener('change', () => {
            otherLangWrapper.classList.toggle('hidden', !otherLangCheckbox.checked);
            if (otherLangCheckbox.checked) {
                const input = otherLangWrapper.querySelector('input');
                if (input) input.focus();
            }
        });
    }

    // -------------------------------------------------------------------------
    if (btnNext) {
        btnNext.addEventListener('click', () => {
            if (validateCurrentStep()) goToStep(currentStep + 1);
        });
    }

    if (btnPrev) {
        btnPrev.addEventListener('click', () => goToStep(currentStep - 1));
    }

    // Enter advances steps (not on textarea/checkbox)
    form.addEventListener('keydown', (e) => {
        const tag = e.target.tagName;
        const type = e.target.type;
        if (e.key === 'Enter' && tag !== 'TEXTAREA' && type !== 'checkbox' && currentStep < totalSteps) {
            e.preventDefault();
            if (btnNext && !btnNext.classList.contains('hidden')) btnNext.click();
        }
    });

    // If returning from a server validation error, scroll the error summary into view
    if (initialStep > 1) {
        const errorSummary = document.getElementById('error-summary');
        if (errorSummary) {
            setTimeout(() => errorSummary.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
        }
    }

    // Init at the correct step
    goToStep(initialStep);
})();
