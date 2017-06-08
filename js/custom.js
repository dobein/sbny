// JavaScript Document
$('document').ready(function(){
	
<!-- Tooltip -->	
 $('[data-toggle="tooltip"]').tooltip()

		
<!-- google map -->		
$("#contactmap").gMap({
	address: "Envato, Elizabeth Street, Melbourne, Victoria, Australia",//replace this with your address
	zoom: 10,
	markers:[
		{
			latitude: -37.817361, //replace this with your latitude
			longitude: 144.965047,//replace this with your longitude
			html: "Envato Pty Ltd" //replace this with your text
		}		
	]
});

<!-- Accrodian -->	
	var $acdata = $('.accrodian-data'),
		$acclick = $('.accrodian-trigger');

	$acdata.hide();
	$acclick.first().addClass('active').next().show();	
	
	$acclick.on('click', function(e) {
		if( $(this).next().is(':hidden') ) {
			$acclick.removeClass('active').next().slideUp(300);
			$(this).toggleClass('active').next().slideDown(300);
		}
		e.preventDefault();
	});
		

<!-- Toggle -->			
	$('.togglehandle').click(function()
	{
		$(this).toggleClass('active')
		$(this).next('.toggledata').slideToggle()
	});
	
	
// Dropdowns
	$('.dropdown').hover(
		function(){$(this).addClass('open')			
		},
		function(){			
			$(this).removeClass('open')
		}
		);
		
// Product thumbnails
	$('.thumbnail').each(function()
	{
		
		$(this).hover(
		function(){
			//$(this).children('a').children('img').fadeOut()
			$(this).children('.shortlinks').fadeIn()
		},
		function(){	
			//$(this).children('a').children('img').fadeIn()		
			$(this).children('.shortlinks').fadeOut()
		}
		);
		
		
		
	});
	$('.thumbnail').each(function()
	{
		
		$(this).hover(
		function(){
			//$(this).children('a').children('img').fadeOut()
			$(this).children('.shortlinksourteam').fadeIn()
		},
		function(){	
			//$(this).children('a').children('img').fadeIn()		
			$(this).children('.shortlinksourteam').fadeOut()
		}
		);
		
		
		
	});
	
// Checkout steps
	$('.checkoutsteptitle').addClass('down').next('.checkoutstep').fadeIn()
	$('.checkoutsteptitle').live('click', function()
	{		
	$("select, input:checkbox, input:radio, input:file").css('display', 'blcok');	
		$(this).toggleClass('down').next('.checkoutstep').slideToggle()
	});
		
// Category Menu mobile
	 $("<select />").appendTo("nav.subnav");
      
	 // Create default option "Go to..."
      $("<option />", {
         "selected": "selected",
         "value"   : "",
         "text"    : "Go to..."
      }).appendTo("nav.subnav select");
      
	// Populate dropdown with menu items
      $("nav.subnav a[href]").each(function() {
       var el = $(this);
       $("<option />", {
           "value"   : el.attr("href"),
           "text"    : el.text()
       }).appendTo("nav.subnav select");
      });
      
	 // To make dropdown actually work
	   // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
      $("nav.subnav select").change(function() {
        window.location = $(this).find("option:selected").val();
      });
	  
// Product Thumb
	// Product Thumb Zoom
	$('.my-foto-container').imagezoomsl({ 
	 zoomrange: [1, 12],
         zoomstart: 4,
         innerzoom: true,
         magnifierborder: "none",	    
          magnifiersize: [500, 300],
          scrollspeedanimate: 10,
          loopspeedanimate: 5,          
         // magnifiereffectanimate: "slideIn"	
	}); 
	$ (".zoom" ).click( function () {
    var That =  this ;
    $( ".my-foto-container" ).fadeOut ( 100 , function (){
	 $(this).attr( "src" ,$ ( That).attr ( "src" ))            
     . attr ("data-large", $ (That).attr ("data-large")).fadeIn (200 )
	 . attr ("data-title", $ (That).attr ("data-title"))
	 . attr ("data-help", $ (That).attr ("data-help"))
				
           }); 
       }); 
	

			
// List & Grid View
	$('#list').click(function()
	{	$(this).addClass ('btn-orange').children('i').addClass('icon-white')
		$('.grid').fadeOut()
		$('.list').fadeIn()
		$('#grid').removeClass ('btn-orange').children('i').removeClass('icon-white')
	});
	$('#grid').click(function()
	{	$(this).addClass ('btn-orange').children('i').addClass('icon-white')
		$('.list').fadeOut()
		$('.grid').fadeIn()
		$('#list').removeClass ('btn-orange').children('i').removeClass('icon-white')
	});
	
// Prdouctpagetab 
	$('#myTab a:first').tab('show')
		$('#myTab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
// index8 tab
	$('#index8tab a:first').tab('show')
		$('#index8tab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
	});
	
// alert close 
	$('.clostalert').click(function()
	{
	$(this).parent('.alert').fadeOut ()
	});	


})

