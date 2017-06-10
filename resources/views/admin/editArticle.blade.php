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

    {!! Form::open(['url' => route('editArticle', $article->id), 'class'=>'form-horizontal', 'enctype'=>'multipart/form-data']) !!}

    <div class="form-group">
        {!! Form::hidden('id', $article->id) !!}
        {!! Form::label('title', 'Title:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('title', $article->title, ['class'=>'form-control', 'placeholder'=>'Enter title of article']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('author', 'Author:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::text('author', $article->author, ['class'=>'form-control', 'placeholder'=>'Enter author']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::textarea('description', $article->description, ['id'=>'description', 'class'=>'form-control', 'placeholder'=>'Enter description']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('text', 'Text:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::textarea('text', $article->text, ['id'=>'text', 'class'=>'form-control', 'placeholder'=>'Enter text']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('old_image', 'Image:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-offset-2 col-xs-10">
            {!! Html::image('img/articles/'.$article->image, '', ['class'=>'img-circle old-article-image'])!!}
            {!! Form::hidden('old_image', $article->image) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('image', 'Image:', ['class'=>'col-xs-2 control-label']) !!}
        <div class="col-xs-8">
            {!! Form::file('image', ['class'=>'filestyle', 'data-buttonText'=>'Choose image', 'data-buttonName'=>'btn-primary', 'data-placeholder'=>'No file', 'data-icon'=>'false']) !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            {!! Form::button('Save', ['class'=>'btn btn-primary', 'type'=>'submit']) !!}
        </div>
    </div>


    {!! Form::close() !!}


@endsection

@section('includes_js')
    @parent
    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('text');
    </script>
@endsection