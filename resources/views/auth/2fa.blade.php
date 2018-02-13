@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Two Factor Автентикација</strong></div>
                    <div class="panel-body">
                        <p>Two factor автентикацијата (2FA) ја зголемува сигурноста со барање на два методи(наречени фактори) за верификација на идентитет. Овој вид на автентикација нуди заштита против фишинг, социјално инженерство и напади со груба сила со што ги заштитува вашите најави од напаѓачи кои експлоатираат слаби или украдени податоци.</p>
                        <br/>
                        <p>За да овозможете Two Factor Автентикација на вашиот профил извршете ги следните чекори:</p>
                        <strong>
                            <ol>
                                <li>Кликнете на "Генерирај таен клуч за да вклучиш 2FA" , за да генерирате уникатен, таен, QR код за вашиот профил</li>
                                <li>Верифицирајте ја OTP лозинката од Google Authenticator мобилната апликација</li>
                            </ol>
                        </strong>
                        <br/>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(is_array($data['user']->passwordSecurity) && !count($data['user']->passwordSecurity))
                            <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                           Генерирај таен клуч за да вклучиш 2FA
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @elseif(!$data['user']->passwordSecurity->google2fa_enable)
                            <strong>1. Скенирајте го овој код со вашата Google Authenticator апликација:</strong><br/>
                            <img src="{{$data['google2fa_url'] }}" alt="">
                            <br/><br/>
                            <strong>2.Внесете го пин кодот за да вклучите 2FA</strong><br/><br/>
                            <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                    <label for="verify-code" class="col-md-4 control-label">Автентикациски код</label>
                                    <div class="col-md-6">
                                        <input id="verify-code" type="password" class="form-control" name="verify-code" required>
                                        @if ($errors->has('verify-code'))
                                            <span class="help-block">
<strong>{{ $errors->first('verify-code') }}</strong>
</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button type="submit" class="btn btn-primary">
                                            Вклучи 2FA
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @elseif($data['user']->passwordSecurity->google2fa_enable)
                            <div class="alert alert-success">
                                2FA моментално е <strong>вклучена</strong> за вашиот профил.
                            </div>
                            <p> Доколку сакате да ја исклучите Two Factor автентикацијата внесете ја вашата лозинка и кликнете на "Исклучи 2FA" копчето.</p>
                            <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                                <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label for="change-password" class="col-md-4 control-label">Моментална лозинка</label>
                                    <div class="col-md-6">
                                        <input id="current-password" type="password" class="form-control" name="current-password" required>
                                        @if ($errors->has('current-password'))
                                            <span class="help-block">
<strong>{{ $errors->first('current-password') }}</strong>
</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 col-md-offset-5">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary ">Исклучи 2FA</button>
                                </div>
                            </form>
                            @endif
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
