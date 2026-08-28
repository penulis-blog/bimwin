<!doctype html>
<html lang="en">
  @include('backend.partials.header')
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
      @include('backend.partials.navbar')
      
      @include('backend.partials.sidebar')
      
      @include('backend.contents.informasi.berita')
      
      @include('backend.partials.footer')
    </div>

    @include('backend.partials.scripts')

    @include('backend.ajaxs.informasi.berita')
  </body>
</html>
