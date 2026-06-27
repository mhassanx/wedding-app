<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin — Ayesha & Adnan's Wedding</title>
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
      max-width: 800px;
      margin: 0 auto;
    }

    h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 26px;
      margin-bottom: 4px;
    }

    .nav {
      display: flex;
      flex-wrap: wrap;
      gap: 10px 16px;
      margin-bottom: 24px;
      font-size: 20px;
    }

    .nav a {
      color: var(--teal);
      text-decoration: none;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
    }

    @media (max-width: 576px) {
      .nav {
        font-size: 16px;
        gap: 8px 12px;
      }
    }

    .summary {
      color: var(--teal);
      font-size: 14px;
      margin-bottom: 20px;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 24px;
      border: 1px solid #eee;
    }

    .card h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 19px;
      margin-bottom: 14px;
      color: var(--maroon);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      text-align: left;
      padding: 10px 12px;
      font-size: 13px;
      border-bottom: 1px solid #eee;
    }

    th {
      background: var(--maroon);
      color: var(--ivory);
      font-weight: 600;
    }

    tr:last-child td {
      border-bottom: none;
    }

    .empty {
      padding: 20px;
      text-align: center;
      color: var(--teal);
      font-size: 13px;
    }

    .add-form {
      display: flex;
      gap: 8px;
      margin-bottom: 16px;
    }

    .add-form input {
      flex: 1;
      padding: 9px 12px;
      border: 1px solid var(--gold);
      border-radius: 6px;
      font-size: 14px;
    }

    .add-form button {
      background: var(--maroon);
      color: var(--ivory);
      border: none;
      border-radius: 6px;
      padding: 9px 16px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
    }

    .link-cell {
      font-size: 12px;
      word-break: break-all;
    }

    .link-cell a {
      color: var(--teal);
    }

    .copy-btn {
      font-size: 11px;
      border: 1px solid var(--gold);
      background: #fff;
      border-radius: 12px;
      padding: 3px 9px;
      cursor: pointer;
      margin-left: 6px;
    }

    .del-btn {
      font-size: 11px;
      border: 1px solid #B3261E;
      color: #B3261E;
      background: #fff;
      border-radius: 12px;
      padding: 3px 9px;
      cursor: pointer;
    }

    .status-yes {
      color: var(--teal);
      font-weight: 600;
    }

    .status-no {
      color: #999;
    }

    .banner {
      background: var(--teal);
      color: var(--ivory);
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 18px;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <h1>Admin dashboard</h1>
    <div class="nav">
      <a href="{{ route('home') }}" target="_blank" rel="noopener">View invitation</a>
      <a href="{{ route('admin.settings.edit', ['key' => $key]) }}">Edit event details</a>
      <a href="{{ route('admin.gallery', ['key' => $key]) }}">Manage gallery</a>
    </div>

    @if (session('guest_added'))
    <div class="banner">Guest added — copy their link below and send it to them.</div>
    @endif

    <div class="card">
      <h2>Add a guest</h2>
      <form class="add-form" method="POST" action="{{ route('admin.guests.store', ['key' => $key]) }}">
        @csrf
        <input type="text" name="name" placeholder="Guest or family name" required maxlength="255">
        <button type="submit">Generate link</button>
      </form>

      @if ($guestLinks->isEmpty())
      <div class="empty">No personalized links yet. Add a name above.</div>
      @else
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Link</th>
            <th>Opened</th>
            <th>RSVP&rsquo;d</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($guestLinks as $guest)
          <tr>
            <td>{{ $guest->name }}</td>
            <td class="link-cell">
              <span id="link-{{ $guest->id }}">{{ url('/invite/' . $guest->invite_code) }}</span>
              <button class="copy-btn" type="button" onclick="copyLink('{{ $guest->id }}')">Copy</button>
            </td>
            <td>{{ $guest->opened_at ? $guest->opened_at->format('d M, h:i A') : '—' }}</td>
            <td>
              @if ($guest->rsvp)
              <span class="status-yes">Yes ({{ $guest->rsvp->guest_count }})</span>
              @else
              <span class="status-no">Not yet</span>
              @endif
            </td>
            <td>
              <form method="POST" action="{{ route('admin.guests.destroy', ['guest' => $guest->id, 'key' => $key]) }}" onsubmit="return confirm('Remove this guest link?');">
                @csrf @method('DELETE')
                <button class="del-btn" type="submit">Remove</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>

    <div class="card">
      <h2>RSVP responses</h2>
      <div class="summary">{{ $rsvps->count() }} response{{ $rsvps->count() === 1 ? '' : 's' }} &middot; {{ $totalGuests }} total guest{{ $totalGuests === 1 ? '' : 's' }}</div>
      @if ($rsvps->isEmpty())
      <div class="empty">No RSVPs yet.</div>
      @else
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Guests</th>
            <th>Message</th>
            <th>Submitted</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($rsvps as $rsvp)
          <tr>
            <td>{{ $rsvp->name }}</td>
            <td>{{ $rsvp->guest_count }}</td>
            <td>{{ $rsvp->message ?: '—' }}</td>
            <td>{{ $rsvp->created_at->format('d M, h:i A') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @endif
    </div>
  </div>

  <script>
    function copyLink(id) {
      var text = document.getElementById('link-' + id).textContent;
      navigator.clipboard.writeText(text);
    }
  </script>
</body>

</html>