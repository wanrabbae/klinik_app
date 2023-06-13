<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Dental Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="css/main.css" />

    <style>
        .background {
            background-image: url('clinic-banner.jpg');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover
        }

        .image-sides {
            width: 450px;
        }
    </style>
</head>

<body class="background show-spinner no-footer">
    {{-- <div class="fixed-background"></div> --}}
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        {{-- <div class=""> --}}
                        <img src="/clinic-logo1.jpg" class="image-sides" alt="">
                        {{-- </div> --}}
                        <div class="form-side">
                            <div class="text-center mb-3">
                                <h2>Hello! Selamat Data</h2>
                                <h6 class="text-muted">Silahkan Login dengan Akun Anda</h6>
                            </div>
                            <h6 class="mb-4">Login</h6>
                            <form method="POST" action="{{ route('auth') }}">
                                @csrf
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="email" />
                                    <span>E-mail</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" placeholder="" name="password" />
                                    <span>Password</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#">Forget password?</a>
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/vendor/jquery-3.3.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/dore.script.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
