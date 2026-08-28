<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>.: Subdit Keluarga Sakinah :.</title>
    <meta property="og:title" content=""/>
    <meta property="og:site_name" content="Bina KUA dan Keluarga Sakinah" />
    <meta property="og:description" content=""/>
    <meta property="og:image" content=""/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta name="author" content="Administrator">
    <meta property="og:type" content="article" />
    <meta property="og:locale" content="id_ID" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="">
    <link rel="shortcut icon" href="{{ asset('assets/frontend/images/favicon16.png') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:100,300,400,400italic,700'>
    <link rel='stylesheet' id='Oswald-css' href='http://fonts.googleapis.com/css?family=Oswald:100,300,400,400italic,700'>
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Patua+One:100,300,400,400italic,700'>
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/structure.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/driving.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/settings.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HHE8H9DX8M"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-HHE8H9DX8M');
    </script>
</head>
<body class="layout-boxed header-classic minimalist-header header-menu-right sticky-header sticky-white subheader-both-center no-content-padding">
    <style type="text/css">
        .custom-pagination ul.pagination {
            list-style: none !important;
            padding-left: 0 !important;
            display: flex !important;
            gap: 6px;
        }

        .custom-pagination li.page-item {
            list-style: none !important;
        }

        .custom-pagination .page-item .page-link {
            border: 1px solid #2e7d32;
            color: #2e7d32;
            padding: 6px 12px;
            border-radius: 4px;
            background: #fff;
        }

        .custom-pagination .page-item.active .page-link {
            background-color: #2e7d32 !important;
            color: #fff !important;
        }

        .custom-pagination .page-link:hover {
            background-color: #e8f5e9 !important;
            color: #2e7d32 !important;
        }

        .text-muted{
            text-align: center !important;
            margin-left:26px;
        }

        .center-div {
            display: flex;
            justify-content: center;
        }

        .d-sm-none{
            visibility: hidden;
        }


        /*=====================================
        LIST BERITA
        =====================================*/
        .berita-list{
            padding:20px 0;
            transition:.3s;
        }

        .berita-list:hover{
            background:#fafafa;
        }

        /*=====================================
        GAMBAR
        =====================================*/
        .berita-image{
            overflow:hidden;
            border-radius:10px;
        }

        .berita-image img{
            width:100%;
            height:210px;
            object-fit:cover;
            transition:.4s;
        }

        .berita-list:hover .berita-image img{
            transform:scale(1.05);
        }

        /*=====================================
        KONTEN
        =====================================*/
        .berita-content{
            padding-left:20px;
        }

        /*=====================================
        META
        =====================================*/
        .berita-meta{
            margin-bottom:12px;
            font-size:14px;
            color:#999;
        }

        .berita-meta .tanggal{
            color:#b68b00;
            font-weight:600;
        }

        /*=====================================
        JUDUL
        =====================================*/
        .berita-title{
            margin:0 0 15px;
            font-size:18px;
            font-weight:900;
            line-height:1.35;
        }

        .berita-title a{
            color:#222;
            text-decoration:none;
            transition:.3s;
        }

        .berita-title a:hover{
            color:#b68b00;
        }

        /*=====================================
        DESKRIPSI
        =====================================*/
        .berita-desc{
            font-size:14px;
            line-height:1.8;
            color:#666;
            margin-bottom:20px;
        }
        
        .blog-search-wrapper {
            width: 100%;
            max-width: 900px;
            margin: 0 auto 45px auto;
            box-sizing: border-box;
        }
        
        .blog-search-form {
            width: 100%;
            height: 52px;
        
            display: flex;
            align-items: center;
        
            padding: 4px 5px 4px 16px;
        
            background: #fff;
        
            border: 1px solid #ddd;
            border-radius: 12px;
        
            box-shadow: 0 5px 18px rgba(0,0,0,.05);
        
            box-sizing: border-box;
        }
        
        
        /* ICON KIRI */
        .blog-search-icon {
            width: 30px;
            min-width: 30px;
        
            display: flex;
            align-items: center;
            justify-content: center;
        
            font-size: 15px;
            color: #999;
        }
        
        
        /* INPUT */
        .blog-search-input {
            flex: 1;
            min-width: 0;
        
            height: 42px !important;
        
            margin: 0 !important;
            padding: 0 10px !important;
        
            border: 0 !important;
            outline: 0 !important;
        
            background: transparent !important;
        
            box-shadow: none !important;
        
            font-size: 14px !important;
            font-weight: 400 !important;
        
            color: #333 !important;
        }
        
        .blog-search-input:focus {
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
        }
        
        .blog-search-input::placeholder {
            color: #aaa;
            opacity: 1;
        }
        
        
        /* BUTTON */
        .blog-search-button {
            width: auto;
            min-width: 90px;
            height: 42px;
        
            display: flex;
            align-items: center;
            justify-content: center;
        
            gap: 6px;
        
            margin: 0 !important;
            padding: 0 18px !important;
        
            border: 0 !important;
            border-radius: 9px;
        
            background: #d79d00;
        
            color: #fff;
        
            font-size: 13px;
            font-weight: 600;
        
            line-height: 1;
        
            cursor: pointer;
        
            box-sizing: border-box;
        
            transition: .2s;
        }
        
        .blog-search-button:hover {
            background: #bd8a00;
        }
        
        
        /* FOCUS CONTAINER */
        .blog-search-form:focus-within {
            border-color: #d79d00;
        
            box-shadow:
                0 5px 18px rgba(0,0,0,.05),
                0 0 0 3px rgba(215,157,0,.08);
        }
        
        
        /* RESET */
        .blog-search-reset {
            width: 30px;
            height: 30px;
        
            display: flex;
            align-items: center;
            justify-content: center;
        
            margin-right: 5px;
        
            border-radius: 50%;
        
            color: #999;
        
            text-decoration: none;
        }
        
        /* MOBILE */
        @media(max-width:768px) {

            .blog-search-wrapper {
                width: 100%;
                padding: 0 15px;
                margin-bottom: 30px;
            }

            .blog-search-form {
                height: 50px;
            }

            .blog-search-input {
                font-size: 13px !important;
                min-width: 0;
            }

            .blog-search-button {
                min-width: 70px;
                width: 70px;

                padding: 0 12px !important;

                flex-shrink: 0;
            }

            .blog-search-button span {
                display: inline-block;
                white-space: nowrap;
            }

        }

        /*=====================================
        BUTTON
        =====================================*/
        .berita-button{
            display:inline-block;
            color:#b68b00;
            font-weight:700;
            text-decoration:none;
            transition:.3s;
        }

        .berita-button span{
            transition:.3s;
        }

        .berita-button:hover{
            color:#8f6d00;
        }

        .berita-button:hover span{
            padding-left:8px;
        }

        /*=====================================
        GARIS
        =====================================*/
        .hr_wide hr{
            border:none;
            border-top:1px solid #ececec;
            margin-top:10px;
        }

        /*=====================================
        RESPONSIVE
        =====================================*/
        @media (max-width:767px){
            .berita-image img{
                height:220px;
            }

            .berita-content{
                padding-left:0;
                margin-top:20px;
            }

            .berita-title{
                font-size:18px;
            }

            .berita-desc{
                font-size:14px;
                line-height:1.7;
            }
        }

        .visi-list{
            list-style-position: outside;
            margin:15px 0;
            padding-left:22px;
        }

        .visi-list li{
            padding-left:8px;
            line-height:1.8;
        }

        /* =========================================
        LOADER PENCARIAN
        ========================================= */
        #LoaderPencarian {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;

            width: 100vw !important;
            height: 100vh !important;

            margin: 0 !important;
            padding: 0 !important;

            z-index: 999999 !important;
        }

        /* MODAL FULLSCREEN */
        #LoaderPencarian .loader-dialog {
            position: fixed !important;

            top: 0 !important;
            left: 0 !important;

            width: 100vw !important;
            max-width: none !important;

            height: 100vh !important;
            min-height: 100vh !important;

            margin: 0 !important;
            padding: 0 !important;

            transform: none !important;
        }

        /* CONTENT */
        #LoaderPencarian .loader-content {
            position: relative !important;

            width: 100vw !important;
            height: 100vh !important;
            min-height: 100vh !important;

            margin: 0 !important;
            padding: 0 !important;

            background: rgba(0, 0, 0, 0.10) !important;

            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }

        /* POSISI LOADER */
        #LoaderPencarian .loader-position {
            position: fixed !important;

            top: 50% !important;
            left: 50% !important;

            transform: translate(-50%, -50%) !important;

            z-index: 1000000 !important;

            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* GAMBAR LOADER */
        #LoaderPencarian .loader-image {
            display: block !important;

            width: 60px !important;
            height: auto !important;

            margin: 0 !important;
        }

        /* =========================================
        HASIL PENCARIAN BLOG
        ========================================= */

        .hasil-pencarian-blog {
            width: 100%;

            max-height: 0;
            overflow: hidden;

            opacity: 0;
            visibility: hidden;

            margin-top: 0;

            transform: translateY(-10px);

            transition:
                max-height .5s ease,
                opacity .35s ease,
                transform .35s ease,
                margin-top .35s ease;
        }


        /* KETIKA HASIL DITAMPILKAN */
        .hasil-pencarian-blog.show {
            max-height: 550px;

            opacity: 1;
            visibility: visible;

            margin-top: 30px;

            transform: translateY(0);
        }


        /* AREA YANG DI-SCROLL */
        #hasil_pencarian_content {
            max-height: 500px;

            overflow-y: auto;
            overflow-x: hidden;

            padding-right: 10px;

            scroll-behavior: smooth;
        }


        /* SCROLLBAR */
        #hasil_pencarian_content::-webkit-scrollbar {
            width: 6px;
        }

        #hasil_pencarian_content::-webkit-scrollbar-track {
            background: #f2f2f2;
            border-radius: 10px;
        }

        #hasil_pencarian_content::-webkit-scrollbar-thumb {
            background: #d6a000;
            border-radius: 10px;
        }

        #hasil_pencarian_content::-webkit-scrollbar-thumb:hover {
            background: #b88900;
        }

        .info-hasil-pencarian {
            display: none;

            margin-top: 15px;
            padding-left: 5px;

            font-size: 14px;
            color: #777;

            opacity: 0;
            transform: translateY(-5px);

            transition: all .3s ease;
        }

        .info-hasil-pencarian.show {
            display: block;

            opacity: 1;
            transform: translateY(0);
        }

        .info-hasil-pencarian strong {
            color: #d6a000;
            font-weight: 600;
        }

        .pembatas-hasil-pencarian {
            display: none !important;
            width: 100%;
            align-items: center;
            gap: 18px;

            margin-top: 30px;
            margin-bottom: 35px;

            color: #999;
            font-size: 14px;
            font-weight: 500;
        }

        .pembatas-hasil-pencarian.show {
            display: flex !important;
        }

        .pembatas-hasil-pencarian::before,
        .pembatas-hasil-pencarian::after {
            content: "";
            flex: 1;
            height: 4px;
            border-radius: 4px;
            background: #ddd;
        }

        .pembatas-hasil-pencarian span {
            white-space: nowrap;
        }

        /*-----------------------------------------Pagination  */
        /* =========================================
   PAGINATION - DESKTOP
========================================= */

