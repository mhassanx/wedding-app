  <section class="hero">
      <svg class="paisley-corner tl" viewBox="0 0 100 100" aria-hidden="true">
          <path d="M10 10 Q 40 5, 50 30 Q 60 55, 35 60 Q 15 63, 18 45 Q 20 32, 32 35 Q 40 37, 36 46" fill="none" stroke="#C9912E" stroke-width="3" stroke-linecap="round" />
          <circle cx="32" cy="35" r="3" fill="#E8A33D" />
      </svg>
      <svg class="paisley-corner tr" viewBox="0 0 100 100" aria-hidden="true">
          <path d="M10 10 Q 40 5, 50 30 Q 60 55, 35 60 Q 15 63, 18 45 Q 20 32, 32 35 Q 40 37, 36 46" fill="none" stroke="#C9912E" stroke-width="3" stroke-linecap="round" />
          <circle cx="32" cy="35" r="3" fill="#E8A33D" />
      </svg>

      <div class="hero-eyebrow">Together with their families</div>
      <h1 class="hero-names">{{ explode(' ', $settings['bride_name'])[0] }}<span class="hero-amp">&amp;</span>{{ explode(' ', $settings['groom_name'])[0] }}</h1>
      <div class="hero-date">{{ $settings['mehndi_date'] }} &ndash; {{ $settings['nikah_date'] }}</div>
      <div class="hero-sub">Mian Channu, Pakistan</div>
      <div class="divider"><span class="line"></span><span class="dot"></span><span class="line"></span></div>

      <div class="share-row">
          <a class="share-btn" id="whatsapp-share" href="#" target="_blank" rel="noopener">Share on WhatsApp</a>
          <button class="share-btn" id="copy-link" type="button">Copy invitation link</button>
      </div>
  </section>