 @if (!empty($settings['gift_bank_details']))
 <section class="gift-section">
     <div class="section-title">With love, no obligation</div>
     <div class="section-title-sub"> Your presence and heartfelt prayers are the greatest gift we could ask for. If you wish to bless us further, you may use the details below.</div>
     <div class="gift-card">{{ $settings['gift_bank_details'] }}</div>
 </section>
 @endif