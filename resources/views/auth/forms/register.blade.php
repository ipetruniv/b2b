<h2 class="title">@lang('messages.REGISTER_TITLE'):</h2>
<div class="group clearfix">
    {!! Form::label('name', __('messages.NAME')) !!}
    {!! Form::text('name', old('name')) !!}
    <span id="name-error" class="sp_error">{{ $errors->first('name') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('surname', __('messages.SURNAME')) !!}
    {!! Form::text('surname', old('surname')) !!}
    <span id="surname-error" class="sp_error">{{ $errors->first('surname') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('phone', __('messages.PHONE_NUMBER')) !!}
    {!! Form::text('phone', old('phone')) !!}
    <span id="phone-error" class="sp_error">{{ $errors->first('phone') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('email', 'EMAIL') !!}
    {{ Form::email('email',old('email')) }}
    <span id="email-error" class="sp_error">{{ $errors->first('email') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('password', __('messages.PASSWORD')) !!}
    {!! Form::password('password') !!}
    <span id="password-error" class="sp_error">{{ $errors->first('password') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('password_confirmation', __('messages.CONFIRM').' '.__('messages.PASSWORD')) !!}
    {!! Form::password('password_confirmation') !!}
</div>

<h2 class="title">@lang('Information about company')</h2>

<div class="group clearfix">
    {!! Form::label('company', __('messages.COMPANY').' '.__('messages.NAME')) !!}
    {!! Form::text('company', old('company')) !!}
    <span id="company-error" class="sp_error">{{ $errors->first('company') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('vat', __('messages.VAT')) !!}
    {!! Form::text('vat', old('vat')) !!}
    <span id="vat-error" class="sp_error">{{ $errors->first('vat') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('phone_company', __('messages.PHONE_NUMBER_COMPANY')) !!}
    {!! Form::text('phone_company', old('phone_company')) !!}
    <span id="phone_company-error" class="sp_error">{{ $errors->first('phone_company') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('email_company', __('messages.EMAIL_COMPANY')) !!}
    {!! Form::text('email_company', old('email_company')) !!}
    <span id="email_company-error" class="sp_error">{{ $errors->first('email_company') }}</span>
</div>

<h2 class="title">@lang('messages.LEGAL_ADDRESS')</h2>

<div class="group clearfix">
    {!! Form::label('autocomplete', __('messages.ADDRESS')) !!}
    {!! Form::text('autocomplete', false, ['placeholder'=>__('messages.ENTER_ADDRESS')]) !!}
</div>
<div class="group clearfix">
    {!! Form::label('build', __('messages.STREET')) !!}
    {!! Form::text('build', false, ['id' => 'street_number', 'disabled'=>true, 'style'=>'width:20%; display: inline-block;']) !!}
    {!! Form::text('street', false, ['id'=>'route', 'disabled'=>true, 'style'=>'width:50%; margin-left:5%; display: inline-block;']) !!}
    <span id="street-error" class="sp_error">{{ $errors->first('street') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('province', __('messages.PROVINCE')) !!}
    {!! Form::text('province', false, ['id'=>'administrative_area_level_2', 'disabled'=>true]) !!}
    <span id="city-error" class="sp_error">{{ $errors->first('province') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('city', __('messages.CITY')) !!}
    {!! Form::text('city', false, ['id'=>'locality', 'disabled'=>true]) !!}
    <span id="city-error" class="sp_error">{{ $errors->first('city') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('region', __('messages.REGION')) !!}
    {!! Form::text('region', false, ['id'=>'administrative_area_level_1', 'disabled'=>true]) !!}
    <span id="region-error" class="sp_error">{{ $errors->first('region') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('post_code', __('messages.POST_CODE')) !!}
    {!! Form::text('post_code', false, ['id'=>'postal_code', 'disabled'=>true]) !!}
    <span id="post_code-error" class="sp_error">{{ $errors->first('post_code') }}</span>
</div>
<div class="group clearfix">
    {!! Form::label('country', __('messages.COUNTRY')) !!}
    {!! Form::text('country', false, ['id'=>'country', 'disabled'=>true]) !!}
    <span id="country-error" class="sp_error">{{ $errors->first('country') }}</span>
</div>

<h2 class="title">@lang('messages.DELIVERY_ADRESS')</h2>

{{--<div class="group my_checkbox clearfix">--}}
    {{--{!! Form::checkbox('legal', 'legal', false, ['id' => "legal", 'class' => 'postal_checkbox']) !!}--}}
    {{--{!! Form::label('legal', 'Same as legal') !!}--}}
{{--</div>--}}

<div class="group my_checkbox clearfix">
    <label>{!! Form::checkbox('legal', 'legal', false, ['id' => "legal", 'class' => 'postal_checkbox']) !!}
     <span>@lang('messages.SAME_AS_LEGAL')</span></label>
    <span class="err_legal"></span>
</div>

<div class="postal_addr">
    <div class="group clearfix">
        {!! Form::label('post_build', __('messages.STREET')) !!}
        {!! Form::text('post_build', false, ['id' => 'post_street_number', 'style'=>'width:20%; display: inline-block;']) !!}
        {!! Form::text('post_street', false, ['id'=>'route', 'style'=>'width:50%; margin-left:5%; display: inline-block;']) !!}
        <span id="post_street-error" class="sp_error">{{ $errors->first('post_street') }}</span>
    </div>
    <div class="group clearfix">
        {!! Form::label('province', __('messages.PROVINCE')) !!}
        {!! Form::text('post_province', false, ['id'=>'post_administrative_area_level_2']) !!}
        <span id="city-error" class="sp_error">{{ $errors->first('post_province') }}</span>
    </div>
    <div class="group clearfix">
        {!! Form::label('post_city', __('messages.CITY')) !!}
        {!! Form::text('post_city', false, ['id'=>'post_locality']) !!}
        <span id="post_city-error" class="sp_error">{{ $errors->first('post_city') }}</span>
    </div>
    <div class="group clearfix">
        {!! Form::label('post_region', __('messages.REGION')) !!}
        {!! Form::text('post_region', false, ['id'=>'post_administrative_area_level_1']) !!}
        <span id="post_region-error" class="sp_error">{{ $errors->first('post_region') }}</span>
    </div>
    <div class="group clearfix">
        {!! Form::label('post_post_code', __('messages.POST_CODE')) !!}
        {!! Form::text('post_post_code', false, ['id'=>'postal_code']) !!}
        <span id="post_post_code-error" class="sp_error">{{ $errors->first('post_post_code') }}</span>
    </div>
    <div class="group clearfix">
        {!! Form::label('post_country', __('messages.COUNTRY')) !!}
        {!! Form::text('post_country', false, ['id'=>'post_country']) !!}
        <span id="post_country-error" class="sp_error">{{ $errors->first('post_country') }}</span>
    </div>
</div>


<div class="group clearfix">
    {!! Form::label('comment', __('messages.COMMENT')) !!}
    {!! Form::textarea('comment', old('comment'), ['cols' => '30', 'rows' => '5']) !!}
</div>

<div class="group my_checkbox parent_captcha clearfix">
    <div class="g-recaptcha" data-sitekey="6Lfk3zAUAAAAAE2l0auGPr99lWyd9-u1RY6YZTD0"></div>
    <span id="captcha-error" class="sp_error">{{ $errors->first('captcha') }}</span>
</div>
<div class="group clearfix">
    {!! Form::submit(__('messages.SUBMIT'), ['id' => 'click_register']) !!}
</div>
<div class="group clearfix">
    <p>
        @lang('messages.ALREADY_REGISTER')?
        <a href="{{ URL::to(App::getLocale().'/login') }}" class="login_link">@lang('messages.SIGN_IN')</a>
    </p>
</div>