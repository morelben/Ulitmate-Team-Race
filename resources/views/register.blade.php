@include('template.header')
<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="{{ asset('assets/img/logo1.jpg') }}" alt="logo" width="130" height="130" class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Create Team Account</h4></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('insertTeam') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="nameTeam" class="control-label">Name Team</label>
                                    <input value="{{ old('nameTeam') }}" placeholder="Name Team" id="nameTeam" type="text" class="form-control @error("nameTeam") is-invalid @enderror" name="nameTeam" tabindex="2" >
                                </div>
                                <div class="input-group custom" >
                                    @error("nameTeam")
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="emailTeam" class="control-label">Email Team</label>
                                    <input value="{{ old('emailTeam') }}" placeholder="xxx@gmail.com" id="emailTeam" type="email" class="form-control @error("emailTeam") is-invalid @enderror" name="emailTeam" tabindex="2" >
                                </div>
                                <div class="input-group custom" >
                                    @error("emailTeam")
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pwdTeam" class="control-label">Password Team</label>
                                    <input value="{{ old('pwdTeam') }}" placeholder="Password Team" id="pwdTeam" type="password" class="form-control @error("pwdTeam") is-invalid @enderror" name="pwdTeam" tabindex="2" >
                                </div>
                                <div class="input-group custom" >
                                    @error("pwdTeam")
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
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
