@extends('layouts.main')

@section('title')
  
@endsection


@section('locale')
    @parent
@endsection

@section('menu-catalog')
    @widget('Catalog')     
@endsection

@section('style')
    <link href="/AdminLTE/plugins/datatables/dataTables.bootstrap.css">
@endsection

@section('select-menu-title')
    
@endsection
 
 
@section('menu-user')
    @parent
@endsection

@section('content')
    <div class="container container_center">
        <div class="row row_center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_center">
                <div class="group clearfix">
                    <h1 class="title"> @if($type) {{ $type }} @endif</h1>
                    
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
                            <h4><i class="icon fa fa-ban"></i> Inaccurate data!</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($users->count())
                    <div class="orders">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="new_user clearfix">
                                <a data-toggle="modal" data-target="#myModal_new_user" id="user-modal">@lang('messages.NEW_USER')</a>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="group_input clearfix">
<!--                                <form id="order_up" action="" class="dilers clearfix">
                                    <div class="group">
                                        <label for="text">Filter by</label>
                                        <input id="text" type="text" value="Filter by">
                                    </div>
                                    <div class="group">
                                        <label>Filter by</label>
                                        <select name="collection" class="diler_select">
                                            <option>Pablo</option>
                                            <option>Pablo</option>
                                            <option>MALORY</option>
                                            <option>Pablo</option>
                                        </select>
                                    </div>
                                    <div class="group">
                                        <label>Filter by</label>
                                        <select name="collection" class="diler_select">
                                            <option>Picaco</option>
                                            <option>Rome</option>
                                            <option>Picaco</option>
                                            <option>Picaco</option>
                                        </select>
                                    </div>
                                    <div class="group ui-widget">
                                        <label for="my_datepicker">Filter by </label>
                                        <input id="my_datepicker" placeholder="Date"/>
                                    </div>
                                </form>-->
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                  
                                <table id="my_edit" class="table my_table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td>@lang('messages.ROLE')</td>
                                            <td>@lang('messages.AGENT')</td>
                                            <td>@lang('messages.NAME')</td>
                                        {{--    <td>Surname</td>  --}}
                                            <td>@lang('messages.COMPANY')</td>
                                           {{-- <td>VAT</td>  --}}
                                            <td>@lang('messages.LEGAL_ADDRESS')</td>
                                            <td>@lang('messages.DELIVERY_ADRESS')</td>
                                            <td>@lang('messages.PHONE_NUMBER')</td>
                                            <td>Email</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($users as $user)
                                        <tr> 
                                            <td>
                                                @if(!$user->diller_id && !$user->agent_id)
                                                    @lang('messages.DILLER')
                                                @elseif($user->diller_id !== null && !$user->agent_id)
                                                    @lang('messages.AGENT')
                                                @elseif($user->diller_id !== null && $user->agent_id !== null)
                                                    @lang('messages.BUYER')
                                                @elseif($user->diller_id == null && $user->agent_id !== null)
                                                    @lang('messages.BUYER')
                                                @endif

                                            </td>
                                            <td>
                                                @if ($user->agent_id)
                                                    {{ $user->getAgent->name }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $user->name}}
                                            </td>
                                             {{--<td>{{ $user->surname }}</td> --}}
                                            <td>{{ $user->company }}</td>
                                            {{-- <td>{{ $user->vat }}</td>  --}}
                                            <td>{{ $user->address }}</td>
                                            <td>
                                                {{ $user->post_country }}
                                                {{ $user->post_region }}
                                                {{ $user->post_city }}
                                                {{ $user->post_street }}
                                                {{ $user->post_post_code }}   
                                            </td>
                                            <td class="phone">{{ $user->phone }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <table class="my_edit" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr style="border-bottom: 1px solid #ddd;">
                                                        <td class="my_edit_input">    {!! Form::open(['url' => URL::to('/'.App::getLocale().'/cabinet/user/showedit'),'method' => 'POST']) !!}
                                                            {{Form::hidden('user',$user->id)}}    
                                                            {{ Form::submit(__('messages.EDIT'),[]) }}
                                                                {!! Form::close() !!}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="{{ URL::to('/'.App::getLocale().'/cabinet/user/history/'.$user->id) }}">@lang('messages.HISTORY')</a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="my_delete">
                                                <a href="#" class="delete-user" data-id="{{ $user->id }}" >X</a>
                                            </td>                                                
                                        </tr>
                                       @endforeach
                                    </tbody> 
                                </table>
                               
                            </div>
                        </div>
                    </div>
                    @else 
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="new_user clearfix">
                                <a data-toggle="modal" data-target="#myModal_new_user" id="user-modal">@lang('messages.NEW_USER')</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div> 

   <div id="preview" title=""></div>

@endsection

@section('js')
@parent
<script src="/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/AdminLTE/plugins/datatables/dataTables.bootstrap.min.js"></script>
<?php $lang = App::getLocale();
if ($lang == "en")
    $database_lang = "//cdn.datatables.net/plug-ins/a5734b29083/i18n/English.json";
else if ($lang == "it")
    $database_lang = "//cdn.datatables.net/plug-ins/a5734b29083/i18n/Italian.json";
else if ($lang == "sp")
    $database_lang = "//cdn.datatables.net/plug-ins/a5734b29083/i18n/Spanish.json";
else if ($lang == "pl")
    $database_lang = "//cdn.datatables.net/plug-ins/a5734b29083/i18n/Polish.json";
else if ($lang == "ru")
    $database_lang = "//cdn.datatables.net/plug-ins/a5734b29083/i18n/Russian.json";
?>
<script>
    $(function () {
        $('#my_edit').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "language": {
                "url": "{{$database_lang}}"
            }

        });
    });
</script>
  <script>


      $(document).on( 'click', '#user-modal', function () {
         preview();
      });

      $(document).on( 'click', '.edit-user', function () {
           previewEdit( $(this).data('id') );
      });

    function preview() {
        window.location = "{{ URL::to('/'.App::getLocale().'/cabinet/user/add/form') }}";
        }


    $('.delete-user').click(function () {
      if (confirm("DELETE THIS USER?")) {
        let element = $(this);
        element.parent().parent().remove();
        let id = $( this ).attr( 'data-id' );
       
        let token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});  

        $.ajax( {
          url: "{{ URL::to('/'.App::getLocale().'/cabinet/user/del') }}"+'/'+id,
          data: {id: id},
         // dataType: 'json',
          type: 'post',
          error: function ( errors ) {
            console.log(errors.responseText);
          },
          success: function ( json ) {
          if ( json.status == 1 ) {  
            $('.info-ajax').empty();
            let item = "<div class='alert alert-success alert-dismissible'>\n\
                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>\n\
                            <h4><i class='icon fa fa-check'></i>User successful delete</h4>\n\
                        </div>";

           return $('.info-ajax').append(item);
          }
          else
              alert('error');
          }
        });
      }
    });  
       
          
    function myselect() {
        $(function() {
            $('.diler_select').styler();
        });
    }


    $('.role_d').css({display: "none"});
           
           
    function agent(el) {
      console.log(el);
       if(  $(el).val() == 'bayer' )  {
            $('.role_d').css("display","table");
         } else {
            $('.role_d').css({display: "none"});
         }
    }
    
    
     function agentEdit(el) {
      console.log(el);
       if(  $(el).val() == 'buyer' )  {
            $('.type_us').css("display","table");
         } else {
            $('.type_us').css({display: "none"});
         }
    }
    (function($) {
            $(function() {
                $('#my_edit_length select').styler();
            });
        })(jQuery);
    
    
  </script>  
  @endsection

 