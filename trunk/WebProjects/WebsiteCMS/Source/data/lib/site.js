/**
 * @author porfirio.ribeiro@sapo.pt
 */
/**
 * 
 */
function TpvSite(){
	
}

function collapseToogle(module,el){
	var hLeft=document.getElementById(module+"_CAL");
	var hRight=document.getElementById(module+"_CAR");
	var moduleEl=document.getElementById(module+"_CT");
	var str;
	if (moduleEl.style.display=="block" || moduleEl.style.display===""){
		moduleEl.style.display="none";
		Cookie.Write(module+"_CL","none");
		if (hLeft!==null){
			str=(el==hLeft)?"Over":"";
			hLeft.className="SmallIcon UnCollapseIcon"+str;
		}
		if (hRight!==null){
			str=(el==hRight)?"Over":"";
			hRight.className="SmallIcon UnCollapseIcon"+str;
		}		
	}else if (moduleEl.style.display=="none"){
		moduleEl.style.display="block";
		Cookie.Write(module+"_CL","block",50000);
		if (hLeft!==null){
			str=(el==hLeft)?"Over":"";
			hLeft.className="SmallIcon CollapseIcon"+str;
		}
		if (hRight!==null){
			str=(el==hRight)?"Over":"";
			hRight.className="SmallIcon CollapseIcon"+str;
		}		
	}
}
function collapseOverOut(module,el,over){
	module=document.getElementById(module+"_CT");
	var classe="SmallIcon ";
	if (module.style.display=="none"){
		classe+="Un";
	}	
	classe+="CollapseIcon";
	if (over){
		classe+="Over";
	}
	el.className=classe;
}
Cookie.Delete("NoScript");
Cookie.Delete("ShowNSWarn");