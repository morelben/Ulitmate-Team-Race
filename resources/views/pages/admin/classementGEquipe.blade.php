@extends('template.base2')
@section('content')
    <?php
    $farany = 0;
    ?>
    <script src="{{ asset('apexcharts/dist/apexcharts.js') }}"></script>
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
                    <div class="row p-5">
                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                            <form action="{{ route('showRankingGByCateg') }}" method="POST">
                                @csrf
                                <div class="input-group">
                                    <select
                                        class="selectpicker form-control form-control-lg"
                                        data-style="btn-outline-secondary btn-lg"
                                        title="Not Chosen"
                                        name="categorie"
                                    >
                                        <option value="M">Homme</option>
                                        <option value="F">Femme</option>
                                        <option value="Junior">Junior</option>
                                        <option value="Senior">Senior</option>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary">Show Runking</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                            <a href="{{ route('exportPDF') }}">
                                <button class="btn btn-danger p-2"><i class="fas fa-file-pdf"></i> Export PDF</button>
                            </a>
                        </div>
                    </div>
                    <div class="row p-4">
                        <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th>Rank Team</th>
                                            <th>Name Team</th>
                                            <th>Total Point</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($rankings as $ranking)
                                            @if($farany == $ranking->total_point_obtenu)
                                                <tr style="background-color: #b1dfbb;color: black">
                                                    <td>{{ $ranking->rang_equipe }} place</td>
                                                    <td>{{ $ranking->nomequipe }}</td>
                                                    <td>{{ $ranking->total_point_obtenu }} </td>
                                                    <td>
                                                        <form action="{{ route('alea') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="idEquipe" value="{{ $ranking->equipe_id }}">
                                                        <button class="btn btn-primary" type="submit">Show Detail</button>
                                                        </form></td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td>{{ $ranking->rang_equipe }} place</td>
                                                    <td>{{ $ranking->nomequipe }}</td>
                                                    <td>{{ $ranking->total_point_obtenu }} </td>
                                                    <td><form action="{{ route('alea') }}" method="POST">
                                                            @csrf
                                                        <input type="hidden" name="idEquipe" value="{{ $ranking->equipe_id }}">
                                                        <button class="btn btn-primary" type="submit">Show Detail</button>
                                                    </form></td>
                                                </tr>
                                            @endif
                                            <?php
                                                $farany = $ranking->total_point_obtenu;
                                            ?>

                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{--                            <div class="p-3" >--}}
                                    {{--                                {{ $rankings->links() }}--}}
                                    {{--                            </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 col-sm-6">
                            <div id="chart"></div>
                            @php
                                $rankings = json_encode($rankings);
                            @endphp
                            <script>
                                var donnee = {!! $rankings !!};

                                var options = {
                                    series: donnee.map(item => item.total_point_obtenu),
                                    chart: {
                                        type: 'pie',
                                        height: 350
                                    },
                                    labels: donnee.map(item => item.nomequipe),
                                    stroke: {
                                        show: false
                                    },
                                    responsive: [
                                        {
                                            breakpoint: 480,
                                            options: {
                                                chart: {
                                                    width: 200
                                                }
                                            }
                                        }
                                    ],
                                    tooltip: {
                                        y: {
                                            formatter: function(val) {
                                                return val + " points";
                                            }
                                        }
                                    }
                                };

                                var chart = new ApexCharts(document.querySelector("#chart"), options);
                                chart.render();
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
