<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <title>.: Login :.</title>
    <link rel="shortcut icon" href="assets/frontend/images/favicon16.png">
    <link rel="stylesheet" type="text/css" href="assets/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/frontend/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="assets/frontend/css/theme.min.css">
</head>

<body>
    <main class="auth-creative-wrapper">
        <div class="auth-creative-inner">
            <div class="creative-card-wrapper">
                <div class="card my-4 overflow-hidden" style="z-index: 1">
                    <div class="row flex-1 g-0">
                        <div class="col-lg-6 h-100 my-auto order-1 order-lg-0">
                            <div class="creative-card-body card-body p-sm-5">
                                <h2 class="fs-20 fw-bolder mb-4">Login</h2>
                                <h4 class="fs-13 fw-bold mb-2">Pastikan akun kamu sudah terdaftar</h4>
                                <p class="fs-12 fw-medium text-muted">Selamat datang di halaman login, silahkan masukkan username dan password kamu.</p>

                                @if (session()->has('UserNotFound'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('UserNotFound') }}
                                </div>
                                @endif

                                @if (session()->has('UserUnVerifikasi'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    {{ session('UserUnVerifikasi') }}
                                </div>
                                @endif

                                @if (session()->has('UserNonActive'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('UserNonActive') }}
                                </div>
                                @endif

                                @if (session()->has('AccountFalse'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('AccountFalse') }}
                                </div>
                                @endif

                                @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                </div>
                                @endif

                                @if (session()->has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                </div>
                                @endif

                                @if (session()->has('reaktivasi'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    {{ session('reaktivasi') }}
                                </div>
                                @endif

                                @if (session()->has('aktivasi'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('aktivasi') }}
                                </div>
                                @endif

                                @if (session()->has('aktivasifailed'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('aktivasifailed') }}
                                </div>
                                @endif

                                @if (session()->has('ReceiverError'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('ReceiverError') }}
                                </div>
                                @endif

                                <form action="434cbfb7-68b1-4c6f-9320-6ad6846da21d" method="post" class="w-100 mt-4 pt-2">
                                    @csrf
                                    <div class="mb-4">
                                        <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Ketikkan Username Disini..." id="username" name="username" value="{{ old('username') }}" autofocus required>
                                    </div>

                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div class="mb-3">
                                        <input type="password" class="form-control" placeholder="Ketikkan Password Disini..." id="password" name="password" autocomplete="on" required>
                                    </div>
                                    <div class="mt-5 px-3 d-flex gap-3">
                                        <button type="submit" class="btn btn-lg btn-primary flex-fill">Login</button>
                                        <button type="button" onclick="Page.Beranda()" class="btn btn-lg btn-secondary flex-fill">Beranda</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-6 bg-white order-0 order-lg-1">
                            <div class="h-100 d-flex align-items-center justify-content-center">
                                <img src="assets/frontend/images/logo1.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="assets/frontend/js/vendors.min.js"></script> --}}
    <script src="assets/frontend/js/common-init.min.js"></script>
    <script src="assets/frontend/js/theme-customizer-init.min.js"></script>
    <script type="text/javascript">
        var Page = {};

        Page.Beranda = function()
        {
            window.location.href = "/";
        }

        $(function(){
            $("input[name='username']").on('input', function(e) {
                $(this).val($(this).val().replace(/[^aA0-zZ9!,.-]/g, ''));
            });
            $("input[name='password']").on('input', function(e) {
                $(this).val($(this).val().replace(/[^aA0-zZ9!,.-]/g, ''));
            });
        });
    </script>
</body>
</html>