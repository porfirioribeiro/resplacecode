#{start:module}
	#{start:default}
		<div id="#{id}" class="Module">                  
	        <div class="modules_title">      	
			    <div style="float:right" id="#{id}_right_icon" class="SmallIcon #{iif:collapsed,CollapseIcon,UnCollapseIcon}" onclick="collapseToogle(this,'#{id}','#{cookie}')"></div>  
				<div class="TitleText">#{title}</div>                        
	        </div>	       
			<div class="modules_content" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>	
		</div> 			
	#{end:default}		
	#{start:left}	
		<div id="#{id}" class="Module">                  
	        <div class="modules_title">      	
			    <div style="float:right" id="#{id}_right_icon" class="SmallIcon #{iif:collapsed,CollapseIcon,UnCollapseIcon}" onclick="collapseToogle(this,'#{id}','#{cookie}')"></div>  
				<div class="TitleText">#{title}</div>                        
	        </div>	       
			<div class="modules_content" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>	
		</div> 	
	#{end:left}	
	#{start:right}	
		<div id="#{id}" class="Module">                  
	        <div class="modules_title">      	
			    <div style="float:right" id="#{id}_left_icon" class="SmallIcon #{iif:collapsed,CollapseIcon,UnCollapseIcon}" onclick="collapseToogle(this,'#{id}','#{cookie}')"></div>  
				<div class="TitleText">#{title}</div>                        
	        </div>	       
			<div class="modules_content" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			</div>	
		</div> 	
	#{end:right}
#{end:module}

#{start:page}	
	#{start:title}	
		<div class="MainMid"> 
			<div class="Box">                                
				<div style="float:right;" id="AjaxLoader"></div>
				<div align="left" style="padding-left:10px;padding-top:4px;">
				#{iif:GlobalLogo,<img class="alpha" src="#{GlobalLogoPath}" border="0" />,<div class="TitleImage alpha" title="My Website Name"></div>}
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
					<div style="padding-bottom:5px"><b>powered by <a href="http://resplace.net/?Projects.OpenWebMS" title="Module based PHP web site management system">OpenWebMS</a></b><br />Copyright &copy; resplace.net</div>
					<img src="#{imgpath}html401.png" alt="[HTML 4.01]" title="HTML 4.01 Complient" />
		</div>
	</div>
	<div align="right" style="padding-top:10px">
		Page generated in #{WebMS_load} seconds.<br>
		#{ResDB_queries} ResDB Queries were made.
	</div>
	#{end:footer}
#{end:page}			