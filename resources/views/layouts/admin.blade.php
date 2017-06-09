@extends('layouts.main')


@section('menu')
    <li class=""><a href="{{ route('Articles') }}">Статті</a></li>
    <li><a href="{{ route('refresh') }}">Оновити ітерацію</a></li>
    <li><a href="{{ route('change_similar') }}">Change</a></li>
@endsection

@section('sidebar')

@endsection

@section('content')
    Admin panel
@endsection

@section('includes_js')
    @parent
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/bootstrap-filestyle.min.js')}}"></script>
@endsection


