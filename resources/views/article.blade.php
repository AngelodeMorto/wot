@extends('layouts.main');

@section('content')

    <img src="/img/{{ $article->image }}">
    <h1 class="flex-center article-name">{{ $article->title }}</h1>
    <p>Опубликовано {{ $article->created_at }} by {{ $article->author }}</p>
    <div class="row">
    <div class="col-md-12">{!! $article->text !!}</div>
    </div>
@endsection