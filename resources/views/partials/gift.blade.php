 @if ($bankAccounts->isNotEmpty())
 <section class="gift-section">
     <div class="section-title">With love, no obligation</div>
     <div class="section-title-sub"> Your presence and heartfelt prayers are the greatest gift we could ask for. If you wish to bless us further, you may use the details below.</div>
     <div class="gift-card">
         @foreach ($bankAccounts as $account)
         <div class="gift-detail-row">
             <span class="gift-detail-text">
                 <strong>{{ $account->account_name }}</strong>
                 @if (!empty($account->account_holder_name))
                 <br>Account Holder: {{ $account->account_holder_name }}
                 @endif
                 @if (!empty($account->account_number))
                 <br>Account Number: {{ $account->account_number }}
                 @endif
                 @if (!empty($account->iban))
                 <br>IBAN: {{ $account->iban }}
                 @endif
             </span>
             <div class="gift-copy-actions">
                 @if (!empty($account->account_number))
                 <button type="button" class="gift-copy-btn" data-copy-value="{{ e($account->account_number) }}">Copy Number</button>
                 @endif
                 @if (!empty($account->iban))
                 <button type="button" class="gift-copy-btn" data-copy-value="{{ e($account->iban) }}">Copy IBAN</button>
                 @endif
             </div>
         </div>
         @endforeach
     </div>
 </section>
 @endif