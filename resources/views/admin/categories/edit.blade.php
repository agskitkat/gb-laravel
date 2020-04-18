@extends('layouts.layout')
@section('content')

    @if(isset($category->id))
        <h1>Редактирование категории: {{ $category->name }}</h1>
    @else
        <h1>Новая категория:</h1>
    @endif

    <form
        enctype="multipart/form-data"
        action="{{ route('categories.update', [$category->id?:0]) }}"
        method="POST">
        <input type="hidden" name="_method" value="PUT">

        @csrf

        <div class="form-group">
            <label>Название категории</label>
            <input name="name" type="text" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ $category->name }}">
            @component('admin.input-errors', ["fieldname" => 'name'])@endcomponent
        </div>

        <div class="form-group">
            <label>Алиас категории</label>
            <input name="alias" type="text" class="form-control  @if($errors->has('alias')) is-invalid @endif" value="{{ $category->alias }}">
            @component('admin.input-errors', ["fieldname" => 'alias'])@endcomponent
        </div>

        <div class="form-group">
            <label>Родительская категория</label>
            <select name="parent_id" class="form-control @if($errors->has('parent_id')) is-invalid @endif">
                <option value="0">Верхняя категория</option>
                @foreach($categoriesList as $cat) {
                    <option value="{{ $cat['id'] }}" @if( $category->parent_id === $cat['id'] ) selected @endif>{{ $cat['name'] }}</option>
                }
                @endforeach
            </select>
            @component('admin.input-errors', ["fieldname" => 'parent_id'])@endcomponent
        </div>

        @if(isset($category->id))
            <input type="hidden" name="id" value="{{ $category->id }}">
            <button type="submit" class="btn btn-success">Сохранить</button>
        @else
            <button type="submit" class="btn btn-success">Добавить категорию</button>
        @endif
    </form>

@endsection
