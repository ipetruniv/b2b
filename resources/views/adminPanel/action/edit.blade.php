@extends('layouts.admin')

@section('navbar')
    @parent
@endsection

@section('content')
        <section class="content-header">
            <h1>Добавлення акції</h1>  
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">   
                        <div class="box-body"> 
                            
                            @if (count($errors) > 0)
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Некоректні дані!</h4>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            {!! Form::open(['route' => ['actions-update',$originals->id],'method' => 'POST']) !!}
                               <div class="box-body">
                                    <div class="form-group">
                                        {!! Form::label('type', 'Тип') !!}      
                                        {{ Form::text('type', $originals->type, [ 'class'=>'form-control','id'=>'type',]) }}
                                    </div>
                                    <div class="form-group" @if($originals->type == 'Націнка') style="display: none" @endif>
                                        {!! Form::label('sign', 'Сумується') !!}    
                                        {{  Form::select('sign',['0'=>'Ні сумується', '1'=>'Cумується'], 0,['class' => 'form-control', 'id'=>'sign']) }}
                                    </div>
                                   
                                    <div id="block-markup" @if(!$originals->size) style="display: none" @endif>                                    
                                        <div class="form-group">
                                            {!! Form::label('size','розмір') !!}  
                                            {{ Form::select('size[]', $size, $originals->size, [ 'class' => 'form-control select2','multiple'=>true,]) }}
                                        </div> 
                                    </div> 
                                    
                                  <div id="block-discount" @if($originals->type == 'Націнка') style="display: none" @endif>
                                                                          
                                    <div class="form-group" id="form-color" @if(!$originals->color) style="display: none" @endif>
                                        {!! Form::label('color','колір') !!}  
                                        {{  Form::select('color[]', $color, $originals->color, ['class' => 'form-control select2','multiple'=>true, 'data-placeholder'=>'Виберіть колір', ]) }}                                  
                                    </div>
                                      
                                    <div class="form-group" id="form-product" @if(!$originals->product) style="display: none" @endif>
                                        {!! Form::label('product','продукт') !!}  
                                        {{ Form::select('product[]', $product ,$originals->product, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'product',]) }}
                                    </div>
                                      
                                    <div class="form-group" id="form-collection" @if(!$originals->collection) style="display: none" @endif>
                                        {!! Form::label('collection','Колекція') !!}  
                                        {{ Form::select('collection[]', $collection ,$originals->collection, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'collection',]) }}
                                    </div>
                                       
                                    <div class="form-group" id="form-brend" @if(!$originals->brend) style="display: none" @endif>
                                        {!! Form::label('brend','Бренд') !!}  
                                        {{ Form::select('brend[]', $brend ,$originals->brend, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'collection',]) }}
                                    </div>
                                      
                                    <div class="form-group" id="form-user"  @if(!$originals->user_id) style="display: none" @endif>
                                        {!! Form::label('user','Юзер') !!}  
                                        {{ Form::select('user_id[]', $users ,$originals->user_id, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'user',]) }}
                                    </div>   
                                </div>
                                <div id="block-character" >
                                    <div class="form-group">
                                        {!! Form::label('active','активная') !!}  
                                        {{ Form::select('active', ['0'=>'не активная', '1'=>'активная'],$originals->active, [ 'class'=>'form-control','id'=>'active']) }}
                                    </div>
                                    
                                    <div class="form-group">
                                        {!! Form::label('sum', 'значення %') !!}      
                                        {{  Form::text('sum',$originals->sum, [ 'class'=>'form-control','id'=>'sum']) }}
                                    </div>
                                </div>
                                    
                                </div>
                                <div class="box-footer">
                                    {{ Form::submit('Редагувати',['class'=>'btn btn-primary']) }}
                                </div>
                            {!! Form::close() !!}  
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <script src="/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <!-- Select2 -->
    <link rel="stylesheet" href="/AdminLTE/plugins/select2/select2.min.css">
  <script>
        $(document).ready(function() {
           $(".select2").select2();
        }); 
        
        function showme(){
            $('#form-size').hide();
            $('#form-color').hide();
            $('#form-product').hide();
            $('#form-collection').hide();
            $('#form-brend').hide();
            $('#form-user').hide();
            var value = $('#attribute').val();
            if(value == 'size')
            $('#form-size').show();
            if(value == 'color')
             $('#form-color').show();
            if(value == 'product')
             $('#form-product').show();
            if(value == 'brend')
             $('#form-brend').show();
            if(value == 'collection')
             $('#form-collection').show();
            if(value == 'user-id')
             $('#form-user').show();
        }
      </script>
@endsection


    


