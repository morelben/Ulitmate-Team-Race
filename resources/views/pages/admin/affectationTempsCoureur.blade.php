@extends('template.base2')
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
                            <h5>Assign Time Runner</h5>
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="card-body p-4">
                        <form action="{{ route('insertTimeRunner') }}" method="POST">
                            @csrf
                            <input type="hidden" name="step_id" value="{{ $step_id }}">
                            <div class="form-group">
                                <label for="runner">Runner</label>
                                <select
                                    class="selectpicker form-control form-control-lg @error("runner") is-invalid @enderror"
                                    data-style="btn-outline-secondary btn-lg"
                                    name="runner"
                                    id="runner"
                                >
                                    @foreach ($runners as $runner)
                                        <option value="{{ $runner->idcoureur }}" @if(old('runner') == $runner->idcoureur) selected @endif>{{ $runner->nomcoureur }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="temps_arriver">Time to arrive</label>
                                <div class="form-group">
                                    <input class="form-control" type="date" name="temps_arriver" id="temps_arriver" value="{{ old('temps_arriver') }}"/>
                                </div>
                                <div class="input-group custom">
                                    @error("temps_arriver")
                                    <span class="alert alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                            <input class="form-control" type="number" name="arrive_hh" id="arrive_hh" value="{{ old('arrive_hh') }}" placeholder="HH"/>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                            <input class="form-control" type="number" name="arrive_mm" id="arrive_mm" value="{{ old('arrive_mm') }}" placeholder="MM"/>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                            <input class="form-control" type="number" name="arrive_ss" id="arrive_ss" value="{{ old('arrive_ss') }}" placeholder="SS"/>
                                        </div>
                                    </div>
                                    <div class="row m-1">
                                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                            <div class="input-group custom">
                                                @error("arrive_hh")
                                                <span class="alert alert-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                            <div class="input-group custom">
                                                @error("arrive_mm")
                                                <span class="alert alert-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                            <div class="input-group custom">
                                                @error("arrive_ss")
                                                <span class="alert alert-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="penalite">Penality</label>
                                <input class="form-control" type="number" name="penalite" id="penalite" value="{{ old('penalite') }}"/>
                            </div>
                            <div class="input-group custom">
                                @error("penalite")
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
