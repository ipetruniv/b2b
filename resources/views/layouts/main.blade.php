<!DOCTYPE html>
<html>
<head lang="en">

    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>@section('title')@show</title>
    <script src="/monika/js/jquery.min.js"></script>
    <script src="/monika/js/bootstrap.min.js"></script>

<!--    <script src="/monika/js/owl.carousel.js"></script>-->
    <script src="/monika/js/jquery.formstyler.js"></script>
    <script src="/monika/js/imagesloaded.pkgd.min.js"></script>
    <script src="/monika/js/masonry.pkgd.js"></script>
<!--    <script src="/monika/js/jquery.colorbox.js"></script>-->
    <script src="/monika/js/select2.min.js"></script>
    <script src="/monika/js/mask.js"></script>
    <script src="/monika/js/jquery.ui.datepicker-ru.js"></script>
    <script src="/monika/js/jquery-ui.js"></script>
    <script src="/monika/js/jquery-ui-i18n.js"></script>
    <script src="/monika/js/jquery.datetimepicker.full.min.js"></script>
<!--    <script src="/monika/js/unitegallery.min.js"></script>-->
<!--    <script src="/monika/js/ug-theme-carousel.js"></script>-->
    <script src="/monika/js/all_my_js.js"></script>

    <link href="/monika/css/jquery.datetimepicker.css" rel="stylesheet">
    <link href="/monika/css/jquery-ui.css" rel="stylesheet">
    <link href="/monika/css/select2.min.css" rel="stylesheet">
    <link href="/monika/css/font-awesome.css" rel="stylesheet">
<!--    <link href="/monika/css/colorbox.css" rel="stylesheet">-->
    <link href="/monika/css/burger.css" rel="stylesheet">

    <link href="/monika/css/bootstrap.css" rel="stylesheet">
    <link href="/monika/css/jquery.formstyler.css" rel="stylesheet">
<!--    <link href="/monika/css/owl.theme.default.css" rel="stylesheet">
    <link href="/monika/css/owl.carousel.css" rel="stylesheet">-->
    <link href="/monika/css/style.css" rel="stylesheet">
    <link href="/css/andrew.css" rel="stylesheet">
<!--    <link href="/monika/css/unite-gallery.css" rel="stylesheet">-->
     <link rel="stylesheet" href="/lobibox-master/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/lobibox-master/dist/css/lobibox.min.css"/>
    <script src="/js/catalog.js"></script>


    @section('style')@show

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
<div class="wrapper">
    <div class="header_group">

        @section('locale')
        <div class=" header_up clearfix">
            <div class="container container_center">
                <div class="row row_center">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <div class="group clearfix">

                            <ul class="language-select clearfix">
                                <?php $lang = App::getLocale(); ?>
                                <li data-lang="en" class = @if ($lang == "en") "active" @endif>
                                    <a href="/setlocale/en">English</a>
                                </li>
                                <li data-lang="it" class = @if ($lang == "it") "active" @endif>
                                    <a href="/setlocale/it">Italian</a>
                                </li>
                                <li data-lang="sp" class = @if ($lang == "sp") "active" @endif>
                                    <a href="/setlocale/sp">Spanish</a>
                                </li>
                                <li data-lang="pl" class = @if ($lang == "pl") "active" @endif>
                                    <a href="/setlocale/pl">Polish</a>
                                </li>
                                <li data-lang="ru" class = @if ($lang == "ru") "active" @endif>
                                    <a href="/setlocale/ru">Russian</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @show


        <div class=" header_down clearfix">
            <div class="container container_center">
                <div class="row row_center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_center">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 transfer">
                            <div class="header_menu_mobile clearfix">
                                @section('menu-catalog')
                                @show
                                <span class="name_title">@section('select-menu-title') @show</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 transfer_one">
                            <div class="logo">
                                <a href="/">
                                    <span>B2B</span>
                                    <span>сlients System</span>
                                </a>
                            </div>
                        </div>
                        @section('menu-user')
                            <div class="col-lg-4 col-md-5 col-sm-5 col-xs-8 transfer_before col_center">
                                <div class="group_user">
                                    <ul class="clearfix">
<!--                                        <li class="create">
                                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                        </li>-->
                                         <li class="search_380">
                                             @if (Auth::check())
                                                 @widget('Search')
                                                 @widget('Cart')
                                             @endif
                                         </li>

                                        <li class="user">
                                            @if (Auth::check())
                                                <span class="user_name_header">{{ Auth::user()->name }}</span>
                                            @endif
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <ul class="sub_menu" style="display: none;">
                                                <li><a href="{{URL::to('/'.App::getLocale().'/cabinet/settings')}}">@lang('messages.SETTINGS')</a></li>
                                                <li><a href="{{URL::to('/'.(App::getLocale().'/cabinet/history')) }}">@lang('messages.HISTORY')</a></li>
                                                @if (Auth::check())
                                                    @if(!Auth::user()->diller_id && !Auth::user()->agent_id || Auth::user()->diller_id !== null && !Auth::user()->agent_id)
                                                        <li><a href="{{URL::to('/'.(App::getLocale().'/cabinet/user')) }}">@lang('messages.USERS')</a></li>
                                                    @endif
                                                @endif
                                                <li>
                                                    <a href="/{{App::getLocale()}}/logout"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                        @lang('messages.EXIT')
                                                    </a>

                                                    <form id="logout-form" action="/{{App::getLocale()}}/logout" method="POST" style="display: none;">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @show
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section id="main">
        @yield('content')
    </section>
    <div class="buffer"></div>
</div>


<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="group">
                    <ul class="footer_menu clearfix">
                        <li><a href="#">@lang('messages.DEALERS')</a></li>
                        <li><a href="#">@lang('messages.PRIVACY')</a></li>
                        <li><a href="#">@lang('messages.CONTACT_US')</a></li>
                        <li><a href="#">@lang('messages.CREDITS')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
@show

    <script src="/lobibox-master/dist/js/lobibox.min.js"></script>
    <script src="/lobibox-master/demo/demo.js"></script>
    <script type="text/javascript">


//      (function($) {
//          $('.row-remove').click(function(e) {
//              e.preventDefault();
//              $(this).closest('tr').remove();
//          });
//
//      }(jQuery));

    if($('#phone').length) {
        $("#phone").mask("+ 999999999999");
    }
    if($('#phone_company').length) {
        $("#phone_company").mask("+ 999999999999");
    }



      $('.delivery_adress > .title.left').click(function(){
          $( "#delivery_hidden" ).toggle("slow");
          if(!$(this).hasClass('active'))
              $(this).addClass('active');
          else
              $(this).removeClass('active');

      });


//      $(function(){
//          $.datepicker.setDefaults(
//                  $.extend($.datepicker.regional["ru"])
//          );
//          $("#my_datepicker").datepicker({
//              showButtonPanel: false,
//              duration:'normal',
//              minDate:0
//          });
//
//      });

    //  $( ".group_check input" ).checkboxradio();

    </script>
<script>
    $(document).ready(function() {
        if ($('body').width() < 440) {
            $('.transfer_one').append($('.search_380'));
        }
        $(window).resize(function () {
            if ($('body').width() < 440) {
                $('.transfer_one').append($('.search_380'));
            } else {
                $(".group_user > ul").prepend($(".search_380"));
            }
        });
    });
</script>

</body>
</html>




