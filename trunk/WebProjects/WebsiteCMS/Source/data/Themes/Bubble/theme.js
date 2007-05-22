
function collapseToogle(el,module,cookie){
	var hLeft=$(module+"_left_icon");
	var hRight=$(module+"_right_icon");
	var moduleEl=$(module+"_container");
	/* Small workaround for make you not be able to collapse while colapsing ;)*/
	if (!moduleEl["___collapsing__"]){
		moduleEl["___collapsing__"]=true;
		Effect.toggle(moduleEl,"slide",{
			afterFinish:function(){
				moduleEl["___collapsing__"]=false;					
			}
		});
		if (hLeft){
			Effect.Fade(hLeft,{duration:0.5,to:0.1,afterFinish:function(){
				hLeft.toggleClasseNameWith("CollapseIcon","UnCollapseIcon");
				Effect.Appear(hLeft,{duration:0.5});
			}});
		}
		if (hRight){
			Effect.Fade(hRight,{duration:0.5,to:0.1,afterFinish:function(){
				hRight.toggleClasseNameWith("CollapseIcon","UnCollapseIcon");
				Effect.Appear(hRight,{duration:0.5});		
			}});		
		}	
		
		Cookie.Write(cookie,moduleEl.visible());	
	}else{
		//alert("wait, we are still collapsing this one...");	
	}
}