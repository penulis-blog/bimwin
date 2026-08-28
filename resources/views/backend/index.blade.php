<!doctype html>
<html lang="en">
  @include('backend.partials.header')
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <style type="text/css">
      /* RESET ADMINLTE YANG SERING BIKIN RUSAK */
      .users-list li img {
        max-width: none !important;
        height: 100% !important;
        width: 100% !important;
        border-radius: 0 !important;
      }

      /* GRID RAPI */
      .users-list {
        display: flex !important;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 0;
        margin: 0;
      }

      .users-list > li {
        list-style: none;
        width: calc(33.333% - 20px); /* 3 kolom */
        text-align: center;
      }

      /* WRAPPER BULAT (KUNCI UTAMA) */
      .user-photo-wrapper {
        width: 100px;
        height: 100px;
        margin: 0 auto 10px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        border: 3px solid #f1f1f1;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        transition: 0.25s ease;
      }

      /* GAMBAR DI DALAM */
      .user-photo-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      /* HOVER AMAN (TIDAK MERUSAK LAYOUT) */
      .user-photo-wrapper:hover {
        transform: translateY(-5px);
      }

      /* TEKS */
      .users-list-name {
        display: block;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

      .users-list-date {
        font-size: 12px;
        color: #777;
      }

      @media (max-width: 768px) {
        .users-list > li {
          width: 50%; /* jadi 2 kolom */
        }
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

    <div class="modal fade" id="Loader_Proses" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content" style="background-color:transparent; border:0px solid;">
              <div class="modal-body">
                  <center><img src="/assets/backend/img/loader.gif" alt="" class="img-fluid d-block w-7" style="width:50px;" /></center>
              </div>
          </div>
      </div>
    </div>

    <div class="app-wrapper">
      @include('backend.partials.navbar')
      
      @include('backend.partials.sidebar')
      
      @include('backend.contents.dashboard')
      
      @include('backend.partials.footer')
    </div>
    
    @include('backend.partials.dashboard')
  </body>
</html>
