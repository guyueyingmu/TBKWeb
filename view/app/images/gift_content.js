var pic_box = document.getElementById('gift_picurl');
var isdrag=false;
var tx,x,ty,y;
var width =60,height =60,rotation = 0; 

/*pic_box.addEventListener('gesturechange',gesturechange);
pic_box.addEventListener('gestureend',gestureend);
pic_box.addEventListener('touchstart',touchStart);  
pic_box.addEventListener('touchmove',touchMove);
*/
function gesturechange(e){
	e.preventDefault();
    var style = e.target.style;  
    style.width = (width * e.scale) + "px";  
    style.height = (height * e.scale) + "px";  
    style.webkitTransform = "rotate(" + ((rotation + e.rotation) % 360) + "deg)";  
}
function gestureend(e){   
    width *= e.scale;  
    height *= e.scale;  
    rotation = (rotation + e.rotation) % 360;  
};   
function touchStart(e){   
   isdrag = true; 
   e.preventDefault();
   tx = parseInt($("#moveid").css('left'));    
   ty = parseInt($("#moveid").css('top'));  
   x = e.touches[0].pageX;
   y = e.touches[0].pageY;  
}

function touchMove(e){   
  if (isdrag){
   e.preventDefault();
	   //var n = tx + e.touches[0].pageX - x;
	  // var h = ty + e.touches[0].pageY - y;   
	   //$("#moveid").css("left",n); 
	   //$("#moveid").css("top",h);    
   }  
}   



function _scroll(call){
	document.addEventListener('scroll',function(e){
		
				if(document.documentElement && document.documentElement['scrollTop']){
					var el = document.documentElement;
				}else{
					var el = document.body;
				}
				
				call(el.scrollTop,el,e);
	})
		/*$(window).scroll(function(e){
				if(document.documentElement && document.documentElement['scrollTop']){
					var el = document.documentElement;
				}else{
					var el = document.body;
				}
				call(el.scrollTop,el,e);
		})*/
}
/*_scroll(function(top){
	if(top<100){
		pic_box.className = 'gift_scroll_out gift_picurl';
	}else{
		pic_box.className = 'gift_scroll_in gift_picurl';
	}

});*/

$('#gift_picurl').touchwipe({


	wipeUp:function(){
		console.log(123);
	},
	wipeDown:function(){
		console.log(222);
	},
	min_move_x:20,
	min_move_y:20,
	preventDefaultEvents:true
});