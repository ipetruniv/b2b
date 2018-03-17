@extends('layouts.admin')

@section('navbar')
    @parent
@endsection

@section('content') 
        <section class="content-header">
            <h1>Користувачі</h1>  
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
                            <h3 class="box-title">Список Користувачів</h3>   
                        </div>     
                        <div class="box-body">                                                   
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Diler</th>
                                        <th>Agent</th>
                                        <th>Ім'я</th>
                                        <th>Тип</th>
                                        <th>email</th>   
                                        <th>Опції</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)   
                                        <tr>
                                            <td>{{$user->diller_id}}</td>
                                            <td>{{$user->agent_id}}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>  @if(!$user->diller_id && !$user->agent_id)
                                                    Diller
                                                @elseif($user->diller_id !== null && !$user->agent_id)
                                                    Agent
                                                @elseif($user->diller_id !== null && $user->agent_id !== null)
                                                    Buyer  
                                                @elseif($user->diller_id == null && $user->agent_id !== null)
                                                    Buyer      
                                                @endif</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="/admin/user/edit/{{ $user->id }}"> 
                                                    <i class="fa fa-edit"></i>
                                                </a>           
                                                <a href="#" class="delete-user" data-id="{{ $user->id }}"> 
                                                    <i class="fa fa-times"></i>
                                                </a>      
                                            </td>
                                        </tr>
                                    @empty
                                        <p>Юзерів немає</p>
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
          $('.delete-user').click(function () {
            if (confirm("Delete User?")) {
              let element = $(this);
              element.parent().parent().remove();
              let id = $( this ).attr( 'data-id' );
              let token  = $('meta[name=csrf-token]').attr('content');
              $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});  

              $.ajax( {
                url:  "/admin/user/destroy/"+id,
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
                                  <h4><i class='icon fa fa-check'></i>User Deleted</h4>\n\
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
