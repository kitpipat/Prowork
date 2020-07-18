jQuery(document).ready(function($) {

    "use strict";

    [].slice.call(document.querySelectorAll('select.cs-select')).forEach(function(el) {
        new SelectFx(el);
    });

    jQuery('.selectpicker').selectpicker;

    $('.search-trigger').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').addClass('open');
    });

    $('.search-close').on('click', function(event) {
        event.preventDefault();
        event.stopPropagation();
        $('.search-trigger').parent('.header-left').removeClass('open');
    });

    $('.equal-height').matchHeight({
        property: 'max-height'
    });

    // var chartsheight = $('.flotRealtime2').height();
    // $('.traffic-chart').css('height', chartsheight-122);


    // Counter Number
    $('.count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 3000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });




    // Menu Trigger
    $('#menuToggle').on('click', function(event) {
        var windowWidth = $(window).width();
        if (windowWidth < 1010) {
            $('body').removeClass('open');
            if (windowWidth < 760) {
				$('#left-panel').slideToggle();
            } else {
                $('#left-panel').toggleClass('open-menu');
			}
        } else {
			$('body').toggleClass('open');
			$('#left-panel').removeClass('open-menu');
		}


		$('.xCNNameMenu').toggleClass('xCNHide');
		$('.xCNIconMenu').toggleClass('col-lg-12');
		$('.xCNSizeIconSubMenu').toggleClass('xCNSizeIconSubMenuToggle');
    });


    $(".menu-item-has-children.dropdown").each(function() {
        $(this).on('click', function() {
			var $temp_text = $(this).children('.dropdown-toggle').html();
			var name_menu = $(this).children('.dropdown-toggle').attr('data-namesubmenu');
            var tCheckClass = $(this).children('.sub-menu').children().hasClass('subtitle');
            if (tCheckClass != true) {
				$(this).children('.sub-menu').prepend('<li class="subtitle">' + name_menu + '</li>');
            }
		});
    });


    // Load Resize
    $(window).on("load resize", function(event) {
        var windowWidth = $(window).width();
        if (windowWidth < 1010) {
            $('body').addClass('small-device');
        } else {
            $('body').removeClass('small-device');
        }
    });


    $('.JSxCallContentMenu').on('click', function(event) {
		if($(this).attr('data-menuname') == '#'){
			return;
		}

		//เมนูหน้าหลัก
		$('.xCNHomeLast').removeClass('ACTIVE').css('display','none');
		$('.xCNHomeFisrt').addClass('ACTIVE').css('display','block');



		$('.JSxCallContentMenu , .xCNMenuImage').removeClass('ACTIVE');
		if($(this).hasClass('xCNSub')){
			$(this).parent().parent().parent().find('.xCNMenuImage').addClass('ACTIVE');
		}else{
			//เมนูอื่น
			$(this).addClass('ACTIVE');
		}

        $.ajax({
            type: "POST",
            url: $(this).attr('data-menuname'),
            cache: false,
            timeout: 0,
            success: function(tResult) {
				
				JSxModalProgress('open');
				
      				// var nWidth = $('#left-panel').width();
      				// if(nWidth > 70){
      				// 	$('#menuToggle').click();
      				// }

      				$('.content').html(tResult);

				//เปิดการแจ้งเตือนของวัด
				$('.xCNDialog_Footer').css('display','block');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(jqXHR, textStatus, errorThrown);
            }
        });
	});
	
});
