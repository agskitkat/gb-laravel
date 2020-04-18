<article class="article pt-4">
    @if(isset($article->image))
        <div class="image" style="background-image: url({{  $article->image }})"></div>
    @endif
    <h2>{{ $article->name }}</h2>
    <p>{!! $article->text !!}</p>

    <a href="{{ route('news', [$article->id]) }}">Подробнее</a>

    @guest

    @else
        <a href="{{ route('articles.edit', [$article->id]) }}">Редактировать новость</a>
    @endguest

</article>
