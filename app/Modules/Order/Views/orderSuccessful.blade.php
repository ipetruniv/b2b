@extends('layouts.main')

@section('title')
 
@endsection

 @section('style')

  
 @endsection

@section('locale')
    @parent
@endsection
@section('menu-catalog')
    @widget('Catalog')     
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
                    <div class="alert alert-success alert-dismissible" style="">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> @lang('messages.THE_ORDER_IS_ACCEPTED')! <a href="/">@lang('messages.BACK_TO_CATALOG')</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('js')
    @parent
    <script>

      $(document).on('click', '.name_select_prod ', function() {
        var id = $(this).closest("tr").attr('data-id'); 
        var def_prod =  $('#name__prod_'+id).val();
       
        
        var data = {
              user : $('#user-buyer').val(),
              agent : $('#agent').val(),
              _token  : '{{csrf_token()}}'
            }
            
        if($('#agent').val()==0) {
            Lobibox.notify('info', {
                size: 'normal',
                position: 'right bottom',
                msg: "First, select agent"
            }); 
        }
        else if($('#user-buyer').val()==0) {
            Lobibox.notify('info', {
                size: 'normal',
                position: 'right bottom',
                msg: "Select user"
            }); 
        } else {
            getProduct(data, id);
        }
        
      }); 

      function getProduct(data, id) {
        
        $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-all-prodict') }}",
          type:"post",
          data: data,
        }).done(function(response) {
            if(response.error) {
              Lobibox.notify('error', {
                size: 'normal',
                position: 'right bottom',
                msg: response.error
              }); 
            }   
            if(response.ok) {
              var prod =  $('#name__prod_'+id).val();
              $('#name__prod_'+id).empty();
              var options = ''; 
              $(response.ok).each(function(i, row) {
                options += '<option  value="' + row.code_1c + '">' + row.name + '</option>';
              });
              $('#name__prod_'+id).append(options);
              $('#name__prod_'+id).select2('destroy').select2();
              $('#name__prod_'+id).val(prod);
              $('#price_prod_'+id).empty();
              $('#price_total_'+id).empty();
              selectProd(id);
              
            }
        })  
      }
      

      $('.my_select_dropdown.name__prod').on('select2:select', function (e) {
        var id = $(this).closest("tr").attr('data-id'); 
        var data = e.params.data;

        var param = {
          user    : $('#user-buyer').val(),
          agent   : $('#agent').val(),
          product : data.id,
          _token  : '{{csrf_token()}}'     
        }
        getSizeProduct(param,id);
     
      });



      // По кольору клік
      function getSizeProduct(param,id) {
     
         $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-product-color-size') }}",
          type:"get",
          data: param,
        }).done(function(response) {
            if(response.error) {
              Lobibox.notify('error', {
                size: 'normal',
                position: 'right bottom',
                msg: response.error
              }); 
            } 
            if(response.ok) {
              
             
              var options_size =  '<option value="0">-Select Size-</option>';
              $('#size_'+id).empty();
            
              $(response.ok).each(function(i, row){
                options_size += '<option  value="' + row.code_1c_characteristic_size_value + '">' + row.name_characteristic_size_value + '</option>';
              });
              
              $('#size_'+id).append(options_size);  
            }
            
            if(response.colors) {
              $('#color_'+id).empty();
              var price = '';
              var ProdSelect = $('#color_'+id);
              var options = '<option value="0">-Select Color-</option>'; 
              $(response.colors).each(function(i, row){
                options += '<option  value="' + row.code_1c_characteristic_color_value + '">' + row.name_characteristic_color_value + '</option>';
              });

              ProdSelect.append(options);

            }
            
        })  
      }
        $('.my_select_dropdown_2.color__prod').on('select2:select', function (e) {
          var pr =  $('.my_select_dropdown.name__prod').val();
          var id = $(this).closest("tr").attr('data-id'); 
          var data = e.params.data;    
          var param = {
            user    : $('#user-buyer').val(),
            agent   : $('#agent').val(),
            product : pr,
            color   : data.id,
            _token  : '{{csrf_token()}}'     
          }
        FindProdByCoror(param,id);
     
      }); 


      function FindProdByCoror(param,id) 
      {
        
         $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-product-color') }}",
          type:"get",
          data: param,
        }).done(function(response) {
            if(response.error) {
              Lobibox.notify('error', {
                size: 'normal',
                position: 'right bottom',
                msg: 'COLOR_NOT_FOUND'
              }); 
            } 
            if(response.ok) {

              var options_size = '<option value="0">-Select Size-</option>'; 
              $('#size_'+id).empty();
            
              $(response.ok).each(function(i, row){
                options_size += '<option  value="' + row.code_1c_characteristic_size_value + '">' + row.name_characteristic_size_value + '</option>';
              });
              $('#price_prod_'+id).empty();
              $('#price_total_'+id).empty();
              $('#size_'+id).append(options_size);  
            }

        })  
      }


      //по розміру клік
       $('.my_select_dropdown_color_size').on('select2:select', function (e) {
        var id = $(this).closest("tr").attr('data-id'); 
        var prod =  $('#name__prod_'+id).val();
        var color =  $('#color_'+id).val(); 
        var data = e.params.data;
        var param = {
          user    : $('#user-buyer').val(),
          agent   : $('#agent').val(),
          product : prod,
          color   : color,
          size    : data.id,
          _token  : '{{csrf_token()}}'     
        }
        getPriceBySize(param,id);
     
      });
      

       function getPriceBySize(param,id) {
     
         $.ajax({
          url: "{{ URL::to('/'.App::getLocale().'/get-product-price') }}",
          type:"get",
          data: param,
        }).done(function(response) {
            if(response.error) {
              Lobibox.notify('error', {
                size: 'normal',
                position: 'right bottom',
                msg: response.error
              }); 
            } 
            if(response.ok) {
              $('#price_prod_'+id).empty();
              $('#price_total_'+id).empty();
              $('#price_prod_'+id).append(response.ok.price_value);
              $('#price_total_'+id).append(response.ok.price_value);
            }

        })  
      }

      function changeAgent() {
          var agent = $('#agent').val();
          if (agent == 0) {
            $('#bauyers').empty();
            //$('#us').empty();
            getBuyer(agent);
          } 
          else {
              getBuyer(agent);
          }
      }
      
      

      function changeUserBuyer() {
       
        if($('#user-buyer').val() == 0) {
          $('#payment').empty();
        } else {
            var data = {
              user : $('#user-buyer').val(),
              agent : $('#agent').val(),
              _token  : '{{csrf_token()}}'
            }

            getPaimentType(data);
        }
      }
      
      
      
      
      function getPaimentType(data) {
       
        var token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }}); 
        
        $.ajax({
            url :"{{ URL::to('/'.App::getLocale().'/get-payment-type') }}",
            data:data,
            type:'post', 
        }).done(function(response){
            if(response.error) {
                $('#payment').empty();
                 Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: 'Price type is not defined'
                        }); 
            }
            if(response.ok) {
              $('#payment').empty();
              var html = " <label for='text_2'>Type of payment</label><p class='type-price'>"+response.ok.name+"</p>";
              $('#payment').append(html);      
              $('#country').val(response.ok.country);
              $('#company').val(response.ok.company);
              $('#region').val(response.ok.region);
              $('#city').val(response.ok.city);
              $('#street').val(response.ok.street);
              $('#build').val(response.ok.build);
              $('#post').val(response.ok.post_code);
              $('#phone').val(response.ok.phone);
              $('#email').val(response.ok.email);
            }
            
          
            if(response.agent) {
             
              $('#agent').val(response.agent.user_code_1c).trigger('change');
            }
            if(response.agent == null) {
               Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: 'No agent found for this user'
                        }); 
            }
            
            
           

        });
        
      }

      function getBuyer(agent) {
        var token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }}); 
        $.ajax({
          url :"{{ URL::to('/'.App::getLocale().'/get-buyer') }}",
          data:{agent:agent},
          type:'post'

        }).done(function(response) {
           
            console.log('***********1*****************');
            console.log(response);
            console.log('*************1***************');
            if(response.error) {
                $('#us').empty();
                $('#payment').empty();
                $('#bauyers').empty();
                  Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: 'This agent doesn\'t have any users, you can add them in the cabinet'
                  });
            } 
            
            if(response.ok) {
              $('#us').empty();
              $('#bauyers').empty();
              $('#payment').empty();
              
              var k = 0;
              var type = '';
              var options = '<option value="0">-Select User-</option>'; 
              $(response.ok).each(function(i, row) {
                
                if(k == 0) {
                  type = 'selected="selected"';
                } else {
                  type = 'selected="false"';
                }
                options += '<option '+type+' value="' + $(this).attr('user_code_1c') + '">' + $(this).attr('name') + '</option>';
                k++;
              });
              var html = "<select  form='order_form' name='buyer' id='user-buyer' onchange='changeUserBuyer()' class='form-control my_select_dropdown'>"+options+"<select>";
              
  
              $('#bauyers').append(html);
              if(agent != 0) {
                  changeUserBuyer();
              }
              
            
              //   $('#bauyers').val($('#bauyers option:first-child').val()).trigger('change');
              //  $('#bauyers').select2().select2('val', $('.select2 option:eq(1)').val());
              return myselect();  
            }
        })
      }
      

      $( ".group_check input" ).checkboxradio();

      function myselect() {
        $( ".my_select_dropdown" ).select2({
          widht:100,
          language: {
              noResults: function(term) {
                  return "Not found";
              }
          }
        });
      }
      
    
      function selectProd(id) {
        $( '#name__prod_'+id ).select2({
          widht:100,
          language: {
            noResults: function(term) {
            return "Not found";
            }
          }
        }).select2("open");
      } 
   
    
    $( ".my_select_dropdown_color_size" ).select2({
     // minimumResultsForSearch: -1,
      widht:100,
      language: {
        noResults: function(term) {
          return "Not found";
        }
      }
    });


    $( ".my_select_dropdown_2" ).select2({
        //minimumResultsForSearch: -1,
        widht:100,
        language: {
            noResults: function(term) {
                return "Not found";
            }
        }
    });


    function myselectDr2() {
      $( ".my_select_dropdown_2" ).select2({
        //minimumResultsForSearch: -1,
        widht:100,
        language: {
            noResults: function(term) {
                return "Not found";
            }
        }
    });
    }



    $( ".my_select_dropdown" ).select2({
        widht:100,
        language: {
            noResults: function(term) {
                return "Not found";
            }
        }
    });

 
    $(function(){
        $.datepicker.setDefaults(
                $.extend($.datepicker.regional["ru"])
        );
        $("#my_datepicker").datepicker({
            showButtonPanel: false,
            duration:'normal',
            minDate:0
        });

    });



    $('.payment > .title.left').click(function(){
        $( "#payment_hidden" ).toggle("slow");
        if(!$(this).hasClass('active'))
            $(this).addClass('active');
        else
            $(this).removeClass('active');

    });
   
    $('.row-remove').click(function () {     
      if (confirm("DELETE THIS PRODUCT?")) {
        var element = $(this);
        element.parent().parent().remove();
        var id =  $(this).closest("tr").attr('data-id');
        
        if(id == Number.isInteger) { 
          return true;
        }
      
        var token  = $('meta[name=csrf-token]').attr('content');
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': token }});  

        $.ajax( {
          url: "{{ URL::to('/'.App::getLocale().'/delete-prodict') }}"+'/'+id,
          data: {id: id},
          dataType: 'json',
          type: 'post',
        }).done(function(response) {
            if(response.error) {

                  Lobibox.notify('error', {
                            size: 'normal',
                            position: 'right bottom',
                            msg: response.error,
                        });
            } 
            
            if(response.ok) {
              

                  Lobibox.notify('success', {
                            size: 'normal',
                          //  rounded: true,
                            position: 'right bottom',
                            msg: response.ok,
                        });
              
            }
        });
      }
    });
   
     function appentTableRow(id) {
      
       $('#tab > tbody:last').append("<tr data-id='empty-column"+id+"'>\n\
           <td><i class='fa fa-eye' aria-hidden='true'></i></td>\n\
            <td class='my_select name_select_prod'>\n\
            <select name='collection' id='name__prod_empty-column' class='form-control my_select_dropdown name__prod 'empty-column"+id+"'>\n\
            </select>\n\
            </td>\n\
            <td class='my_select my_select_2 my_color'>\n\
            <select name='color' id='empty-column"+id+"' class='form-control my_select_dropdown_2 color__prod'>\n\
            </select>\n\
            </td>\n\
            <td class='my_select my_select_2'>\n\
            <select name='color' id='empty-column"+id+"'  class='form-control my_select_dropdown_color_size'>\n\
            <option ></option></select></td>\n\
            <td id='price_prod_empty-column"+id+"'>\n\
            </td>\n\
            <td>\n\
            </td>\n\
            <td>\n\
            </td>\n\
            <td  id='price_total_empty-column"+id+"'></td><td class='my_textarea'><textarea rows='6' cols='15' placeholder=''></textarea></td><td class='my_delete'>\n\
            <a href='#' class='row-remove'>X</a></td></tr>");
            myselectDr2();
            myselect();
     }
   
     
</script>


@endsection