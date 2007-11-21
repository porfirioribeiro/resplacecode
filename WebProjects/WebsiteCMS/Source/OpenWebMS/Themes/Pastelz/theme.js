
function collapseToogle(el,module,cookie){
	var MIcon=$(module+"_icon");

	var moduleEl=$(module+"_container");
	/* Small workaround for make you not be able to collapse while colapsing ;)*/
	if (!moduleEl["___collapsing__"]){
		moduleEl["___collapsing__"]=true;
		Effect.toggle(moduleEl,"slide",{
			afterFinish:function(){
				moduleEl["___collapsing__"]=false;
			}
		});
		if (MIcon){
			Effect.Fade(MIcon,{duration:0.5,to:0.1,afterFinish:function(){
			   Effect.Appear(MIcon,{duration:0.5});
				MIcon.toggleClasseNameWith("CollapseIcon","UnCollapseIcon");
			}});
		}
		
		Cookie.Write(cookie,moduleEl.visible());	
	}else{
		//alert("wait, we are still collapsing this one...");	
	}
}
