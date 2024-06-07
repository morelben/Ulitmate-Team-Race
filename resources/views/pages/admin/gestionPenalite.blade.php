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
            <h1>PENALITY</h1>
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
                            <h4>List Penality</h4>
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="card-body p-0">
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                    <tr>
                                        <th>Name Step</th>
                                        <th>Name Team</th>
                                        <th>Penality time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($penalites as $penality)
                                        <tr>
                                            <td>{{ $penality->nom_etape }}</td>
                                            <td>Equipe {{ $penality->nom_equipe }}</td>
                                            <td>{{ $penality->temp_penalite }}</td>
                                            <td>
                                                <button
                                                    class="btn btn-danger btn-action mr-1"
                                                    data-toggle="tooltip"
                                                    title="Delete"
                                                    onclick="openModalDelete('{{ $penality->id }}')"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                                <div class="input-group p-2">
                                <button type="submit" class="btn btn-primary btn-action mr-1 p-2" onclick="openModalAdd()">
                                    <i class="fas fa-plus-circle"></i>
                                    Add Penality
                                </button>
                                </div>
{{--                                <div class="p-3" >--}}
{{--                                    {{ $penalites->links() }}--}}
{{--                                </div>--}}
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
                    <h5 class="modal-title">New Penality</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('insertPenality') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="penalite">Step Name</label>
                            <select
                                class="selectpicker form-control form-control-lg"
                                data-style="btn-outline-secondary btn-lg"
                                title="Not Chosen"
                                name="etape"
                            >
                                @foreach ($etapes as $etape)
                                    <option value="{{ $etape->id }}" @if(old('etape') == $etape->id) selected @endif>{{ $etape->nometape }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group custom">
                            @error("etape")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="penalite">Team Name</label>
                            <select
                                class="selectpicker form-control form-control-lg"
                                data-style="btn-outline-secondary btn-lg"
                                title="Not Chosen"
                                name="equipe"
                            >
                                @foreach ($equipes as $equipe)
                                    <option value="{{ $equipe->id }}" @if(old('equipe') == $equipe->id) selected @endif>{{ $equipe->nomequipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group custom">
                            @error("equipe")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="penalite">Penality Time</label>
                            <input type="time" step="1" class="form-control @error("penalite") is-invalid @enderror"  value="{{ old('penalite') }}" name="penalite">
                        </div>
                        <div class="input-group custom">
                            @error("penalite")
                            <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
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
                    <h5 class="modal-title">Realy?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you want to continue?</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <form action="{{ route('deletePenality') }}" method="POST">
                        @method("delete")
                        @csrf
                        <input type="hidden" name="idEP" id="idEP" value="{{ old('idEP') }}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModalDelete($idEquipePenalite){
            document.getElementById('idEP').value = $idEquipePenalite;
            $('#exampleModal2').modal('show');
        }
    </script>
@endsection
