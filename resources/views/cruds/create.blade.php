@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Add new employee</h1>

                @include('cruds._form-create');

            </div>
        </div>
    </div>

@endsection