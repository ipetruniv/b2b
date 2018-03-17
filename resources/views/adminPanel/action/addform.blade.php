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
                            
                            {!! Form::open(['route' => 'actions-create','method' => 'POST']) !!}
                                <div class="box-body">
                                    <div class="form-group">
                                        {!! Form::label('type', 'Тип') !!}      
                                        {{ Form::select('type', [ '0'=>'Виберіть тип', '1'=>'націнка', '2'=>'знижка'],0, [ 'class'=>'form-control','id'=>'type_action', 'value'=>'Виберіть']) }}
                                    </div>
                                    
                                    <div id="block-markup" style="display: none">                                    
                                        <div class="form-group">
                                            {!! Form::label('size','розмір') !!}  
                                            {{ Form::select('size[]', $size, null, [ 'class'=>'form-control select2','id'=>'size',  'multiple'=>true,]) }}
                                        </div> 
                                    </div> 
                                    
                                  <div id="block-discount" style="display: none">
                                    <div class="form-group" >
                                        {!! Form::label('sign', 'Сумується') !!}    
                                        {{  Form::select('sign',['0'=>'Ні сумується', '1'=>'Cумується'], 0,['class' => 'form-control', 'id'=>'sign']) }}
                                    </div> 
                                    <div class="form-group">
                                        {!! Form::label('attribute','атрибут') !!}  
                                        {{ Form::select('attribute', ['0'=>'Виберіть атрибут', 'size'=>'Розмір', 'color'=>'Колір', 'product'=>'Продукт', 'collection'=>'Каталог', 'user_id'=>'Юзер','brend'=>'Бренд'], null, [ 'class'=>'form-control','id'=>'attribute','onchange'=>'showme()']) }}
                                    </div>
                                      
                                    <div class="form-group" id="form-size" style="display: none">
                                            {!! Form::label('size','розмір') !!}  
                                            {{ Form::select('size[]', $size, null, ['class' => 'form-control select2','multiple'=>true, 'id'=>'size']) }}
                                    </div> 
                                      
                                    <div class="form-group" id="form-color" style="display: none">
                                        {!! Form::label('color','колір') !!}  
                                        {{  Form::select('color[]', $color, null, ['class' => 'form-control select2','multiple'=>true, 'data-placeholder'=>'Виберіть колір' ]) }}                                  
                                    </div>
                                      
                                    <div class="form-group" id="form-product" style="display: none">
                                        {!! Form::label('product','продукт') !!}  
                                        {{ Form::select('product[]', $product ,1, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'product']) }}
                                    </div>
                                      
                                    <div class="form-group" id="form-collection" style="display: none">
                                        {!! Form::label('collection','Каталог') !!}  
                                        {{ Form::select('collection[]', $collection ,1, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'collection']) }}
                                    </div>
                                      
                                    <div class="form-group" id="form-brend" style="display: none">
                                        {!! Form::label('brend','Бренд') !!}  
                                        {{ Form::select('brend[]', $brend ,1, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'brend']) }}
                                    </div>
                                      
                                    <div class="form-group" id="form-user" style="display: none">
                                        {!! Form::label('user','Юзер') !!}  
                                        {{ Form::select('user_id[]', $users,1, [ 'class' => 'form-control select2','multiple'=>true,'id'=>'user']) }}
                                    </div>        
                                      
                                </div>
                                <div id="block-character" style="display: none">
                                    <div class="form-group">
                                        {!! Form::label('active','активная') !!}  
                                        {{ Form::select('active', ['0'=>'не активная', '1'=>'активная'],1, [ 'class'=>'form-control','id'=>'active']) }}
                                    </div>
                                    
                                    <div class="form-group">
                                        {!! Form::label('sum', 'сума %') !!}      
                                        {{  Form::text('sum',old('sum'), [ 'class'=>'form-control','id'=>'sum']) }}
                                    </div>
                                </div>
                                    
                                </div>                                
                                <div class="box-footer">
                                    {{ Form::submit('Создать',['class'=>'btn btn-primary']) }}
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
          $('#type_action').change(function () {
            var type = $('#type_action').val();
            if(type ==1) {
              $('#block-discount').hide();
              $('#block-markup').show();
              $('#block-character').show();
            } else if(type == 2) {
              $('#block-character').show();
              $('#block-discount').show();
              $('#block-markup').hide();
            }
            else{
                $('#block-discount').hide();
                $('#block-markup').hide();
                $('#block-character').hide();
            }
          });
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
            if(value == 'collection')
             $('#form-collection').show();
            if(value == 'brend')
             $('#form-brend').show();
            if(value == 'user_id')
             $('#form-user').show();
        }
      </script>
@endsection


    


