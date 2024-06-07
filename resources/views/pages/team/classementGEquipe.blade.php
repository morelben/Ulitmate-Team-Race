@extends('template.base')
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
                            <h5>Ranking Team</h5>
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                <tr>
                                    <th>Rank Team</th>
                                    <th>Name Team</th>
                                    <th>Total Point</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($rankings as $ranking)
                                    <tr>
                                        <td>{{ $ranking->rang_equipe }} place</td>
                                        <td>{{ $ranking->nomequipe }}</td>
                                        <td>{{ $ranking->total_point_obtenu }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
{{--                            <div class="p-3" >--}}
{{--                                {{ $rankings->links() }}--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