$(window).load(function() {
			
// Home page Slider 1
	$('#layerslider1').layerSlider({
		skinsPath : 'layerslider/skins/',
		skin : 'borderlessdark3d',
		thumbnailNavigation : 'hover',
		hoverPrevNext : false,
		autoPlayVideos : false,
		slideDelay  : 9000,             
			//autoStart               : false,
	});
				
// Home page Slider 2

	$("#mainslider2").carouFredSel({
		responsive: true,
	items		: 1,
	scroll		: {
		fx			: "crossfade"
	},
	auto: false,
	//mousewheel: true,	
	swipe: {
		onMouse: true,
		onTouch: true
	},
	
	pagination	: {
		container		: "#mainslider2_pag",
		anchorBuilder	: function( nr ) {
			var src = $("img", this).attr( "src" );
				//src = src.replace( "/large/", "/small/");
			return '<img src="' + src + '" style="width:100px" />';
			}
		}
	});
	

// Home page Slider 3
$('#layerslider3').layerSlider({
					skinsPath : 'layerslider/skins/',
					skin : 'fullwidth',
					thumbnailNavigation : 'hover',
					hoverPrevNext : false,
					responsive : false,
					responsiveUnder : 960,
					sublayerContainer : 960
				});
	
	
// Home page Slider 4 
	$('#mainslider4').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
        }
   });			

// Home page Slider 5				
$('#layerslider5').layerSlider({
					skinsPath : 'layerslider/skins/',
					skin : 'minimal',
					autoStart : false,
					navStartStop : false,
					hoverPrevNext : false,
					thumbnailNavigation : false
				});

// Home page Slider 6				
$('#mainslider6').carouFredSel({
					//width: 900,
					//height: '100%',
					direction: 'up',
					auto : false,
					items: 1,
					prev: '#prevmainslider6',
					next: '#nextmainslider6',
					pagination: "#pagermainslider6",
					//mousewheel: true,
					swipe: {
						onMouse: true,
						onTouch: true
					}
					
					
				});


// Home page Slider 7

	// Flexslider index banner
	$('#mainslider7').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
        }
   });


// Home page Slider 8

$('#layerslider8').layerSlider({
					skinsPath : 'layerslider/skins/',
					hoverPrevNext : false,
					skin : 'fullwidth',
					cbInit				: function(element){jQuery('.c-api').append(jQuery('<span>function cbInit() called</span><br>'));},
					cbStart				: function(data){jQuery('.c-api').append( jQuery('<span>function cbStart() called</span><br>'));},
					cbStop				: function(data){jQuery('.c-api').append( jQuery('<span>function cbStop() called</span><br>'));},
					cbPause				: function(data){jQuery('.c-api').append( jQuery('<span>function cbPause() called (pauseOnHover)</span><br>'));},
					cbAnimStart			: function(data){jQuery('.c-api').append( jQuery('<span>function cbAnimStart() called, current layer is: '+data.curLayerIndex+', next layer is: '+data.nextLayerIndex+'</span><br>'));},
					cbAnimStop			: function(data){jQuery('.c-api').append( jQuery('<span>function cbAnimStop() called</span><br>'));},
					cbPrev				: function(data){jQuery('.c-api').append( jQuery('<span>function cbPrev() called</span><br>'));},
					cbNext				: function(data){jQuery('.c-api').append( jQuery('<span>function cbNext() called</span><br>'));}
				});
// Home page Slider 9
	
	$('#mainslider9').carouFredSel({
		responsive: true,
		auto: true,
	//	width: 1170,
		height: '100%',
		direction: 'left',
		items: 1,
		swipe: {
				onMouse: true,
				onTouch: true
			},
		scroll: {
			duration: 1000,
			onBefore: function( data ) {
				data.items.visible.children().css( 'opacity', 0 ).delay( 200 ).fadeTo( 400, 1 );
				data.items.old.children().fadeTo( 400, 0 );
			}
		}
	});
	

// Home page Slider 10	
			function prevTimers() {
				return allTimers().slice( 0, $('.sliderindex10pager a.selected').index() );
			}
			function allTimers() {
				return $('.sliderindex10pager a span');
			}

			$(function() {
				$('#sliderindex10').carouFredSel({
					items: 1,
					responsive : true,
					auto: {
						pauseOnHover: 'resume',
						progress: {
							bar: '.sliderindex10pager a:first span'
						}
					},
					scroll: {
						fx: 'crossfade',
						duration: 300,
						timeoutDuration: 2000,
						onAfter: function() {
							allTimers().stop().width( 0 );
						//	prevTimers().width(  );
							$(this).trigger('configuration', [ 'auto.progress.bar', '.sliderindex10pager a.selected span' ]);
						}
					},
					pagination: {
						container: '.sliderindex10pager',
						anchorBuilder: false
					}
				});
			});
			
// Home page Slider 11				
	$('#layerslider11').layerSlider({
		skinsPath : 'layerslider/skins/',
		skin : 'borderlessdark3d',
		thumbnailNavigation : 'hover'
	});
	


// Home page Slider 12
	
  // The slider being synced must be initialized first
  $('#carouseindex12').flexslider({
	animation: "slide",
	controlNav: false,
	animationLoop: false,
	slideshow: false,
	itemWidth: 226,
	//itemMargin: 15,
	asNavFor: '#sliderindex12'
  });
  
  $('#sliderindex12').flexslider({
	animation: "slide",
	controlNav: false,
	animationLoop: false,
	slideshow: false,
	sync: "#carouseindex12"
  });
});


		
// Brand Carousal
$(window).load(function() {
	$('#featuredcarousal').carouFredSel({						
						scroll: 1,
						auto: false,
						prev: '#prev',
						next: '#next',
						swipe: {
							onMouse: true,
							onTouch: true
						},
		
		prev: '#prevfeatured',
		next: '#nextfeatured',
	});
	$('#latestcarousal').carouFredSel({
		
						scroll: 1,
						auto: false,
						prev: '#prev',
						next: '#next',
						swipe: {
							onMouse: true,
							onTouch: true
						},
		
		prev: '#prevlatest',
		next: '#nextlatest',
	});
});
			
// Brand Carousal
$(window).load(function() {
$('#brandcarousal').carouFredSel({
							width: '100%',
						scroll: 1,
							auto: false,
						prev: '#prev',
						next: '#next',
					   // mousewheel: true,
						
						swipe: {
							onMouse: true,
							onTouch: true
						}
					});
					});
					
// Category Carousal
$(window).load(function() {
$('#categorycarousal').carouFredSel({
							width: '100%',
						scroll: 1,
							auto: false,
						prev: '#prevcat',
						next: '#nextcat',
					    // mousewheel: true,
						
						swipe: {
							onMouse: true,
							onTouch: true
						}
					});
					});


								

