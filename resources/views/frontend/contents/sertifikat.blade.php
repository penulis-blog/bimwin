<!DOCTYPE html>
<html class="no-js">
    @include('frontend.partials.header')
<body class="home page template-slider layout-boxed header-classic minimalist-header header-menu-right sticky-header sticky-white subheader-both-center no-content-padding">
    <div class="modal fade center-screen" id="Loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" style="display:none;">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content bg-transparent border-0">
            <div class="center-screen">
                <img src="/assets/backend/img/loader.gif" style="width:60px;" alt="loading...">
            </div>
            </div>
        </div>
    </div>
    <!-- Main Theme Wrapper -->
    <div id="Wrapper">
        <!-- Header Wrapper -->
        <div id="Header_wrapper">
            <!-- Header -->
            <header id="Header">
                <!-- Header -  Logo and Menu area -->
                @include('frontend.partials.menu')
            </header>
        </div>

        <div id="Content">
            <div class="content_wrapper clearfix">

                <!-- .sections_group -->
                <div class="sections_group">
                    <div class="entry-content">
                        <div class="section sections_style_4">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- One Fourth (1/4) Column -->
                                    <div class="column one-fourth column_column">
                                        <div class="column_attr">
                                            <h3>Q&A SERTIFIKAT</h3>
                                            <ul style="font-size: 13px; margin-left: 7%;">
                                                <li style="list-style-image: url(assets/frontend/images/home_driving_list_icon.png); padding-left: 6px;">
                                                    <a href="javascript:;" onclick="Page.Info()">Bagaimana cara mendapatkan sertifikat kegiatan?</a>
                                                </li>
                                                <li style="list-style-image: url(assets/frontend/images/home_driving_list_icon.png); padding-left: 6px;">
                                                    <a href="javascript:;" onclick="Page.Info()">Berapa hari, untuk mendapatkan sertifikat kegiatan?</a>
                                                </li>
                                                <li style="list-style-image: url(assets/frontend/images/home_driving_list_icon.png); padding-left: 6px;">
                                                    <a href="javascript:;" onclick="Page.Info()">Bagaimana jika terdapat kesalahan atau perubahan biodata diri?</a>
                                                </li>
                                                <li style="list-style-image: url(assets/frontend/images/home_driving_list_icon.png); padding-left: 6px;">
                                                    <a href="javascript:;" onclick="Page.Info()">Berapa nilai untuk 1 sertifikat di masing-masing kegiatan?</a>
                                                </li>
                                                {{-- <li style="list-style-image: url(assets/frontend/images/home_driving_list_icon.png); padding-left: 6px;">
                                                    <a href="#">Mauris in erat justo. Nullam ac urna eu felis augue</a>
                                                </li>
                                                <li style="list-style-image: url(assets/frontend/images/home_driving_list_icon.png); padding-left: 6px;">
                                                    <a href="#">Aenean ligula nibh in, molestie id viverra a, dapibus at dolor. Duis sed odio sit amet</a>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- One Fourth (1/4) Column -->
                                    <div class="column one-fourth column_column">
                                        <div class="column_attr">
                                            <h3>TANYA ADMIN</h3>
                                            <div style="width: 51px; float: left;">
                                                <div class="image_frame no_link scale-with-grid no_border alignnone">
                                                    <div class="image_wrapper"><img class="scale-with-grid" src="assets/frontend/images/home_drivingschool_logo_contact.png">
                                                    </div>
                                                </div>

                                            </div>
                                            <div style="margin-left: 60px; margin-top: 20px;">
                                                <h4 class="themecolor">BK & KS</h4>
                                                <p style="padding: 0 0 20px; margin: 0 0 20px; border-bottom: 1px solid rgba(0,0,0,.1);">
                                                    Tanyakan kepada kami, jika terdapat hal yang tidak dipahami tentang sertifikat kegiatan.
                                                </p>
                                                <p class="hrmargin_b_7">
                                                    <i class="icon-phone"></i><a href="https://api.whatsapp.com/send?phone=6285254713900&text=Nama%20%3A%20%0AInstansi%2FSatuan%20Kerja%20%3A%0AKota%2FKabupaten%3A%0APertanyaan%2FPengaduan%2FKritik%2FSaran%20%3A" target="_blank">+62852-5471-3900</a>
                                                </p>
                                                <p class="hrmargin_b_7">
                                                    <i class="icon-mail"></i><a href="javascript;:">admin@bksakinah.com</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- One Second (1/2) Column -->
                                    <div class="column one-second column_column">
                                        <div class="column_attr">
                                            <h3>SERTIFIKAT KEGIATAN</h3>
                                            <p class="big">
                                                Sertifikat bisa dicari dengan menggunakan beberapa pilihan, yaitu:
                                                <ol>
                                                    <li>Nomor sertifikat yang didapatkan pada saat melengkapi proses pendaftaran melalui formulir online.</li>
                                                    <li>NIP Pegawai terkait.</li>
                                                    <li>NIK kartu tanda penduduk.</li>
                                                </ol>
                                            </p>
                                            <div id="contactWrapper">
                                                <form id="sertifikat" method="post">
                                                    @csrf
                                                    <div class="column one">
                                                        <input placeholder="Ketikkan Disini..." type="text" name="id_sertifikat" id="id_sertifikat" size="40" aria-invalid="false" />
                                                    </div>
                                                    <div class="column one">
                                                        <input type="submit" value="Kirim">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="sections_group" id="div_sertifikat">
                    <div class="entry-content">
                        <div class="section sections_style_4">
                            <div class="section_wrapper clearfix">
                                <div class="items_group clearfix">
                                    <!-- One Second (1/2) Column -->
                                    <div class="column one column_column">
                                        <div class="column_attr">
                                            <h3>DATA SERTIFIKAT</h3>
                                            <div id="contactWrapper">
                                                <div class="table-responsive">
                                                    <table class="table" width="100%">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">No.</th>
                                                            <th scope="col">Nama Lengkap</th>
                                                            <th scope="col">Kegiatan</th>
                                                            <th scope="col">Tempat</th>
                                                            <th scope="col">Lokasi</th>
                                                            <th scope="col">Keterangan</th>
                                                            <th scope="col">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="sertifikat_data">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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

    @include('frontend.partials.js')

</body>
</html>
