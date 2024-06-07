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
                        <h5>Ranking By Step</h5>
                    </div>
                </div>
                <hr class="m-2">
                <div class="row p-4">
                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                        <form action="{{ route('showRankingGByStepTeam') }}" method="GET">
                            @csrf
                            <div class="input-group">
                                <select
                                    class="selectpicker form-control form-control-lg"
                                    data-style="btn-outline-secondary btn-lg"
                                    title="Not Chosen"
                                    name="step"
                                >
                                    <option value="">Choose step</option>
                                    @foreach ($steps as $step)
                                        <option value="{{ $step->id }}" @if(old('step') == $step->id) selected @endif>{{ $step->nometape }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Show Ranking</button>
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
                                <th>Rank Runner</th>
                                <th>Name Step</th>
                                <th>Name Runner</th>
                                <th>Name Team</th>
                                <th>Point Runner</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($rankings as $ranking)
                                <tr>
                                    <td>{{ $ranking->rang }} place</td>
                                    <td>{{ $ranking->nom_etape }}</td>
                                    <td>{{ $ranking->nom_coureur }}</td>
                                    <td>{{ $ranking->nomequipe }}</td>
                                    <td>{{ $ranking->point_obtenu }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
{{--                        <div class="p-3" >--}}
{{--                            {{ $rankings->appends(['step_id' => $etape_id])->links() }}--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
