@extends('layouts.admin')
@section('title') Add News @parent @stop
@section('content')

<form method="post" action="{{ route('admin.news.store') }}">
@csrf

<div class="form-group">
    <label for="category_id">Category</label>
    <select name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
            @if(old('category_id') === $category->id) selected @endif>{{ $category->title }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}">
</div>

@error('title') <div class="alert">{{ $message }}</div> @enderror

<div class="form-group">
    <label for="author">Author</label>
    <input type="text" name="author" id="author" value="{{ old('author') }}">
</div>

@error('author') <div class="alert">{{ $message }}</div> @enderror

<div class="form-group">
    <label for="description">Description</label>
    <textarea rows="10" name="description" id="description">{!! old('description') !!}</textarea>
</div>

@error('description') <div class="alert">{{ $message }}</div> @enderror

<div class="form-group">
    <label for="short">Short description</label>
    <input type="text" name="short" id="short" value="{{ old('short') }}">
</div>

@error('short') <div class="alert">{{ $message }}</div> @enderror

<button type="submit" class="success">SAVE</button>
</form>

@endsection
