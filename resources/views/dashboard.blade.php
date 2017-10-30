@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h1>All employees of company</h1>
            <a href="{{ url('/create') }}" class="btn btn-default">Add new</a>
            <a href=""></a>
            <table class="table table-striped">
                <thead>
                    <th>Full name</th>
                    <th>Salary</th>
                    <th>Begin work</th>
                    <th></th>
                </thead>
                <tbody>

                    @foreach($employees as $employee)
                    <tr>
                        <td>
                            <a href="{{ url('/view', ['id' => $employee->id]) }}">{{ $employee->fullname }}</a>
                            <a href="{{ url('/edit', ['id' => $employee->id]) }}" class="btn btn-info pull-right">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </td>
                        <td>{{ $employee->salary }}</td>
                        <td>{{ $employee->beg_work }}</td>
                        <td>
                            <a href="#" class="btn btn-danger _actionBtn pull-right" data-action="delete" data-val="{{ $employee->id }}">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            {{ $employees->links() }}

        </div>
    </div>
</div>

@endsection
