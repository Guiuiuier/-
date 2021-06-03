(function ($) {
	"use strict";
/*--文档激活*/
    jQuery(document).ready(function($){
		
		
	//打字效果 激活
    $('.header-inner h6').typed({
        strings: ["中山大学南方学院", "电气与计算机工程学院", "计算机科学与技术"],
        loop: true,
        startDelay: 1000,
        backDelay: 1000,
        typeSpeed: 30,
        showCursor: true,
        cursorChar: '|',
        autoInsertCss: true
    });
		
	/*圈的相关*/
		CircleProg('.70','#00B9E4',$('#circle-1'));
		CircleProg('.60','#DF457E',$('#circle-2'));
		CircleProg('.80','#2FD4BE',$('#circle-3'));
		CircleProg('.70','#F28055',$('#circle-4'));
		
		
	/*循环圈的厚度和相关*/
		function CircleProg(val,color,selector){
			selector.append('<span>'+val.substr(1)+' % </span>');
			selector.circleProgress({
				value: val,
				size: 150, //图像大小
				fill: {
				  color: color
				},
				 thickness:15, //厚度
				 lineCap:'round',
				 emptyFill:"#ddd"
			  });
		}
		
		/*----portfolio masonay激活与图像加载  点击下面的导航页转换------*/
            var Container =$('.container'); 
                Container.imagesLoaded( function() {
                    var festivarMasonry = $('.portolio-masonary').isotope({
                          layoutMode: 'fitRows',
                          itemSelector: '.grid-size'
                        });
                    $(document).on('click','.porfolio-menu li', function() {
                      var filterValue = $(this).attr('data-filter');
                      festivarMasonry.isotope({ filter: filterValue });
                    });
            });
        
        /*---- 照片墙  ------*/
          var portfolioMenu = '.porfolio-menu li';
          $(document).on('click',portfolioMenu,function(){
              $(this).siblings().removeClass('active');
              $(this).addClass('active');
          });
  		
		 /* counter 部分激活  */
             var counternumber = $('.counter-number'); 
                counternumber.counterUp({
                  delay: 20,
                  time: 5000
                });
		
		/*--放大图片后删除--*/
        var imgPopUp =$('.image-popup')
            imgPopUp.magnificPopup({
              
              gallery: {
                enabled: true
              },
              image: {
                titleSrc: 'title'
              },
                type: 'image'
                
        });
		
		/*--留言板--*/
        var testimonial = $('#testimonial-slider');
            testimonial.owlCarousel({
            loop:true,
            dots:true,
            nav:false,
            center:true,
            autoplay:true,
            responsive : {
              0 : {
                  items: 1
              },
              768 : {
                  items: 2
              },
              960 : {
                  items: 3
              },
              1200 : {
                  items: 3
              },
              1920 : {
                  items: 3
              }
            }
        }); 
		/* smoth 定位滚动*/
		 $('#main-menu li a').on('click', function(event) {
			 // event.preventDefault();
			 var anchor = $(this).attr('href');
			  var top = $(anchor).offset().top;
			     $('html, body').animate({
						scrollTop: $(anchor).offset().top
					}, 1000); //数值越大滑动越平缓
		  });
        /*从最下到最上 右下角的图标*/
        $(document).on('click','.go-top',function(){
           $("html,body")({
                scrollTop: 0
            }, 1000);
        });
        /*--slick Nav Responsive Navbar activation--*/
          var SlicMenu = $('#main-menu');
         SlicMenu.slicknav();
		/*--- 滚动监听 --*/
  			// new ScrollSpy('#main-menu', {
  			// 	nav: '#main-menu > li a',
  			// 	className: 'active'
  			// });
    });

/*--窗口滚动功能 下拉时显示导航页,-*/
    $(window).on('scroll', function () {
      /*--显示和隐藏滚动到顶部 --*/
         var ScrollTop = $('.go-top');
        if ($(window).scrollTop() > 1000) {
                ScrollTop.show(1000);
        } else {
                ScrollTop.fadeOut(100);
       }
        /*--sticky 菜单激活--*/
            var mainMenuTop = $('.nav-area');
            if ($(window).scrollTop() > 300) {
                mainMenuTop.addClass('nav-fixed');
            } else {
                mainMenuTop.removeClass('nav-fixed');
            }
        /*--sticky Mobile 移动菜单激活--*/
            var mobileMenuTop = $('.slicknav_menu');
            if ($(window).scrollTop() > 300) {
                mobileMenuTop.addClass('nav-fixed');
            } else {
                mobileMenuTop.removeClass('nav-fixed');
            }
		
		
    });
           
/*--正方块窗口加载功能*/
    $(window).on('load',function(){
        var preLoder = $(".preloader");
        preLoder.fadeOut(1000);
		
    });

}(jQuery));	