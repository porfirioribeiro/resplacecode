MenuFN={
	toogle:function(_this,mnu){
		var el=document.getElementById(mnu);
		if (el.style.display=="block" || el.style.display===""){
			el.style.display="none";
			Cookie.Write(mnu,"none");	
			_this.className="section";
		}else if (el.style.display=="none"){
			el.style.display="block";
			Cookie.Write(mnu,"block",50000);	
			_this.className="sectionOpen";
		}
	}
};