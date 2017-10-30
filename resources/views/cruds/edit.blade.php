@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit employee profile</h1>

                @include('cruds._form-edit');

            </div>
        </div>
    </div>

@endsection