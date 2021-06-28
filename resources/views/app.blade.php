<!DOCTYPE html>
<html lang="en">
<head>
    @include('_partials.header')
    @include('_partials.css_asset')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
     
        {{-- navbar --}}
        @include('_partials.navbar')

        {{-- sidebar --}}
        @include('_partials.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>{{$headerTitle}}</h1>
          </div>
          
          @yield('content')
        </section>
      </div>
      
      @include('_partials.footer')
    </div>
  </div>

  {{-- <!-- JS Libraies -->
  <script src="../node_modules/simpleweather/jquery.simpleWeather.min.js"></script>
  <script src="../node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="../node_modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="../node_modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="../node_modules/summernote/dist/summernote-bs4.js"></script>
  <script src="../node_modules/chocolat/dist/js/jquery.chocolat.min.js"></script> --}}

  <!-- Page Specific JS File -->
  @include('_partials.js')

  @stack('script')

  
</body>
</html>
