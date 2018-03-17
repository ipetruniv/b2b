

$(document).ready(function () {
    $('.user' ).click(function(){
        $( ".user .sub_menu" ).toggle('slow');
    });
    $(document).click(function (e) {
        var container = $('.user');
        if (container.has(e.target).length === 0){
            $( ".user .sub_menu" ).hide('slow');
        }
    });


    $('.language-select').click(function(){
        $(this).toggleClass('open');
    })

    // $('.language-select li').click(function(){
    //     var setLang = $('.language-select').data('location'),
    //         dataLangSelect = $(this).data('lang')
    //     $('.language-select').data('location', dataLangSelect);
    //     $('.language-select li').removeClass('active');
    //     $(this).toggleClass('active');
    // })


    $('body').on('click',function(e){
        if($.inArray('burger', e.target.classList) == 0){
            if($('.burger').attr('data-id') == 'cls'){

                $('.burger').attr('data-id','opn');

                $('.burger').addClass("open");
                $('#short_menu').show('slow',function() {
                    $(".sub > a").click();
                });

            }else{

                $('.burger').attr('data-id','cls');
                $('.burger').removeClass("open");
                $('#short_menu').hide('slow',function(){
                    $(".sub > a").click();
                });

            }
        }else{
            if($('.burger').attr('data-id') == 'opn')
                $('.burger').attr('data-id','cls');
            if($('.burger').hasClass('open'))
                $('.burger').removeClass('open')
            $('#short_menu').hide('slow');
        }
    });

    $(".sub > a").click(function() {
        var ul = $(this).next(),
            clone = ul.clone().css({"height":"auto"}).appendTo(".mini-menu"),
            height = ul.css("height") === "0px" ? ul[0].scrollHeight + "px" : "0px";
        clone.remove();
        ul.animate({"height":height});
        return false;
    });

    $('.mini-menu > ul > li > a').click(function(){
        $('.sub a').removeClass('active');
        $(this).addClass('active');
    }),
        $('.sub ul li a').click(function(){
            $('.sub ul li a').removeClass('active');
            $(this).addClass('active');
        });

    if ($('body').width() < 768) {
        $('.transfer').before($('.transfer_one'));
    }
    $(window).resize(function () {
        if ($('body').width() < 768) {
            $('.transfer').before($('.transfer_one'));
        } else {
            $('.transfer_before').before($('.transfer_one'));
        }
    });


    $(function() {
        $('#type_value').styler();
    });
    $(function() {
        $('#paymant_type').styler();
    });
    $(function() {
        $('#currency').styler();
    });
    $(function() {
        $('.diler_select').styler();
    });
    $('#user-buyer').styler({
        selectSearch: true,
        selectSearchPlaceholder: ''
    }).removeAttr('visibility');

});

























