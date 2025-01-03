<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>System Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    @vite(['resources/css/login.css'])
    <link rel="icon" type="image/png" href="favicon.png">
    <style>
        @media screen and (max-width: 600px) {
            h4 {
                font-size: 85%;
            }
        }
    </style>
</head>

<body style="background-image: url('{{ Vite::asset('resources/images/bg.jpg') }}');">
    <div align="center">
        <img src="{{ Vite::asset('resources/images/TVRI_Jawa_Timur_2023.svg') }}" width="15%" style="margin-top:5%">
        <br><br>
        <div class="container">
            <div style="color:white">
                <label>Login untuk mengakses</label><br>
                @if (session('status'))
                    <p class="alert alert-success">{{ session('status') }}</p>
                @endif
                @if ($errors->any())
                    <p class="alert alert-danger">{{ $errors->first() }}</p>
                @endif
            </div>
            <form method="post" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username" autofocus>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                </div>
                <button type="submit" class="btn btn-primary" name="btn-login">Masuk</button>
            </form>
            <br>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pesan Kesalahan</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <p>{{ $errors->first() }}</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if ($errors->any())
                $('#myModal').modal('show');
            @endif
        });
    </script>
</body>

</html>
