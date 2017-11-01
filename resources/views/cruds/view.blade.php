@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>View profile</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <img width="250px"
                     src="{{ ($employee->photo == null) ? 'http://via.placeholder.com/250x250': '/images/uploads/'.$employee->photo}}"
                     class="img-thumbnail" alt="{{ $employee->fullname }}">
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Employee information</h3></div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="well well-sm">
                                    <strong>Full name: </strong>{{ $employee->fullname }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="well well-sm">
                                    <strong>Salary: </strong>{{ $employee->salary }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="well well-sm">
                                    <strong>Works since: </strong>{{ $employee->beg_work }}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h3>Branch of department</h3>
                                <div class="list-group">

                                    @php $i = true; @endphp
                                    @foreach($model as $item)
                                        @if ($i)
                                            @php $i = false; @endphp
                                            <a href="#" class="list-group-item disabled">
                                                {{ $item->fullname }}
                                                <span class="badge">{{ $item->cnt_children }}</span>
                                            </a>
                                        @else
                                            <a href="{{ route('view', ['id' => $item->id]) }}" class="list-group-item">
                                                {{ $item->fullname }}
                                                @if ($item->is_branch) <span class="badge">{{ $item->cnt_children }}</span>
                                                @endif
                                            </a>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <a href="{{ url()->previous() }}" class="btn btn-info">Come back</a>
                        <a class="btn btn-warning" href="{{ url('/edit', ['id' => $employee->id]) }}">Edit profile</a>
                        <a class="btn btn-success" href="{{ url('/create', ['parentId' => $employee->id]) }}">Add a subordinate</a>
                        <a class="btn btn-danger pull-right _actionBtn" data-action="delete" data-val="{{ $employee->id }}" href="#">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
