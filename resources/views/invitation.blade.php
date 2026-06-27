<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $settings['bride_name'] }} & {{ $settings['groom_name'] }} — Wedding Invitation</title>
  <meta name="description" content="Join us in celebrating the wedding of {{ $settings['bride_name'] }} and {{ $settings['groom_name'] }}.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Allura&family=Mukta:wght@400;500;600&display=swap" rel="stylesheet">
  <link
    rel="stylesheet"
    href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox/fancybox.css" />
  <link rel="stylesheet" href="{{ asset('css/invitation.css') }}">





</head>

<body>

  <div class="wrap" id="invitation-content">
    <div class="frame-border">

      @if ($guest)
      <div class="greeting-bar">Dear {{ $guest->name }}, you're warmly invited &mdash; we hope to celebrate with you</div>
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
  @endphp

  <script>
    window.invitationSettings = {
      brideName: "{{ $brideName }}",
      groomName: "{{ $groomName }}"
    };
  </script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox/fancybox.umd.js"></script>
  <script src="{{ asset('js/invitation.js') }}"></script>






</body>

</html>