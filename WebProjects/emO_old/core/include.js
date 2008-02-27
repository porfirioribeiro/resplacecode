// JavaScript Document
var PageSizeW=20
var PageSizeH=20
var Fi=0
var Fx=0
var Fy=0
var Ei=0
var Ex=0
var Ey=0
var MI=0
var Mx=0
var My=0
var Mspeed=1
var currentTab="faces"
    function doEmote(){
      document.getElementById("emote").src="emote.php?pw="+PageSizeW+"&ph="+PageSizeH+"&fi="+Fi+"&fx="+Fx+"&fy="+Fy+"&ei="+Ei+"&ex="+Ex+"&ey="+Ey+"&mi="+Mi+"&mx="+Mx+"&my="+My
	  document.getElementById("zoom").src="emote.php?pw="+PageSizeW+"&ph="+PageSizeH+"&fi="+Fi+"&fx="+Fx+"&fy="+Fy+"&ei="+Ei+"&ex="+Ex+"&ey="+Ey+"&mi="+Mi+"&mx="+Mx+"&my="+My
      //document.getElementById("shortcut").href="emote.php?face="+Fi+"&eye="+Ei+"&mouth="+Mi
    }
	speed={
		up  :function(){Mspeed++;document.getElementById("speedEl").innerHTML=Mspeed},
		down:function(){Mspeed--;document.getElementById("speedEl").innerHTML=Mspeed}	
	}
	move={
		center:function(){
			if ($$("chfaces").checked){
				Fx=(PageSizeW/2)-10
				Fy=(PageSizeH/2)-10
			}	
			if ($$("cheyes").checked){
				Ex=(PageSizeW/2)-10
				Ey=(PageSizeH/2)-10
			}
			if ($$("chmouths").checked){
				Mx=(PageSizeW/2)-10
				My=(PageSizeH/2)-10
			}
			doEmote()			
		},
		left:function(){
			if ($$("chfaces").checked){Fx-=Mspeed}	
			if ($$("cheyes").checked){Ex-=Mspeed}
			if ($$("chmouths").checked){Mx-=Mspeed}
			doEmote()
		},
		right:function(){
			if ($$("chfaces").checked){Fx+=Mspeed}	
			if ($$("cheyes").checked){Ex+=Mspeed}
			if ($$("chmouths").checked){Mx+=Mspeed}
			doEmote()
		},
		up:function(){
			if ($$("chfaces").checked){Fy-=Mspeed}	
			if ($$("cheyes").checked){Ey-=Mspeed}
			if ($$("chmouths").checked){My-=Mspeed}
			doEmote()
		},	
		down:function(){
			if ($$("chfaces").checked){Fy+=Mspeed}	
			if ($$("cheyes").checked){Ey+=Mspeed}
			if ($$("chmouths").checked){My+=Mspeed}
			doEmote()
		}	
	}
	function doNew(){
		Fi=0
		Ei=0
		Mi=0
		PageSizeW=20
		PageSizeH=20
		doEmote()
	}
    function doRandom(){
     Fi=Math.round(Math.random()*totalFaces-1);
     Ei=Math.round(Math.random()*totalEyes-1);
     Mi=Math.round(Math.random()*totalMouth-1);
     doEmote()
    }
    function doExport(ob){
		ex=document.getElementById("exportForm")
		ex.pw.value=PageSizeW
		ex.ph.value=PageSizeH
		ex.fi.value=Fi
		ex.fx.value=Fx
		ex.fy.value=Fy
		ex.ei.value=Ei
		ex.ex.value=Ex
		ex.ey.value=Ey
		ex.mi.value=Mi
		ex.mx.value=Mx
		ex.my.value=My
		showForm(ob,'export')
        document.getElementById("ims").src="emote.php?pw="+PageSizeW+"&ph="+PageSizeH+"&fi="+Fi+"&fx="+Fx+"&fy="+Fy+"&ei="+Ei+"&ex="+Ex+"&ey="+Ey+"&mi="+Mi+"&mx="+Mx+"&my="+My
      //location.href="download.php?face="+Fi+"&eye="+Ei+"&mouth="+Mi
    }
    function loaded(){
		document.getElementById("loading").style.visibility="hidden";
		document.getElementById("faces").style.visibility="visible";
	}	
   function showEyes(){
	   currentTab="eyes"
    document.getElementById("faces").style.visibility="hidden";
    document.getElementById("mouth_test").style.visibility="hidden";
    document.getElementById("eyes").style.visibility="visible";
    document.getElementById("emfaces").disabled=false
    document.getElementById("emeyes").disabled=true
    document.getElementById("ememouth").disabled=false
   }
   function showFaces(){
	   currentTab="faces";
    document.getElementById("faces").style.visibility="visible";
    document.getElementById("eyes").style.visibility="hidden";
    document.getElementById("mouth_test").style.visibility="hidden";
    document.getElementById("emfaces").disabled=true
    document.getElementById("emeyes").disabled=false
    document.getElementById("ememouth").disabled=false
   }
  function showMouth(){
	  currentTab="mouths"
    document.getElementById("faces").style.visibility="hidden";
    document.getElementById("eyes").style.visibility="hidden";
    document.getElementById("mouth_test").style.visibility="visible";
    document.getElementById("emfaces").disabled=false
    document.getElementById("emeyes").disabled=false
    document.getElementById("ememouth").disabled=true
   }
   selectedFace=0
   selectedEye=0
   selectedMouth=0
   Fi=0
   Ei=0
   Mi=0
   function selectFace(ob){
    if (selectedFace!=0){selectedFace.className='bem'}
    ob.className='bemp'
    Fi=ob.childNodes[0].alt
    selectedFace=ob
    //document.getElementById("emote").src="emote.php?face="+Fi+"&eye="+Ei+"&mouth="+Mi
    doEmote()
   }
   
   function selectEye(ob){
    if (selectedEye!=0){selectedEye.className='bem'}
    ob.className='bemp'
    Ei=ob.childNodes[0].alt
    selectedEye=ob
     //document.getElementById("emote").src="emote.php?face="+Fi+"&eye="+Ei+"&mouth="+Mi
  doEmote()
   }
   function selectMouth(ob){
    if (selectedMouth!=0){selectedMouth.className='bem'}
    ob.className='bemp'
    Mi=ob.childNodes[0].alt
    selectedMouth=ob
      //document.getElementById("emote").src="emote.php?face="+Fi+"&eye="+Ei+"&mouth="+Mi
   doEmote()
   }
   function setSize(w,h){
	PageSizeW=w
	PageSizeH=h
	doEmote()
   }
	function setMsg(ob,i){
		$$('messages').innerHTML=msg[i]
		ob.onmouseout=function(){
			$$('messages').innerHTML=msg[0]
		}
	}