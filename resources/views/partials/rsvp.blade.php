<section class="rsvp-section" id="rsvp">
    <div class="section-title">Will you join us?</div>
    <div class="section-title-sub">Kindly RSVP below</div>

    @if (session('rsvp_success'))
    <div class="rsvp-success">Thank you! Your RSVP has been received. We can&rsquo;t wait to celebrate with you.</div>
    @endif

    <form class="rsvp-form" method="POST" action="{{ route('rsvp.store') }}">
        @csrf
        @if ($guest)
        <input type="hidden" name="invite_code" value="{{ $guest->invite_code }}">
        @endif

        <div class="form-group">
            <label class="form-label" for="name">Your name</label>
            <input class="form-input" type="text" id="name" name="name" value="{{ old('name', $guest?->name) }}" required maxlength="255">
            @error('name')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="guest_count">Number of guests attending</label>
            <input class="form-input" type="number" id="guest_count" name="guest_count" min="1" max="20" value="{{ old('guest_count', 1) }}" required>
            @error('guest_count')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="message">A message or wish for the couple (optional)</label>
            <textarea class="form-textarea" id="message" name="message" maxlength="1000">{{ old('message') }}</textarea>
            @error('message')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <button class="form-submit" type="submit">Send RSVP</button>
    </form>
</section>