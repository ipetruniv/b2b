

@extends('layouts.main')
@section('title')
    @lang('messages.RESET_PASSWORD')
@endsection
@section('content')
    <section id="main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="group clearfix">
                        <div class="my_tabs">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="home">
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if (session('status'))
                                        <div class="alert alert-danger alert-dismissible" style="">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-ban"></i>{{ session('status') }} </h4>
                                        </div>
                                    @endif
                                    {!! Form::open(['route' => 'password.request', 'method' => 'POST', 'class' => 'login']) !!}
                                        {{ csrf_field() }}
                                        <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="group form-group{{ $errors->has('email') ? ' has-error' : '' }} clearfix">
                                        <label for="email" class="col-md-4 control-label">E-Mail</label>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="group form-group{{ $errors->has('password') ? ' has-error' : '' }} clearfix">
                                        <label for="password" class="col-md-4 control-label">@lang('messages.PASSWORD')</label>
                                        <input id="password" type="password" class="form-control" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="group form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} clearfix">
                                        <label for="password-confirm" class="col-md-4 control-label">@lang('messages.CONFIRM') @lang('messages.PASSWORD')</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            {{ Form::submit(__('messages.RESET_PASSWORD'), ['class' => 'btn btn-primary']) }}
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js-files')
    @parent
@endsection
