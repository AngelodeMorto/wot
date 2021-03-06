@extends('layouts.main')

@section('content')
    <h1>Content</h1>
    {{--<h2>more content</h2>--}}
    <div class="panel-group row">

        @foreach($articles as $article)

            <div class="col-sm-5 col-sm-offset-1 panel panel-default ">
                <div class="panel-heading"><img src="img/{{ $article->image }}" class="img-thumbnail"><h3 class="flex-center article-name">{{ $article->title }}</h3></div>
                <div class="panel-body">{!! $article->description !!}</div>
            </div>

        @endforeach
    </div>
@endsection