@extends('layouts.main')

@section('title')
  @lang('messages.LOGIN')
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
                         @if($errors->all())
                            @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible" style="">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-ban"></i>{{$error}}</h4>   
                            </div>
                            @endforeach       
                         @endif
                        <!-- Навигация -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#home" id="a_login" aria-controls="home" role="tab" data-toggle="tab">@lang('messages.LOGIN')</a></li>
                            <li><a href="{{URL::to('/'.(App::getLocale().'/register')) }}" >@lang('messages.REGISTRATION')</a></li>
                            <li><a href="{{URL::to('/'.(App::getLocale().'/password/reset')) }}">@lang('messages.RESET_PASSWORD')</a></li>
                        </ul>
                        <!-- Содержимое вкладок -->
                        <div class="tab-content"> 
                            
                            <div role="tabpanel" class="tab-pane active" id="home">
                                {!! Form::open(['route' => 'custom-login', 'method' => 'POST', 'class' => 'login', 'id' => 'login_form']) !!}
                                    @include('auth.forms.login')
                                {!! Form::close() !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
