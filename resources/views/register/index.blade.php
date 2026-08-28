<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="">
    <title>.: Register :.</title>
    <link rel="stylesheet" href="assets/frontend/css/style.css" />
    <link rel="stylesheet" href="assets/frontend/css/custom-styles.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" type="text/css" />
  </head>

  <body>
    <div id="slow_warning" style="display: none;">
      <img src="assets/frontend/img/preloader.gif" class="img-fluid" width="70px">
      <center style="color: white;">Loading. . .</center>
    </div>

    <section class="container">
      <header>Register</header>
      <center>
      @if (session()->has('available'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 3px; color: red;">
          {{ session('available') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session()->has('unlistmails'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 3px; color: red;">
          {{ session('unlistmails') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
            
      @if (session()->has('karakterunvalid'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 3px; color: red;">
          {{ session('karakterunvalid') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      </center>

      <form action="/register" method="post" class="form">
        @csrf
        <div class="input-box">
          <label>Username</label>
          <input type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Ketikkan disini..." autocomplete="off" name="nama" value="{{ old('nama') }}">
        </div>

        <div class="input-box">
          <label>Email</label>
          <input type="text" class="form-control @error('mails') is-invalid @enderror" placeholder="Ketikkan disini..." autocomplete="off" name="mails" value="{{ old('mails') }}">
        </div>
        <button type="submit" id="daftarAnggota">Submit</button>
      </form>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
      window.onload = function() {
      };

      function show_slow_warning() {
        $("#slow_warning").show();
      }

      $(document).ready(function() {
        $('#daftarAnggota').click(function(){
          $('.container').hide();
          show_slow_warning();
        });
      });

      var Exe = [];

      Exe.Register = function()
      {
        var a = $('input[name="_token"]').val();
        var b = $('input[name="nama"]').val();
        var c = $('input[name="mails"]').val();

        if(a == ''){
          toastr.error('Maaf, form token tidak boleh kosong.', 'Error!');
        }else if(b == ''){
          toastr.error('Maaf, nama lengkap tidak boleh kosong.', 'Error!');
        }else if(c == ''){
          toastr.error('Maaf, email tidak boleh kosong.', 'Error!');
        }else{
          $.ajax({
            url: "{{ url('register/proses-register') }}",
            type: 'POST',
            data: {_token:a, nama:b, mails:c},
            beforeSend: function() {
            },
            complete: function(response) {
              if(response.responseJSON.message == 404){
                // Swal.fire("Error", "Maaf, data streaming tidak di temukan.", "error");
                // $('#laporanStreaming').modal('show');
                // $('#StreamingLoader').hide();
              }else{
                // $('#StreamingLoader').hide();
                // $('#laporanStreaming').modal('hide');
              }
            },
            success: function(response) {
              if(response.message == 200){
              }
            }
          });
        }
      }

      $(function(){
        $("input[name='nama']").on('input', function(e) {
          $(this).val($(this).val().replace(/[^aA0-zZ9!-.,()]/g, ''));
        });
        $("input[name='mails']").on('input', function(e) {
          $(this).val($(this).val().replace(/[^a-zA-Z0-9.,_!@-]/g, ''));
        });
      });
    </script>
  </body>
</html>
