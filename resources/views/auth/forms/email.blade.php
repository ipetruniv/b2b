{{ csrf_field() }}
<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
        <input id="email" name="email" placeholder="Email" class="form-control"  type="email">
    </div>
    @if ($errors->has('email'))
        <span class="help-block email_error">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
</div>
<div class="form-group">
    {!! Form::submit(__('messages.SUBMIT'), ['class' => 'btn btn-lg btn-primary btn-block']) !!}
</div>