@extends('layouts.template')

@section('title')
    Improove HR Tool
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">New Survey</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="div-row">
                        <div class="col-md-12">
                            <form>
                                <div class="form-row">
                                <div class="col">
                                    <p>Resposta fechada</p>
                                    <input type="text" class="form-control" placeholder="Survey name">
                                    <input type="text" class="form-control" placeholder="write question">
                                    <input type="number" class="form-control" placeholder="question weight">
                                    <input type="text" class="form-control" placeholder="Assessment areas">
                                    <input type="text" class="form-control" placeholder="Categories">
                                    <input type="text" class="form-control" placeholder="Parameters">
                                </div>
                                </div>
                                <button class="btn btn-warning">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h4 class="card-title">New Survey</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="div-row">
                        <div class="col-md-12">
                            <form>
                                <div class="form-row">
                                <div class="col">
                                    <p>Resposta aberta</p>
                                    <input type="text" class="form-control" placeholder="Survey name">
                                    <input type="text" class="form-control" placeholder="write question">
                                    <input type="number" class="form-control" placeholder="question weight">
                                    <input type="text" class="form-control" placeholder="Assessment areas">
                                    <input type="text" class="form-control" placeholder="Categories">
                                    <input type="text" class="form-control" placeholder="Parameters">
                                </div>
                                </div>
                                <button class="btn btn-warning">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection
