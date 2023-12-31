(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      try {
        const originalUrl = new URL(element.attr('href'));
        if(typeof(originalUrl) == 'undefined'){
            return;
        }
        let currentPath = window.location.pathname;
        let originalUrlPath = originalUrl.pathname;
        
        if(currentPath[currentPath.length-1] == '/') {
            originalUrlPath = originalUrlPath + '/';
        }
        let currentPathParent = currentPath.split('/').slice(0,3).join('/')
        let originalUrlPathParent = originalUrlPath.split('/').slice(0,3).join('/')
        
        if(currentPathParent == originalUrlPathParent){
            element.parents('.nav-item').last().addClass('active');
    
            if (element.parents('.sub-menu').length) {
                element.closest('.collapse').addClass('show');
                if (currentPath == originalUrlPath || currentPath.indexOf(originalUrlPath+'/') !== -1) {
                    element.addClass('active'); 
                }
            }

            if (currentPath == originalUrlPath || currentPath.indexOf(originalUrlPath+'/') !== -1) {
                if (currentPath == originalUrlPath) {
                    if (element.parents('.submenu-item').length) {
                        element.addClass('active');
                    }
                }
            }
        } 
    
    } catch (error) {
        return ;
    }
    
    return;
    }

    $('.nav li a', sidebar).each(function() {
      var $this = $(this);
      addActiveClass($this);
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar

    $('[data-toggle="minimize"]').on("click", function() {
      body.toggleClass('sidebar-icon-only');
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    // Remove pro banner on close

   
    if ($.cookie('majestic-free-banner')!="true") {
      document.querySelector('#proBanner').classList.add('d-flex');
      document.querySelector('.navbar').classList.remove('fixed-top');
    }
    else {
      document.querySelector('#proBanner').classList.add('d-none');
      document.querySelector('.navbar').classList.add('fixed-top');
    }
    
    if ($( ".navbar" ).hasClass( "fixed-top" )) {
      document.querySelector('.page-body-wrapper').classList.remove('pt-0');
      document.querySelector('.navbar').classList.remove('pt-5');
    }
    else {
      document.querySelector('.page-body-wrapper').classList.add('pt-0');
      document.querySelector('.navbar').classList.add('pt-5');
      document.querySelector('.navbar').classList.add('mt-3');
      
    }
    document.querySelector('#bannerClose').addEventListener('click',function() {
      document.querySelector('#proBanner').classList.add('d-none');
      document.querySelector('#proBanner').classList.remove('d-flex');
      document.querySelector('.navbar').classList.remove('pt-5');
      document.querySelector('.navbar').classList.add('fixed-top');
      document.querySelector('.page-body-wrapper').classList.add('proBanner-padding-top');
      document.querySelector('.navbar').classList.remove('mt-3');
      var date = new Date();
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000); 
      $.cookie('majestic-free-banner', "true", { expires: date });
    });

  });



})(jQuery);