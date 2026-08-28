<!doctype html>
<html lang="en">
  @include('backend.partials.header')
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <style type="text/css">
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

        .info-title-icon{

            width:34px;
            height:34px;

            border-radius:8px;

            background:#e8f1ff;

            color:#0d6efd;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:15px;

        }

        .info-section{

            margin-top:5px;

        }

        .info-label{

            font-size:12px;

            color:#8b9098;

            text-transform:uppercase;

            letter-spacing:.5px;

        }

        .info-value{

            margin-top:3px;

            font-size:18px;

            color:#2d3748;

        }

        .info-item{

            display:flex;

            align-items:flex-start;

            gap:12px;

        }

        .info-item i{

            margin-top:4px;

            font-size:18px;

            width:20px;

        }

        .info-item small{

            display:block;

            color:#8b9098;

            font-size:12px;

            text-transform:uppercase;

            letter-spacing:.4px;

        }

        .info-item div div{

            font-size:15px;

            font-weight:600;

            color:#2d3748;

            margin-top:2px;

        }

        @media(max-width:768px){

            .info-value{

                font-size:16px;

            }

            .info-item{

                margin-bottom:8px;

            }
        }

        .compare-card{
            border:1px solid #dfe7f3;
            border-radius:18px;
            background:#fff;
            overflow:hidden;
            box-shadow:0 8px 24px rgba(0,0,0,.05);
        }

        /* ================= HEADER ================= */

        .compare-header{
            display:flex;
            align-items:flex-start;
            gap:20px;
            padding:26px 30px;
            border-bottom:1px solid #eef2f6;
        }

        .compare-icon{
            width:56px;
            height:56px;
            border-radius:14px;
            background:#eef5ff;
            color:#0d6efd;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:24px;
            flex-shrink:0;
        }

        .compare-info{
            flex:1;
        }

        .compare-header h3{
            margin:0;
            font-size:32px;
            font-weight:700;
            line-height:1.2;
        }

        .compare-header p{
            margin:6px 0 15px;
            color:#777;
            font-size:15px;
        }

        /* ================= INFORMASI KEGIATAN ================= */

        .compare-meta{
            margin-top:18px;
            padding-top:18px;
            border-top:1px dashed #dee2e6;
        }

        .meta-row{
            display:flex;
            align-items:flex-start;
            margin-bottom:12px;
        }

        .meta-col{
            display:flex;
            flex:1;
        }

        .meta-label{
            width:120px;
            font-size:15px;
            font-weight:700;
            color:#495057;
            flex-shrink:0;
        }

        .meta-label i{
            width:18px;
            margin-right:6px;
        }

        .meta-value{
            flex:1;
            color:#212529;
            font-size:15px;
            font-weight:500;
            line-height:1.6;
        }

        @media(max-width:768px){

            .meta-row,
            .meta-col{
                display:block;
            }

            .meta-col{
                margin-bottom:10px;
            }

            .meta-label{
                width:100%;
                margin-bottom:4px;
            }

        }

        /* ================= TABLE ================= */

        .compare-table th,
        .compare-table td{
            padding:16px;
            vertical-align:middle;
        }

        .compare-table thead th{
            font-size:16px;
            font-weight:700;
        }

        .compare-table tbody td:first-child{
            background:#fafafa;
            font-weight:600;
        }

        /* ================= FOTO ================= */

        .photo-box{
            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;
            padding:12px;
        }

        .compare-photo{
            width:110px;
            height:145px;
            object-fit:cover;
            border-radius:10px;
            border:3px solid #e9ecef;
            box-shadow:0 5px 12px rgba(0,0,0,.08);
            transition:.25s;
        }

        .compare-photo:hover{
            transform:scale(1.04);
        }

        .photo-label{
            margin-top:8px;
            font-size:13px;
            color:#666;
            font-weight:600;
        }

        /* ================= FOOTER ================= */

        .compare-footer{
            padding:28px;
        }

        .compare-footer .form-label{
            margin-bottom:8px;
            font-weight:600;
        }

        .compare-footer .form-select,
        .compare-footer textarea{
            border-radius:10px;
        }

        .compare-footer textarea{
            resize:none;
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width:768px){

            .compare-header{
                flex-direction:column;
                gap:16px;
                padding:20px;
            }

            .compare-header h3{
                font-size:25px;
            }

            .compare-header p{
                margin-bottom:15px;
            }

            .meta-row{
                flex-direction:column;
                align-items:flex-start;
                gap:8px;
            }

            .meta-col{
                width:100%;
            }

            .meta-label{
                width:95px;
                font-size:13px;
            }

            .meta-value{
                font-size:14px;
            }

            .compare-photo{
                width:85px;
                height:115px;
            }

            .compare-table th,
            .compare-table td{
                padding:12px;
                font-size:13px;
            }

            .compare-footer{
                padding:20px;
            }

        }
    </style>
    
    <div class="app-wrapper">
      @include('backend.partials.navbar')
      
      @include('backend.partials.sidebar')
      
      @include('backend.contents.informasi.sertifikat')
      
      @include('backend.partials.footer')
    </div>
    @include('backend.partials.scripts')

    @include('backend.ajaxs.informasi.sertifikat')
  </body>
</html>
