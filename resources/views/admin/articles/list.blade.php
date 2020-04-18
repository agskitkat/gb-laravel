@extends('layouts.layout')
@section('content')
    <h1>Список статей</h1>
    <p>
        <a class="btn btn-primary dusk-add-article"
           href="{{ route('articles.create') }}">
            Добавить статью
        </a>
    </p>

    <table class="table">
        <thead>
        <tr>
            <th>Назание</th>
            <th>Алиас</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $article)
            <tr>
                <td>{{$article->name}}</td>
                <td>{{$article->alias}}</td>
                <td>
                    <form  action="{{ route('articles.destroy', [$article]) }}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        <a class="btn btn-primary btn-sm" href="{{ route('articles.edit', [$article]) }}">Изменить</a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $list->render() }}
@endsection
