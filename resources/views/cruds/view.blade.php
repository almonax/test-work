@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>View profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <img src="http://via.placeholder.com/250x250" class="img-circle" alt="Cinque Terre">
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Employee information</div>
                    <div class="panel-body">
                        <table class="table table-condensed">
                            <tr>
                                <td><strong>Full name:</strong></td>
                                <td>{{ $employee->fullname }}</td>
                            </tr>
                            <tr>
                                <td><strong>Salary:</strong></td>
                                <td>{{ $employee->salary }}</td>
                            </tr>
                            <tr>
                                <td><strong>Begin work:</strong></td>
                                <td>{{ $employee->beg_work }}</td>
                            </tr>
                        </table>
                        <a href="{{ url()->previous() }}" class="btn btn-info">Come back</a>
                        <a class="btn btn-warning" href="{{ url('/edit', ['id' => $employee->id]) }}">Edit profile</a>
                        <a class="btn btn-danger" href="{{ url('/create', ['parentId' => $employee->id]) }}">Add a subordinate</a>
                        <a class="btn btn-danger _actionBtn" data-action="delete" data-val="{{ $employee->id }}" href="#">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
