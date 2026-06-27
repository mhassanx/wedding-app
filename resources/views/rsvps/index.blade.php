<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Guest list — Ayesha & Adnan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Mukta:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --maroon: #7A1230;
    --gold: #C9912E;
    --teal: #1B4D44;
    --ivory: #FFF6E9;
  }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Mukta', sans-serif; background: var(--ivory); color: var(--maroon); padding: 30px 20px; }
  .wrap { max-width: 720px; margin: 0 auto; }
  h1 { font-family: 'Cormorant Garamond', serif; font-size: 28px; margin-bottom: 6px; }
  .summary { color: var(--teal); font-size: 14px; margin-bottom: 24px; }
  table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
  th, td { text-align: left; padding: 12px 14px; font-size: 14px; border-bottom: 1px solid #eee; }
  th { background: var(--maroon); color: var(--ivory); font-weight: 600; }
  tr:last-child td { border-bottom: none; }
  .empty { padding: 30px; text-align: center; color: var(--teal); }
</style>
</head>
<body>
<div class="wrap">
  <h1>Guest list</h1>
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
</body>
</html>
