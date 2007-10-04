//MenuFN={
//	toogle:function(_this,mnu){
//		var el=document.getElementById(mnu);
//		if (el.style.display=="block" || el.style.display===""){
//			el.style.display="none";
//			Cookie.Write(mnu,"none");	
//			_this.className="section";
//		}else if (el.style.display=="none"){
//			el.style.display="block";
//			Cookie.Write(mnu,"block",50000);	
//			_this.className="sectionOpen";
//		}
//	}
//};

function togglemenu(id){
	var _this=$("MENU_PANEL_"+id);
	var _item=$("MENU_ITEM_"+id);
	var mnu="MENU_"+id+"_COOKIE";
	if (!_this.visible()){
		Cookie.Write(mnu,"block");	
		//_this.show();
		//_item.className="sectionOpen";
	} else {
		Cookie.Write(mnu,"none",50000);	
		//_this.hide();
		//_item.className="section";
	}
	Effect.toggle(_this,"slide",{duration:0.4});
		Effect.Fade(_item,{duration:0.2,to:0.1,afterFinish:function(){
			_item.toggleClasseNameWith("sectionOpen","section");
			Effect.Appear(_item,{duration:0.2});
	}});
}