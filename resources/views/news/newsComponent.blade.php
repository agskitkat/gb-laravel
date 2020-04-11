<article class="article pt-4">
    <h2>{{ $article->name }}</h2>
    <p>{!! $article->text !!}</p>
    <a href="{{ route('news', [$article->id]) }}">Подробнее</a>

    @guest

    @else
        <a href="{{ route('admin.article.edit', [$article->id]) }}">Редактировать новость</a>
    @endguest

</article>
