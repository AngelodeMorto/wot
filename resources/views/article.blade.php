@extends('layouts.main')

@section('content')
    <div class="titles_main">
        <div class="col-md-12">
            <div class="thumbnail">
                <img src="/img/articles/{{ $article->image }}">
                <div class="caption">
                    <h1 class="flex-center article-name">{{ $article->title }}</h1>
                    <p>Опубликовано {{ $article->created_at }} by {{ $article->author }}</p>
                    <div class="row">
                        <div class="col-md-12">{!! $article->text !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection