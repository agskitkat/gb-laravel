@extends('layouts.layout')

@section('content')
    <article class="article pt-4">
        <h1>{{ $article->name }}</h1>
        <p>{{ $article->text }}</p>
        @guest

        @else
            <a href="{{ route('admin.article.edit', [$article->id]) }}">Редактировать новость</a>
        @endguest
    </article>
@endsection
