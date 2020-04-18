@extends('layouts.layout')

@section('content')
    <h1>{{ $category['name'] }} :</h1>

    @if( isset($category['child']) )

        @foreach($category['child'] as $category)
            @component('news.categoryComponent', ["category" => $category, "parentPath" => $parent_path])
            @endcomponent
        @endforeach

    @endif

    <div class="news">
    @if(count($news))
            @foreach($news as $article)
                @component('news.newsComponent', ["article" => $article])
                @endcomponent
            @endforeach
            {{ $news->render() }}
    @else
        <div class="news__empty center">
            Нет новостей
        </div>
    @endif
    </div>
@endsection
