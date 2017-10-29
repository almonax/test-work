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
                </thead>
                <tbody>

                    @foreach($employees as $employee)
                    <tr>
                        <td><a href="{{ url('/views', ['id' => $employee->id]) }}">{{ $employee->fullname }}</a></td>
                        <td>{{ $employee->salary }}</td>
                        <td>{{ $employee->beg_work }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            {{ $employees->links() }}

        </div>
    </div>
</div>

@endsection
