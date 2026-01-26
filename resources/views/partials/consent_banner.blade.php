<div class="consent-banner" data-consent-banner>
    <div class="consent-banner__logo">
        @include('partials.logo_path', ['logoAlt' => 'WNانفو'])
    </div>
    <div class="consent-banner__content">
        <p>{{ __('public.consent_prompt') }}</p>
    </div>
    <div class="consent-banner__actions">
        <button type="button" data-consent-action="accept">{{ __('public.consent_accept') }}</button>
        <button type="button" data-consent-action="decline">{{ __('public.consent_decline') }}</button>
    </div>
</div>
