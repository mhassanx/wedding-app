  @if (!empty($settings['contact_name_1']) || !empty($settings['contact_name_2']))
  <section class="contact-section">
      <div class="section-title" style="color: var(--maroon);">Questions?</div>
      <div class="section-title-sub" style="color: var(--gold);">Reach out to us</div>
      <div class="contact-grid">
          @if (!empty($settings['contact_name_1']))
          <div class="contact-card"><strong>{{ $settings['contact_name_1'] }}</strong>{{ $settings['contact_phone_1'] }}</div>
          @endif
          @if (!empty($settings['contact_name_2']))
          <div class="contact-card"><strong>{{ $settings['contact_name_2'] }}</strong>{{ $settings['contact_phone_2'] }}</div>
          @endif
      </div>
  </section>
  @endif