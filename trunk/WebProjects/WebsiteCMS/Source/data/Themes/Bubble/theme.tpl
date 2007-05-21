#{start:module}
	#{start:main}
		<div id=#{module_id} class="Module">                  
			#{module_header}         
			<div class="Box" id="#{module_id_container}" style="display:#{module_display}">
				<div class="BoxContent">
					#{module_content}
				</div>
			<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>	
		</div> 			
	#{end:main}		
	#{start:left}	
        <div class="TitleMid">                            
	        <div class="TitleLeft"></div>
		    <div class="TitleRight"></div>       	
		    <div style="float:right" id="#{module_id_right}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div>  
			<div class="TitleText">#{module_title}</div>                        
        </div>	
	#{end:left}	
	#{start:right}	
        <div class="TitleMid">                            
            <div class="TitleLeft"></div>	
		    <div style="float:left;" id="#{module_id_left}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div> 
			<div class="TitleRight"></div> 
			<div class="TitleText">#{module_title}</div>                        
        </div>			
	#{end:right}	
	#{start:center}		
        <div class="TitleMid">                            
            <div class="TitleLeft"></div>
		    <div style="float:left;" id="#{module_id_left}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div>  
		    <div class="TitleRight"></div>   
		    <div style="float:right;" id="#{module_id_right}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div>
			<div class="TitleText">#{module_title}</div>                        
        </div>	
	#{end:center}
	#{start:top}	
        <div class="TitleMid">                            
            <div class="TitleLeft"></div>
			<div style="float:left;" id="#{module_id_left}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div>  
			<div class="TitleRight"></div>   
			<div style="float:right;" id="#{module_id_right}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div>
			<div class="TitleText">#{module_title}</div>                        
        </div>	
	#{end:top}	
	#{start:bottom}		
        <div class="TitleMid">                            
            <div class="TitleLeft"></div>
			<div style="float:left;" id="#{module_id_left}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div>  
			<div class="TitleRight"></div>   
			<div style="float:right;" id="#{module_id_right}" class="SmallIcon #{iif:module_collapsed,CollapseIcon,UnCollapseIcon}" onmouseover="collapseOverOut('#{module_id}',this,true)" onmouseout="collapseOverOut('#{module_id}',this,false)" onclick="collapseToogle('#{module_id}',this)"></div>
			<div class="TitleText">#{module_title}</div>                        
        </div>				
	#{end:bottom}	
#{end:module}

#{start:page}	
	#{start:title}	
		<div class="MainMid"> 
			<div class="Box">                
				<div class="TopLeft"><div class="TopRight"></div></div>                
				
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
#{end:page}			