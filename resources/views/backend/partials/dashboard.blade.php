    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
      integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
      integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
      crossorigin="anonymous"
    ></script>
    <script src="/assets/backend/js/adminlte.js"></script>
    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Swal 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Toastr --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- Datatables --}}
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    {{-- Datatables Buttons --}}
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    {{-- Timepicker --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    {{-- Font Awesome --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- charts --}}
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/map/js/indonesia.js"></script>
    {{-- Custom --}}
    <script type="text/javascript">
      var Page = {};

      const chartDom = document.getElementById('peta-indonesia');
      const chart = echarts.init(chartDom);

      fetch("{{ url('be276c30-0d2e-40ca-8dec-8ec6b592ccf7') }}")
        .then(res => res.json())
        .then(response => {

          const dbData = response.data;
          const geoJson = response.geojson;

          echarts.registerMap('indonesia', geoJson);

          const mapProvinsi = {
            "ACEH": "Aceh",
            "SUMATERA UTARA": "Sumatera Utara",
            "SUMATERA BARAT": "Sumatera Barat",
            "RIAU": "Riau",
            "KEPULAUAN RIAU": "Kepulauan Riau",
            "JAMBI": "Jambi",
            "BENGKULU": "Bengkulu",
            "SUMATERA SELATAN": "Sumatera Selatan",
            "KEPULAUAN BANGKA BELITUNG": "Kepulauan Bangka Belitung",
            "LAMPUNG": "Lampung",
            "DKI JAKARTA": "DKI Jakarta",
            "BANTEN": "Banten",
            "JAWA BARAT": "Jawa Barat",
            "JAWA TENGAH": "Jawa Tengah",
            "DAERAH ISTIMEWA YOGYAKARTA": "DI Yogyakarta",
            "JAWA TIMUR": "Jawa Timur",
            "BALI": "Bali",
            "NUSA TENGGARA BARAT": "Nusa Tenggara Barat",
            "NUSA TENGGARA TIMUR": "Nusa Tenggara Timur",
            "KALIMANTAN BARAT": "Kalimantan Barat",
            "KALIMANTAN TENGAH": "Kalimantan Tengah",
            "KALIMANTAN SELATAN": "Kalimantan Selatan",
            "KALIMANTAN TIMUR": "Kalimantan Timur",
            "KALIMANTAN UTARA": "Kalimantan Utara",
            "SULAWESI UTARA": "Sulawesi Utara",
            "SULAWESI TENGAH": "Sulawesi Tengah",
            "SULAWESI SELATAN": "Sulawesi Selatan",
            "SULAWESI TENGGARA": "Sulawesi Tenggara",
            "GORONTALO": "Gorontalo",
            "SULAWESI BARAT": "Sulawesi Barat",
            "MALUKU": "Maluku",
            "MALUKU UTARA": "Maluku Utara",
            "P A P U A": "Papua",
            "PAPUA BARAT": "Papua Barat"
          };

          // ====================
          //  PETA ECHARTS
          // ====================
          const chartData = dbData.map(item => {
              const rawNama = item?.nama?.trim() || "UNKNOWN";
              const key = rawNama.toUpperCase();

              return {
                  name: mapProvinsi[key] ?? rawNama,
                  value: Number(item?.total) || 0
              };
          });

          const option = {
            tooltip: {
              trigger: 'item',
              formatter: '{b}: {c} peserta'
            },
            visualMap: {
              min: 0,
              max: Math.max(...chartData.map(x => x.value)),
              left: 'right',
              bottom: 30,
              calculable: true
            },
            series: [{
              name: 'Sebaran',
              type: 'map',
              map: 'indonesia',
              roam: true,
              data: chartData,

              // Tampilkan angka di atas peta
              label: {
                show: true,
                fontSize: 10,
                color: '#000',
                formatter: (p) => p.value > 0 ? p.value : ''
              },
              emphasis: {
                label: {
                  show: true,
                  fontSize: 12,
                  fontWeight: 'bold',
                  color: '#000'
                }
              }
            }]
          };

          chart.setOption(option);

          const sortedList = [...chartData].sort((a, b) => b.value - a.value);

          let html = `
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:8px;">
          `;

          sortedList.forEach(item => {
            html += `
              <div style="
                padding:10px;
                border-radius:6px;
                background:#f8f8f8;
                border:1px solid #e0e0e0;
                font-size:14px;
                display:flex;
                justify-content:space-between;
              ">
                <span>${item.name}</span>
                <strong>${item.value}</strong>
              </div>
            `;
          });

          html += `</div>`;

          document.getElementById('list-provinsi').innerHTML = html;

        });

      var chartDomBar = document.getElementById('barsChart');
      var barChart = echarts.init(chartDomBar);

      fetch("{{ url('d281d78d-6e79-45e8-9b9d-3388dbc2e6ad') }}")
        .then(res => res.json())
        .then(response => {

          const dbData = response.data;

          let datasetSource = [
            ['score', 'amount', 'product']  // header ECharts wajib
          ];

          dbData.forEach(item => {
            datasetSource.push([
              Number(item.total),
              Number(item.total),
              item.pegawai       
            ]);
          });

          const option = {
            dataset: { source: datasetSource },
            grid: { containLabel: true },
            xAxis: { name: 'Jumlah' },
            yAxis: { type: 'category' },
            visualMap: {
              min: 0,
              max: Math.max(...dbData.map(d => d.total)),
              dimension: 0,
              inRange: { color: ['#65B581', '#FFCE34', '#FD665F'] }
            },
            series: [
              { type: 'bar', encode: { x: 'amount', y: 'product' } }
            ]
          };

          barChart.setOption(option);
      });

      Page.Fasilitator = function()
      {
        window.location.href = "{{ url('b7256ae8-a040-4a3d-bea5-52cc443b69bc') }}";
      }

      Page.Golongan = function()
      {
        window.location.href = "{{ url('109c726c-d08c-4d11-a5d4-9d17819cd783') }}";
      }

      Page.Pegawai = function()
      {
        window.location.href = "{{ url('eb4b303c-e0e8-4c08-9969-293dc870cfbf') }}";
      }

      Page.Keluar = function() {
        var out = $('input[name="_token"]').val();
        if (!out) return;
        Swal.fire({
            title: 'Apakah Anda ingin keluar dari aplikasi?',
            text: "Pastikan semua data sudah benar sebelum keluar dari aplikasi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {

            // ❗ gunakan isConfirmed (bukan result.value)
            if (result.isConfirmed) {

                // ✅ TAMPILKAN LOADER (Bootstrap 5)
                var loader = new bootstrap.Modal(document.getElementById('Loader_Proses'));
                loader.show();

                $.ajax({
                    url: "{{ url('a38bed7b-6a73-4e14-aa5a-730c045cc09a') }}",
                    type: 'POST',
                    data: {_token: out},

                    success: function(response) {
                        Swal.fire("Berhasil!", "Selamat, Anda telah keluar dari aplikasi.", "success")
                        .then(() => {
                            window.location.href = "{{ url('/') }}";
                        });
                    },

                    error: function() {
                        loader.hide(); // kalau gagal, baru di-hide
                        Swal.fire("Error!", "Terjadi kesalahan saat logout.", "error");
                    }
                });

            } else {
                Swal.fire({
                    title: 'Batal!',
                    text: 'Anda tidak jadi keluar dari aplikasi.',
                    icon: 'info',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

        });
      };
    </script>