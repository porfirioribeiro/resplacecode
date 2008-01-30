#{start:module}
  #{start:TitledD}
    <div id="#{id}" class="ModuleBox">
	        <div class="ModuleTitle">
				#{minimizer}
				<div class="TitleText">#{title}</div>
	        </div>	       
			<div class="ModuleContent" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>	
		</div> 
  #{end:TitledD}
  #{start:UntitledD}
    <div id="#{id}" class="ModuleBox">
			<div class="ModuleContent" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>	
		</div> 
  #{end:UntitledD}
#{end:module}

#{start:page}	
	#{start:title}	
		<div class="MainMid"> 
			<div class="Box">                                
				<div style="float:right;" id="AjaxLoader"></div>
				<div align="left" style="">
				#{iif:GlobalLogo,<img class="alpha" src="#{GlobalLogoPath}" border="0" />,<div class="TitleImage" title="My Website Name"></div>}
				</div>
				<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>
		</div>
		
	#{end:title}	
	#{start:content}
		<div style="#{display_modulestop}; padding-left:2px ;padding-right:2px ;">
			#{write_modulestop}
		</div>	
		<table cellpadding="0" cellspacing="0" width="100%">                
		    <tr>           
		    	<td id="LeftColumn" style="#{display_modulesleft}">  
		    	#{write_modulesleft}
		    	</td>        
		    	<td id="CenterColumn" style="#{display_modulescenter}">
		    	#{write_modulescenter}
		    	</td>	
		    	<td id="RightColumn" style="#{display_modulesright}">
		    	#{write_modulesright}
		    	</td>	              
		    </tr>           
		</table>
		<div style="#{display_modulesbottom} padding-left:2px ;padding-right:2px ;">
			#{write_modulesbottom}
		</div>	
	#{end:content}
	#{start:footer}
	<div align="center">
		<div class="Footer"> 
					<div style="padding-bottom:5px">
          Website desenvolvido por: <a href="/AboutAutoSys">Porfirio Ribeiro</a><br>
          <b>Powered by <a href="http://resplace.net/?Projects.OpenWebMS" title="Module based PHP web site management system">OpenWebMS</a> &copy; resplace.net</b></div>
					<img src="#{imgpath}html401.png" alt="[HTML 4.01]" title="HTML 4.01 Complient" />
		</div>
	</div>
	#{end:footer}
#{end:page}			
