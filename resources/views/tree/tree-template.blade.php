@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-">
                <h2>Employees</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- TREE BEGIN -->
                <div id="tree1" data-url="/get-next-branch"></div>
                <!-- TREE END -->
            </div>
            <div class="col-md-6">
                <button id="actionSave" class="btn btn-success">Save changes <span class="badge"></span></button>
                <button id="actionReload" class="btn btn-info">Reload without save</button>
            </div>
        </div>
    </div>

    @push('init_tree')
        <script src="{{ asset('/assets/js/initTree.js') }}"></script>
    @endpush

@endsection