@foreach ($berita as $info)
    <div class="items_group clearfix berita-list">
        <div class="column one-third column_image">
            <div class="image_frame no_link scale-with-grid no_border aligncenter">
                <div class="image_wrapper berita-image">
                    <a href="{{ url('blog/'.$info->pranala) }}">
                        <img class="scale-with-grid img-fixed" src="{{ Storage::url($info->files) }}"
                            alt="{{ $info->meta_title }}" title="{{ $info->meta_title }}">
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

                    <a class="berita-button" href="{{ url('blog/'.$info->pranala) }}">
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
@endforeach