@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-8 blog-main">
            @include('articles/full')
            <nav class="blog-pagination">
                <a class="btn btn-outline-primary" href="#">Older</a>
                <a class="btn btn-outline-secondary disabled" href="#" tabindex="-1" aria-disabled="true">Newer</a>
            </nav>
        </div>
    </div>
@endsection
