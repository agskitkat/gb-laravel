<article class="article pt-4">
    <h2>{{$article['title']}}</h2>
    <p>{{$article['text']}}</p>
    <a href="{{route('news', [$article['id']])}}">Подробнее</a>
</article>
