<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="content-type" content="text/html" charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>@section('title') @show</title>
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/colorbox.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/burger.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.formstyler.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/owl.theme.default.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/andrew.css') }}" />
    <script src='https://www.google.com/recaptcha/api.js?hl=en'></script>
</head>
<body>
<div class="wrapper">
    <div class="header_group">
        <div class=" header_up clearfix">
            <div class="container container_center">
                <div class="row row_center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="group clearfix">
                            <ul class="language clearfix">
                                <li class="en active"><a href="">English</a></li>
                                <li class="it"><a href="">Italian</a></li>
                                <li class="sp"><a href="">Spanish</a></li>
                                <li class="pl"><a href="">Polish</a></li>
                                <li class="hu"><a href="">Hungary</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" header_down clearfix">
            <div class="container container_center">
                <div class="row row_center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col_center">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 transfer">
                            <div class="header_menu_mobile clearfix">
                                <div class="burger" id="burger" style="display: none"  data-id="cls" >
                                    <a class="burger">
                                        <span class="burger mybtn"></span>
                                        <span class="burger mybtn"></span>
                                        <span class="burger mybtn"></span>
                                        <span class="burger mybtn"></span>
                                    </a>
                                    <div class="mini-menu" id="short_menu" style="display: none">
                                        <ul>
                                            <li class="sub">
                                                <a href="">Catalog</a>
                                                <ul>
                                                    <li><a href="#">Monica loretti</a></li>
                                                    <li><a href="#">Viterbo Collection</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub">
                                                <a href="#">Brend 2</a>
                                                <ul>
                                                    <li><a href="#">Collection 1</a></li>
                                                    <li><a href="#">Collection 2</a></li>
                                                </ul>
                                            </li>
                                            <li class="sub">
                                                <a href="#">Orders</a>
                                            </li>
                                            <li class="sub">
                                                <a href="#">Users</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="name_title">Monica loretti</span>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 transfer_one">
                            <div class="logo">
                                <a href="">
                                    <span>B2B</span>
                                    <span>сlients System</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 transfer_before col_center">
                            <div class="group_user">
                                <ul class="clearfix">
                                    @if (Auth::guest())
                                        <li class="create">
                                            <a href="{{route('login')}}">
                                                <i class="fa fa-sign-in" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="create">
                                            <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                        </li>
                                        <li class="basket">
                                            <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                            <div class="basket_item"><span class="bas_count">999</span></div>
                                        </li>
                                        <li class="user">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <ul class="sub_menu" style="display: none;">



                                                    <li><a href="#">Settings</a></li>
                                                    <li>
                                                        <a href="{{ route('logout') }}"
                                                           onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                            Logout
                                                        </a>

                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </li>

                                            </ul>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('content')
    <div class="buffer"></div>
</div>
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="group">
                    <ul class="footer_menu clearfix">
                        <li><a href="#">Dealers</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#"> Contact us</a></li>
                        <li><a href="#">Credits</a></li>
                    </ul>
                    <div class="copyright">
                        © 2016 Copyright  Monika Loretti  S.p.A - PIVA 08812061003 - REA CN - 265232 - ALL RIGHTS RESERVED
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js-files')
    <script src="{{ URL::asset('js/jquery-3.1.0.min.js') }}"></script>
    <script src="{{ URL::asset('js/all_my_js.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/owl.carousel.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.formstyler.js') }}"></script>
    <script src="{{ URL::asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ URL::asset('js/masonry.pkgd.js') }}"></script>
    <script src="{{ URL::asset('js/jquery.colorbox.js') }}"></script>
@show

</body>
</html>