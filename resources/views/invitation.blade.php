<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pageTitle }}</title>
  <meta name="description" content="{{ $pageDescription }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ $shareUrl }}">
  <meta property="og:title" content="{{ $pageTitle }}">
  <meta property="og:description" content="{{ $pageDescription }}">
  @if ($shareImage)
  <meta property="og:image" content="{{ $shareImage }}">
  <meta property="og:image:alt" content="{{ $settings['bride_name'] }} and {{ $settings['groom_name'] }} wedding invitation">
  @endif
  <meta name="twitter:card" content="{{ $shareImage ? 'summary_large_image' : 'summary' }}">
  <meta name="twitter:title" content="{{ $pageTitle }}">
  <meta name="twitter:description" content="{{ $pageDescription }}">
  @if ($shareImage)
  <meta name="twitter:image" content="{{ $shareImage }}">
  @endif
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cormorant+Garamond:wght@400;500;600;700&family=Allura&family=Mukta:wght@400;500;600&family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox/fancybox.css" />
  <link rel="stylesheet" href="{{ asset('css/invitation.css') }}">





</head>

<body class="invitation-locked">

  @include('partials.opening-card')

  <div class="wrap" id="invitation-content">
    <div class="frame-border">

      @if ($guest)
      <div class="greeting-banner">
        <div class="greeting-banner__ornament" aria-hidden="true">✦</div>
        <p class="greeting-banner__text">
          <span class="greeting-banner__dear">Dear {{ $guest->name }},</span>
          <span class="greeting-banner__message">you are warmly invited to share in our joy</span>
        </p>
        <div class="greeting-banner__ornament" aria-hidden="true">✦</div>
      </div>
      @endif

      @include('partials.hero')

      @include('partials.countdown')

      @include('partials.schedule')

      @include('partials.map')

      @include('partials.gallery')

      @include('partials.gift')

      @include('partials.contact')

      @include('partials.rsvp')

      @include('partials.footer')

    </div>
  </div>
  @php
  $brideName = addslashes($settings['bride_name'] ?? '');
  $groomName = addslashes($settings['groom_name'] ?? '');
  $guestName = addslashes($guest?->name ?? '');
  $inviteCode = addslashes($guest?->invite_code ?? '');
  @endphp

  <script>
    window.invitationSettings = {
      brideName: "{{ $brideName }}",
      groomName: "{{ $groomName }}",
      guestName: "{{ $guestName }}",
      inviteCode: "{{ $inviteCode }}"
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox/fancybox.umd.js"></script>
  <script src="{{ asset('js/invitation.js') }}"></script>






</body>

</html>