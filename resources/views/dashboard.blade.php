@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h1>All employees of company</h1>

            @foreach($employees as $employee)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="{{ url('/view', ['id' => $employee->id]) }}">{{ $employee->fullname }}</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <img width="100px"
                                         src="{{ ($employee->photo == null) ? 'http://via.placeholder.com/100x100': '/images/thumbs/'.$employee->photo }}"
                                         class="img-thumbnail" alt="{{ $employee->fullname }}">
                                </div>
                                <div class="col-md-7">
                                    <div class="well well-sm">
                                        <strong>Salary: </strong>{{ $employee->salary }}
                                    </div>
                                    <div class="well well-sm">
                                        <strong>Works since: </strong>{{ $employee->beg_work }}
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ url('/edit', ['id' => $employee->id]) }}" class="btn btn-info pull-right">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                </div>
                                <div class="col-md-1">
                                    <a href="#" class="btn btn-danger _actionBtn pull-right" data-action="delete" data-val="{{ $employee->id }}">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{ $employees->links() }}

        </div>
    </div>
</div>

@endsection
