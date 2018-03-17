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
                    <h1 class="title">@lang('messages.ORDERS')</h1>
                    
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
                  
                    <div class="orders">
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="group_input clearfix">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                  
                                <table id="my_edit" class="table my_table" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td>@lang('messages.DATE')</td>
                                            <td>@lang('messages.BUYER')</td>
                                            <td>@lang('messages.ORDER')</td>
                                            <td>@lang('messages.TOTAL')</td>
                                            <td>@lang('messages.STATUS')</td>
                                            <td>@lang('messages.DATE_OF_SHIPMENT')</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                      @foreach($carts as $cart)
                                        <tr> 
                                            <td>
                                                {{date('d/m/Y', strtotime($cart->created_at))}}
                                            </td>
                                            <td>
                                                {{  $cart->getByersOrder->name  }}

                                            </td>
                                            <td>
                                              {{  $cart->order_number_1c }}

                                            </td>
                                            <td>
                                              {{  $cart->total }}

                                            </td>
                                            <td>
                                              {{ $cart->getStatus() }}
                                            </td>
                                            <td>
                                                {{date('d/m/Y', strtotime($cart->desirable_delivery))}}
                                            </td>
                                            <td>
                                                <table cellpadding="0" cellspacing="0" width="100%">  
                                                    <tr>
                                                        <td>
                                                            <a href="{{ URL::to('/'.App::getLocale().'/cabinet/history/detail/'.$cart->id) }}">@lang('messages.LEARN_MORE')</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>                                             
                                        </tr>
                                       @endforeach
                                    </tbody> 
                                </table>
                               
                            </div>
                        </div>
                    </div>
                   
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


  (function($) {
      $(function() {
          $('#my_edit_length select').styler();
      });
  })(jQuery);
</script>  
  
@endsection

 