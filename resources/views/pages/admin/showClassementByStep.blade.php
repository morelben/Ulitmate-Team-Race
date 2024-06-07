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
                            <h5>Ranking Runner</h5>
                        </div>
                    </div>
                    <hr class="m-2">

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Runner Rank</th>
                                    <th>Name Runner</th>
                                    <th>Runner Gender</th>
                                    <th>Runner Team</th>
                                    <th>Time Chrono</th>
                                    <th>Penality</th>
                                    <th>Final Time</th>
                                    <th>Point</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rankings as $ranking)
                                    <tr>
                                        <td>{{ $ranking->rang }}</td>
                                        <td>{{ $ranking->nom_coureur }}</td>
                                        <td>{{ $ranking->genre }}</td>
                                        <td>{{ $ranking->nomequipe }}</td>
                                        <td>{{ $ranking->temps_passe }}</td>
                                        <td>{{ $ranking->temps_penalite }}</td>
                                        <td>{{ $ranking->temps_finale }}</td>
                                        <td>{{ $ranking->point_obtenu }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="p-3" >
                                {{ $rankings->appends(['step' => $etape_id])->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
