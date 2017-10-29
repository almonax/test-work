@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>View profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="image"><img src="https://dummyimage.com/mediumrectangle/222222/eeeeee" alt=""></div>
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
                        <a href="{{ url('/') }}" class="btn btn-info">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
