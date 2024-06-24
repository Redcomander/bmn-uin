<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <title>Login</title>
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }

            .col-md-9.col-lg-6.col-xl-5 img {
                display: none;
            }
        }

        .icon-image {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .icon-image img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 767px) {
            .img-fluid {
                display: none;
                /* Hide the image on mobile devices */
            }

            .content-container {
                margin-top: -150px;
                /* Raise the content up on mobile devices */
            }
        }

        .bottom-section {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100 content-container">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('login.jpg') }}" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Icon Image -->
                        <div class="icon-image">
                            <img src="{{ asset('logo_uin.png') }}" alt="Icon Image">
                        </div>

                        <!-- Username input -->
                        <div class="form-outline mb-4">
                            <input id="username" type="text" name="username" :value="old('username')" required
                                autofocus autocomplete="username" type="username" class="form-control form-control-lg"
                                placeholder="Enter a valid username" />
                            <label for="username" :value="__('username')" class="form-label" for="form3Example3">Username</label>
                        </div>
                        <x-input-error :messages="$errors->get('username')" class="mt-2 text-danger" />

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input id="password" type="password" class="form-control form-control-lg " name="password"
                                required autocomplete="current-password" placeholder="Enter password" />
                            <label for="password" :value="__('Password')" class="form-label"
                                for="form3Example4">Password</label>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value=""
                                    id="form2Example3" />
                                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}
                            </div>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;"
                                type="submit">{{ __('Log in') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div
            class="bottom-section d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <!-- Copyright -->

            <!-- Right -->
            <div>
                <a class="text-white">
                    <i class="fas fa-lock"></i>
                </a>
            </div>
            <!-- Right -->
        </div>
    </section>
</body>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</html>
