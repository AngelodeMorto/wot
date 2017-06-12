@extends('layouts.main')

@section('content')
    <h2>Кабинет</h2>
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                    <br>

                    @if(!Auth::user()->account_id)
                    <a href="#" onclick="event.preventDefault(); document.getElementById('WG-add-acc-form').submit();"><i class="fa fa-eye" aria-hidden="true"></i>Привязать картошкинский аккаунт</a>
                    <form style="display: none" id="WG-add-acc-form" class="form-horizontal" action="https://api.worldoftanks.ru/wot/auth/login/?application_id=df13c5fa140af811b023333b08201ab5&redirect_uri={{ config('app.url', 'localhost') }}/add-account" method="post" name="form2"></form>
                    @endif

                    @if(session('random_pass'))
                        <p>Вам установлен рандомный пароль <b>{{ session('random_pass') }}</b>. Запомните его, или измените</p>
                    @endif
                    <form action="{{ route('setPassword') }}" method="post">
                        {{ csrf_field() }}
                        <input type="password" name="password" required>
                        <button>Изменить пароль</button>
                    </form>

                    @if(preg_match("~^guest\d+~",Auth::user()->name))
                    <form action="{{ route('changeNickname') }}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="name" required>
                        <button>Сменить логин</button>
                    </form>
                    @endif

                </div>
            </div>
@endsection
