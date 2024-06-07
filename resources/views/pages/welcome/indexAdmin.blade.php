@extends('template.base2')
@section('content')
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    @if ($errors->any())
        <script>
            $(document).ready(function(){
                $('#exampleModal').modal('show');
            });
            $(document).ready(function(){
                $('#exampleModal2').modal('show');
            });
        </script>
    @endif
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
                            <h5>List of steps</h5>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 col-sm-6 text-right">
                            <button
                                type="submit"
                                class="btn btn-outline-success"
                                data-toggle="tooltip"
                                title="Add"
                                onclick="openModalAdd()"
                            >
                                <i class="fas fa-plus-circle"></i> New Step
                            </button>
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="row p-4">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                            <form id="search-form" action="{{ route('search') }}" method="GET">
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
                                            <button
                                                class="btn btn-primary btn-action mr-1"
                                                data-toggle="tooltip"
                                                title="Edit"
                                                onclick="openModalModif('{{ $step->rang }}','{{ $step->nometape }}','{{ $step->longueur }}','{{ $step->nbrcoureur }}','{{ $step->id }}')"
                                            >
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            <a href="{{ route('runnerListStep', ['id' => $step->id]) }}">
                                                <button type="button" class="btn btn-warning btn-action mr-1">
                                                    <i class="fas fa-clock"></i>
                                                    Assign Time
                                                </button>
                                            </a>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Step</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('insertStep') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="number_step">Number Step</label>
                            <input type="number" class="form-control @error("number_step") is-invalid @enderror" value="{{ old('number_step') }}" name="number_step">
                        </div>
                        <div class="input-group custom">
                            @error("number_step")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name_step">Name Step</label>
                            <input type="text" class="form-control @error("name_step") is-invalid @enderror" value="{{ old('name_step') }}" placeholder="Name step" name="name_step">
                        </div>
                        <div class="input-group custom">
                            @error("name_step")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="length_step">Length Step</label>
                            <input type="number" class="form-control @error("length_step") is-invalid @enderror" value="{{ old('length_step') }}" name="length_step">
                        </div>
                        <div class="input-group custom">
                            @error("length_step")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="number_runner">Number Runner</label>
                            <input type="number" class="form-control @error("number_runner") is-invalid @enderror" value="{{ old('number_runner') }}" name="number_runner">
                        </div>
                        <div class="input-group custom">
                            @error("number_runner")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="departure_time">Departure Time</label>
                            <div class="form-group">
                                <input class="form-control" type="date" name="departure_time" id="departure_time" value="{{ old('departure_time') }}"/>
                            </div>
                            <div class="input-group custom">
                                @error("departure_time")
                                <span class="alert alert-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                        <input class="form-control" type="number" name="depart_hh" id="depart_hh" value="{{ old('depart_hh') }}" placeholder="HH"/>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                        <input class="form-control" type="number" name="depart_mm" id="depart_mm" value="{{ old('depart_mm') }}" placeholder="MM"/>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                        <input class="form-control" type="number" name="depart_ss" id="depart_ss" value="{{ old('depart_ss') }}" placeholder="SS"/>
                                    </div>
                                </div>
                                <div class="row m-1">
                                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                        <div class="input-group custom">
                                            @error("depart_hh")
                                            <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                        <div class="input-group custom">
                                            @error("depart_mm")
                                            <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-4 col-sm-4">
                                        <div class="input-group custom">
                                            @error("depart_ss")
                                            <span class="alert alert-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function openModalAdd(){
            $('#exampleModal').modal('show');
        }
    </script>

    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Step</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('editStep') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="step_id" name="step_id" value="">
                        <div class="form-group">
                            <label for="number_step_edit">Number Step</label>
                            <input type="number" id="number_step_edit" class="form-control @error("number_step_edit") is-invalid @enderror" value="{{ old('number_step_edit') }}" name="number_step_edit">
                        </div>
                        <div class="input-group custom">
                            @error("number_step_edit")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name_step_edit">Name Step</label>
                            <input type="text" id="name_step_edit" class="form-control @error("name_step_edit") is-invalid @enderror" value="{{ old('name_step_edit') }}" placeholder="Name step" name="name_step_edit">
                        </div>
                        <div class="input-group custom">
                            @error("name_step_edit")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="length_step_edit">Length Step</label>
                            <input type="number" id="length_step_edit" class="form-control @error("length_step_edit") is-invalid @enderror" value="{{ old('length_step_edit') }}" name="length_step_edit">
                        </div>
                        <div class="input-group custom">
                            @error("length_step_edit")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="number_runner_edit">Number Runner</label>
                            <input type="number" id="number_runner_edit" class="form-control @error("number_runner_edit") is-invalid @enderror" value="{{ old('number_runner_edit') }}" name="number_runner_edit">
                        </div>
                        <div class="input-group custom">
                            @error("number_runner_edit")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function openModalModif($number_step,$name_step,$length_step,$number_runner,$step_id){
            document.getElementById('number_step_edit').value = $number_runner;
            document.getElementById('name_step_edit').value =$name_step;
            document.getElementById('length_step_edit').value = $length_step;
            document.getElementById('number_runner_edit').value = $number_runner;
            document.getElementById('step_id').value = $step_id;
            $('#exampleModal2').modal('show');
        }
    </script>
@endsection
