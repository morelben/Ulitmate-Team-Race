@extends('template.base')
@section('content')
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="input-group custom" >
            @if(session('success'))
                <span class="alert alert-success">{{ session('success') }}</span>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="row p-4">
                        <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                            <h4>Equipe {{ $name_equipe }}</h4>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                            <p>{{ $step->nometape }}({{ $step->longueur }} km) - {{ $step->nbrcoureur }} Runner</p>
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="card-body p-0">
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>Name Runner</th>
                                        <th>Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($chronos as $chrono)
                                        <tr>
                                            <td>{{ $chrono->nom_coureur }}</td>
                                            <td>{{ $chrono->temps_passe }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form action="{{ route('runnerList') }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="step_id" value="{{ $etape_id }}">
                                    <div class="form-group"></div>
                                    <button type="submit" class="btn btn-primary btn-action mr-1 p-2">
                                        <i class="fas fa-running"></i>
                                        Assign Runner
                                    </button>
                                </form>
                                <div class="p-3" >
                                    {{ $chronos->appends(['step_id' => $etape_id, 'equipe_id' => $equipe_id])->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
