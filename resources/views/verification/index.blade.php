<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MUA.KU | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<!-- PERBAIKAN: Tambahkan tag div untuk .login-box -->
<div class="login-box">
  <div class="login-logo">
    <b>Verification</b>
  </div>
  <!-- /.login-logo -->
  <!-- PERBAIKAN: Tambahkan tag div untuk .card -->
  <div class="card">
    <div class="card-body login-card-body">

      @if (session('failed'))
        <div class="alert alert-danger">{{ session('failed') }}</div>
      @endif

      <p class="login-box-msg">Please verify your account!</p>

      <!-- Form Pilihan Channel -->
      <form action="/verify" method="post">
        @csrf
        <input type="hidden" name="type" value="register">

        <div class="form-group">
          <label>Pilih Metode Verifikasi:</label>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="email" name="send_via" value="email" checked>
            <label for="email" class="custom-control-label">Kirim via Email</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="whatsapp" name="send_via" value="whatsapp">
            <label for="whatsapp" class="custom-control-label">Kirim via WhatsApp</label>
          </div>
        </div>

        <button type="submit" class="btn btn-sm btn-primary">Kirim OTP</button>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>

</body>
</html>