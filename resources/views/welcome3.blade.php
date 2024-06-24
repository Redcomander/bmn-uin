<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <style>
        /* Custom CSS can be added here if needed */
        /* Add your custom CSS styles here */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{ asset('background_uin.png') }});
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .logo {
            max-width: 100px;
            /* Adjust the max width to your desired size */
            width: 100%;
            display: block;
            margin: 0 auto;
        }

        .buttons {
            margin-top: 20px;
        }

        .button {
            margin: 5px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .smaller-image {
            max-width: 120px;
            /* Adjust the desired width */
            height: auto;
        }

        /* Media query for screens up to 767px (typical mobile devices) */
        @media (max-width: 767px) {
            .card {
                width: 80%;
                padding: 10px; /* Reduce top and bottom padding */
                margin: 0 auto;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="card">
            <img src="{{ asset('logo_uin.png') }}" alt="Your Logo" class="img-fluid mb-3 logo">
            <div class="text-center mb-4">
                <p class="mb-0" style="font-family: 'Roboto', sans-serif; font-size: 24px; color: #000;"><b>SELAMAT DATANG DI APLIKASI E-ASSET BMN<br>FAKULTAS SYARI'AH DAN HUKUM UIN RADEN FATAH PALEMBANG</b></p>
            </div>
            <div class="row align-items-center">
                <div class="col-12 col-md-6 text-center mb-3">
                    <img src="{{ asset('admin.png') }}" alt="Image 1" class="img-fluid mb-2 smaller-image">
                    <a href="{{ url('/login') }}" class="btn btn-primary btn-lg btn-block">Login sebagai Admin</a>
                </div>
                <div class="col-12 col-md-6 text-center mb-3"> <!-- Adjusted column size for mobile -->
                    <img src="{{ asset('user.png') }}" alt="Image 2" class="img-fluid mb-2 smaller-image">
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg btn-block">Login sebagai Tamu</a>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

</html>
