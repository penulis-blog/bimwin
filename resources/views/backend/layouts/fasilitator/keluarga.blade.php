<!doctype html>
<html lang="en">
  @include('backend.partials.header')
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <style type="text/css">
      .select2-container .select2-selection--single {
          height: 38px;
          padding: 5px 10px;
      }

      .select2-container--default .select2-selection--single .select2-selection__rendered {
          line-height: 28px;
      }

      .select2-container--default .select2-selection--single .select2-selection__arrow {
          height: 38px;
      }

      /* =============================================
          DASHBOARD SWITCHER
        ============================================= */

        .dashboard-switcher{
            display:flex;
            align-items:center;

            padding:4px;

            background:#f3f6f9;

            border:1px solid #e8edf2;
            border-radius:10px;
        }


        /* ITEM */

        .dashboard-switch{
            height:34px;

            display:flex;
            align-items:center;
            justify-content:center;

            gap:7px;

            padding:0 14px;

            border-radius:7px;

            color:#6c757d;

            font-size:13px;
            font-weight:500;

            text-decoration:none;

            transition:all .2s ease;
        }


        /* ICON */

        .dashboard-switch i{
            font-size:14px;
        }


        /* HOVER */

        .dashboard-switch:hover{
            background:#e9eef3;

            color:#17a2b8;

            text-decoration:none;
        }


        /* ACTIVE */

        .dashboard-switch.active{
            background:#17a2b8;

            color:#fff;

            box-shadow:0 2px 5px rgba(23,162,184,.20);
        }


        /* ACTIVE HOVER */

        .dashboard-switch.active:hover{
            background:#138496;

            color:#fff;
        }
    </style>
    
    <div class="app-wrapper">
      @include('backend.partials.navbar')
      
      @include('backend.partials.sidebar')
      
      @include('backend.contents.fasilitator.keluarga')
      
      @include('backend.partials.footer')
    </div>

    @include('backend.partials.scripts')

    @include('backend.ajaxs.fasilitator.keluarga')
  </body>
</html>
