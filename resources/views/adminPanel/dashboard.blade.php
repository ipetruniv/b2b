@extends('layouts.admin')

@section('navbar')
    @parent
@endsection

@section('content')
    
    @if (session('status'))
        <div class="alert alert-warning alert-dismissible" style="">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i>{{ session('status') }} </h4>   
        </div>
    @endif
    
    <section class="content-header">
        <h1>Управління</h1>  
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">                   
                    <div class="box-body">
                       @if($adminsCount)
                            <div class="col-lg-3 col-xs-6">         
                                <div class="small-box bg-yellow">
                                    <div class="inner">              
                                        <h3>{{ $adminsCount }}</h3>
                                        <p>Адміністраторів</p> 
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                    <a href="/admin/admn" class="small-box-footer">
                                     Переглянути <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                        @if($shops)
                              <div class="col-lg-3 col-xs-6">         
                                  <div class="small-box bg-aqua">
                                      <div class="inner">          
                                          <h3>{{ $shops }}</h3>
                                          <p>Магазинів</p>
                                      </div>
                                      <div class="icon">
                                          <i class="ion ion-bag"></i>
                                      </div>
                                    <a href="/admin/shop" class="small-box-footer">
                                       Переглянути <i class="fa fa-arrow-circle-right"></i>
                                      </a>
                                  </div>
                              </div>       
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
