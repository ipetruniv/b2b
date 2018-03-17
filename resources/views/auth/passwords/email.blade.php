@extends('layouts.main')

@section('title')
    @lang('messages.RESET_PASSWORD')
@endsection

@section('locale')
    @parent
@endsection

@section('menu-catalog')
@endsection

@section('menu-user')
@endsection


@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="group clearfix">

                    <div class="my_tabs">
                        @if (session('status'))
                            <div class="alert alert-danger alert-dismissible" style="">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-ban"></i>{{ session('status') }} </h4>
                            </div>
                    @endif
                    <!-- Навигация -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li><a href="{{URL::to('/'.(App::getLocale().'/login')) }}">@lang('messages.LOGIN')</a></li>
                            <li><a href="{{URL::to('/'.(App::getLocale().'/register')) }}" >@lang('messages.REGISTRATION')</a></li>
                            <li class="active"><a href="#messages" id="a_reset" aria-controls="messages" role="tab" data-toggle="tab">@lang('messages.RESET_PASSWORD')</a></li>
                        </ul>
                        <!-- Содержимое вкладок -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="messages">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                                            <h2 class="text-center">@lang('messages.FORGOT_PASSWORD')?</h2>
                                            <p>@lang('messages.CAN_RESET_PASSWORD').</p>
                                            <div class="panel-body">
                                                {!! Form::open(['route' => ('password.email'), 'method' => 'POST', 'class' => 'form', 'id' => 'email_form']) !!}
                                                @include('auth.forms.email')
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
