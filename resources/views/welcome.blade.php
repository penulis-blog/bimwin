<!DOCTYPE html>
<html class="no-js"> 
  @include('frontend.partials.header')
  <body class="home page template-slider layout-boxed header-classic minimalist-header header-menu-right sticky-header sticky-white subheader-both-center no-content-padding">
    <style type="text/css">
      .img-fixed {
        object-fit: cover;
        object-position: center;
        border-radius: 6px;
      }

      /* ==========================================
        CARD BERITA
      ========================================== */

      .berita-card{
          text-align:center;
      }

      /* ==========================================
        GAMBAR
      ========================================== */

      .berita-image{
          width:100%;
          height:220px;
          overflow:hidden;
          border-radius:6px;
          margin-bottom:18px;
      }

      .berita-image img{
          width:100%;
          height:100%;
          object-fit:cover;
          object-position:center;
          display:block;
          transition:.35s ease;
      }

      .berita-image:hover img{
          transform:scale(1.05);
      }

      /* ==========================================
        JUDUL
      ========================================== */

      .berita-title{
          margin:0 0 12px;
          padding:0 10px;
          font-size:18px;
          font-weight:900;
          line-height:1.45;
          min-height:78px;
          overflow:hidden;
          display:-webkit-box;
          -webkit-box-orient:vertical;
          -webkit-line-clamp:2;
      }

      .berita-title a{
          color:#222;
          text-decoration:none;
          transition:.3s;
      }

      .berita-title a:hover{
          color:#d7a100;
      }

      /* ==========================================
        DESKRIPSI
      ========================================== */
      .berita-desc{
          padding:0 10px;
          color:#666;
          /* font-size:15px; */
          line-height:1.75;
          min-height:105px;
          overflow:hidden;
          display:-webkit-box;
          -webkit-box-orient:vertical;
          -webkit-line-clamp:4;

      }

      /* ==========================================
        BUTTON
      ========================================== */
      .berita-button{
          margin-top:18px;
      }

      .berita-button .btn{
          width:170px;
          border-radius:5px;
      }

      /* ==========================================
        TABLET
      ========================================== */
      @media only screen and (max-width:960px){
          .berita-image{
              height:200px;
          }

          .berita-title{
              font-size:17px;
              min-height:72px;
              line-height:1.4;
          }

          .berita-desc{
              min-height:95px;
              line-height:1.7;
          }

      }

      /* ==========================================
        MOBILE
      ========================================== */
      @media only screen and (max-width:767px){
          .berita-image{
              height:200px;
          }

          .berita-title{
              font-size:18px;
              line-height:1.4;
              min-height:auto;
              margin-bottom:8px;
              -webkit-line-clamp:2;
          }

          .berita-desc{
              font-size:14px;
              line-height:1.6;
              min-height:auto;
              -webkit-line-clamp:4;
          }

          .berita-button{
              margin-top:15px;
          }

          .berita-button .btn{
              width:100%;
          }
      }

      /* FAQ */
      /* Bootstrap Accordion Override for BeTheme */
      .faq-accordion{
          width:100%;
          border:1px solid #dee2e6;
          border-radius:8px;
          overflow:hidden;
          background:#fff;
      }

      .faq-item{
          border-bottom:1px solid #dee2e6;
      }

      .faq-item:last-child{
          border-bottom:none;
      }

      .faq-button{
          width:100%;
          background:#fff;
          border:none;
          padding:18px 20px;
          font-size:18px;
          font-weight:600;
          cursor:pointer;
          text-align:left;

          display:flex;
          justify-content:space-between;
          align-items:center;

          transition:.3s;
      }

      .faq-button:hover{
          background:#f8f9fa;
      }

      .faq-item.active .faq-button{
          background:#e7f1ff;
          color:#0d6efd;
      }

      .faq-icon{
          font-size:26px;
          font-weight:bold;
          transition:.3s;
      }

      .faq-item.active .faq-icon{
          transform:rotate(45deg);
      }

      .faq-content{
          max-height:0;
          overflow:hidden;
          transition:max-height .35s ease;
          background:#fff;
      }

      .faq-item.active .faq-content{
          max-height:500px;
      }

      .faq-body{
          padding:20px;
          color:#444;
          line-height:1.8;
      }

      /* Warna tombol accordion */
      .faq-button{
          color:#212529 !important;
          background:#fff !important;
      }

      /* Saat aktif */
      .faq-item.active .faq-button{
          color:#d7a100 !important;
          background:#e7f1ff !important;
      }

      /* Saat hover */
      .faq-button:hover{
          color:#d7a100 !important;
          background:#f8f9fa !important;
      }

      /* Pastikan semua elemen di dalam button ikut berwarna */
      .faq-button,
      .faq-button span{
          color:inherit !important;
      }

      /* Media Sosial */
      .social-grid{
        display:grid;
        grid-template-columns:repeat(2,1fr);
        gap:20px;
      }

      .social-alert{
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        text-align:center;
        min-height:100px;
        padding:18px 15px;
        border-radius:12px;
        text-decoration:none;
        box-sizing:border-box;
        transition:.3s;
        text-decoration: none !important;
      }

      .social-alert:hover{
        text-decoration: none !important;
        transform:translateY(-4px);
        box-shadow:0 8px 20px rgba(0,0,0,.15);
      }

      .social-alert i{
        font-size:29px;
        margin-bottom:12px;
      }

      .social-alert span{
        font-size:14px;
        font-weight:600;
        line-height:1.4;
        text-decoration: none !important;
      }

      /* Youtube */
      .social-alert.youtube{
        background:#FFF1F1;
        border-left:6px solid #FF0000;
        color:#C62828;
      }

      .social-alert.youtube i{
        color:#FF0000;
      }

      /* Facebook */
      .social-alert.facebook{
        background:#EAF3FF;
        border-left:6px solid #1877F2;
        color:#0D47A1;
      }

      .social-alert.facebook i{
        color:#1877F2;
      }

      /* Instagram */
      .social-alert.instagram{
        background:#FFF0F6;
        border-left:6px solid #E1306C;
        color:#AD1457;
      }

      .social-alert.instagram i{
        color:#E1306C;
      }

      /* X */
      .social-alert.x{
        background:#F7F7F7;
        border-left:6px solid #000;
        color:#222;
      }

      .social-alert.x i{
        color:#000;
      }

      /* Tablet & HP */
      @media(max-width:768px){
        .social-grid{
          grid-template-columns:1fr;
        }

        .social-alert{
          min-height:150px;
        }

        .social-alert i{
          font-size:42px;
        }

        .social-alert span{
          font-size:16px;
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
    </style>
    <!-- Main Theme Wrapper -->
    <div id="Wrapper">
      <!-- Header Wrapper -->
      <div id="Header_wrapper">
        <!-- Header -->
        <header id="Header">
          <!-- Header -  Logo and Menu area --> @include('frontend.partials.menu')
          <!-- Revolution slider area--> @include('frontend.partials.slider')
        </header>
      </div>
      <!-- Main Content -->
      <div id="Content">
        <div class="content_wrapper clearfix">
          <!-- .sections_group -->
          <div class="sections_group">
            <div class="entry-content">
              <div class="section full-width section-border-bottom" style="padding-top:25px; padding-bottom:25px; background-color:#f9f9f7">
                <div class="section_wrapper clearfix">
                  <div class="items_group clearfix">
                    <!-- One full width row-->
                    <div class="column one column_column">
                      <div class="column_attr align_center">
                        <h2 class="hrmargin_0">INFORMASI <span class="themecolor">TERKINI</span>
                        </h2>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

             <div class="section" style="padding-top:20px; padding-bottom:0; background:#fff;">
                <div class="section_wrapper clearfix">
                    <div class="items_group clearfix">
                        @foreach($informasi_terkini as $info)
                        <div class="column one-fourth column_icon_box">
                            <div class="icon_box icon_position_top no_border berita-card">
                                <div class="image_wrapper berita-image">
                                    <a href="{{ url('blog/'.$info->pranala) }}"
                                      onclick="Page.View('{{ $info->public_id }}')">
                                        <img
                                            src="{{ Storage::url($info->files) }}"
                                            alt="{{ $info->meta_title }}"
                                            title="{{ $info->meta_title }}"
                                            class="scale-with-grid">
                                    </a>
                                </div>

                                <div class="desc_wrapper">
                                    <h4 class="berita-title" style="text-align: left;">
                                        <a href="{{ url('blog/'.$info->pranala) }}"
                                          onclick="Page.View('{{ $info->public_id }}')">
                                            {{ Str::words($info->judul,8,'...') }}
                                        </a>
                                    </h4>
                                    <div class="desc berita-desc" style="text-align: left;">
                                        {{ Str::words(strip_tags($info->excerpt),20,'...') }}
                                    </div>
                                </div>

                                <div class="berita-button">
                                    <a href="{{ url('blog/'.$info->pranala) }}"
                                      onclick="Page.View('{{ $info->public_id }}')">
                                        <button class="btn btn-sm">
                                            Selengkapnya
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

              <div class="section full-width section-border-bottom" style="padding-top:25px; padding-bottom:25px; background-color:#f9f9f7">
                <div class="section_wrapper clearfix">
                  <div class="items_group clearfix">
                    <!-- One full width row-->
                    <div class="column one column_column">
                      <div class="column_attr align_center">
                        <h2 class="hrmargin_0">PILIHAN <span class="themecolor">INFORMASI</span> LAINNYA </h2>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="section" style="padding-top:40px; padding-bottom:0px; background-color:#fff">
                <div class="section_wrapper clearfix">
                  <div class="items_group clearfix">
                    <!-- One Fourth (1/4) Column -->
                    <div class="column one-fourth column_column">
                      <div class="column_attr">
                        <h3>MEDIA SOSIAL</h3>
                        <div class="image_frame no_link scale-with-grid no_border aligncenter">
                          <div class="image_wrapper">
                            <img class="scale-with-grid" src="assets/frontend/images/banner-sosmed.png" alt="Media Sosial Subdit Keluarga Sakinah" title="Media Sosial Subdit Keluarga Sakinah" style="border-radius: 6px;">
                          </div>
                        </div>
                        <hr class="no_line hrmargin_b_20" />
                        <h6>Ikuti media sosial kami dengan beberapa pilihan dibawah ini, supaya kamu tidak ketinggalan informasi dari kami.</h6>
                        <div class="social-grid">
                          <a href="javascript:;" class="social-alert youtube">
                              <i class="fab fa-youtube"></i>
                              <span>Youtube</span>
                          </a>

                          <a href="javascript:;" class="social-alert facebook">
                              <i class="fab fa-facebook-f"></i>
                              <span>Facebook</span>
                          </a>

                          <a href="javascript:;" class="social-alert instagram">
                              <i class="fab fa-instagram"></i>
                              <span>Instagram</span>
                          </a>

                          <a href="javascript:;" class="social-alert x">
                              <i class="fab fa-twitter"></i>
                              <span>X (Twitter)</span>
                          </a>
                        </div>
                      </div>
                    </div>

                    {{-- <!-- Bahan Materi -->
                    <div class="column one-fourth column_column">
                      <div class="column_attr">
                        <h3>BAHAN MATERI</h3>
                        <ul style="font-size: 13px; margin-left: 7%;">
                          @forelse ($materi as $info)
                              <li style="list-style-image: url(assets/frontend/images/home_driving_list_icon.png); padding-left: 6px;">
                                  <a href="{{ $info->pranala }}">{{ $info->judul }}</a>
                              </li>
                          @empty
                              <h6 style="margin-left: -17px;">Mohon maaf, bahan materi belum tersedia masih menunggu persetujuan.</h6>
                          @endforelse
                        </ul>
                      </div>
                    </div> --}}

                    <!-- FAQ -->
                    <div class="column one-fourth column_column">
                      <div class="column_attr">
                          <h3>FAQ (Frequently Asked Questions)</h3>
                          <div class="faq-accordion">
                              <div class="faq-item active">
                                  <button class="faq-button">
                                      Unduh Sertifikat
                                      <span class="faq-icon">+</span>
                                  </button>

                                  <div class="faq-content">
                                      <div class="faq-body">
                                          <strong>Bagaimana cara mengunduh sertifikat?</strong><br>
                                          Untuk mengunduh sertifikat bisa klik menu sertifikat di bagian atas atau klik menu dibawah ini
                                          dan ikuti petunjuk selanjutnya.<br>
                                          <div class="berita-button">
                                            <a href="{{ url('sertifikat-kegiatan') }}">
                                                <button class="btn btn-sm">
                                                    Selengkapnya
                                                </button>
                                            </a>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="faq-item">
                                  <button class="faq-button">
                                      Perbaharui Sertifikat
                                      <span class="faq-icon">+</span>
                                  </button>
                                  <div class="faq-content">
                                      <div class="faq-body">
                                          <strong>Bagaimana cara perbaharui data sertifikat?</strong><br>
                                          Sedang dalam masa pengerjaan untuk perbaharui data sertifikat secara mandiri, cek kembali informasi
                                          selanjutnya di website ini. Terima kasih.
                                      </div>
                                  </div>
                              </div>

                              {{-- <div class="faq-item">
                                  <button class="faq-button">
                                      Accordion Item #3
                                      <span class="faq-icon">+</span>
                                  </button>
                                  <div class="faq-content">
                                      <div class="faq-body">
                                          <strong>This is the third item's accordion body.</strong>
                                          It is hidden by default.
                                      </div>
                                  </div>
                              </div> --}}
                          </div>
                      </div>
                  </div>

                    <!-- One Second (1/2) Column -->
                    <div class="column one-second column_column">
                      <div class="column_attr">
                        <h3>GALERI</h3>
                        <div id='gallery-1' class='gallery galleryid-2 gallery-columns-3 gallery-size-thumbnail'>
                          @foreach ($galeri as $info)
                            <dl class='gallery-item'>
                              <dt class='gallery-icon landscape'>
                                <a href='{{ Storage::url($info->files) }}'>
                                  <img width="300" height="300" src="{{ Storage::url($info->files) }}" class="attachment-thumbnail" alt="{{ $info->judul }}" title="{{ $info->judul }}" />
                                </a>
                              </dt>
                              <dd></dd>
                            </dl>
                          @endforeach
                          <br class="flv_clear_both" />
                        </div>
                      </div>
                    </div>
                    <!-- One full width row-->
                    <div class="column one column_testimonials">
                      <div class="testimonials_slider">
                        <div class="slider_images">
                          <a href="#">
                            <img width="85" height="85" src="assets/frontend/images/our_team_4-85x85.jpg" class="scale-with-grid wp-post-image" />
                          </a>
                          <a href="#">
                            <img width="85" height="85" src="assets/frontend/images/our_team_2-85x85.jpg" class="scale-with-grid wp-post-image" />
                          </a>
                          <a href="#">
                            <img width="85" height="85" src="assets/frontend/images/our_team_3-85x85.jpg" class="scale-with-grid wp-post-image" />
                          </a>
                          <a href="#">
                            <img width="85" height="85" src="assets/frontend/images/our_team_1-85x85.jpg" class="scale-with-grid wp-post-image" />
                          </a>
                        </div>
                        <ul class="testimonials_slider_ul">
                          <li>
                            <div class="bq_wrapper">
                              <blockquote> Cegah kawin anak berarti memberi ruang bagi setiap remaja untuk tumbuh, belajar, dan menemukan jati diri. Ketika mereka diberi kesempatan meraih mimpi, masa depan yang lebih cerah terbuka tanpa harus terburu memasuki jenjang pernikahan. </blockquote>
                            </div>
                            <div class="hr_dots hrmargin_b_10">
                              <span></span>
                              <span></span>
                              <span></span>
                            </div>
                            <div class="author">
                              <h5>
                                <a href="javascript:;">Admin</a>
                              </h5>
                              <span class="company">-</span>
                            </div>
                          </li>
                          <li>
                            <div class="bq_wrapper">
                              <blockquote> Bimbingan remaja usia sekolah adalah ruang aman untuk belajar, tumbuh, dan memahami diri. Dengan dukungan yang tepat, mereka mampu membentuk karakter kuat, membuat pilihan bijak, serta menapaki masa depan dengan percaya diri dan penuh harapan. </blockquote>
                            </div>
                            <div class="hr_dots hrmargin_b_10">
                              <span></span>
                              <span></span>
                              <span></span>
                            </div>
                            <div class="author">
                              <h5>
                                <a href="javascript:;">Admin</a>
                              </h5>
                              <span class="company">-</span>
                            </div>
                          </li>
                          <li>
                            <div class="bq_wrapper">
                              <blockquote> Bimbingan perkawinan membantu calon pasangan memahami tanggung jawab, komunikasi, dan kesiapan emosional. Melalui pembelajaran yang terarah, mereka dapat membangun rumah tangga harmonis, saling menghargai, serta menghadapi tantangan kehidupan dengan bijak dan penuh komitmen bersama yang kokoh. </blockquote>
                            </div>
                            <div class="hr_dots hrmargin_b_10">
                              <span></span>
                              <span></span>
                              <span></span>
                            </div>
                            <div class="author">
                              <h5>
                                <a href="javascript:;">Admin</a>
                              </h5>
                              <span class="company">-</span>
                            </div>
                          </li>
                          <li>
                            <div class="bq_wrapper">
                              <blockquote> Peer educator membantu remaja belajar dari teman sebaya yang dipercaya, menyampaikan pesan positif, membangun karakter, serta mendorong perubahan perilaku. Dengan pendekatan setara, edukasi menjadi lebih mudah diterima, relevan, dan berdampak nyata di lingkungan. </blockquote>
                            </div>
                            <div class="hr_dots hrmargin_b_10">
                              <span></span>
                              <span></span>
                              <span></span>
                            </div>
                            <div class="author">
                              <h5>
                                <a href="javascript:;">Admin</a>
                              </h5>
                              <span class="company">-</span>
                            </div>
                          </li>
                        </ul>
                        <a class="button button_js slider_prev" href="#">
                          <span class="button_icon">
                            <i class="icon-left-open-big"></i>
                          </span>
                        </a>
                        <a class="button button_js slider_next" href="#">
                          <span class="button_icon">
                            <i class="icon-right-open-big"></i>
                          </span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> @include('frontend.layouts.footer')
    </div>
    <!-- #Wrapper -->
    <!-- JS -->
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
    <script>
      var tpj = jQuery;
      var revapi1;
      tpj(document).ready(function() {
        if (tpj("#rev_slider_1_2").revolution == undefined) {
          revslider_showDoubleJqueryError("#rev_slider_1_2");
        } else {
          revapi1 = tpj("#rev_slider_1_2").show().revolution({
            sliderType: "standard",
            sliderLayout: "auto",
            dottedOverlay: "none",
            delay: 9000,
            navigation: {
              keyboardNavigation: "off",
              keyboard_direction: "horizontal",
              mouseScrollNavigation: "off",
              onHoverStop: "on",
              touch: {
                touchenabled: "on",
                swipe_threshold: 75,
                swipe_min_touches: 50,
                swipe_direction: "horizontal",
                drag_block_vertical: false
              },
              arrows: {
                style: "uranus",
                enable: true,
                hide_onmobile: true,
                hide_under: 600,
                hide_onleave: true,
                hide_delay: 200,
                hide_delay_mobile: 1200,
                tmp: '',
                left: {
                  h_align: "left",
                  v_align: "bottom",
                  h_offset: 30,
                  v_offset: 30
                },
                right: {
                  h_align: "right",
                  v_align: "bottom",
                  h_offset: 30,
                  v_offset: 30
                }
              }
            },
            responsiveLevels: [1240, 1024, 778, 480],
            gridwidth: [1240, 1024, 778, 480],
            gridheight: [600, 768, 960, 720],
            lazyType: "smart",
            parallax: {
              type: "mouse",
              origo: "slidercenter",
              speed: 2000,
              levels: [2, 3, 4, 5, 6, 7, 12, 16, 10, 50],
            },
            shadow: 2,
            spinner: "off",
            stopLoop: "off",
            stopAfterLoops: -1,
            stopAtSlide: -1,
            shuffle: "off",
            autoHeight: "off",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            startWithSlide: 0,
            debugMode: false,
            fallbacks: {
              simplifyAll: "off",
              nextSlideOnWindowFocus: "off",
              disableFocusListener: "off",
            }
          });
        }
      });

      var Page = {};

      Page.View = function(val)
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
            url: "{{ url('8b555323-4085-4143-abac-aed5ca7dfd58') }}",
            type: 'POST',
            data: {val:a, _token:e},
            success: function(response){
              // if(response.message == 200){
              //   Swal.fire({
              //     title: "Berhasil",
              //     text: "Terima kasih, telah memberikan like di berita ini.",
              //     icon: "success",
              //     allowOutsideClick: false,
              //     allowEscapeKey: false,
              //     confirmButtonText: "OK"
              //   });
              // }else if(response.message == 201){
              //   Swal.fire({
              //     title: "Berhasil",
              //     text: "Terima kasih, telah memberikan like kembali di berita ini.",
              //     icon: "success",
              //     allowOutsideClick: false,
              //     allowEscapeKey: false,
              //     confirmButtonText: "OK"
              //   });
              // }else if(response.message == 404){
              //   Swal.fire({
              //     title: "Informasi",
              //     text: "Maaf, Terjadi kesalahan saat memberikan like.",
              //     icon: "error",
              //     allowOutsideClick: false,
              //     allowEscapeKey: false,
              //     confirmButtonText: "OK"
              //   });
              // }
            }
          });
        }
      }
    </script>

    <script>
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

      document.addEventListener("DOMContentLoaded", function () {

        const items = document.querySelectorAll(".faq-item");

        items.forEach(function(item){

            const button = item.querySelector(".faq-button");

            button.addEventListener("click", function(){

                items.forEach(function(i){

                    if(i !== item){
                        i.classList.remove("active");
                    }

                });

                item.classList.toggle("active");

            });

        });

    });
    </script>
  </body>
</html>