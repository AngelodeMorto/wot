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
                    <a href="#" onclick="event.preventDefault(); document.getElementById('WG-add-acc-form').submit();"><i class="fa fa-eye" aria-hidden="true"></i>Привязать картошкинский аккаунт</a>
                    <form style="display: none" id="WG-add-acc-form" class="form-horizontal" action="https://api.worldoftanks.ru/wot/auth/login/?application_id=df13c5fa140af811b023333b08201ab5&redirect_uri={{ config('app.url', 'localhost') }}/add-account" method="post" name="form2"></form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
