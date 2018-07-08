
$(function(){
    setNubeAnimation();
    

});

function setNubeAnimation(){
    
            
    $("#nubes-slider").bind("animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd", function(){ 
        var dir = 0.4;
    setInterval(function(){
    
        windowWidth = screen.width;

        var x = $("#nubes-slider").offset().left;
        var y = $("#nubes-slider").offset().top;
        var width = $("#nubes-slider").width();

        $("#nubes-slider").offset({top: 130, left:x-dir});

        if(x+width < 0) $("#nubes-slider").offset({top: 0, left:windowWidth});
        console.log(x,y,width,windowWidth);

    },10);  


        
     });
      

    
    
}

