#{start:module}
	#{start:main}
		<div id=#{module_id} class="Module">                  
	        <div class="TitleMid">                            
	            <div class="TitleLeft">                            
	            </div>
				#{module_type}
				<div class="TitleText">
	                #{module_title}                            
	            </div>                        
	        </div>	                      
			<div class="Box" id="#{module_container_id}" style="display:#{module_control}">
				<div class="BoxContent">
					#{module_content}
				</div>
			<div class="BoxBotLeft"><div class="BoxBotRight"></div></div>
			</div>				
	#{end:main}		
	#{start:left}	
	    <div class="TitleRight">                            
	    </div>       	
	    <div style="float:right;display:#{module_nsdisplay}" id="#{module_id_right}" #{module_collapse}></div>  
	#{end:left}	
	#{start:right}		
	    <div style="float:left;display:#{module_nsdisplay}" id="#{module_id_left}" #{module_collapse}></div> 
		<div class="TitleRight">                            
	    </div> 
	#{end:right}	
	#{start:center}		
	    <div style="float:left;display:#{module_nsdisplay}" id="#{module_id_left}" #{module_collapse}></div>  
	    <div class="TitleRight">                            
	    </div>   
	    <div style="float:right;display:#{module_nsdisplay}" id="#{module_id_right}" #{module_collapse}></div>
	#{end:center}
	#{start:top}	
		<div style="float:left;display:#{module_nsdisplay}" id="#{module_id_left}" #{module_collapse}></div>  
		<div class="TitleRight">                            
		</div>   
		<div style="float:right;display:#{module_nsdisplay}" id="#{module_id_right}" #{module_collapse}></div>
	#{end:top}	
	#{start:bottom}		
		<div style="float:left;display:#{module_nsdisplay}" id="#{module_id_left}" #{module_collapse}></div>  
		<div class="TitleRight">                            
		</div>   
		<div style="float:right;display:#{module_nsdisplay}" id="#{module_id_right}" #{module_collapse}></div>
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