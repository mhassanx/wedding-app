<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit event details — Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Mukta:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --maroon: #7A1230;
      --gold: #C9912E;
      --teal: #1B4D44;
      --ivory: #FFF6E9;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Mukta', sans-serif;
      background: var(--ivory);
      color: var(--maroon);
      padding: 30px 20px;
    }

    .wrap {
      max-width: 600px;
      margin: 0 auto;
    }

    h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 26px;
      margin-bottom: 4px;
    }

    .nav {
      margin-bottom: 24px;
      font-size: 13px;
    }

    .nav a {
      color: var(--teal);
      text-decoration: none;
      font-weight: 600;
      margin-right: 16px;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid #eee;
    }

    .card h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 18px;
      margin-bottom: 14px;
      color: var(--maroon);
    }

    .row {
      display: grid;
      grid-template-columns: 1fr 1fr 1.5fr;
      gap: 8px;
      margin-bottom: 12px;
    }

    label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      margin-bottom: 4px;
      color: var(--maroon);
    }

    input,
    textarea {
      width: 100%;
      padding: 9px 10px;
      border: 1px solid var(--gold);
      border-radius: 6px;
      font-size: 14px;
      font-family: 'Mukta', sans-serif;
    }

    textarea {
      min-height: 90px;
      resize: vertical;
    }

    .field {
      margin-bottom: 14px;
    }

    .submit-btn {
      background: var(--maroon);
      color: var(--ivory);
      border: none;
      border-radius: 6px;
      padding: 12px 20px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      width: 100%;
    }

    .banner {
      background: var(--teal);
      color: var(--ivory);
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 18px;
    }

    .error {
      color: #B3261E;
      font-size: 12px;
      margin-top: 4px;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <h1>Edit event details</h1>
    <div class="nav">
      <a href="{{ route('admin.dashboard', ['key' => $key]) }}">&larr; Back to dashboard</a>
    </div>

    @if (session('settings_saved'))
    <div class="banner">Saved. Changes are live on the invitation page now.</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update', ['key' => $key]) }}" enctype="multipart/form-data">
      @csrf

      <div class="card">
        <h2>Link preview image</h2>
        <p style="font-size: 13px; color: var(--teal); margin-bottom: 14px;">This image appears when you paste your invitation link in WhatsApp, Facebook, iMessage, and other apps. Recommended size: 1200&times;630 px.</p>
        @if (!empty($settings['share_image']))
        <img src="{{ str_starts_with($settings['share_image'], 'images/') ? asset($settings['share_image']) : asset('storage/' . $settings['share_image']) }}" alt="Current link preview image" style="width: 100%; max-width: 420px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #eee;">
        <div class="field" style="margin-top: 12px;">
          <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; cursor: pointer;">
            <input type="checkbox" name="use_default_share_image" value="1" {{ old('use_default_share_image') ? 'checked' : '' }}>
            Use default preview image instead
          </label>
        </div>
        @else
        <img src="{{ asset('images/og-preview.jpg') }}" alt="Default link preview image" style="width: 100%; max-width: 420px; border-radius: 8px; margin-bottom: 12px; border: 1px solid #eee;">
        <p style="font-size: 12px; color: #666; margin-bottom: 12px;">Using the default preview image until you upload your own.</p>
        @endif
        <div class="field">
          <label>Upload preview image</label>
          <input type="file" name="share_image" accept="image/*">
        </div>
      </div>

      <div class="card">
        <h2>Couple</h2>
        <div class="field"><label>Bride's full name</label><input type="text" name="bride_name" value="{{ old('bride_name', $settings['bride_name']) }}" required></div>
        <div class="field"><label>Groom's full name</label><input type="text" name="groom_name" value="{{ old('groom_name', $settings['groom_name']) }}" required></div>
      </div>

      <div class="card">
        <h2>Mehndi</h2>
        <div class="row">
          <div><label>Date</label><input type="text" name="mehndi_date" value="{{ old('mehndi_date', $settings['mehndi_date']) }}" required></div>
          <div><label>Time</label><input type="text" name="mehndi_time" value="{{ old('mehndi_time', $settings['mehndi_time']) }}" required></div>
          <div><label>Venue</label><input type="text" name="mehndi_venue" value="{{ old('mehndi_venue', $settings['mehndi_venue']) }}" required></div>
        </div>
      </div>

      <div class="card">
        <h2>Nikah</h2>
        <div class="row">
          <div><label>Date</label><input type="text" name="nikah_date" value="{{ old('nikah_date', $settings['nikah_date']) }}" required></div>
          <div><label>Time</label><input type="text" name="nikah_time" value="{{ old('nikah_time', $settings['nikah_time']) }}" required></div>
          <div><label>Venue</label><input type="text" name="nikah_venue" value="{{ old('nikah_venue', $settings['nikah_venue']) }}" required></div>
        </div>
      </div>

      <div class="card">
        <h2>Walima</h2>
        <div class="row">
          <div><label>Date</label><input type="text" name="walima_date" value="{{ old('walima_date', $settings['walima_date']) }}" required></div>
          <div><label>Time</label><input type="text" name="walima_time" value="{{ old('walima_time', $settings['walima_time']) }}" required></div>
          <div><label>Venue</label><input type="text" name="walima_venue" value="{{ old('walima_venue', $settings['walima_venue']) }}" required></div>
        </div>
      </div>

      <div class="card">
        <h2>Countdown timer</h2>
        <div class="field">
          <label>Countdown target (date and time the countdown reaches zero)</label>
          <input type="text" name="countdown_target" value="{{ old('countdown_target', $settings['countdown_target']) }}" placeholder="2026-07-23T18:00:00+05:00" required>
        </div>
      </div>

      <div class="card">
        <h2>Contact information</h2>
        <div class="row" style="grid-template-columns: 1fr 1fr;">
          <div><label>Contact 1 name</label><input type="text" name="contact_name_1" value="{{ old('contact_name_1', $settings['contact_name_1']) }}"></div>
          <div><label>Contact 1 phone</label><input type="text" name="contact_phone_1" value="{{ old('contact_phone_1', $settings['contact_phone_1']) }}"></div>
        </div>
        <div class="row" style="grid-template-columns: 1fr 1fr;">
          <div><label>Contact 2 name</label><input type="text" name="contact_name_2" value="{{ old('contact_name_2', $settings['contact_name_2']) }}"></div>
          <div><label>Contact 2 phone</label><input type="text" name="contact_phone_2" value="{{ old('contact_phone_2', $settings['contact_phone_2']) }}"></div>
        </div>
      </div>

      <div class="card">
        <h2>Gift &amp; bank details</h2>
        <p style="font-size: 13px; color: var(--teal); margin-bottom: 14px;">Add one or more bank accounts. Each account can have a name, account number, and optional IBAN.</p>

        <div id="bank-accounts-list">
          @foreach ((old('bank_accounts', $bankAccounts->toArray()) ?: []) as $index => $account)
          <div class="bank-account-row" style="border: 1px solid #eee; border-radius: 8px; padding: 12px; margin-bottom: 12px;">
            <div class="row" style="grid-template-columns: 1fr 1fr;">
              <div class="field">
                <label>Bank name</label>
                <input type="text" name="bank_accounts[{{ $index }}][account_name]" value="{{ $account['account_name'] ?? '' }}" required>
              </div>
              <div class="field">
                <label>Account holder name</label>
                <input type="text" name="bank_accounts[{{ $index }}][account_holder_name]" value="{{ $account['account_holder_name'] ?? '' }}">
              </div>
            </div>
            <div class="row" style="grid-template-columns: 1fr 1fr;">
              <div class="field">
                <label>Sort order</label>
                <input type="number" name="bank_accounts[{{ $index }}][sort_order]" value="{{ $account['sort_order'] ?? $index }}" min="0">
              </div>
            </div>
            <div class="row" style="grid-template-columns: 1fr 1fr;">
              <div class="field">
                <label>Account number</label>
                <input type="text" name="bank_accounts[{{ $index }}][account_number]" value="{{ $account['account_number'] ?? '' }}">
              </div>
              <div class="field">
                <label>IBAN (optional)</label>
                <input type="text" name="bank_accounts[{{ $index }}][iban]" value="{{ $account['iban'] ?? '' }}">
              </div>
            </div>
            <button type="button" class="remove-bank-account" style="border: 1px solid #B3261E; color: #B3261E; background: #fff; border-radius: 999px; padding: 4px 10px; cursor: pointer;">Remove</button>
          </div>
          @endforeach
        </div>

        <button type="button" id="add-bank-account" style="background: var(--teal); color: #fff; border: none; border-radius: 6px; padding: 8px 14px; cursor: pointer; font-weight: 600;">Add another account</button>
      </div>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const list = document.getElementById('bank-accounts-list');
          const addButton = document.getElementById('add-bank-account');

          if (!list || !addButton) return;

          function createAccountRow(index) {
            return `
            <div class="bank-account-row" style="border: 1px solid #eee; border-radius: 8px; padding: 12px; margin-bottom: 12px;">
              <div class="row" style="grid-template-columns: 1fr 1fr;">
                <div class="field">
                  <label>Bank name</label>
                  <input type="text" name="bank_accounts[${index}][account_name]" required>
                </div>
                <div class="field">
                  <label>Account holder name</label>
                  <input type="text" name="bank_accounts[${index}][account_holder_name]">
                </div>
              </div>
              <div class="row" style="grid-template-columns: 1fr 1fr;">
                <div class="field">
                  <label>Sort order</label>
                  <input type="number" name="bank_accounts[${index}][sort_order]" value="${index}" min="0">
                </div>
              </div>
              <div class="row" style="grid-template-columns: 1fr 1fr;">
                <div class="field">
                  <label>Account number</label>
                  <input type="text" name="bank_accounts[${index}][account_number]">
                </div>
                <div class="field">
                  <label>IBAN (optional)</label>
                  <input type="text" name="bank_accounts[${index}][iban]">
                </div>
              </div>
              <button type="button" class="remove-bank-account" style="border: 1px solid #B3261E; color: #B3261E; background: #fff; border-radius: 999px; padding: 4px 10px; cursor: pointer;">Remove</button>
            </div>`;
          }

          addButton.addEventListener('click', function() {
            const index = list.querySelectorAll('.bank-account-row').length;
            list.insertAdjacentHTML('beforeend', createAccountRow(index));
          });

          list.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-bank-account')) {
              event.target.closest('.bank-account-row').remove();
            }
          });
        });
      </script>

      <button class="submit-btn" type="submit">Save changes</button>
    </form>
  </div>
</body>

</html>