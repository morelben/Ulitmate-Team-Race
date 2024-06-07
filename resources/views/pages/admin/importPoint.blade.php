@extends('template.base2')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Importation</h1>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Importation Point</h4>
                    </div>
                    <form method="POST" action="{{ route('importPoint') }}"  enctype="multipart/form-data" >
                        @csrf
                        <div class="input-group custom p-4">
                            @if(session('success'))
                                <span class="alert alert-success">{{ session('success') }}</span>
                            @endif
                        </div>
                        <div class="form-group p-4">
                            <label>Point</label>
                            <div class="custom-file mb-20">
                                <input type="file" class="custom-file-input" name="file" id="importFile">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                            <div class="form-group text-right m-2">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-cloud-download-alt"></i> Importer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
