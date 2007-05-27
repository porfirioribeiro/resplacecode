#{start:module}
	#{start:default}
		<div id="#{id}" class="Module">                  
	        <div class="TitleMid">                            
	            <div class="TitleLeft"></div>
			    <div style="float:left;" id="#{id}_left_icon" class="SmallIcon #{iif:collapsed,CollapseIcon,UnCollapseIcon}" onclick="collapseToogle(this,'#{id}','#{cookie}')"></div>  
			    <div class="TitleRight"></div>   
			    <div style="float:right;" id="#{id}_right_icon" class="SmallIcon #{iif:collapsed,CollapseIcon,UnCollapseIcon}" onclick="collapseToogle(this,'#{id}','#{cookie}')"></div>
				<div class="TitleText">#{title}</div>                        
	        </div>	        
			<div class="Box" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>	
		</div> 			
	#{end:default}		
	#{start:left}	
		<div id="#{id}" class="Module">                  
	        <div class="TitleMid">                            
		        <div class="TitleLeft"></div>
			    <div class="TitleRight"></div>       	
			    <div style="float:right" id="#{id}_right_icon" class="SmallIcon #{iif:collapsed,CollapseIcon,UnCollapseIcon}" onclick="collapseToogle(this,'#{id}','#{cookie}')"></div>  
				<div class="TitleText">#{title}</div>                        
	        </div>	       
			<div class="Box" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>	
		</div> 	
	#{end:left}	
	#{start:right}	
		<div id="#{id}" class="Module">                  
	        <div class="TitleMid">                            
	            <div class="TitleLeft"></div>	
			    <div style="float:left;" id="#{id}_left_icon" class="SmallIcon #{iif:collapsed,CollapseIcon,UnCollapseIcon}" onclick="collapseToogle(this,'#{id}','#{cookie}')"></div> 
				<div class="TitleRight"></div> 
				<div class="TitleText">#{title}</div>                        
	        </div>	       
			<div class="Box" id="#{id}_container" style="display:#{iif:collapsed,none,block}">
				<div class="BoxContent">
					#{content}
				</div>
			<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>	
		</div>         		
	#{end:right}	
#{end:module}

#{start:page}	
	#{start:title}	
		<div class="MainMid"> 
			<div class="Box">                
				<div class="TopLeft"><div class="TopRight"></div></div>                
				<div style="float:right;" id="AjaxLoader"></div>
				<div align="center">
				<div class="TitleImage"></div>
				</div>
				<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>
		</div>
	#{end:title}	
	#{start:content}	
		<table cellpadding="0" cellspacing="0" width="100%" >                
		    <tr>
		    	<td colspan="3" style="#{display_modulestop}">
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
				<td colspan="3" style="#{display_modulesbottom}">
		    	#{write_modulesbottom} 
				</td>				
			</tr>           
		</table>
	#{end:content}
	#{start:footer}
		<div class="MainMid"> 
			<div class="Box">                
				<div class="TopLeft"><div class="TopRight"></div></div>                
				<div align="center">
					<div style="padding-bottom:2px">powered by <a href="resplace.net" title="Module based PHP website management system">OpenWebMS</a> | Copyright &copy; resplace.net</div>
					<img src="#{imgpath}gen_php.png" alt="[DB]" title="Generated in #{WebMS_load} sec/s" /> <img src="#{imgpath}gen_resdb.png" alt="[DB]" title="#{ResDB_queries} ResDB Queries" /> <img src="#{imgpath}html401.png" alt="[HTML 4.01]" title="HTML 4.01 Complient" />
				</div>
				<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>
		</div>
	#{end:footer}
#{end:page}			