<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
          <div class="row">
            <section class="col-lg-8 connectedSortable">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Fasilitator di Indonesia</h3>
                    </div>

                    <div class="card-body p-0">
                      <div class="col-lg-12">
                        <div id="peta-indonesia" style="width: 100%; height: 600px;"></div>

                        <div id="list-provinsi" class="mb-2" style="margin-top: 20px;"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Fasilitator Berdasarkan Pegawai</h3>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="chart-responsive">
                            <div id="barsChart" style="width:100%; height:400px;"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="card-footer text-center">
                      <a href="javascript:" onclick="Page.Pegawai()">Selengkapnya</a>
                    </div>
                  </div>
                </div>
              </div>
            </section>

            <section class="col-lg-4 connectedSortable">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Jumlah Fasilitator</h3>
                    </div>

                    <div class="card-body p-0">
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-lg-6 col-6 mt-2">
                              <div class="small-box text-bg-primary">
                                <div class="inner">
                                  <h3>{{ $jumlah[0]->total ?? 0 }}</h3>
                                  <p>F. Bimb. Perkawinan</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path d="M7 8a3 3 0 116 0 3 3 0 01-6 0zM15 8a3 3 0 116 0 3 3 0 01-6 0zM4 19a5 5 0 0110 0v1H4v-1zm8 0a5 5 0 0110 0v1h-4v-1a3 3 0 00-6 0v1h-4v-1z" />
                                </svg>
                              </div>
                            </div>

                            <div class="col-lg-6 col-6 mt-2">
                              <div class="small-box text-bg-success">
                                <div class="inner">
                                  <h3>{{ $jumlah[1]->total ?? 0 }}</h3>
                                  <p>F. B. R. Usia Sekolah</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path d="M12 2L1 7l11 5 9-4.09V17a1 1 0 01-2 0v-4l-7 3.18L3 10.53V17a5 5 0 005 5h8a5 5 0 005-5V7L12 2z"/>
                                </svg>
                              </div>
                            </div>
                          </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="row">
                          <div class="col-lg-6 col-6">
                            <div class="small-box text-bg-warning">
                              <div class="inner">
                                <h3>{{ $jumlah[2]->total ?? 0 }}</h3>
                                <p>F. Jejaring Lokal</p>
                              </div>
                              <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M12 2a10 10 0 100 20 10 10 0 000-20zm0 1.5a8.48 8.48 0 014.92 1.59l-2.29 2.3A5.5 5.5 0 0012 5.5a5.5 5.5 0 00-2.63.67l-2.29-2.3A8.48 8.48 0 0112 3.5zM4.09 8.1A8.48 8.48 0 0110 5.5v3a5.5 5.5 0 00-3.83 1.58L4.09 8.1zM3.5 12a8.48 8.48 0 011.6-4.92l2.29 2.29A5.5 5.5 0 005.5 12a5.5 5.5 0 001.89 4.1l-2.29 2.29A8.48 8.48 0 013.5 12zm2.3 5.9l2.08-2.09A5.5 5.5 0 0010 18.5v3a8.48 8.48 0 01-4.2-1.6zM12 20.5a8.48 8.48 0 01-1.59-.16l2.29-2.3A5.5 5.5 0 0012 18.5a5.5 5.5 0 002.63-.67l2.29 2.3A8.48 8.48 0 0112 20.5zm7.91-3.6A8.48 8.48 0 0114 18.5v-3a5.5 5.5 0 003.83-1.58l2.29 2.29a8.48 8.48 0 01-.21 1.69zM20.5 12a8.48 8.48 0 01-1.59 4.92l-2.29-2.29A5.5 5.5 0 0018.5 12a5.5 5.5 0 00-1.89-4.1l2.29-2.29A8.48 8.48 0 0120.5 12z"/>
                              </svg>
                            </div>
                          </div>

                          <div class="col-lg-6 col-6">
                            <div class="small-box text-bg-danger">
                              <div class="inner">
                                <h3>{{ $jumlah[3]->total ?? 0 }}</h3>
                                <p>F. Pendam. Keluarga</p>
                              </div>
                              <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M20 2H4a2 2 0 00-2 2v16l4-4h14a2 2 0 002-2V4a2 2 0 00-2-2zm-4 9H8a1 1 0 010-2h8a1 1 0 010 2zm0-3H8a1 1 0 010-2h8a1 1 0 010 2z"/>
                              </svg>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 col-6">
                              <div class="small-box text-bg-info">
                                <div class="inner">
                                  <h3>{{ $jumlah[5]->total ?? 0 }}</h3>
                                  <p>F. Relasi Harmonis</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.74 0 3.41.81 4.5 2.09C12.09 4.81 13.76 4 15.5 4 18 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                              </div>
                            </div>

                            <div class="col-lg-6 col-6">
                              <div class="small-box text-bg-secondary">
                                <div class="inner">
                                  <h3>{{ $jumlah[4]->total ?? 0 }}</h3>
                                  <p>F. Literasi Keuangan</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path d="M2 7a2 2 0 012-2h16a2 2 0 012 2v3H2V7zm0 5h20v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5zm14 3a1 1 0 100-2 1 1 0 000 2z"/>
                                </svg>
                              </div>
                            </div>
                        </div>
                      </div>

                      {{-- <div class="col-lg-12">
                          <div class="row">
                            <div class="col-lg-6 col-6">
                              <div class="small-box text-bg-dark">
                                <div class="inner">
                                  <h3>0</h3>
                                  <p>-</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.74 0 3.41.81 4.5 2.09C12.09 4.81 13.76 4 15.5 4 18 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                              </div>
                            </div>

                            <div class="col-lg-6 col-6">
                              <div class="small-box text-bg-dark">
                                <div class="inner">
                                  <h3>0</h3>
                                  <p>-</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                  <path d="M2 7a2 2 0 012-2h16a2 2 0 012 2v3H2V7zm0 5h20v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5zm14 3a1 1 0 100-2 1 1 0 000 2z"/>
                                </svg>
                              </div>
                            </div>
                          </div>
                      </div> --}}
                    </div>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Fasilitator Multi Bimbingan</h3>
                    </div>

                    <div class="card-body p-0">
                      <ul class="users-list clearfix">
                        @foreach ($fasilitator->take(6) as $info)
                          <li>
                            <div class="user-photo-wrapper">
                              @if($info->files)
                                <img src="{{ Storage::url($info->files) }}" alt="{{ $info->nama }}">
                              @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($info->nama) }}" alt="{{ $info->nama }}">
                              @endif
                            </div>

                            <a class="users-list-name" href="javascript:;">
                              {{ $info->nama }}
                            </a>

                            <span class="users-list-date">
                              {{ $info->jumlah_kegiatan_berbeda }} Kegiatan
                            </span>
                          </li>
                        @endforeach
                      </ul>
                    </div>

                    <div class="card-footer text-center">
                      <a href="javascript:" onclick="Page.Fasilitator()">Selengkapnya</a>
                    </div>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Fasilitator Berdasarkan Golongan</h3>
                    </div>

                    <div class="card-body p-0">
                      <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($golongan as $info)
                          <li class="item">
                            <div class="product-img">
                              <img src="{{ url('assets/backend/img/default-150x150.png') }}" alt="Product Image" class="img-size-50">
                            </div>
                            <div class="product-info">
                              <a href="javascript:void(0)" class="product-title">{{ $info->golongan }}
                                <span class="badge badge-warning float-right">{{ $info->total }}</span></a>
                              <span class="product-description">
                                {{ $info->keterangan }}
                              </span>
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    </div>

                    <div class="card-footer text-center">
                      <a href="javascript:" onclick="Page.Golongan()">Selengkapnya</a>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
    </div>
</main>

<style type="text/css">
.user-photo {
    width: 128px;
    height: 128px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
}
</style>