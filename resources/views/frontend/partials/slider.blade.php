<div class="mfn-main-slider" id="mfn-rev-slider">
    <div id="rev_slider_1_2_wrapper" class="rev_slider_wrapper fullwidthbanner-container"
        style="margin:0px auto;background-color:transparent;padding:0px;margin-top:0px;margin-bottom:0px;">
        <div id="rev_slider_1_2" class="rev_slider fullwidthabanner" data-version="5.0.4.1">
            <ul>
                @foreach ($slider as $info)
                    @php
                        // posisi
                        $posisi = $loop->iteration % 2 == 1 ? 'left' : 'right';

                        // pecah judul menjadi 3 baris
                        $judulParts = explode('|', $info->judul);

                        $judul1 = $judulParts[0] ?? '';
                        $judul2 = $judulParts[1] ?? ''; // ini yang akan diberi warna
                        $judul3 = $judulParts[2] ?? '';
                    @endphp

                    <li data-index="rs-{{ $loop->iteration }}" data-transition="fade"
                        data-thumb="{{ Storage::url($info->files) }}" data-title="Slide">

                        <!-- MAIN IMAGE -->
                        <img src="{{ Storage::url($info->files) }}" width="1200" height="502"
                            alt="{{ $info->judul }}" title="{{ $info->judul }}"
                            data-bgposition="center top" data-bgfit="cover" class="rev-slidebg">

                        <!-- LAYER 1 (JUDUL) -->
                        <div class="tp-caption mfnrsdrivinglargewhite tp-resizeme rs-parallaxlevel-0"
                            data-x="['{{ $posisi }}','{{ $posisi }}','{{ $posisi }}','{{ $posisi }}']"
                            data-hoffset="['40','40','40','40']"
                            data-y="['middle','middle','middle','middle']"
                            data-voffset="['-40','-40','-40','-40']"
                            data-start="500">

                            {{ $judul1 }} <br>

                            @if(!empty($judul2))
                                <span class="themecolor">{{ $judul2 }}</span><br>
                            @endif

                            {{ $judul3 }}
                        </div>

                        <!-- LAYER 2 (DESKRIPSI) -->
                        <div class="tp-caption mfnrsdrivingsmall tp-resizeme rs-parallaxlevel-0"
                            data-x="['{{ $posisi }}','{{ $posisi }}','{{ $posisi }}','{{ $posisi }}']"
                            data-hoffset="['40','40','40','40']"
                            data-y="['middle','middle','middle','middle']"
                            data-voffset="['90','90','90','90']"
                            data-start="1200">

                            {!! nl2br(e($info->deskripsi)) !!}
                        </div>

                    </li>
                @endforeach
            </ul>
            <div class="tp-bannertimer" style="height: 5px; background-color: rgba(0, 0, 0, 0.15);">
            </div>
        </div>
    </div>
</div>
