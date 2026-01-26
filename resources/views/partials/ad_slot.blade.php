@php
    $slotConfig = config("ads.slots.{$slot}");
    $showSlot = false;

    if ($slotConfig && ($slotConfig['enabled'] ?? false)) {
        $now = now();
        $showSlot = true;

        if (!empty($slotConfig['starts_at']) && $now->lt(\Illuminate\Support\Carbon::parse($slotConfig['starts_at']))) {
            $showSlot = false;
        }

        if (!empty($slotConfig['ends_at']) && $now->gt(\Illuminate\Support\Carbon::parse($slotConfig['ends_at']))) {
            $showSlot = false;
        }
    }
@endphp

@if ($showSlot)
    <div class="ad-slot ad-slot--hidden {{ $class ?? '' }}" data-ad-slot="{{ $slot }}">
        <button class="ad-close" type="button" aria-label="Fermer la publicite" data-ad-close>
            &times;
        </button>
        <div class="ad-label">{{ __('public.ad_label') }}</div>
        @if (!empty($slotConfig['target_url']))
            <a href="{{ $slotConfig['target_url'] }}" target="_blank" rel="noopener" class="ad-media">
                @if (!empty($slotConfig['image_url']))
                    <img src="{{ $slotConfig['image_url'] }}" alt="{{ $slotConfig['title'] ?? __('public.ad_label') }}">
                @endif
            </a>
        @else
            <div class="ad-media">
                @if (!empty($slotConfig['image_url']))
                    <img src="{{ $slotConfig['image_url'] }}" alt="{{ $slotConfig['title'] ?? __('public.ad_label') }}">
                @endif
            </div>
        @endif

        @if (!empty($slotConfig['title']))
            <div class="ad-title">{{ $slotConfig['title'] }}</div>
        @endif
    </div>
@endif
