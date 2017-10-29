@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit profile: {{ $employee->fullname }}</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" class="form-horizontal" action="{{ route('/save') }}">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fullname">Full name:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fullname" placeholder="Enter full name" name="fullname" value="{{ $employee->fullname }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="salary">Salary:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="salary" placeholder="Enter salary value" name="salary" value="{{ $employee->salary }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="beg_work">Enter date begin work:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="beg_work" placeholder="Date format YYYY-MM-DD" name="beg_work" value="{{ $employee->beg_work }}">
                        </div>
                    </div>

                    <h3>Service information</h3>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="ID">Employee ID:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control disabled" id="ID" value="{{ $employee->id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="left">Left key:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="left" placeholder="Enter left key" name="lft" value="{{ $employee->lft }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="right">Right key:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="right" placeholder="Enter right key" name="rht" value="{{ $employee->rht }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="level">Level:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="level" placeholder="Enter level" name="lvl" value="{{ $employee->lvl }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection