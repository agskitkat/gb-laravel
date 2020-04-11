@extends('layouts.layout')

@section('content')
    <article class="article pt-4">
        @if(isset($article->image))
            <div class="image" style="background-image: url({{  $article->image }})"></div>
        @endif
        <h1>{{ $article->name }}</h1>
        <p>{!! $article->text !!}</p>
        @guest

        @else
            <a href="{{ route('admin.article.edit', [$article->id]) }}">Редактировать новость</a>
        @endguest
    </article>
@endsection
