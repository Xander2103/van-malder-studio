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

    const initialStep = Math.max(1, Math.min(parseInt(form.dataset.initialStep) || 1, totalSteps));
    let currentStep   = initialStep;

    const projectTypeLabels = {
        new_website:              'Nieuwe website',
        redesign:                 'Website vernieuwen',
        webshop:                  'Webshop / online verkoop',
        contact_form:             'Contact- of offerteformulier',
        seo_local:                'SEO / lokale vindbaarheid',
        app_tool:                 'App, tool of webapplicatie',
        maintenance:              'Onderhoud / aanpassingen',
        audit:                    'Website audit / advies',
        other:                    'Iets anders',
        // Legacy values — backwards compat
        web_application:          'Webapplicatie / dashboard',
        app_idea:                 'App idee',
    };

    function goToStep(n) {
        n = Math.max(1, Math.min(n, totalSteps));

        steps.forEach(step => {
            const num = parseInt(step.dataset.step);
            step.classList.toggle('hidden', num !== n);
        });

        form.querySelectorAll('[data-step-dot]').forEach(dot => {
            const num = parseInt(dot.dataset.stepDot);
            const active = num <= n;
            dot.classList.toggle('bg-slate-900', active);
            dot.classList.toggle('text-white', active);
            dot.classList.toggle('bg-stone-200', !active);
            dot.classList.toggle('text-slate-400', !active);
            dot.setAttribute('aria-current', num === n ? 'step' : 'false');
        });

        form.querySelectorAll('[data-step-line]').forEach(line => {
            const num = parseInt(line.dataset.stepLine);
            line.classList.toggle('step-line-active', num < n);
            line.classList.toggle('bg-stone-200', num >= n);
        });

        if (btnPrev) btnPrev.classList.toggle('invisible', n === 1);
        if (btnNext)   btnNext.classList.toggle('hidden', n === totalSteps);
        if (btnSubmit) btnSubmit.classList.toggle('hidden', n !== totalSteps);

        if (n === totalSteps) updateSummary();

        currentStep = n;
    }

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

    // "Andere taal" checkbox → show/hide the other_language input
    const otherLangWrapper  = document.getElementById('other-lang-wrapper');
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

    if (btnNext) {
        btnNext.addEventListener('click', () => {
            if (validateCurrentStep()) goToStep(currentStep + 1);
        });
    }

    if (btnPrev) {
        btnPrev.addEventListener('click', () => goToStep(currentStep - 1));
    }

    form.addEventListener('keydown', (e) => {
        const tag  = e.target.tagName;
        const type = e.target.type;
        if (e.key === 'Enter' && tag !== 'TEXTAREA' && type !== 'checkbox' && currentStep < totalSteps) {
            e.preventDefault();
            if (btnNext && !btnNext.classList.contains('hidden')) btnNext.click();
        }
    });

    if (initialStep > 1) {
        const errorSummary = document.getElementById('error-summary');
        if (errorSummary) {
            setTimeout(() => errorSummary.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
        }
    }

    goToStep(initialStep);
})();

