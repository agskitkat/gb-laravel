@extends('layouts.layout')

@section('content')
    <h1>Все категории:</h1>
    @foreach($caterorys as $category)
        @component('news.categoryComponent', ["category" => $category, "parentPath" => ""])
        @endcomponent
    @endforeach
@endsection
