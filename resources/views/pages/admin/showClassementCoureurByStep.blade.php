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
                    <div class="row p-4">
                        Etape 1
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Total Point</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rankings as $ranking)
                                    <tr>
                                        <td>{{ $ranking->nom_etape }}</td>
                                        <td>{{ $ranking->point_etape }}</td>

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