// =============================================================================
// Studio Intro — woven particle canvas
// Brighter particles + lines, visible mouse glow, stronger repulsion.
// =============================================================================
(function () {
    const canvas = document.getElementById('woven-canvas');
    if (!canvas) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        canvas.style.display = 'none';
        return;
    }

    const ctx      = canvas.getContext('2d');
    const dpr      = Math.min(window.devicePixelRatio || 1, 2);
    const isMobile = window.innerWidth < 768;
    const COUNT    = isMobile ? 65 : 190;
    const MAX_DIST = isMobile ? 100 : 140;
    const MOUSE_R  = 150;

    let W = canvas.width  = window.innerWidth  * dpr;
    let H = canvas.height = window.innerHeight * dpr;
    canvas.style.width  = window.innerWidth  + 'px';
    canvas.style.height = window.innerHeight + 'px';
    ctx.scale(dpr, dpr);

    let mouse   = { x: (W / dpr) / 2, y: (H / dpr) * 0.45 };
    let running = true;

    const pts = Array.from({ length: COUNT }, () => ({
        x:  Math.random() * (W / dpr),
        y:  Math.random() * (H / dpr),
        vx: (Math.random() - 0.5) * 0.38,
        vy: (Math.random() - 0.5) * 0.38,
        r:  Math.random() * 1.8 + 0.7,
        a:  Math.random() * 0.60 + 0.38,   // brighter: 0.38–0.98 (was 0.25–0.80)
    }));

    const RW = () => W / dpr;
    const RH = () => H / dpr;

    function tick() {
        if (!running) return;
        requestAnimationFrame(tick);

        ctx.clearRect(0, 0, RW(), RH());

        // Central glow behind headline
        const cx = RW() / 2, cy = RH() * 0.44;
        const cg = ctx.createRadialGradient(cx, cy, 0, cx, cy, Math.min(RW(), RH()) * 0.40);
        cg.addColorStop(0,   'rgba(30,64,175,0.16)');
        cg.addColorStop(0.45,'rgba(30,64,175,0.07)');
        cg.addColorStop(1,   'rgba(30,64,175,0)');
        ctx.fillStyle = cg;
        ctx.fillRect(0, 0, RW(), RH());

        // Mouse glow
        if (!isMobile) {
            const mg = ctx.createRadialGradient(mouse.x, mouse.y, 0, mouse.x, mouse.y, MOUSE_R * 1.4);
            mg.addColorStop(0,   'rgba(99,130,210,0.12)');
            mg.addColorStop(0.4, 'rgba(99,130,210,0.05)');
            mg.addColorStop(1,   'rgba(99,130,210,0)');
            ctx.fillStyle = mg;
            ctx.fillRect(0, 0, RW(), RH());
        }

        for (let i = 0; i < COUNT; i++) {
            const p  = pts[i];
            const dx = p.x - mouse.x;
            const dy = p.y - mouse.y;
            const d  = Math.sqrt(dx * dx + dy * dy);

            // Stronger repulsion so mouse interaction is clearly visible
            if (d < MOUSE_R && d > 0) {
                const f = (MOUSE_R - d) / MOUSE_R * 0.036;
                p.vx += (dx / d) * f;
                p.vy += (dy / d) * f;
            }

            p.vx *= 0.982;
            p.vy *= 0.982;
            p.x  += p.vx;
            p.y  += p.vy;

            if (p.x < 0) p.x = RW(); else if (p.x > RW()) p.x = 0;
            if (p.y < 0) p.y = RH(); else if (p.y > RH()) p.y = 0;

            // Particles near cursor get extra brightness
            const distMouse = Math.sqrt((p.x - mouse.x) ** 2 + (p.y - mouse.y) ** 2);
            const glow = Math.max(0, 1 - distMouse / MOUSE_R) * 0.35;

            ctx.beginPath();
            ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(168,185,210,${Math.min(1, p.a + glow)})`;
            ctx.fill();
        }

        // Constellation lines — significantly brighter
        for (let i = 0; i < COUNT; i++) {
            for (let j = i + 1; j < COUNT; j++) {
                const dx = pts[i].x - pts[j].x;
                const dy = pts[i].y - pts[j].y;
                const d  = Math.sqrt(dx * dx + dy * dy);
                if (d < MAX_DIST) {
                    const alpha = (1 - d / MAX_DIST) * 0.42;
                    ctx.beginPath();
                    ctx.moveTo(pts[i].x, pts[i].y);
                    ctx.lineTo(pts[j].x, pts[j].y);
                    ctx.strokeStyle = `rgba(110,135,200,${alpha})`;
                    ctx.lineWidth = 0.75;
                    ctx.stroke();
                }
            }
        }
    }

    tick();

    window.addEventListener('mousemove', e => { mouse.x = e.clientX; mouse.y = e.clientY; }, { passive: true });
    window.addEventListener('touchmove', e => {
        if (e.touches.length) { mouse.x = e.touches[0].clientX; mouse.y = e.touches[0].clientY; }
    }, { passive: true });
    window.addEventListener('resize', () => {
        W = canvas.width  = window.innerWidth  * dpr;
        H = canvas.height = window.innerHeight * dpr;
        canvas.style.width  = window.innerWidth  + 'px';
        canvas.style.height = window.innerHeight + 'px';
        ctx.scale(dpr, dpr);
    });
    document.addEventListener('visibilitychange', () => {
        running = !document.hidden;
        if (running) tick();
    });
})();

// =============================================================================
// Studio Intro — mouse parallax on CSS orbs
// =============================================================================
(function () {
    const orbs = document.querySelectorAll('.intro-orb');
    if (!orbs.length) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    let targetX = 0, targetY = 0, curX = 0, curY = 0;

    window.addEventListener('mousemove', e => {
        targetX = (e.clientX / window.innerWidth  - 0.5) * 22;
        targetY = (e.clientY / window.innerHeight - 0.5) * 16;
    }, { passive: true });

    let rafId;
    function lerp() {
        curX += (targetX - curX) * 0.06;
        curY += (targetY - curY) * 0.06;
        orbs.forEach((orb, i) => {
            const depth = (i + 1) * 0.4;
            orb.style.transform = `translate(${curX * depth}px, ${curY * depth}px)`;
        });
        rafId = requestAnimationFrame(lerp);
    }
    lerp();

    document.addEventListener('visibilitychange', () => {
        if (document.hidden) cancelAnimationFrame(rafId);
        else lerp();
    });
})();

// =============================================================================
// Homepage Hero — interactive wave canvas
// Mouse interaction scoped to the hero section. Higher opacity, soft glow.
// =============================================================================
(function () {
    const canvas = document.getElementById('hero-bg-canvas');
    if (!canvas) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        canvas.style.display = 'none';
        return;
    }

    const ctx    = canvas.getContext('2d');
    const mobile = window.innerWidth < 768;
    let W, H, running = true, time = 0;

    // Lerped mouse position (0–1 relative to hero section)
    let tMouseX = 0.5, tMouseY = 0.5;
    let cMouseX = 0.5, cMouseY = 0.5;
    let glowTarget = 0, glowCur = 0;

    // Slightly more visible on desktop, mobile unchanged
    const waves = [
        { amp: mobile ? 22 : 44, freq: 0.0058, speed: 0.40, offset: 0.20, opacity: mobile ? 0.22 : 0.26, rgb: '100,116,139' },
        { amp: mobile ? 14 : 30, freq: 0.0098, speed: 0.58, offset: 0.38, opacity: mobile ? 0.17 : 0.21, rgb: '71,85,105'   },
        { amp: mobile ? 26 : 50, freq: 0.0044, speed: 0.24, offset: 0.57, opacity: mobile ? 0.14 : 0.17, rgb: '100,116,139' },
        { amp: mobile ? 16 : 34, freq: 0.0080, speed: 0.50, offset: 0.32, opacity: mobile ? 0.20 : 0.24, rgb: '148,163,184' },
        { amp: mobile ? 12 : 24, freq: 0.0116, speed: 0.70, offset: 0.75, opacity: mobile ? 0.11 : 0.14, rgb: '96,108,168'  },
    ];
    if (!mobile) {
        waves.push({ amp: 18, freq: 0.0062, speed: 0.32, offset: 0.88, opacity: 0.09, rgb: '171,130,68' });
    }

    function resize() {
        const p = canvas.parentElement;
        W = canvas.width  = p.offsetWidth;
        H = canvas.height = p.offsetHeight;
    }

    let frameCount = 0;
    function draw() {
        if (!running) return;
        requestAnimationFrame(draw);

        frameCount++;
        if (mobile && frameCount % 2 !== 0) return;

        time += 0.008;

        // Lerp toward target mouse position
        cMouseX += (tMouseX - cMouseX) * 0.05;
        cMouseY += (tMouseY - cMouseY) * 0.05;
        glowCur  += (glowTarget - glowCur) * 0.06;

        ctx.clearRect(0, 0, W, H);

        // Soft blue glow near cursor (desktop only, fades when mouse leaves)
        if (!mobile && glowCur > 0.002) {
            const gx = cMouseX * W;
            const gy = cMouseY * H;
            const gr = ctx.createRadialGradient(gx, gy, 0, gx, gy, 190);
            gr.addColorStop(0,   `rgba(99,120,190,${0.058 * glowCur})`);
            gr.addColorStop(0.5, `rgba(99,120,190,${0.020 * glowCur})`);
            gr.addColorStop(1,   'rgba(99,120,190,0)');
            ctx.fillStyle = gr;
            ctx.fillRect(0, 0, W, H);
        }

        // Soft ambient amber glow top-right (desktop only) — warmth behind studio card
        if (!mobile) {
            const ax = W * 0.80, ay = H * 0.30;
            const ag = ctx.createRadialGradient(ax, ay, 0, ax, ay, Math.min(W, H) * 0.55);
            ag.addColorStop(0,   'rgba(180,110,0,0.05)');
            ag.addColorStop(0.5, 'rgba(180,110,0,0.02)');
            ag.addColorStop(1,   'rgba(180,110,0,0)');
            ctx.fillStyle = ag;
            ctx.fillRect(0, 0, W, H);
        }

        const mx = (cMouseX - 0.5) * 0.62;   // horizontal phase shift
        const my = (cMouseY - 0.5) * 0.42;   // vertical amplitude influence

        waves.forEach((w, idx) => {
            const baseY = H * w.offset;
            // Waves near cursor Y get extra bend
            const proximity = Math.max(0, 1 - Math.abs(w.offset - cMouseY) * 3.2);
            const ampBoost  = 1 + proximity * my * 0.95;

            ctx.beginPath();
            ctx.moveTo(0, baseY);
            const step = mobile ? 5 : 3;
            for (let x = 0; x <= W; x += step) {
                const y = baseY
                    + Math.sin(x * w.freq + time * w.speed + mx * 3.4) * w.amp * ampBoost
                    + Math.sin(x * w.freq * 0.47 + time * w.speed * 0.52) * (w.amp * 0.30);
                ctx.lineTo(x, y);
            }
            ctx.strokeStyle = `rgba(${w.rgb},${w.opacity})`;
            ctx.lineWidth   = idx < 2 ? 1.5 : 1.2;
            ctx.stroke();
        });
    }

    resize();
    draw();

    window.addEventListener('resize', resize, { passive: true });
    document.addEventListener('visibilitychange', () => {
        running = !document.hidden;
        if (running) draw();
    });

    // Scope mouse interaction to the hero section only (not global window)
    if (!mobile) {
        const hero = canvas.parentElement;
        hero.addEventListener('mousemove', e => {
            const r = hero.getBoundingClientRect();
            tMouseX = Math.max(0, Math.min(1, (e.clientX - r.left) / r.width));
            tMouseY = Math.max(0, Math.min(1, (e.clientY - r.top)  / r.height));
            glowTarget = 1;
        }, { passive: true });
        hero.addEventListener('mouseleave', () => {
            tMouseX = 0.5;
            tMouseY = 0.5;
            glowTarget = 0;
        }, { passive: true });
    }
})();

// =============================================================================
// Showcase — scroll-preview tilt reveal on enter viewport
// =============================================================================
(function () {
    const mockup = document.getElementById('scroll-mockup');
    if (!mockup) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        mockup.classList.add('revealed');
        return;
    }

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                mockup.classList.add('revealed');
                observer.unobserve(mockup);
            }
        });
    }, { threshold: 0.4 });

    observer.observe(mockup);
})();

// =============================================================================
// Showcase — UI micro-interactions demo card
// Scoped to [data-showcase-card="interactions"].
// =============================================================================
(function () {
    const card = document.querySelector('[data-showcase-card="interactions"]');
    if (!card) return;

    const stateButtons = card.querySelectorAll('[data-interact-state]');
    const stepButtons  = card.querySelectorAll('[data-interact-step]');
    const stepLines    = card.querySelectorAll('[data-interact-line]');
    const preview      = card.querySelector('[data-interact-preview]');
    const progressBar  = card.querySelector('[data-interact-progress]');
    const microcopy    = card.querySelector('[data-interact-copy]');

    if (!preview || !stateButtons.length) return;

    const states = {
        hover: {
            progress: 33,
            previewClass: 'bg-blue-50 border-blue-400 text-blue-700 shadow-sm',
            copy: 'Op hover: kleur en schaduw communiceren dat het element klikbaar is.',
        },
        active: {
            progress: 66,
            previewClass: 'bg-slate-900 border-slate-900 text-white shadow-md',
            copy: 'Actieve staat: directe visuele bevestiging dat de actie geregistreerd is.',
        },
        disabled: {
            progress: 100,
            previewClass: 'bg-stone-100 border-stone-200 text-stone-400 cursor-not-allowed opacity-70',
            copy: 'Disabled staat: grijze tint en cursor-not-allowed communiceren geen interactie.',
        },
    };

    function setState(key) {
        const cfg = states[key];
        if (!cfg) return;

        stateButtons.forEach(btn => {
            const active = btn.dataset.interactState === key;
            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
            btn.classList.toggle('bg-slate-900',     active);
            btn.classList.toggle('text-white',        active);
            btn.classList.toggle('border-slate-900',  active);
            btn.classList.toggle('bg-white',         !active);
            btn.classList.toggle('text-slate-600',   !active);
            btn.classList.toggle('border-stone-200', !active);
        });

        if (progressBar) progressBar.style.width = cfg.progress + '%';

        const previewBtn = preview.querySelector('[data-preview-btn]');
        if (previewBtn) {
            previewBtn.className = 'inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-lg border transition-all duration-200 ' + cfg.previewClass;
            previewBtn.textContent = key === 'hover' ? 'Hover →' : key === 'active' ? 'Actief ✓' : 'Disabled';
        }

        if (microcopy) microcopy.textContent = cfg.copy;
    }

    function setStep(n) {
        const total = stepButtons.length;
        stepButtons.forEach(btn => {
            const num    = parseInt(btn.dataset.interactStep);
            const active = num === n;
            if (active) {
                btn.setAttribute('aria-current', 'step');
            } else {
                btn.removeAttribute('aria-current');
            }
            btn.classList.toggle('bg-slate-900',   active);
            btn.classList.toggle('text-white',      active);
            btn.classList.toggle('bg-stone-200',   !active);
            btn.classList.toggle('text-stone-400', !active);
        });
        stepLines.forEach(line => {
            const num = parseInt(line.dataset.interactLine);
            line.classList.toggle('bg-slate-900', num < n);
            line.classList.toggle('bg-stone-200', num >= n);
        });
        if (progressBar && total > 0) progressBar.style.width = Math.round(n / total * 100) + '%';
    }

    stateButtons.forEach(btn => {
        btn.addEventListener('click', () => setState(btn.dataset.interactState));
        btn.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setState(btn.dataset.interactState); }
        });
    });

    stepButtons.forEach(btn => {
        btn.addEventListener('click', () => setStep(parseInt(btn.dataset.interactStep)));
        btn.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setStep(parseInt(btn.dataset.interactStep)); }
        });
    });

    setState('hover');
    setStep(1);
})();

// =============================================================================
// Showcase — scroll-preview section tabs + play sequence
// Scoped to [data-showcase-card="scroll-preview"].
// =============================================================================
(function () {
    const card = document.querySelector('[data-showcase-card="scroll-preview"]');
    if (!card) return;

    const tabs      = card.querySelectorAll('[data-section-tab]');
    const sections  = card.querySelectorAll('[data-section-content]');
    const caption   = card.querySelector('[data-section-caption]');
    const progress  = card.querySelector('[data-section-progress]');
    const mockup    = card.querySelector('#scroll-mockup');
    const playBtn   = card.querySelector('[data-scroll-play]');
    const reduced   = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const captions = {
        'first-impression': 'De bezoeker ziet meteen wie je bent en wat je aanbiedt.',
        'offer':    'Diensten worden duidelijk opgesplitst zodat de bezoeker snel herkent wat hij nodig heeft.',
        'seo':      'Een technische SEO-basis helpt Google en bezoekers de site beter begrijpen.',
        'pricing':  'Richtprijzen geven vertrouwen zonder je vast te pinnen op elk detail.',
        'contact':  'Een duidelijke CTA verlaagt de drempel om een aanvraag te sturen.',
    };

    const progressValues = {
        'first-impression': 20,
        'offer': 40,
        'seo':   60,
        'pricing': 80,
        'contact': 100,
    };

    function setSection(key) {
        tabs.forEach(tab => {
            const active = tab.dataset.sectionTab === key;
            tab.setAttribute('aria-pressed', active ? 'true' : 'false');
            tab.classList.toggle('bg-slate-900',     active);
            tab.classList.toggle('text-white',        active);
            tab.classList.toggle('border-slate-900',  active);
            tab.classList.toggle('bg-white',         !active);
            tab.classList.toggle('text-slate-500',   !active);
            tab.classList.toggle('border-stone-200', !active);
        });

        sections.forEach(sec => {
            const active = sec.dataset.sectionContent === key;
            sec.classList.toggle('opacity-100', active);
            sec.classList.toggle('opacity-40',  !active);
            sec.classList.toggle('ring-2',       active);
            sec.classList.toggle('ring-blue-400', active);
        });

        if (caption)  caption.textContent = captions[key]         || '';
        if (progress) progress.style.width = (progressValues[key] || 20) + '%';
    }

    let isPlaying  = false;
    let playTimer  = null;
    const STAGES   = ['first-impression', 'offer', 'seo', 'pricing', 'contact'];
    const DELAY_MS = reduced ? 600 : 1400;

    function playSequence() {
        if (isPlaying) return;
        isPlaying = true;
        clearTimeout(playTimer);
        if (mockup && !reduced) mockup.classList.add('is-playing');
        if (playBtn) { playBtn.disabled = true; playBtn.setAttribute('aria-busy', 'true'); }

        let i = 0;
        function step() {
            if (i >= STAGES.length) {
                isPlaying = false;
                if (mockup) mockup.classList.remove('is-playing');
                if (playBtn) { playBtn.disabled = false; playBtn.removeAttribute('aria-busy'); }
                return;
            }
            setSection(STAGES[i]);
            i++;
            playTimer = setTimeout(step, DELAY_MS);
        }
        step();
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            if (isPlaying) { clearTimeout(playTimer); isPlaying = false; if (mockup) mockup.classList.remove('is-playing'); if (playBtn) { playBtn.disabled = false; playBtn.removeAttribute('aria-busy'); } }
            setSection(tab.dataset.sectionTab);
        });
        tab.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); tab.click(); }
        });
    });

    if (playBtn) {
        playBtn.addEventListener('click', playSequence);
        playBtn.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); playSequence(); }
        });
    }

    setSection('first-impression');
})();

// =============================================================================
// Showcase — smart request flow demo card (Slimme aanvraagflow)
// Scoped to [data-showcase-card="contactflow"]. No backend interaction.
// =============================================================================
(function () {
    const card = document.querySelector('[data-showcase-card="contactflow"]');
    if (!card) return;

    const optionBtns    = card.querySelectorAll('[data-cf-option]');
    const summaryEl     = card.querySelector('[data-cf-summary]');
    const successEl     = card.querySelector('[data-cf-success]');
    const resultTextEl  = card.querySelector('[data-cf-result-text]');
    const validationEl  = card.querySelector('[data-cf-validation]');
    const checklistEl   = card.querySelector('[data-cf-checklist]');
    const checklistItems= card.querySelector('[data-cf-checklist-items]');

    const labels = {
        new_website:  'Nieuwe website',
        redesign:     'Website vernieuwen',
        catalogue:    'Productcatalogus',
        smart_flow:   'Slimme aanvraagflow',
        maintenance:  'Onderhoud',
    };

    const checklists = {
        new_website:  ['doel van de website', 'bestaande website ja/nee', 'gewenste pagina\'s', 'talen', 'budget en timing'],
        redesign:     ['huidige website', 'wat werkt niet goed', 'gewenste verbeteringen', 'mobiel gebruik', 'SEO of snelheid'],
        catalogue:    ['type producten', 'aantal producten', 'online aanvragen of betalingen', 'categorieën', 'productfoto\'s en teksten'],
        smart_flow:   ['soort aanvraag', 'stappen in het proces', 'opvolging nodig ja/nee', 'automatische bevestiging', 'eventueel AI-samenvatting'],
        maintenance:  ['bestaande website', 'hosting/domein', 'gewenste opvolging', 'kleine aanpassingen', 'technische problemen'],
    };

    const results = {
        new_website:  'De aanvraag komt gestructureerd binnen, zodat het eerste gesprek meteen concreter wordt.',
        redesign:     'Met de juiste context vooraf bespaar je tijd en kan ik een beter voorstel maken.',
        catalogue:    'Scope en budget worden sneller duidelijk — zonder lang heen-en-weer mailen.',
        smart_flow:   'Aanvragen worden gestructureerd samengevat en klaargemaakt voor opvolging.',
        maintenance:  'Technische context is meteen beschikbaar, waardoor ik sneller kan handelen.',
    };

    let selected = null;

    function update() {
        optionBtns.forEach(btn => {
            const active = btn.dataset.cfOption === selected;
            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
            btn.classList.toggle('bg-slate-900',     active);
            btn.classList.toggle('text-white',        active);
            btn.classList.toggle('border-slate-900',  active);
            btn.classList.toggle('bg-white',         !active);
            btn.classList.toggle('text-slate-600',   !active);
            btn.classList.toggle('border-stone-200', !active);
        });

        if (summaryEl) summaryEl.textContent = selected ? (labels[selected] || selected) : '—';

        const hasSelection = selected !== null;
        if (validationEl) validationEl.classList.toggle('hidden', hasSelection);
        if (successEl)    successEl.classList.toggle('hidden',    !hasSelection);
        if (checklistEl)  checklistEl.classList.toggle('hidden',  !hasSelection);

        if (hasSelection && checklistItems) {
            const items = checklists[selected] || [];
            checklistItems.textContent = '';
            items.forEach(text => {
                const li   = document.createElement('li');
                li.className = 'flex items-center gap-1.5 text-xs text-slate-600';
                const dot  = document.createElement('span');
                dot.className = 'w-1 h-1 rounded-full bg-blue-500 shrink-0';
                dot.setAttribute('aria-hidden', 'true');
                const label = document.createElement('span');
                label.textContent = text;
                li.appendChild(dot);
                li.appendChild(label);
                checklistItems.appendChild(li);
            });
        }

        if (hasSelection && resultTextEl) {
            resultTextEl.textContent = results[selected] || '';
        }
    }

    optionBtns.forEach(btn => {
        btn.addEventListener('click', () => { selected = btn.dataset.cfOption; update(); });
        btn.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); selected = btn.dataset.cfOption; update(); }
        });
    });

    update();
})();

// =============================================================================
// Business Card — 3D flip interaction
// Scoped to [data-flip-card]. No external dependencies.
// =============================================================================
(function () {
    const scenes = document.querySelectorAll('[data-flip-card]');
    if (!scenes.length) return;

    scenes.forEach(function (scene) {
        const inner = scene.querySelector('.bc-inner');
        const hint  = scene.querySelector('.bc-hint');
        if (!inner) return;

        const labelFront = inner.dataset.labelFront || '';
        const labelBack  = inner.dataset.labelBack  || '';

        function flip() {
            const isFlipped = inner.classList.toggle('bc-flipped');
            inner.setAttribute('aria-pressed', isFlipped ? 'true' : 'false');
            if (labelFront || labelBack) {
                inner.setAttribute('aria-label', isFlipped ? labelBack : labelFront);
            }
            if (!scene.classList.contains('bc-interacted')) {
                scene.classList.add('bc-interacted');
                if (hint) hint.classList.add('bc-hint-gone');
            }
        }

        inner.addEventListener('click', flip);
        inner.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                flip();
            }
        });
    });
})();
