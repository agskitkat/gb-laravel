@extends('layouts.layout')

@section('content')
    @if(isset($article->id))
        <h1>Редактирование новости: {{ $article->name }}</h1>
    @else
        <h1>Новая новость:</h1>
    @endif

    <form
        enctype="multipart/form-data"
        action="{{ route('articles.update', [$article->id?:0]) }}"
        method="POST">
        <input type="hidden" name="_method" value="PUT">

        @csrf

        <div class="form-group">
            <label>Заголовок</label>
            <input name="name" type="text" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ $article->name }}">
            @component('admin.input-errors', ["fieldname" => 'name'])@endcomponent
        </div>

        <div class="form-group">
            <label>Категория</label>
            <select name="categories[]" multiple class="form-control @if($errors->has('categories')) is-invalid @endif">
                <option value="0">Без категории</option>
                @foreach($categoriesList as $category) {
                    <option value="{{ $category->id }}" @if($category->is_use || in_array($category->id, isset($article->categories)?$article->categories:[])) selected @endif>
                        {{ $category->name }}
                    </option>
                }
                @endforeach
            </select>
            @component('admin.input-errors', ["fieldname" => 'categories'])@endcomponent
        </div>

        @if($article->image)
            <div class="image" style="background-image: url({{  $article->image }})"></div>
        @endif

        <div class="form-group">
            <label>Картинка</label>
            <input name="image" type="file" class="form-control-file">
        </div>

        <div class="form-group">
            <label>Текст новости</label>
            <textarea id="ckeditor" name="text" class="form-control @if($errors->has('text')) is-invalid @endif" rows="10">{{ $article->text }}</textarea>
            @component('admin.input-errors', ["fieldname" => 'text'])@endcomponent
        </div>

        @if($article->id)
                <input type="hidden" name="id" value="{{ $article->id }}">
                <button type="submit" class="btn btn-success">Сохранить</button>
            @else
                <button type="submit" class="btn btn-success">Добавить новость</button>
        @endif
    </form>
@endsection
