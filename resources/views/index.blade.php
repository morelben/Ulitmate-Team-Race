@include('template.header')
<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="{{ asset('assets/img/logo1.jpg') }}" alt="logo" width="130" height="130"  class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Login</h4></div>

                        <div class="card-body">
                            <form action="{{ route('dologin')}}" method="POST">
                                @csrf
                                <div class="input-group custom" >
                                    @if(session('success'))
                                        <span class="alert alert-success">{{ session('success') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input value="{{ old('email') }}" placeholder="xxxx@gmail.com" id="email" type="email" class="form-control @error("email") is-invalid @enderror" name="email" tabindex="1" >
                                </div>
                                <div class="input-group custom" >
                                    @error("email")
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label">Password</label>
                                    <input value="{{ old('password') }}" placeholder="Password" id="password" type="password" class="form-control @error("password") is-invalid @enderror" name="password" tabindex="2" >
                                </div>
                                <div class="input-group custom" >
                                    @error("password")
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-muted text-center">
                        Your team Don't have an account? <a href="{{ route('register') }}">Create one</a>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; Stisla 2018
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('template.footer')
