@extends('layouts.admin')

@section('menu')

    <li class="active"><a href="{{ route('Articles') }}">Статьи</a></li>
    <li><a href="#">Шото там еще</a></li>
@endsection

@section('sidebar')
    <div class="last-articles">
        <h2 class="flex-center">Articles</h2>
        <p><a href="{{ route('createArticle') }}">Create Article</a></p>
    </div>
@endsection

@section('content')

    <table class="table table-hover">

        <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>description</th>
            <th>text</th>
            <th>image</th>
            <th>created_at</th>
        </tr>
        </thead>

        <tbody>

            @foreach($articles as $article)

                <tr>
                    <td><a href="{{ route('editArticle', $article->id) }}">{{ $article->title }}</a></td>
                    <td>{{ $article->author }}</td>
                    <td>{!! $article->description !!}</td>
                    <td>{{ $article->text }}</td>
                    <td>{{ $article->image }}</td>
                    <td>{{ $article->created_at }}</td>
                </tr>

            @endforeach

        </tbody>

    </table>

@endsection