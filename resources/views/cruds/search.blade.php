@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h1>Search</h1>
                <a href="{{ url('/') }}" class="btn btn-default">Back to home</a>
                <hr>

                @if (count($model) == 0)

                    <h2>Sorry, but nothing found for this query =(</h2>
                    <p>Search again</p>
                    <div class="row">
                        @include('cruds.search-form')
                    </div>

                @else

                    @foreach($model as $item)
                        <div class="row">
                            <div class="col-md-4">
                                <div class="well well-sm"><a href="{{ route('view', ['id' => $item->id])  }}">{{ $item->fullname }}</a></div>
                            </div>
                        </div>
                    @endforeach

                @endif

            </div>
        </div>
    </div>

@endsection
