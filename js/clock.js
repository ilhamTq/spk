// JavaScript Document
window.onload = function(){

var canvas = Raphael("pane",0,0,500,500);

canvas.circle(150,150,10).attr("stroke-width",2).attr("fill","#ffffff");

canvas.circle(150,150,100).attr("stroke-width",2).attr("fill","#ebebeb");
canvas.circle(150,150,3).attr("fill","#000");

var angleplus = 360,rad = Math.PI / 180,
    cx = 150,cy =150 ,r = 90,		
    startangle = -90,angle=30,x,y, endangle;
		 
	 for(i=1;i<13;i++)
	 {
		 
		 
		 endangle = startangle + angle ;
		 
		 x = cx + r  * Math.cos(endangle * rad);
		 y = cy + r * Math.sin(endangle * rad);
		 
				 
		 canvas.text(x,y,i+"");
		 
		  startangle = endangle;
	 }

var hand = canvas.path("M150 70L150 150").attr("stroke-width",1);
var minute_hand = canvas.path("M150 100L150 150").attr("stroke-width",2);
var hour_hand = canvas.path("M150 110L150 150").attr("stroke-width",3);

var time = new Date();


angle = time.getSeconds() * 6;

minute_hand.rotate(6 * time.getMinutes(),150,150); 

var hr = time.getHours();
if(hr>12)
hr = hr -11;

hour_hand.rotate(30 * hr,150,150);

var minute_angle= 6 + time.getMinutes()*6,hour_angle=0.5+ hr*30;
setInterval(function(){
					 angle = angle + 6;
					 if(angle>=360)
					 {
						 angle=0;
					
					minute_hand.rotate(minute_angle,150,150); 
				     minute_angle = minute_angle + 6;
					 
					  hour_hand.rotate(hour_angle,150,150); 
						  hour_angle = hour_angle + 0.6;
					 }
					  if(minute_angle>=360)
					  {
						  minute_angle=0;
						 
					  }
					 
					 hand.rotate(angle,150,150);
					 },1000);
};