@php
  $brideFirst = explode(' ', $settings['bride_name'])[0];
  $groomFirst = explode(' ', $settings['groom_name'])[0];
@endphp

<div id="opening-overlay" class="opening-overlay" aria-hidden="false">
  <div class="opening-backdrop" aria-hidden="true"></div>

  <div class="opening-scene">
    <div class="opening-card" id="opening-card" role="button" tabindex="0" aria-label="Tap to open your invitation">

      {{-- Closed face --}}
      <div class="opening-card__cover">
        <div class="opening-card__pattern" aria-hidden="true"></div>

        <svg class="opening-card__corner opening-card__corner--tl" viewBox="0 0 80 80" aria-hidden="true">
          <path d="M8 8 Q 32 4, 40 24 Q 48 44, 28 48 Q 12 50, 14 36 Q 16 26, 26 28 Q 32 30, 29 37" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="26" cy="28" r="2.5" fill="currentColor"/>
        </svg>
        <svg class="opening-card__corner opening-card__corner--tr" viewBox="0 0 80 80" aria-hidden="true">
          <path d="M8 8 Q 32 4, 40 24 Q 48 44, 28 48 Q 12 50, 14 36 Q 16 26, 26 28 Q 32 30, 29 37" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="26" cy="28" r="2.5" fill="currentColor"/>
        </svg>
        <svg class="opening-card__corner opening-card__corner--bl" viewBox="0 0 80 80" aria-hidden="true">
          <path d="M8 8 Q 32 4, 40 24 Q 48 44, 28 48 Q 12 50, 14 36 Q 16 26, 26 28 Q 32 30, 29 37" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="26" cy="28" r="2.5" fill="currentColor"/>
        </svg>
        <svg class="opening-card__corner opening-card__corner--br" viewBox="0 0 80 80" aria-hidden="true">
          <path d="M8 8 Q 32 4, 40 24 Q 48 44, 28 48 Q 12 50, 14 36 Q 16 26, 26 28 Q 32 30, 29 37" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="26" cy="28" r="2.5" fill="currentColor"/>
        </svg>

        <p class="opening-card__bismillah" dir="rtl" lang="ur">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِیْمِ</p>

        @if ($guest)
        <p class="opening-card__cover-for">For</p>
        <p class="opening-card__cover-name">{{ $guest->name }}</p>
        @else
        <p class="opening-card__cover-for">Wedding</p>
        <p class="opening-card__cover-name">Invitation</p>
        @endif

        <div class="opening-card__seal">
          <span class="opening-card__seal-ring" aria-hidden="true"></span>
          <span class="opening-card__seal-inner">
            <svg viewBox="0 0 32 32" width="28" height="28" aria-hidden="true">
              <path fill="currentColor" d="M18 6c-4.4 0-8 3.6-8 8 0 4.4 3.6 8 8 8 1.2 0 2.3-.3 3.3-.7-2.8-1.5-4.7-4.5-4.7-8 0-3.5 1.9-6.5 4.7-8.1C20.3 6.3 19.2 6 18 6z"/>
              <path fill="currentColor" d="M24 5l.8 1.6 1.8.3-1.3 1.3.2 1.8L24 8.8l-1.5.9.2-1.8-1.3-1.3 1.8-.3L24 5z"/>
            </svg>
          </span>
        </div>

        <p class="opening-card__hint">Tap to open</p>
      </div>

      {{-- Inner invitation revealed on open --}}
      <div class="opening-card__inner">
        <div class="opening-card__inner-frame">
          <p class="opening-card__inner-bismillah" dir="rtl" lang="ur">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِیْمِ</p>

          @if ($guest)
          <p class="opening-card__guest-label">Dear</p>
          <h2 class="opening-card__guest-name">{{ $guest->name }}</h2>
          <p class="opening-card__guest-message">You are cordially invited to celebrate with us</p>
          @else
          <p class="opening-card__guest-label">You're</p>
          <h2 class="opening-card__guest-name">Invited</h2>
          <p class="opening-card__guest-message">Join us in this blessed celebration</p>
          @endif

          <div class="opening-card__divider" aria-hidden="true">
            <span class="opening-card__divider-line"></span>
            <span class="opening-card__divider-star">✦</span>
            <span class="opening-card__divider-line"></span>
          </div>

          <p class="opening-card__couple-label">Wedding of</p>
          <p class="opening-card__couple-names">{{ $brideFirst }} <span>&amp;</span> {{ $groomFirst }}</p>
          <p class="opening-card__couple-date">{{ $settings['mehndi_date'] }} &ndash; {{ $settings['walima_date'] }}</p>
        </div>
      </div>

    </div>
  </div>
</div>
