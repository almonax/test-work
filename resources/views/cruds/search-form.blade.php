    <form method="get" action="{{ url('/search/') }}" class="navbar-form navbar-left" role="search">
        {{--{{ csrf_field() }}--}}
        <div class="form-group">
            <input name="query" type="text" class="form-control" placeholder="Search by id or name">
        </div>
        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
    </form>
</li>