// Contact Form
	$(document).ready(function() {	
		$(".contactform").validate({
	   submitHandler: function(form) {
		   var name = $("input#name").val();
		   var email = $("input#email").val();
		   var url = $("input#url").val();
		   var message = $("textarea#message").val();
		   
		   var dataString = 'name='+ name + '&email=' + email + '&url=' + url+'&message='+message;
		  $.ajax({
		  type: "POST",
		  url: "email.php",
		  data: dataString,
		  success: function() {
			  $('#contactmsg').remove();
			  $('.contactform').prepend("<div id='contactmsg' class='successmsg'>Form submitted successfully!</div>");
			   $('#contactmsg').delay(1500).fadeOut(500);
			  $('#submit_id').attr('disabled','disabled');
			  }
		 	});   
	   return false;
	  	}
		});
	});


// Flexsliders	  
$(window).load(function(){	
	
	// Fancyboxpopup
	$("a.prettyphotpopup").each(function() {		
		$(this).append('<span class="viewfancypopup">&nbsp;</span>'); 
	});
	
	$('a.prettyphotpopup').prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false, allow_expand: false});
	
	
	
	// Flexslider 
	$('#mainslider7').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
        }
   });
   // Flexslider2 
   $('#flexslider2').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
        }
   });
	
   // Flexslider side banner
	$('#mainsliderside').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
        }
   });
   
    // Flexslider ad banner
	$('#adbanner').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
        }
   });
	// Flexslider Category banner  
	$('#catergoryslider').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
        }
    });
	 
	 // Flexslider Brand    
	$('#advertise').flexslider({
        animation: "fade",		
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
	  
	// Flexslider Blog   
	$('#blogslider').flexslider({
        animation: "fade",		
        start: function(slider){
          $('body').removeClass('loading');
    }
      });
	  // smallbanner5   
	$('#smallbanner5').flexslider({
        animation: "fade",		
        start: function(slider){
          $('body').removeClass('loading');
    }
      });
	  
	  
	  // Flexslider  Musthave    
	$('#musthave').flexslider({
        animation: "fade",		
        start: function(slider){
          $('body').removeClass('loading');
    }
      });
	  
	  $('#testimonialsidebar').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
    }
      });
	   $('#latesetblogsidebar').flexslider({
        animation: "fade",		
        start: function(slider){
          $('body').removeClass('loading');
    }
      });
	  
	  
	    $('#portfolioslider').flexslider({
        animation: "slide",		
        start: function(slider){
          $('body').removeClass('loading');
    }
      });
	  
	  
	  
	  
});

<!-- Scroll top -->		  
$(window).scroll(function () {
		if ($(this).scrollTop() > 50) {
			$('#gotop').fadeIn(500);
		} else {
			$('#gotop').fadeOut(500);
		}
	});	
	

$(document).ready(function() {

//cowntdown function. Set the date by modifying the date in next line (January 01, 2013 00:00:00):
		var austDay = new Date("December 31, 2013 00:00:00");
		
			$('#comingsoon').countdown({until: austDay, layout: '<div class="box"><div>{dn}</div> <span> {dl} </span></div> <div class="box"><div>{hn}</div> <span> {hl} </span></div> <div class="box"><div>{mn}</div> <span> {ml} </span></div> <div class="box"><div>{sn}</div> <span> {sl} </span></div>'});
			$('#year').text(austDay.getFullYear());
})



$(document).ready(function() {
	 
// Twitter
	 $("#twitter").tweet({
          join_text: "auto",
         /* username: "envato", //replace this with your username*/
		  modpath: './twitter/',
          avatar_size: 32,
          count: 3,
          auto_join_text_default: "we said,",
          auto_join_text_ed: "we",
          auto_join_text_ing: "we were",
          auto_join_text_reply: "we replied",
          auto_join_text_url: "we were checking out",
          loading_text: "loading tweets..."
        });
		
		// Scroll top
	$(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#gotop').fadeIn(500);
							
			} else {
				$('#gotop').fadeOut(500);
			}
		});	
	$('#gotop').click(function()
			{
				
				$("html, body").animate({ scrollTop: 0 }, 600);
			})
})

