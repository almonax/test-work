@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" class="form-horizontal" action="{{ url('/edit') }}" enctype="multipart/form-data">

    {{ csrf_field() }}
    {{ method_field('PUT') }}

    <input type="hidden" name="id" value="{{ $employee->id }}">

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

    <div class="form-group">
        <label class="control-label col-sm-2" for="photo">Edit photo:</label>
        <div class="col-sm-10">
            <input name="photo" type="file" class="form-control" id="photo">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 text-right"><strong>Current photo:</strong></div>
        <div class="col-sm-10">
            <img width="100px"
                 src="{{ ($employee->photo == null) ? 'http://via.placeholder.com/100x100': '/images/uploads/'.$employee->photo}}"
                 class="img-thumbnail" alt="{{ $employee->fullname }}">
        </div>
    </div>

    <h3>Service information</h3>

    <div class="form-group">
        <label class="control-label col-sm-2" for="id">Employee ID:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="id" value="{{ $employee->id }}" disabled>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </div>

</form>
