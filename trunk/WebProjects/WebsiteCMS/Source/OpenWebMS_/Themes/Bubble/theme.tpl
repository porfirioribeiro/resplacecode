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
				#{iif:GlobalLogo,<img src="#{GlobalLogoPath}" border="0" />,<div class="TitleImage alpha" title="My Website Name"></div>}
				</div>
				<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>
		</div>
	#{end:title}	
	#{start:content}	
		<div style="#{display_modulestop}; padding-left:2px;padding-right:2px;">
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
		<div style="#{display_modulesbottom}; padding-left:2px;padding-right:2px;">
			#{write_modulesbottom}
		</div>	
	#{end:content}
	#{start:footer}
	<div align="center">
		<div> 
					<div style="padding-bottom:5px; padding-top:10px"><b>powered by <a href="http://resplace.net/OpenWebMS/" title="Module based PHP web site management system">OpenWebMS</a></b><br />Copyright &copy; resplace.net</div>
					<img src="#{imgpath}gen_php.png" alt="[DB]" title="Generated in #{WebMS_load} sec/s" /> <img src="#{imgpath}gen_resdb.png" alt="[DB]" title="#{ResDB_queries} ResDB Queries" /> <img src="#{imgpath}html401.png" alt="[HTML 4.01]" title="HTML 4.01 Complient" />
		</div>
	</div>
	#{end:footer}
#{end:page}			