/* Floating layer css */

/*function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}*/

function findPosX(obj)
  {
    var curleft = 0;
    if(obj.offsetParent)
        while(1) 
        {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
  }

  function findPosY(obj)
  {
    var curtop = 0;
    if(obj.offsetParent)
        while(1)
        {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
  }


  ie=(navigator.appName=="Microsoft Internet Explorer")?1:0
  window_width=function(){return (navigator.appName=="Netscape")?window.innerWidth:document.body.offsetWidth}
  window_height=function(){return (navigator.appName=="Netscape")?window.innerHeight:document.body.offsetHeight}
    var dhandle;
    old_x=0;
    old_y=0;
    pressed=0;
   function setDrag(ob){
    dhandle=ob
    //alert(document.getElementById("test").style.left)
   }
  function dragStart(ob,e){
    _x=(e.pageX)?e.pageX:e.clientX;
    _y=(e.pageY)?e.pageY:e.clientY;
    old_x=_x-dhandle.offsetLeft
    old_y=_y-dhandle.offsetTop
    _ob=document.getElementById("thediv");
    if (pressed){
      if (ie){_ob.style.filter="alpha(opacity=100)";}else{_ob.style.opacity=1;}
      ob.innerHTML=ob._text;
      pressed=0;
    }else{
      if (ie){_ob.style.filter="alpha(opacity=50)";}else{_ob.style.opacity=0.5;}
      //_ob.style.opacity=0.5;  
      ob._text=ob.innerHTML;
      ob.innerHTML="Draging!";
      pressed=1;
    }
    
  }
  function doDrag(ob,e){
    _x=(e.pageX)?e.pageX:e.clientX;
    _y=(e.pageY)?e.pageY:e.clientY;
    if (pressed){
      dhandle.style.left=_x-old_x
      dhandle.style.top= _y-old_y
    }
  }
  function showDiv(ob,w,h,s){
    var ww,hh,xx,yy;
    ww=18+w;
    hh=90+h;
    _x=findPosX(ob);
    _y=findPosY(ob);
    _w=ob.offsetWidth;
    _h=ob.offsetHeight;
    xx=(_x+ww>window_width())?(_x-ww+_w):(_x)
    yy=(_y+_h+hh>window_height())?(_y-hh):(_y+_h)
    this._ob=document.getElementById(s);
    ob._ob=this._ob
    /*this._ct=document.getElementById("thecont");
    with (this._ct){
      src=s;
      with (style){
        width=w;
        height=h;
      }
    }*/
    this._ob.style.visibility="visible"
    this._ob.style.left=xx
    this._ob.style.top=yy
  }
  function hideDiv(ob){
    this._ob=document.getElementById(ob)
    /*document.getElementById("thecont").src="about:blank";
    if (!ie){history.back();}*/
    
    this._ob.style.visibility="hidden"
  }
	$$=function(element){
	  	return (typeof element == 'object')?element:document.getElementById(element);
	}
//form
	function isFunction(a) {
    	return typeof a == 'function';
	}
	function showForm(ob,sr){
		ob=$$(ob)
		s =$$(sr)
		s.style.visibility="visible"
		s.style.left=findPosX(ob)+"px";
		s.style.top=findPosY(ob)+ob.style.height+"px";
  	}
  function hideForm(ob){
	  $$(ob).style.visibility="hidden"
  }