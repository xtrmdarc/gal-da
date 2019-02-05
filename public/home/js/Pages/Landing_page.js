
$(function(){
    setAnimation();
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
    
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    fbq('track','ViewContent',{content_ids:'land_1',content_name:'home',content_type:'landing_page'});
    
});

function setAnimation(){
    
      /*      
    $("#nubes-slider").bind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(){ 
        var dir = 0.4;
    setInterval(function(){
    
        windowWidth = screen.width;

        var x = $("#nubes-slider").offset().left;
        var y = $("#nubes-slider").offset().top;
        var width = $("#nubes-slider").width();

        $("#nubes-slider").offset({top: 130, left:x-dir});

        if(x+width < 0) $("#nubes-slider").offset({top: 0, left:windowWidth});
       

    },10);  
  
    });*/

    $("#zepellin-slider").bind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(){ 
        var dir = 0.4;
    setInterval(function(){
    
        windowWidth = screen.width;

        var x = $("#zepellin-slider").offset().left;
        var y = $("#zepellin-slider").offset().top;
        var width = $("#zepellin-slider").width();

        $("#zepellin-slider").offset({top: 130, left:x-dir});

        if(x+width < 0) $("#zepellin-slider").offset({top: 0, left:windowWidth});
        //console.log(x,y,width,windowWidth);

    },8);  
  
    });

    
    
}

