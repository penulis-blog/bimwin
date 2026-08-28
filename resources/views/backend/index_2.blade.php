<!doctype html>
<html lang="en">
  @include('backend.partials.header')
  <link rel="stylesheet" href="/assets/backend/css/dashboard2.css" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

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
      
      @include('backend.contents.dashboard_2')
      
      @include('backend.partials.footer')
    </div>
    
    @include('backend.partials.dashboard')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('mapIndonesia', {
          zoomControl: true,
          attributionControl: false,
          minZoom: 4,
          maxZoom: 8
        }).setView([-2.2,118.5],5);

        L.tileLayer(
          'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
          {
            maxZoom:22
          }
        ).addTo(map);

        map.setMaxBounds([
          [-13,93],
          [8,142]
        ]);

        const data = [
          {nama:"DKI Jakarta",lat:-6.175,lng:106.827,jumlah:120},
          {nama:"Jawa Barat",lat:-6.91,lng:107.60,jumlah:450},
          {nama:"Jawa Tengah",lat:-7.00,lng:110.42,jumlah:390},
          {nama:"Jawa Timur",lat:-7.25,lng:112.75,jumlah:410},
          {nama:"Aceh",lat:5.55,lng:95.31,jumlah:80},
          {nama:"Sumatera Utara",lat:3.59,lng:98.67,jumlah:215},
          {nama:"Sulawesi Selatan",lat:-5.14,lng:119.41,jumlah:180},
          {nama:"Papua",lat:-2.55,lng:140.70,jumlah:55}
        ];

        data.forEach(function(item){
          L.circleMarker([item.lat,item.lng],{
            radius:10,
            color:"#1565C0",
            fillColor:"#1E88E5",
            fillOpacity:1,
            weight:3
          })
          .bindPopup(
            "<b>"+item.nama+"</b><br>Fasilitator : "+item.jumlah
          )
          .addTo(map);
        });

        var chart = echarts.init(document.getElementById('expenseChart'));
        chart.setOption({
          animation:true,
          series:[{
            type:'pie',
            radius:['60%','78%'],
            center:['50%','48%'],
            startAngle:90,
            padAngle:2,
            label:{
              show:false
            },
            labelLine:{
              show:false
            },
            itemStyle:{
              borderColor:'#fff',
              borderWidth:4
            },
            data:[
              {
                value:2100,
                name:'Rent',
                itemStyle:{color:'#1F5B54'}
              },
              {
                value:525,
                name:'Investment',
                itemStyle:{color:'#98E85D'}
              },
              {
                value:420,
                name:'Education',
                itemStyle:{color:'#EDF4EA'}
              },
              {
                value:280,
                name:'Food',
                itemStyle:{color:'#D9D9D9'}
              },
              {
                value:175,
                name:'Entertainment',
                itemStyle:{color:'#8C8C8C'}
              }
            ]
          }],

          graphic:[
            {
              type:'text',
              left:'center',
              top:'39%',
              style:{
                text:'Semua Tahun',
                fill:'#999',
                font:'12px sans-serif'
              }
            },
            {
              type:'text',
              left:'center',
              top:'47%',
              style:{
                text:'3.900',
                fill:'#234E4A',
                font:'bold 28px sans-serif'
              }
            }
          ]
        });

        //---------------------------------------- fasilitator
        var options = {
          series: [{
            name: 'Jumlah Fasilitator',
            data: [820, 125, 430, 365, 58]
          }],
          chart: {
            type: 'bar',
            height: 300,
            toolbar: {
              show: false
            }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              distributed: true, // setiap batang memiliki warna berbeda
              columnWidth: '50%',
              borderRadius: 6
            }
          },
          colors: [
            '#1F5B54', // PNS
            '#98E85D', // CPNS
            '#6CDBC2', // PPNPN
            '#343A40', // PPPK
            '#FF9AAD'  // Lembaga
          ],
          dataLabels: {
            enabled: false
          },
          xaxis: {
            categories: [
              'PNS',
              'CPNS',
              'PPNPN',
              'PPPK',
              'Lembaga'
            ]
          },
          yaxis: {
            title: {
              text: 'Kategori Fasilitator'
            }
          },
          tooltip: {
            y: {
              formatter: function(val) {
                return val + " Orang";
              }
            }
          },
          legend: {
            show: false // tidak perlu legend karena nama sudah ada di bawah batang
          },
          grid: {
            borderColor: '#f1f1f1'
          }
        };

        var chart = new ApexCharts(document.querySelector("#pegawaiChart"), options);
        chart.render();

        //---------------------------------------- pendidikan
        var educationOptions = {

          series: [
              45,     // S3
              180,    // S2
              620,    // S1
              240,    // D4
              310,    // D3
              420,    // SMA/MA
              350,    // SMK/MAK
              135     // SMP/MTs
          ],

          chart: {
              type: 'donut',
              height: 230
          },

          labels: [
              'S3',
              'S2',
              'S1',
              'D4',
              'D3',
              'SMA/MA',
              'SMK/MAK',
              'SMP/MTs'
          ],

          colors: [
              '#4f46e5',
              '#6366f1',
              '#8b5cf6',
              '#06b6d4',
              '#0ea5e9',
              '#14b8a6',
              '#84cc16',
              '#f59e0b'
          ],

          stroke: {
              width: 4,
              colors: ['#ffffff']
          },

          dataLabels: {
              enabled: false
          },

          legend: {
              show: false
          },

          tooltip: {
              y: {
                  formatter: function(value){
                      return value + ' Fasilitator';
                  }
              }
          },

          plotOptions: {

              pie: {

                  donut: {

                      size: '68%',

                      labels: {
                          show: false
                      }

                  }

              }

          },

          states: {

              hover: {
                  filter: {
                      type: 'none'
                  }
              }

          }
        };

        var educationChart =
          new ApexCharts(
              document.querySelector("#educationChart"),
              educationOptions
        );

        educationChart.render();
      });
    </script>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function () {
          const modalElement = document.getElementById('modalDummyData');
          const modalDummy = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
          });
          modalDummy.show();
        }, 2000);
      });
    </script>
  </body>
</html>
