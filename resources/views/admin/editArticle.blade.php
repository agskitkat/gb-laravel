@extends('layouts.layout')

@section('content')
    <h1>Новая новость:</h1>
    <form>
        <div class="form-group">
            <label>Заголовок</label>
            <input name="title" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label>Категория</label>
            <select name="categories" multiple class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="form-group">
            <label>Текст новости</label>
            <textarea name="text" class="form-control" rows="10"></textarea>
        </div>
    </form>
@endsection
