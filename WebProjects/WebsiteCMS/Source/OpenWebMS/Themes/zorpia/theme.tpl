#{start:module}
   #{start:TitledD}
		<div id="#{id}" class="Module">
	   	<div class="modules_lrtb_title">
            #{minimizer}
				<div class="TitleText">#{title}</div>
	      </div>
			<div class="modules_lrtb_content" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>
		</div>
  #{end:TitledD}

	#{start:TitledC}
		<div id="#{id}" class="Module">
	   	<div class="modules_c_title">
				#{minimizer}
				<div class="TitleText">#{title}</div>
	   	</div>
			<div class="modules_c_content" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>
		</div>
  #{end:TitledC}
  
  #{start:UntitledD}
		<div id="#{id}" class="Module">
			<div class="modules_lrtb_content" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>
		</div>
  #{end:UntitledD}
  
  #{start:UntitledC}
		<div id="#{id}" class="Module">
			<div class="modules_c_title">

	      </div>
			<div class="modules_c_content" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>
		</div>
  #{end:UntitledC}
#{end:module}

#{start:page}	
	#{start:title}	
		<div class="MainMid"> 
			<div class="Box">                
				<div class="TopLeft"><div class="TopRight"></div></div>                
				<div style="float:right;" id="AjaxLoader"></div>
				<div align="center">
				#{iif:GlobalLogo,<img class="alpha" src="#{GlobalLogoPath}" border="0" />,<div class="TitleImage alpha" title="My Website Name"></div>}
				</div>
				<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>
		</div>
		
	#{end:title}	
	#{start:content}	
		<table cellpadding="0" cellspacing="0" width="100%" >                
		    <tr>
		    	<td id="TopColumn" colspan="3" style="#{display_modulestop}">
		    	#{write_modulestop}           	
		    	</td>
		    </tr>
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
			<tr>				
				<td id="BottomColumn" colspan="3" style="#{display_modulesbottom}">
		    	#{write_modulesbottom} 
				</td>				
			</tr>           
		</table>
	#{end:content}
	#{start:footer}
	<div align="center">
		<div class="Footer"> 
					<div style="padding-bottom:5px"><b>powered by <a href="http://resplace.net/?Projects.OpenWebMS" title="Module based PHP website management system">OpenWebMS</a></b><br />Copyright &copy; resplace.net</div>
				    <img src="#{imgpath}html401.png" alt="[HTML 4.01]" title="HTML 4.01 Complient" />
		</div>
	</div>
	<div align="right" style="padding-top:10px">
		Page generated in #{WebMS_load} seconds.<br>
		#{ResDB_queries} ResDB Queries were made.
	</div>
	#{end:footer}
#{end:page}			
