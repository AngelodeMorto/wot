@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <br>

                    @if(!Auth::user()->account_id)
                    <a href="#" onclick="event.preventDefault(); document.getElementById('WG-add-acc-form').submit();"><i class="fa fa-eye" aria-hidden="true"></i>Привязать картошкинский аккаунт</a>
                    <form style="display: none" id="WG-add-acc-form" class="form-horizontal" action="https://api.worldoftanks.ru/wot/auth/login/?application_id=df13c5fa140af811b023333b08201ab5&redirect_uri={{ config('app.url', 'localhost') }}/add-account" method="post" name="form2"></form>
                    @endif

                    @if(!Auth::user()->password)
                    <form action="{{ route('setPassword') }}" method="post">
                        {{ csrf_field() }}
                        <input type="password" name="password" required>
                        <button>Установить пароль</button>
                    </form>
                    @endif

                    @if(preg_match("~^guest\d+~",Auth::user()->name))
                    <form action="{{ route('changeNickname') }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="name" required>
                        <button>Сменить логин</button>
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
