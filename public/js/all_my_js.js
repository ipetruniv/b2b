
$(document).ready(function () {

    $('.language li').click(function(){
        $('li').removeClass("active");
        $(this).addClass("active");
    });

    $(".group1").colorbox({rel:'group1'});
    $(".group2").colorbox({rel:'group2', transition:"fade"});
    $(".group3").colorbox({rel:'group3', transition:"none", width:"75%", height:"75%"});
    $(".group4").colorbox({rel:'group4', slideshow:true});
    $(".ajax").colorbox();
    $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    $(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
    $(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
    $(".inline").colorbox({inline:true, width:"50%"});
    $(".callbacks").colorbox({
        onOpen:function(){ alert('onOpen: colorbox is about to open'); },
        onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
        onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
        onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
        onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
    });

    $('.non-retina').colorbox({rel:'group5', transition:'none'})
    $('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});

    //Example of preserving a JavaScript event for inline calls.
    $("#click").click(function(){
        $('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
        return false;
    });
    
    var $grid = $('.catalog').imagesLoaded( function() {
        $grid.masonry({
            itemSelector: '.item',
            columnWidth: '.item',
            transitionDuration: '0.8s',
            resize: true,
            percentPosition: true,
            initLayout: true
        });
    });

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
    $('.user' ).click(function(){
        $( ".user .sub_menu" ).toggle('slow');
    });
    $(document).click(function (e) {
        var container = $('.user');
        if (container.has(e.target).length === 0){
            $( ".user .sub_menu" ).hide('slow');
        }
    });
    
        var $grid = $('.catalog').imagesLoaded( function() {
            $grid.masonry({
                itemSelector: '.item',
                columnWidth: '.item',
                transitionDuration: '0.8s',
                resize: true,
                percentPosition: true,
                initLayout: true
            });
        });

 
});

























