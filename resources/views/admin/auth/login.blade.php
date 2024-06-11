@include('admin.lauout.import.head')

<body class="hold-transition login-page">

<div class="login-box">
    <!-- /.login-logo -->

    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="#" class="h3">Administrative Panel</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in</p>



            @include('admin.lauout.import.message')

            <form action="{{route('login.functionality')}}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control  @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}"
                           placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password"
                           placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <p class="invalid-feedback">{{$message}}</p>
                    @enderror
                </div>
                <div class="row">
                                         <div class="col-8">
                                              <div class="icheck-primary">
                                                <input type="checkbox" id="remember" name="remember">
                                                <label for="remember">
                                                      Remember Me
                                                </label>
                                              </div>
                                        </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
@include('admin.lauout.import.script')

</body>
</html>
