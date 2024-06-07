@extends('template.base2')
@section('content')
    <section class="section">
    <div class="section-header">
        <h1>RANKING</h1>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
                <div class="row p-4">
                    <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                        <h5>List Steps</h5>
                    </div>
                </div>
                <hr class="m-2">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr>
                                <th>Step Rank</th>
                                <th>Step Name</th>
                                <th>Step Length</th>
                                <th>Number Runner</th>
                                <th>Departure Time</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($steps as $step)
                                <tr>
                                    <td>{{ $step->rang }}</td>
                                    <td>{{ $step->nometape }}</td>
                                    <td>{{ $step->longueur }} km</td>
                                    <td>{{ $step->nbrcoureur }}</td>
                                    <td>{{ $step->date_depart }}</td>
                                    <td>
                                        <form action="{{ route('showRankingGByStep') }}" method="GET">
                                            <input type="hidden" name="step" value="{{ $step->id }}">
                                            <button class="btn btn-primary" type="submit">Show Ranking</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
