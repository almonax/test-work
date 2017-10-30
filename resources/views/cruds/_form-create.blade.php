@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="post" class="form-horizontal" action="{{ url('/create') }}">

    {{ csrf_field() }}

    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-9">

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="fullname">Full name:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="fullname" placeholder="Enter full name" name="fullname" value="{{ old('fullname') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="salary">Salary:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="salary" placeholder="Enter salary value" name="salary" value="{{ old('salary') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="beg_work">Enter date begin work:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="beg_work" placeholder="Date format YYYY-MM-DD" name="beg_work" value="{{ old('beg_work') }}">
        </div>
    </div>

    <h3>Service information</h3>

    @if (! empty($parentData))
        <h4>Manager</h4>
        <div class="well well-sm"><a href="{{ url('/view', ['id' => $parentData->id]) }}">{{ $parentData->fullname }}</a></div>
        <input type="hidden" value="{{ $parentData->id }}" name="parentId">
    @else
    <div class="form-group">
        <label class="control-label col-sm-2" for="parentId">Manager ID:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="parentId" value="" name="parentId">
        </div>
    </div>
    @endif

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </div>

</form>
