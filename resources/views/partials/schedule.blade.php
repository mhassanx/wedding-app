  <section class="schedule-section">
    <svg class="paisley-corner bl" viewBox="0 0 100 100" style="opacity:0.5" aria-hidden="true">
      <path d="M10 10 Q 40 5, 50 30 Q 60 55, 35 60 Q 15 63, 18 45 Q 20 32, 32 35 Q 40 37, 36 46" fill="none" stroke="#E8A33D" stroke-width="3" stroke-linecap="round" />
    </svg>
    <svg class="paisley-corner br" viewBox="0 0 100 100" style="opacity:0.5" aria-hidden="true">
      <path d="M10 10 Q 40 5, 50 30 Q 60 55, 35 60 Q 15 63, 18 45 Q 20 32, 32 35 Q 40 37, 36 46" fill="none" stroke="#E8A33D" stroke-width="3" stroke-linecap="round" />
    </svg>

    <div class="section-title">Wedding events</div>
    <div class="section-title-sub">Join us in celebration</div>
    <div class="events-grid">
      <div class="event-card">
        <div class="event-name">Mehndi</div>
        <div class="event-date">{{ $settings['mehndi_date'] }}</div>
        <div class="event-time">{{ $settings['mehndi_time'] }}</div>
        <div class="event-venue">{{ $settings['mehndi_venue'] }}</div>
      </div>
      <div class="event-card">
        <div class="event-name">Nikah</div>
        <div class="event-date">{{ $settings['nikah_date'] }}</div>
        <div class="event-time">{{ $settings['nikah_time'] }}</div>
        <div class="event-venue">{{ $settings['nikah_venue'] }}</div>
      </div>
      <!-- Walima removed from public site per request -->
    </div>
  </section>