@extends('layouts.layout')

@section('content')
    <article class="article pt-4">
        <h1>{{$article['title']}}</h1>
        <p>{{$article['text']}}</p>
    </article>
@endsection
