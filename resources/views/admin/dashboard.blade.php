@extends('layouts.template')

@section('title')
    Improove HR Tool
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Simple table teste</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <tbody class="table">
                        <thead class="text-primary">
                            <th>something</th>
                            <th>something</th>
                            <th>something</th>
                            <th>something</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12</td>
                                <td>12</td> 
                                <td>12</td>
                                <td>12</td>
                            </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page Content -->
<div class="content">
   
    <!-- Your Block -->
    <div class="block">
        <div class="block-header">
            <h3 class="block-title">
                Title <small>Get Started</small>
            </h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                    <i class="si si-pin"></i>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                    <i class="si si-close"></i>
                </button>
            </div>
        </div>
        <div class="block-content font-size-sm">
            <p>
                Create your own awesome project!
            </p>
        </div>
    </div>
    <!-- END Your Block -->
</div>
<!-- END Page Content -->

@endsection

@section('scripts')

@endsection
