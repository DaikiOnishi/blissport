// JavaScript Document


	var linkTouchStart = function(){
    thisAnchor = $(this);
    touchPos = thisAnchor.offset().top;
    moveCheck = function(){
        nowPos = thisAnchor.offset().top;
        if(touchPos == nowPos){
            thisAnchor.addClass("hover");
        }
    }
    setTimeout(moveCheck,800);
}
var linkTouchEnd = function(){
    thisAnchor = $(this);
    hoverRemove = function(){
        thisAnchor.removeClass("hover");
    }
    setTimeout(hoverRemove,1000);
}
 
$(document).on('touchstart mousedown','a',linkTouchStart);
$(document).on('touchend mouseup','a',linkTouchEnd);
