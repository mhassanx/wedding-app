<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit event details — Admin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Mukta:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root { --maroon: #7A1230; --gold: #C9912E; --teal: #1B4D44; --ivory: #FFF6E9; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Mukta', sans-serif; background: var(--ivory); color: var(--maroon); padding: 30px 20px; }
  .wrap { max-width: 600px; margin: 0 auto; }
  h1 { font-family: 'Cormorant Garamond', serif; font-size: 26px; margin-bottom: 4px; }
  .nav { margin-bottom: 24px; font-size: 13px; }
  .nav a { color: var(--teal); text-decoration: none; font-weight: 600; margin-right: 16px; }
  .card { background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 20px; border: 1px solid #eee; }
  .card h2 { font-family: 'Cormorant Garamond', serif; font-size: 18px; margin-bottom: 14px; color: var(--maroon); }
  .row { display: grid; grid-template-columns: 1fr 1fr 1.5fr; gap: 8px; margin-bottom: 12px; }
  label { display: block; font-size: 12px; font-weight: 600; margin-bottom: 4px; color: var(--maroon); }
  input, textarea { width: 100%; padding: 9px 10px; border: 1px solid var(--gold); border-radius: 6px; font-size: 14px; font-family: 'Mukta', sans-serif; }
  textarea { min-height: 90px; resize: vertical; }
  .field { margin-bottom: 14px; }
  .submit-btn { background: var(--maroon); color: var(--ivory); border: none; border-radius: 6px; padding: 12px 20px; font-size: 14px; font-weight: 600; cursor: pointer; width: 100%; }
  .banner { background: var(--teal); color: var(--ivory); padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px; }
  .error { color: #B3261E; font-size: 12px; margin-top: 4px; }
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

  <form method="POST" action="{{ route('admin.settings.update', ['key' => $key]) }}">
    @csrf

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
      <div class="field">
        <label>This text shows on the invitation page exactly as typed (leave blank to hide this section)</label>
        <textarea name="gift_bank_details">{{ old('gift_bank_details', $settings['gift_bank_details']) }}</textarea>
      </div>
    </div>

    <button class="submit-btn" type="submit">Save changes</button>
  </form>
</div>
</body>
</html>
