@extends('layouts.layout')
@section('content')
    <h1>Список категорий</h1>
    <p>
        <a class="btn btn-primary"
           href="{{ route('categories.create') }}">
            Добавить категорию
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
        @foreach($list as $category)
            <tr>
                <td>{{$category->name}}</td>
                <td>{{$category->alias}}</td>
                <td>
                    <form  action="{{ route('categories.destroy', [$category]) }}" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        <a class="btn btn-primary btn-sm" href="{{ route('categories.edit', [$category]) }}">Изменить</a>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $list->render() }}
@endsection
