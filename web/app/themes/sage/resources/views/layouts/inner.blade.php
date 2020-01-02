<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>


    <div class="theme-app d-flex flex-column">
      <div class="theme-wrap">
        <!-- Site Overlay -->
        <section class="site-overlay"></section>
        <main class="theme-main">
          @php do_action('get_header') @endphp
          @include('partials.header')
          <section class="above-the-fold">
            <div id="carouselExampleIndicators" class="carousel carousel-hero slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-caption">
                  <div class="container">
                    <div class="row text-left">
                      <div class="col-12 col-md-7 offset-md-5">
                        <h1 class="text-uppercase">
                        </h1>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="carousel-item__innerpages active">
                  <img src="@asset('images/news-hero-bg-thumb.jpg')"
                       class="carousel-img lazy bg-lazyloading" alt="Visit Nepal 2020" width="100%"
                       height="100%" data-img="true"
                       data-src="@asset('images/news-hero-bg@2x.jpg')" />
                </div>
              </div>
            </div>
          </section>
          <!-- End of above the fold -->

          @yield('content')
        </main>
      </div>
      @php do_action('get_footer') @endphp
      @include('partials.footer')
      @php wp_footer() @endphp
    </div>



  </body>
</html>
