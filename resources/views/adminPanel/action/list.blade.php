@extends('layouts.admin')

@section('navbar')
    @parent
@endsection

@section('content') 
        <section class="content-header">
            <h1>Акції</h1>  
        </section>
        <section class="content">
          
            <div class="info-ajax"></div> 
            
            @if (session('status'))
                <div class="alert alert-success alert-dismissible" style="">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('status') }} </h4>   
                </div>
            @endif
            @if (session('stat_error'))
                <div class="alert alert-danger alert-dismissible" style="">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i>{{ session('stat_error') }} </h4>   
                </div>
            @endif
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
              
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Список Акцій</h3>   
                        </div>  
                        <div class="btn-group">
                            <a href="{{ route('users-add-form') }}" class="btn btn-block btn-primary">Створити</a>
                        </div>
                        <div class="box-body">                                                   
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Тип</th>
                                        <th>Розмір</th>
                                        <th>Колір</th>   
                                        <th>Продукт</th>   
                                        <th>Колекція</th> 
                                        <th>Бренд</th> 
                                        <th>Користувач</th> 
                                        <th>Признак Сумується чи ні</th>
                                        <th>Значення знижки</th>
                                        <th>Активная</th>
                                        <th>Опції</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($actions as $action)   
                                        <tr>
                                            <!--<td>@if(isset($action->actionValue->color)){{ $action->actionValue->color }} @endif</td>-->
                                            <td>@if($action->type  == '1') Націнка @else Знижка @endif</td>
                                            <td>{{ $action->size }}</td>
                                            <td>{{ $action->color }}</td>                                            
                                            <td>{{ $action->product }}</td>
                                            <td>{{ $action->collection }}</td>
                                            <td>{{ $action->brend }}</td>
                                            <td>{{ $action->user_id }}</td>
                                            <td>@if($action->sign == 1) YES @else NO @endif </td>
                                            <td>{{ $action->sum }}%</td>
                                            <td>@if($action->active == 1) YES @else NO @endif </td>
                                            <td>
                                                <a href="/admin/actions/edit/{{ $action->id }}"> 
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a href="#" class="delete-action" data-id="{{ $action->id }}">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <p>Акцій немає</p>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<script>
    $(document).ready(function() {
        $('.delete-action').click(function () {
            if (confirm("Delete Action?")) {
                let element = $(this);
                element.parent().parent().remove();
                let id = $( this ).attr( 'data-id' );
                let token  = $('meta[name=csrf-token]').attr('content');
                $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});

                $.ajax( {
                    url:  "/admin/action/destroy/"+id,
                    data: {id: id},
                    dataType: 'json',
                    method: 'POST',
                    error: function ( errors ) {
                        console.log('error');
                    },
                    success: function ( json ) {
                        if ( json.status == 'ok' ) {
                            let item = "<div class='alert alert-success alert-dismissible'>\n\
                          <a type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</a>\n\
                          <h4><i class='icon fa fa-check'></i>Action has been Deleted</h4>\n\
                      </div>";

                            return $('.info-ajax').append(item);
                        }
                        else
                            alert('error');
                    }
                });
            }
        })
    });
</script>
@endsection
