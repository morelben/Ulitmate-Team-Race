@extends('template.base')
@section('content')
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger" >
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="input-group custom" >
            @if(session('success'))
                <span class="alert alert-success">{{ session('success') }}</span>
            @endif
        </div>
        <div class="input-group custom">
            @if(session('error'))
                <span class="alert alert-danger">{{ session('error') }}</span>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="row p-4">
                        <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                            <h4>List of runners</h4>
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="card-body p-0">
                        <form method="POST" action="{{ route('insertStepRunner') }}">
                            @csrf
                            <input type="hidden" value="{{ $step->id }}" name="step_id">
                            <div class="form-group">
                                <div class="row p-2">
                                    @foreach ($runners as $runner)
                                        <div class="col-12 col-md-6 col-lg-3">
                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h4>Name Runner: {{ $runner->nomcoureur }}</h4>
                                                </div>
                                                <div class="card-body">
                                                    <p>Jersey number: {{ $runner->numero_dossard }}</p>
                                                </div>
                                                <div class="card-footer p-5">
                                                    <input class="form-check-input" type="checkbox" value="{{ $runner->id }}" name="coureur[]" style="height: 20px;width: 20px">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group p-2">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
