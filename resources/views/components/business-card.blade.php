@props(['size' => 'normal'])
<div class="bc-scene {{ $size === 'compact' ? 'bc-scene--compact' : '' }}" data-flip-card>
    <div class="bc-float-wrapper">
        <div
            class="bc-inner"
            role="button"
            tabindex="0"
            aria-pressed="false"
            aria-label="{{ __('site.contact.card_aria_front') }}"
            data-label-front="{{ __('site.contact.card_aria_front') }}"
            data-label-back="{{ __('site.contact.card_aria_back') }}"
        >
            {{-- ───────────────────────────────────────────────────────── --}}
            {{-- FRONT — premium brand side (shown by default)            --}}
            {{-- Required asset: public/images/vm-logo.png                --}}
            {{-- ───────────────────────────────────────────────────────── --}}
            <div class="bc-face bc-front" aria-hidden="true">

                {{-- Left: brand identity --}}
                <div class="bc-f-left">
                    <h3 class="bc-brand-name">Van Malder<br>Studio</h3>
                    <div class="bc-hdivider"></div>
                    <p class="bc-tagline">Websites voor<br>lokale ondernemers</p>
                    <p class="bc-f-front-hint">{{ __('site.contact.card_front_hint') }}</p>
                </div>

                {{-- Right: VM monogram circle --}}
                <div class="bc-f-right">
                    <div class="bc-f-circle">
                        @if(file_exists(public_path('images/vm-logo.png')))
                            <img
                                src="{{ asset('images/vm-logo.png') }}"
                                alt=""
                                class="bc-f-logo-img"
                                aria-hidden="true"
                                loading="lazy"
                            >
                        @else
                            <svg class="bc-f-logo-svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <circle cx="12" cy="12" r="10.5" stroke="#c49a3a" stroke-width="1"/>
                                <text x="12" y="16.5" text-anchor="middle" font-family="'Instrument Serif', Georgia, serif" font-size="9.5" fill="#c49a3a">VM</text>
                            </svg>
                        @endif
                    </div>
                </div>

            </div>{{-- .bc-front --}}

            {{-- ───────────────────────────────────────────────────────── --}}
            {{-- BACK — contact info side (shown after flip)              --}}
            {{-- ───────────────────────────────────────────────────────── --}}
            <div class="bc-face bc-back" aria-hidden="true">

                {{-- Left: VM logo --}}
                <div class="bc-b-left">
                    @if(file_exists(public_path('images/vm-logo.png')))
                        <img
                            src="{{ asset('images/vm-logo.png') }}"
                            alt=""
                            class="bc-logo-img"
                            aria-hidden="true"
                            loading="lazy"
                        >
                    @else
                        <svg class="bc-logo-svg" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                            <circle cx="12" cy="12" r="10.5" stroke="#c49a3a" stroke-width="1"/>
                            <text x="12" y="16.5" text-anchor="middle" font-family="'Instrument Serif', Georgia, serif" font-size="9.5" fill="#c49a3a">VM</text>
                        </svg>
                    @endif
                    <div class="bc-hdivider"></div>
                    <p class="bc-tagline">Websites voor<br>lokale ondernemers</p>
                </div>

                {{-- Vertical divider --}}
                <div class="bc-vdivider"></div>

                {{-- Right: contact details --}}
                <div class="bc-b-right">
                    <h3 class="bc-name">Xander Van Malder</h3>
                    <p class="bc-studio-label">VAN MALDER STUDIO</p>

                    <div class="bc-contacts">

                        {{-- Email --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <rect x="2" y="4" width="20" height="16" rx="2"/>
                                    <polyline points="2,4 12,13 22,4"/>
                                </svg>
                            </div>
                            <span class="bc-contact-text">{{ config('studio.email') }}</span>
                        </div>
                        <div class="bc-hdivider-sm"></div>

                        {{-- Website --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="2" y1="12" x2="22" y2="12"/>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                </svg>
                            </div>
                            <span class="bc-contact-text">www.vanmalderstudio.be</span>
                        </div>
                        <div class="bc-hdivider-sm"></div>

                        {{-- Location --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <span class="bc-contact-text">Druivenstreek (Tervuren)</span>
                        </div>
                        <div class="bc-hdivider-sm"></div>

                        {{-- LinkedIn --}}
                        <div class="bc-contact-row">
                            <div class="bc-icon-circle">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                                    <rect x="2" y="9" width="4" height="12"/>
                                    <circle cx="4" cy="4" r="2"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="bc-contact-text">LinkedIn</p>
                                <a
                                    href="https://www.linkedin.com/in/xander-van-malder/"
                                    class="bc-contact-link"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    tabindex="-1"
                                >linkedin.com/in/xander-van-malder/</a>
                            </div>
                        </div>

                    </div>{{-- .bc-contacts --}}
                </div>{{-- .bc-b-right --}}

            </div>{{-- .bc-back --}}

        </div>{{-- .bc-inner --}}
    </div>{{-- .bc-float-wrapper --}}

    <p class="bc-hint" aria-hidden="true">↻&ensp;{{ __('site.contact.card_hint') }}</p>

</div>{{-- .bc-scene --}}
