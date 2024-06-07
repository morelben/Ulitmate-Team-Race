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
                            <h4>List of steps</h4>
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="row p-4">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                            <form id="search-form" action="{{ route('searchTeam') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" id="address" class="form-control"  placeholder="Search Here"
                                           name="mot">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Number Step</th>
                                    <th>Name Step</th>
                                    <th>Length Step</th>
                                    <th>Number of runners</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($steps as $step)
                                    <tr>
                                        <td>{{ $step->rang }}</td>
                                        <td>{{ $step->nometape }}</td>
                                        <td>{{ $step->longueur }} km</td>
                                        <td>{{ $step->nbrcoureur }}</td>
                                        <td>
                                            <form action="{{ route('listChronoRunner') }}" method="GET">
                                                @csrf
                                                @if(session()->has('idequipe'))
                                                    <input type="hidden" name="idequipe" value="{{ session('idequipe') }}">
                                                    <input type="hidden" name="nameequipe" value="{{ session('nameequipe') }}">
                                                @endif
                                                <input type="hidden" name="step_id" value="{{ $step->id }}">
                                                <button type="submit" class="btn btn-warning btn-action mr-1">
                                                    <i class="fas fa-clock"></i>
                                                    Runners Time
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="p-3" >
                                {{ $steps->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
