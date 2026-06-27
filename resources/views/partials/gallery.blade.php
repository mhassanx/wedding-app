  <section class="gallery-section">
      <div class="section-title">Our gallery</div>
      <div class="section-title-sub">A few favourite moments</div>
      @if ($galleryImages->isEmpty())
      <p class="gallery-empty">Photos coming soon.</p>
      @else
      <div class="swiper weddingSwiper">

          <div class="swiper-wrapper">

              @foreach($galleryImages as $image)

              <div class="swiper-slide">

                  <div class="gallery-card">

                      <a
                          href="{{ asset('storage/'.$image->path) }}"
                          data-fancybox="gallery"
                          data-caption="{{ $image->caption }}">

                          <img
                              src="{{ asset('storage/'.$image->path) }}"
                              alt="{{ $image->caption ?? 'Wedding photo' }}"
                              loading="lazy">

                      </a>

                  </div>

              </div>

              @endforeach

          </div>

          <div class="swiper-pagination"></div>

          <div class="swiper-button-next"></div>

          <div class="swiper-button-prev"></div>

          <div class="gallery-counter">
              <span id="current-slide">1</span>
              /
              <span id="total-slides">{{ count($galleryImages) }}</span>
          </div>

      </div>
      @endif
  </section>