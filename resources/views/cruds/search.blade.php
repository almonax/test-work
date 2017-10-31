@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h1>Search</h1>
                <a href="{{ url('/') }}" class="btn btn-default">Back to home</a>

                @if ($model === null)

                    <h2>Sorry, but nothing found for this query =(</h2>
                    <hr>
                    Search again
                    @include('cruds.search-form);

                @else

                    @foreach($model as $item)
                        <div class="well-lg"><a href="{{ route('view', ['id' => $item->id])  }}">{{ $item->fullname }}</a></div>
                    @endforeach

                    {{ $model->links() }}

                @endif

            </div>
        </div>
    </div>

@endsection
