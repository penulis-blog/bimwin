<html class="no-js">
<head>
    <meta charset="utf-8">
    <title>.: Subdit Keluarga Sakinah :.</title>
    <meta property="og:title" content="{{ $berita->meta_title ?? '' }}"/>
    <meta property="og:site_name" content="Bina KUA dan Keluarga Sakinah" />
    <meta property="og:description" content="{{ $berita->meta_deskripsi ?? '' }}"/>
    <meta property="og:image" content="{{ $berita?->files ? asset(Storage::url($berita->files)) : '' }}">
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta name="author" content="Administrator">
    <meta property="og:type" content="article" />
    <meta property="og:locale" content="id_ID" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="{{ $berita->meta_keywords ?? '' }}">
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

    <style>
        .comment-wrapper {
            max-width: 900px;
            margin: auto;
        }

        .comment-title {
            font-weight: bold;
            margin-bottom: 12px;
            font-size: 18px;
        }

        .comment-box {
            background: #fff;
            border-radius: 10px;
            padding: 12px 14px 48px;
            position: relative;

            box-shadow:
                0 4px 12px rgba(0, 0, 0, 0.12),
                0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .comment-box textarea {
            width: 100%;
            border: none;
            outline: none;
            resize: none;
            min-height: 90px;
            font-size: 14px;
        }

        .comment-box textarea::placeholder {
            color: #999;
        }

        .comment-footer {
            position: absolute;
            left: 14px;
            right: 14px;
            bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .char-count {
            font-size: 12px;
            color: #666;
        }

        .btn-send {
            background: #dbac00;
            color: #fff;
            border: none;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-send:hover {
            background: #dbac00;
        }

        /* INPUT NAMA */
        .comment-name {
            width: 100%;
            padding: 8px 10px;
            font-size: 14px;
            border: 1px solid #e1e1e1;
            border-radius: 6px;
            margin-bottom: 12px;
            background: #fafafa;
        }

        .comment-name:focus {
            outline: none;
            border-color: #dbac00;
            box-shadow: 0 0 0 2px rgba(219, 172, 0, 0.15);
            background: #fff;
        }

        /* TEXTAREA */
        .comment-box textarea {
            width: 100%;
            border: 1px solid #e1e1e1;     /* ← INI YANG MEMBEDAKAN */
            border-radius: 6px;
            padding: 10px;
            resize: none;
            min-height: 100px;
            font-size: 14px;
            margin-bottom: 14px;
            background: #fff;
        }

        .comment-box textarea:focus {
            outline: none;
            border-color: #dbac00;
            box-shadow: 0 0 0 2px rgba(219, 172, 0, 0.15);
        }

        .comment-name,
        .comment-box textarea {
            box-sizing: border-box;
        }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            .comment-name {
                font-size: 13px;
            }

            .comment-box textarea {
                font-size: 13px;
                min-height: 90px;
            }
        }

        .comment-list {
            max-width: 900px;
            margin: auto;
            font-family: Arial, sans-serif;
        }

        .comment-item {
            display: flex;
            gap: 12px;
            padding: 16px 0;
            border-bottom: 1px solid #eee;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            color: #fff;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }

        .purple { background: #7b1fa2; }
        .greenkemenag { background: #066215; }
        .greykemenag { background: #797979; }
        .orange { background: #f57c00; }
        .red    { background: #e53935; }

        .comment-content {
            flex: 1;
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .comment-header strong {
            color: #000;
        }

        .comment-header .time {
            color: #777;
            font-size: 12px;
        }

        .comment-header .menu {
            margin-left: auto;
            cursor: pointer;
            color: #999;
        }

        .comment-text {
            font-size: 14px;
            margin: 6px 0 8px;
            line-height: 1.5;
        }

        .comment-actions {
            font-size: 13px;
            color: #666;
            display: flex;
            gap: 16px;
        }

        .comment-actions span {
            cursor: pointer;
        }

        .comment-actions .reply {
            color: #1976d2;
        }

        /* BALASAN */
        .comment-reply {
            margin-top: 12px;
            padding-left: 30px;
            border-left: 2px solid #eee;
        }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            .comment-item {
                gap: 10px;
            }

            .avatar {
                width: 36px;
                height: 36px;
                font-size: 13px;
            }

            .comment-text {
                font-size: 13px;
            }

            .comment-actions {
                font-size: 12px;
            }
        }

        .comment-form {
            position: sticky;
            bottom: 0;
            background: #fff;
            padding-top: 10px;
        }

        .comment-scroll-wrapper {
            max-height: 420px;          /* atur sesuai kebutuhan */
            overflow-y: auto;
            padding-right: 10px;
        }

        /* Scrollbar modern */
        .comment-scroll-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .comment-scroll-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .comment-scroll-wrapper::-webkit-scrollbar-thumb {
            background: #bbb;
            border-radius: 10px;
        }

        .comment-scroll-wrapper::-webkit-scrollbar-thumb:hover {
            background: #999;
        }

        @media (max-width: 768px) {
            .comment-scroll-wrapper {
                max-height: 300px;
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

        .detail-blog-image {
            display: block;
            width: 100%;
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .detail-blog-image {
                width: 100%;
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body class="layout-boxed header-classic minimalist-header header-menu-right sticky-header sticky-white subheader-both-center no-content-padding">
    <div id="Wrapper">
        <div id="Header_wrapper">
            <header id="Header">
                @include('frontend.partials.menu')
            </header>
            <div id="Subheader">
                <div class="container">
                    <div class="column one">
                        <h1 class="title">{{ strtoupper($berita?->kategori_berita ?? '') }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div id="Content">
            <div class="content_wrapper clearfix">
                <div class="sections_group">
                    <div class="entry-content">
                        <div class="section" style="padding-top:50px; padding-bottom:0px;">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <div class="column two-third column_column">
                                        <div class="column_attr">
                                            <h3 style="font-weight: 400;">{{ $berita?->judul ?? '' }}</h3>
                                            <p class="big">
                                                <b>Keluarga Sakinah,</b> 
                                                {{ $berita?->tgl ? indo_date($berita->tgl) : '' }},
                                                {{ $berita?->jam_menit ?? '' }}
                                            </p>
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button class="btn btn-sm" title="Share Facebook" onclick="Page.FB(this.value)" value="{{ $berita?->public_id ?? '' }}"><i class="icon-facebook themecolor" style="color: white; font-size:20px;"></i></button>
                                            <button class="btn btn-sm" title="Share Twitter" onclick="Page.Twit(this.value)" value="{{ $berita?->public_id ?? '' }}"><i class="icon-twitter themecolor" style="color: white; font-size:20px;"></i></button>
                                            <button class="btn btn-sm" title="Salink Link" onclick="Page.Copy(this.value)" value="{{ $berita?->public_id ?? '' }}"><i class="icon-link themecolor" style="color: white; font-size:20px;"></i></button>
                                            <button class="btn btn-sm" title="Like Berita" onclick="Page.Like(this.value)" value="{{ $berita?->public_id ?? '' }}"><i class="icon-thumbs-up themecolor" style="color: white; font-size:20px;"></i></button>
                                            <button class="btn btn-sm" title="unLike Berita" onclick="Page.unLike(this.value)" value="{{ $berita?->public_id ?? '' }}"><i class="icon-thumbs-down themecolor" style="color: white; font-size:20px;"></i></button>
                                            <div class="image_wrapper">
                                                <img src="{{ $berita?->files ? Storage::url($berita->files) : '' }}"
                                                    class="scale-with-grid detail-blog-image"
                                                    alt="{{ $berita?->meta_title ?? '' }}"
                                                    title="{{ $berita?->meta_title ?? '' }}" />
                                            </div>
                                            <p class="big">{!! $berita?->isi ?? '' !!}</p>
                                            <p><b>Sumber:</b><br> {{ $berita?->post_by ?? '' }}</p>
                                            @php
                                                $tags = array_map('trim', explode(',', $berita->meta_tags ?? ''));
                                            @endphp

                                            @foreach ($tags as $tag)
                                                @if($tag !== '')
                                                    <a href="{{ url('tag/' . Str::slug($tag)) }}"><button type="button"
                                                        class="btn btn-sm btn-primary me-1"
                                                        style="background-color: grey;">
                                                        {{ ucwords($tag) }}
                                                    </button></a>
                                                @endif
                                            @endforeach

                                            <h3>Komentar</h3>
                                            <div class="comment-wrapper" id="form-komentar">
                                                <div class="comment-box">
                                                    <form method="post" enctype="multipart/form-data" id="komentarpost">
                                                        @csrf
                                                        <input type="hidden" id="id_berita" name="id_berita" value="{{ $berita?->public_id ?? '' }}">
                                                        <input type="hidden" id="id_child" name="id_child">
                                                        <input type="text" id="name" name="name" class="comment-name" placeholder="Nama Lengkap" style="width: 50% !important;">
                                                        <textarea id="comment" name="comment" maxlength="1000" placeholder="Tulis Komentar"></textarea>

                                                        <div class="comment-footer">
                                                            <div class="char-count">
                                                                <span id="charLeft">1000</span> Karakter tersisa
                                                            </div>

                                                            <button type="submit" class="btn-send"> Kirim ➤ </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div><!-- comment-wrapper -->

                                            <h3></h3>
                                            @php
                                                $komentarMap = collect($komentar)->keyBy('id');
                                            @endphp

                                            <div class="comment-scroll-wrapper">
                                                <div class="comment-list">
                                                    @foreach ($komentar as $info)
                                                        @if ($info->child == 0)

                                                            <!-- KOMENTAR UTAMA -->
                                                            <div class="comment-item">
                                                                <div class="avatar greenkemenag">
                                                                    {{ $info->nama_singkat }}
                                                                </div>

                                                                <div class="comment-content">
                                                                    <div class="comment-header">
                                                                        <strong>{{ ucwords($info->nama) }}</strong>
                                                                        <span class="time">{{ $info->waktu_lalu }}</span>
                                                                    </div>

                                                                    <div class="comment-text">
                                                                        {{ $info->pesan }}
                                                                    </div>

                                                                    <div class="comment-actions">
                                                                        <span onclick="Page.KomentarLike('{{ $info->public_id }}')">👍 {{ $info->total_like }}</span>
                                                                        <span onclick="Page.KomentarunLike('{{ $info->public_id }}')">👎 {{ $info->total_unlike }}</span>
                                                                        <span onclick="Page.BalasKomentar('{{ $info->id }}')" class="reply">Balas</span>
                                                                    </div>

                                                                    <!-- BALASAN -->
                                                                    @foreach ($komentar as $reply)

                                                                        @php
                                                                            // Cari induk utama
                                                                            $rootId = $reply->child;
                                                                            while (
                                                                                isset($komentarMap[$rootId]) &&
                                                                                $komentarMap[$rootId]->child != 0
                                                                            ) {
                                                                                $rootId = $komentarMap[$rootId]->child;
                                                                            }

                                                                            // Parent langsung (untuk @mention)
                                                                            $parent = $komentarMap[$reply->child] ?? null;
                                                                        @endphp

                                                                        @if ($rootId == $info->id)
                                                                            <div class="comment-reply">
                                                                                <div class="comment-item">
                                                                                    <div class="avatar greykemenag">
                                                                                        {{ $reply->nama_singkat }}
                                                                                    </div>

                                                                                    <div class="comment-content">
                                                                                        <div class="comment-header">
                                                                                            <strong>{{ ucwords($reply->nama) }}</strong>
                                                                                            <span class="time">{{ $reply->waktu_lalu }}</span>
                                                                                        </div>

                                                                                        <div class="comment-text">
                                                                                            @if ($parent)
                                                                                                <b>{{ '@'.strtolower($parent->nama) }}</b>,
                                                                                            @endif
                                                                                            {{ $reply->pesan }}
                                                                                        </div>

                                                                                        <div class="comment-actions">
                                                                                            <span onclick="Page.KomentarLike('{{ $reply->public_id }}')">👍 {{ $reply->total_like }}</span>
                                                                                            <span onclick="Page.KomentarunLike('{{ $reply->public_id }}')">👎 {{ $reply->total_unlike }}</span>
                                                                                            <span onclick="Page.BalasKomentar('{{ $reply->id }}')" class="reply">Balas</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    @endforeach

                                                                </div>
                                                            </div>

                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                        </div><!-- column_attr -->
                                    </div><!-- column two-third column_column -->

                                    <div class="column one-third column_chart">
                                        <div class="column_attr">
                                            <h3 style="font-weight: 400;">Informasi Terkini</h3>
                                            @foreach ($informasi_terkini as $info)
                                                <div class="column two-second column_icon_box">
                                                    <div class="icon_box icon_position_top no_border">
                                                        <div class="image_wrapper">
                                                            <img src="{{ Storage::url($info->files) }}" alt="{{ $info->meta_title }}" title="{{ $info->meta_title }}" style="border-radius: 6px;" class="scale-with-grid">
                                                        </div>
                                                        <div class="desc_wrapper">
                                                            <h4><a href="{{ url('blog/'.$info->pranala) }}">{{ $info->judul }}</a></h4>
                                                            <div class="desc">
                                                                {{ $info->excerpt }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="column one column_divider">
                                        <hr class="no_line" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer-->
        @include('frontend.layouts.footer')

    </div>
    <script src="{{ url('assets/frontend/js/jquery-3.6.0.min.js') }}"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="application/ld+json">
    {!! json_encode([
        "@context" => "https://schema.org",
        "@type" => "NewsArticle",
        "headline" => $berita?->meta_title ?? '',
        "description" => $berita?->excerpt ?? '',
        "image" => $berita?->files ? Storage::url($berita->files) : '',
        "author" => [
            "@type" => "Person",
            "name" => url(''),
        ],
        "publisher" => [
            "@type" => "Organization",
            "name" => "Kementerian Agama Republik Indonesia",
            "logo" => [
                "@type" => "ImageObject",
                "url" => asset('assets/frontend/images/logo1.png'),
            ],
        ],
        "datePublished" => $berita?->created_date 
            ? \Carbon\Carbon::parse($berita->created_date)->format('c') 
            : null,
        "dateModified" => $berita?->updated_date 
            ? \Carbon\Carbon::parse($berita->updated_date)->format('c') 
            : null,
        "mainEntityOfPage" => [
            "@type" => "WebPage",
            "@id" => url()->current(),
        ],
    ], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
    </script>

    <script type="text/javascript">
        window.onload = function() {
            $('#Loader').hide();
            // $('#tambahBalasan').hide();
        };

        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("komentarpost");

                form.addEventListener("submit", async (e) => {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const id_berita = formData.get("id_berita")?.trim();
                    const id_child = formData.get("id_child")?.trim();
                    const name = formData.get("name")?.trim();
                    const comment = formData.get("comment")?.trim();
                    const token = formData.get("_token")?.trim();

                    const fields = {
                        id_berita: { value: id_berita, message: "Maaf, id berita harus diisi." },
                        name: { value: name, message: "Maaf, nama lengkap harus diisi." },
                        comment: { value: comment, message: "Maaf, komentar harus diisi." },
                        token: { value: token, message: "Token harus diisi." }
                    };

                    for (const key in fields) {
                        const { value, message, skipIf } = fields[key];
                        if (!value || value === skipIf) {
                            return showError(message);
                        }
                    }

                try {
                    showLoader();

                    const response = await fetch("{{ url('fcfb5402-d55c-4b88-91d6-012237679c20') }}", {
                        method: "POST",
                        body: formData,
                        headers: {
                        },
                    });

                    const result = await response.json();

                    if (result.message === 200) {
                        form.reset();
                        Swal.fire(
                            "Berhasil",
                            "Komentar berhasil dikirim dan sedang ditinjau.",
                            "success"
                        ).then(() => {
                            window.location.href = window.location.pathname;
                        });
                    } else if(result.message === 201) {
                        Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan.", "error");
                    }
                } catch (error) {
                    console.error("Fetch Error:", error);
                    Swal.fire("Error", "Terjadi kesalahan jaringan atau server.", "error");
                } finally {
                    hideLoader();
                }
            });

            // Fungsi bantu
            function showError(msg) {
                if (typeof toastr !== "undefined") {
                    toastr.error(msg, "Error");
                } else {
                    alert(msg);
                }
            }

            function showLoader() {
                const overlay = document.getElementById("page-overlay");
                if (overlay) {
                    overlay.style.display = "block";
                    document.body.style.overflow = "hidden"; // lock scroll
                }
            }

            function hideLoader() {
                const overlay = document.getElementById("page-overlay");
                if (overlay) {
                    overlay.style.display = "none";
                    document.body.style.overflow = ""; // unlock scroll
                }
            }

        });

        var Page = {};

        jQuery(window).on('load', function() {
            var retina = window.devicePixelRatio > 1 ? true : false;

            if (retina) {
                var retinaEl = jQuery("#logo img");
                var retinaLogoW = retinaEl.width();
                var retinaLogoH = retinaEl.height();

                retinaEl
                    .attr("src", "{{ asset('assets/frontend/images/logo1.png') }}")
                    .width(retinaLogoW)
                    .height(retinaLogoH);
            }
        });

        Page.Copy = function(val) {
            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                var a = val;
                var e = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('f587cef2-c74a-4885-a869-e210e15606a0') }}",
                    type: 'POST',
                    data: {val:a, _token:e},
                    success: function(response){
                        if(response.message == 200){
                            const url = window.location.href;
                            
                            navigator.clipboard.writeText(url)
                            .then(() => {
                                Swal.fire({
                                    title: "Berhasil",
                                    text: "URL/Link berita telah berhasil di salin.",
                                    icon: "success",
                                    timer: 1500,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonText: "OK"
                                });
                            });
                        }else if(response.message == 201){
                            const url = window.location.href;
                            
                            navigator.clipboard.writeText(url)
                            .then(() => {
                                Swal.fire({
                                    title: "Berhasil",
                                    text: "URL/Link berita telah berhasil di salin.",
                                    icon: "success",
                                    timer: 1500,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    confirmButtonText: "OK"
                                });
                            });
                        }else if(response.message == 404){
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Terjadi kesalahan saat memberikan like.",
                                icon: "error",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            }
        };

        Page.Like = function(val)
        {
            var a = val;
            var e = $('input[name="_token"]').val();

            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                $.ajax({
                    url: "{{ url('b254a285-698f-4550-8a91-fd79ec800088') }}",
                    type: 'POST',
                    data: {val:a, _token:e},
                    success: function(response){
                        if(response.message == 200){
                            Swal.fire({
                                title: "Berhasil",
                                text: "Terima kasih, telah memberikan like di berita ini.",
                                icon: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }else if(response.message == 201){
                            Swal.fire({
                                title: "Berhasil",
                                text: "Terima kasih, telah memberikan like kembali di berita ini.",
                                icon: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }else if(response.message == 404){
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Terjadi kesalahan saat memberikan like.",
                                icon: "error",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            }
        }

        Page.unLike = function(val)
        {
            var a = val;
            var e = $('input[name="_token"]').val();

            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                $.ajax({
                    url: "{{ url('e8ee9f8f-9560-4c06-b6e7-4d84ebb79536') }}",
                    type: 'POST',
                    data: {val:a, _token:e},
                    success: function(response){
                        if(response.message == 200){
                            Swal.fire({
                                title: "Berhasil",
                                text: "Oops.., mohon maaf atas ketidaksukaan berita ini.",
                                icon: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }else if(response.message == 201){
                            Swal.fire({
                                title: "Berhasil",
                                text: "Oops.., mohon maaf atas ketidaknyamanan berita ini.",
                                icon: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }else if(response.message == 404){
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Terjadi kesalahan saat memberikan like.",
                                icon: "error",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            }
        }

        Page.FB = function(val) {
            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                var a = val;
                var e = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('9293b2a5-49a6-4d93-9942-6b0f38f87d6f') }}",
                    type: 'POST',
                    data: {val:a, _token:e},
                    success: function(response){
                        const url = encodeURIComponent(window.location.href);
                        const fbShare = "https://www.facebook.com/sharer/sharer.php?u=" + url;
                        window.open(
                            fbShare,
                            "Share to Facebook",
                            "width=600,height=400"
                        );
                    }
                });
            }
        };

        Page.Twit = function(val) {
            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                var a = val;
                var e = $('input[name="_token"]').val();

                $.ajax({
                    url: "{{ url('1c0c24ad-f4ff-42fe-9a03-010bb2ba7d38') }}",
                    type: 'POST',
                    data: {val:a, _token:e},
                    success: function(response){
                        const url = encodeURIComponent(window.location.href);
                        const title = encodeURIComponent(document.title);

                        const twitterShare =
                            "https://twitter.com/intent/tweet?url=" + url + "&text=" + title;

                        window.open(
                            twitterShare,
                            "Share to Twitter",
                            "width=600,height=400"
                        );
                    }
                });
            }
        };

        Page.KomentarLike = function(val)
        {
            var a = val;
            var e = $('input[name="_token"]').val();

            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                $.ajax({
                    url: "{{ url('c2e52814-7c8e-4b9d-b369-94cf5b8ae477') }}",
                    type: 'POST',
                    data: {val:a, _token:e},
                    success: function(response){
                        if(response.message == 200){
                            Swal.fire(
                                "Berhasil",
                                "Terima kasih, telah memberikan like di komentar ini.",
                                "success"
                            ).then(() => {
                                window.location.href = window.location.pathname;
                            });
                        }else if(response.message == 404){
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Terjadi kesalahan saat memberikan like.",
                                icon: "error",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            }
        }

        Page.KomentarunLike = function(val)
        {
            var a = val;
            var e = $('input[name="_token"]').val();

            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                $.ajax({
                    url: "{{ url('56658361-d191-477e-b219-2301a4fd872a') }}",
                    type: 'POST',
                    data: {val:a, _token:e},
                    success: function(response){
                        if(response.message == 200){
                            Swal.fire(
                                "Berhasil",
                                "Terima kasih, telah memberikan unlike di komentar ini.",
                                "success"
                            ).then(() => {
                                window.location.href = window.location.pathname;
                            });
                        }else if(response.message == 404){
                            Swal.fire({
                                title: "Informasi",
                                text: "Maaf, Terjadi kesalahan saat memberikan like.",
                                icon: "error",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            }
        }

        Page.BalasKomentar = function(val)
        {
            var a = val;
            var e = $('input[name="_token"]').val();

            if(val == '' || val == null || val == 0){
                Swal.fire({
                    title: "Informasi",
                    text: "Maaf, ID tidak tersedia.",
                    icon: "error",
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: "OK"
                });
            }else{
                const wrapper = document.getElementById("form-komentar");
                if (wrapper) {
                    wrapper.scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                }

                // Fokus ke input nama (delay agar scroll selesai)
                setTimeout(() => {
                    const nameInput = document.getElementById("name");
                    if (nameInput) {
                        nameInput.focus();
                    }
                }, 500);

                // (opsional) set parent komentar
                $('#parent_id').val(val);
                $('#id_child').attr('value', val);
            }
        }

        const textarea = document.getElementById('comment');
        const charLeft = document.getElementById('charLeft');
        const maxChar = 1000;

        textarea.addEventListener('input', function () {
            charLeft.textContent = maxChar - this.value.length;
        });

        $("textarea[name='comment']").on('input', function () {
            this.value = this.value.replace(/[^a-zA-Z0-9.,:\/\- ]/g, '');
        });
        $("input[name='name']").on('input', function () {
            this.value = this.value.replace(/[^a-zA-Z., ]/g, '');
        });
    </script>
</body>

</html>