.custom-pagination {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.custom-pagination .pagination {
    display: flex;
    justify-content: center;

    width: auto;
    margin-left: auto !important;
    margin-right: auto !important;
}


/* =========================================
   PAGINATION - MOBILE
========================================= */

@media (max-width: 768px) {

    .custom-pagination {
        display: block !important;

        width: 100% !important;
        max-width: 100% !important;

        overflow-x: auto !important;
        overflow-y: hidden !important;

        padding: 10px 5px 15px !important;

        box-sizing: border-box;

        -webkit-overflow-scrolling: touch;
    }

    .custom-pagination .pagination {
        display: flex !important;
        flex-wrap: nowrap !important;

        width: max-content !important;
        min-width: max-content !important;

        justify-content: flex-start !important;

        margin: 0 !important;
        padding: 0 !important;

        gap: 6px;
    }

    .custom-pagination .page-item {
        flex: 0 0 auto !important;
    }

    .custom-pagination .page-link {
        white-space: nowrap;
    }

}
    </style>

    <div class="modal fade" id="LoaderPencarian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen loader-dialog">
            <div class="modal-content bg-transparent border-0 loader-content">
                <div class="loader-position">
                    <img src="{{ asset('assets/backend/img/loader.gif') }}" class="loader-image" alt="loading..." title="Loader Pencarian">
                </div>
            </div>
        </div>
    </div>

    <div id="Wrapper">
        <div id="Header_wrapper">
            <header id="Header">
                @include('frontend.partials.menu')
            </header>

            <div id="Subheader">
                <div class="container">
                    <div class="column one">
                        <h1 class="title">BLOG</h1>
                    </div>
                </div>
            </div>
        </div>

        <div id="Content">
            <div class="content_wrapper clearfix">
                <div class="sections_group">
                    <div class="entry-content">
                        <div class="section sections_style_2">
                            <div class="section_wrapper clearfix">

                                <!-- PENCARIAN BERITA -->
                                <div class="column one column_column">
                                    <div class="blog-search-wrapper">
                                        <form id="pencarian_blog" method="post" class="blog-search-form">
                                            @csrf

                                            <div class="blog-search-icon">
                                                <i class="icon-search themecolor"></i>
                                            </div>

                                            <input type="text"
                                                name="judul_blog"
                                                id="judul_blog"
                                                class="blog-search-input"
                                                placeholder="Ketikkan judul berita disini..."
                                                autocomplete="off">

                                            <button type="submit" class="blog-search-button">
                                                <span>Cari</span>
                                            </button>
                                        </form>

                                        <div id="info_hasil_pencarian" class="info-hasil-pencarian">
                                        </div>

                                        <div id="hasil_pencarian_blog" class="hasil-pencarian-blog">
                                            <div id="hasil_pencarian_content"></div>
                                        </div>

                                        <div id="pembatas_hasil_pencarian" class="pembatas-hasil-pencarian">
                                            <span>Batas akhir hasil pencarian berita</span>
                                        </div>
                                    </div>
                                </div>

                                @forelse ($berita as $info)

                                    <div class="items_group clearfix berita-list">

                                        <div class="column one-third column_image">
                                            <div class="image_frame no_link scale-with-grid no_border aligncenter">

                                                <div class="image_wrapper berita-image">

                                                    <a href="{{ url('blog/'.$info->pranala) }}">
                                                        <img
                                                            class="scale-with-grid img-fixed"
                                                            src="{{ Storage::url($info->files) }}"
                                                            alt="{{ $info->meta_title }}"
                                                            title="{{ $info->meta_title }}">
                                                    </a>

                                                </div>

                                            </div>
                                        </div>


                                        <div class="column two-third column_column">
                                            <div class="column_attr">

                                                <div class="berita-content">

                                                    <div class="berita-meta">

                                                        <span class="tanggal">
                                                            📅 {{ indo_date($info->tgl) }}
                                                        </span>

                                                        <span class="jam">
                                                            • {{ $info->jam_menit }}
                                                        </span>

                                                    </div>


                                                    <h3 class="berita-title">

                                                        <a href="{{ url('blog/'.$info->pranala) }}">
                                                            {{ $info->judul }}
                                                        </a>

                                                    </h3>


                                                    <p class="berita-desc">
                                                        {{ Str::words(strip_tags($info->excerpt),35,'...') }}
                                                    </p>


                                                    <a class="berita-button"
                                                    href="{{ url('blog/'.$info->pranala) }}">

                                                        Baca Selengkapnya
                                                        <span>→</span>

                                                    </a>

                                                </div>

                                            </div>
                                        </div>


                                        <div class="column one column_divider">
                                            <div class="hr_wide hrmargin_b_40">
                                                <hr>
                                            </div>
                                        </div>

                                    </div>

                                @empty

                                    <div class="column one column_column">

                                        <div class="blog-empty">

                                            <div class="blog-empty-icon">
                                                <i class="fas fa-search"></i>
                                            </div>

                                            <h3>
                                                Berita tidak ditemukan
                                            </h3>

                                            <p>
                                                Tidak ditemukan berita dengan kata kunci
                                                <strong>"{{ request('q') }}"</strong>.
                                            </p>

                                            <a href="{{ url('blog') }}">
                                                Tampilkan Semua Berita
                                            </a>

                                        </div>

                                    </div>

                                @endforelse


                                <div class="column one column_column">
                                    <div class="center-div">

                                        <div class="custom-pagination mt-3">

                                            {{ $berita->appends(request()->query())
                                                    ->links('pagination::bootstrap-5') }}

                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('frontend.layouts.footer')

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="{{ url('assets/frontend/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/frontend/js/jquery-migrate-3.4.0.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/mfn.menu.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.plugins.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/jquery.jplayer.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/animations.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.video.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.migration.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/rs-plugin/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.onload = function() {
            $('#LoaderPencarian').hide();
        };

        //<![CDATA[
        jQuery(window).on('load', function () {
            var retina = window.devicePixelRatio> 1 ? true : false;
            if (retina) {
                var retinaEl = jQuery("#logo img");
                var retinaLogoW = retinaEl.width();
                var retinaLogoH = retinaEl.height();
                retinaEl.attr("src","{{ asset('assets/frontend/images/logo1.png') }}").width(retinaLogoW).height(retinaLogoH)
            }
        });
        //]]>

        //---------------------------------------------------------- Pencarian Blog
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("pencarian_blog");
            const inputPencarian = document.getElementById("judul_blog");
            const wrapper = document.getElementById("hasil_pencarian_blog");
            const content = document.getElementById("hasil_pencarian_content");
            const info = document.getElementById("info_hasil_pencarian");
            const pembatas = document.getElementById("pembatas_hasil_pencarian");

            inputPencarian.addEventListener("input", function () {

                if (this.value.trim() === "") {
                    if (wrapper) {
                        wrapper.classList.remove("show");
                    }

                    if (info) {
                        info.classList.remove("show");
                        info.style.display = "none";
                    }

                    if (pembatas) {
                        pembatas.classList.remove("show");
                    }

                    setTimeout(() => {
                        if (content) {
                            content.innerHTML = "";
                        }

                        if (info) {
                            info.innerHTML = "";
                        }
                    }, 300);
                }
            });

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const judul_blog = formData.get("judul_blog")?.trim();
                const token = formData.get("_token")?.trim();

                if (!judul_blog) {
                    return showError(
                        "Maaf, pastikan kolom pencarian sudah diisi."
                    );
                }

                if (!token) {
                    return showError("Token harus diisi.");
                }try {
                    showLoader();

                    const response = await fetch(
                        "{{ url('/blog/pencarian') }}",
                        {
                            method: "POST",
                            body: formData
                        }
                    );

                    const result = await response.json();
                    if (result.message === 200) {
                        info.style.display = "block";
                        info.innerHTML = `
                            Ditemukan <strong>${result.total}</strong> berita
                        `;
                        info.classList.add("show");
                        content.innerHTML = result.html;
                        requestAnimationFrame(() => {
                            wrapper.classList.add("show");
                            if (pembatas) {
                                pembatas.classList.add("show");
                            }
                        });
                        content.scrollTop = 0;
                    }else if (result.message === 201) {
                        info.style.display = "block";
                        info.innerHTML = `
                            <h4 style="margin-top:15px;">
                                Mohon maaf, berita tidak ditemukan.
                            </h4>
                        `;
                        info.classList.add("show");
                        wrapper.classList.add("show");
                        if (pembatas) {
                            pembatas.classList.remove("show");
                        }
                    }
                } catch (error) {
                    console.error("Fetch Error:", error);
                    Swal.fire(
                        "Error",
                        "Terjadi kesalahan jaringan atau server.",
                        "error"
                    );
                } finally {
                    hideLoader();
                }
            });

            function showError(msg) {
                if (typeof toastr !== "undefined") {
                    toastr.error(msg, "Error");
                } else {
                    alert(msg);
                }
            }

            function showLoader() {
                const loader =
                    document.getElementById("LoaderPencarian");
                if (loader) {
                    loader.style.display = "block";
                }
            }

            function hideLoader() {
                const loader =
                    document.getElementById("LoaderPencarian");
                if (loader) {
                    loader.style.display = "none";
                }
            }
        });

        //---------------------------------------------------------- Karakter
        $(function(){
            $("input[name='judul_blog']").on('input', function() {
                $(this).val(
                    $(this).val().replace(/[^a-zA-Z0-9, ]/g, '')
                );
            });
        });
    </script>
</body>

</html>