@php
    $currentLocale = $currentLocale ?? app()->getLocale();
    $logoByLocale = [
        'ar' => 'assets/images/logo-ar.png',
        'fr' => 'assets/images/logo-fr.png',
        'en' => 'assets/images/logo-en.png',
    ];
    $logoPath = asset($logoByLocale[$currentLocale] ?? $logoByLocale['fr']);
    $logoClass = $logoClass ?? '';
    $logoAlt = $logoAlt ?? 'WNانفو';
@endphp

<img src="{{ $logoPath }}" class="{{ $logoClass }}" alt="{{ $logoAlt }}">
