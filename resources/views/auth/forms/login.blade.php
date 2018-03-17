<h2 class="title">@lang('messages.LOGIN_TITLE'):</h2>
<div class="group clearfix">
    {!! Form::label('login', __('messages.LOGIN')) !!}
    {!! Form::text('login', old('login')) !!}
    <span id="login-error" class="sp_error">{{ $errors->first('login') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('password_login', __('messages.PASSWORD')) !!}
    {!! Form::password('password_login') !!}
    <span id="password_login-error" class="sp_error">{{ $errors->first('password_login') }}</span>
</div>
<div class="group clearfix">
    {{ Form::submit(__('SUBMIT'), ['id' => 'click_login']) }}
</div>