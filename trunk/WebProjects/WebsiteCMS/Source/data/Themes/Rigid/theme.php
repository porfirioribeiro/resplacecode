<?php
//theme path is already known!!
//$tpath=$this->themespath."Rigid-Blue/";
//echo $this->themespath.$this->selectedskin;
$tpath=$this->themespath.$this->selectedskin;
//include("module.php");
$this->addCSS($tpath."style.css");
$this->addPreloadImg(array(
	$tpath."Images/collapse.png",
	$tpath."Images/collapse_over.png",
	$tpath."Images/minimize_left.png",
	$tpath."Images/minimize_left_over.png",
	$tpath."Images/minimize_right.png",
	$tpath."Images/minimize_right_over.png"
));

//Module Templates
$this->module_main=new Template("
		<div id=#{module_id} class=\"Module\">                  
            <div class=\"TitleMid\">                            
                <div class=\"TitleLeft\">                            
                </div>
				#{module_type}
				<div class=\"TitleText\">
                    #{module_title}                            
                </div>                        
            </div> 			                      
            <div class=\"BoxContent\" id=\"#{module_container_id}\" style=\"display:#{module_control}\">");
			
$this->module_left=new Template("    
	                <div class=\"TitleRight\">                            
	                </div>       	
	                <div style=\"float:right;display:#{module_nsdisplay}\" id=\"#{module_id_right}\" #{module_collapse}></div>  
");

$this->module_right=new Template("  	
	                <div style=\"float:left;display:#{module_nsdisplay}\" id=\"#{module_id_left}\" #{module_collapse}></div> 
					<div class=\"TitleRight\">                            
	                </div> 
");

$this->module_center=new Template("  	
	                <div style=\"float:left;display:#{module_nsdisplay}\" id=\"#{module_id_left}\" #{module_collapse}></div>  
	                <div class=\"TitleRight\">                            
	                </div>   
	                <div style=\"float:right;display:#{module_nsdisplay}\" id=\"#{module_id_right}\" #{module_collapse}></div>
");

$this->module_top=new Template("  	
	                <div style=\"float:left;display:#{module_nsdisplay}\" id=\"#{module_id_left}\" #{module_collapse}></div>  
	                <div class=\"TitleRight\">                            
	                </div>   
	                <div style=\"float:right;display:#{module_nsdisplay}\" id=\"#{module_id_right}\" #{module_collapse}></div>
");

$this->module_bottom=new Template("  	
	                <div style=\"float:left;display:#{module_nsdisplay}\" id=\"#{module_id_left}\" #{module_collapse}></div>  
	                <div class=\"TitleRight\">                            
	                </div>   
	                <div style=\"float:right;display:#{module_nsdisplay}\" id=\"#{module_id_right}\" #{module_collapse}></div>
");

//Now we setup all the template material
$this->page_title=new Template("
		<div class=\"MainMid\">                
            <div class=\"MainLeft\">                
            </div>                
            <div class=\"MainRight\">                
            </div>
			<div align=\"center\">
			<div class=\"TitleImage\"></div>
			</div>
        </div>");
		
$this->page_content=new Template("
		<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" >                
            <tr>
            	<td colspan=\"3\" style=\"#{display_modulestop}\">
            	#{write_modulestop}           	
            	</td>
            </tr>
            <tr>           
            	<td id=\"LeftColumn\" style=\"#{display_modulesleft}\">  
            	#{write_modulesleft}
            	</td>        
            	<td id=\"CenterColumn\" style=\"#{display_modulescenter}\">
            	#{write_modulescenter}
            	</td>	
            	<td id=\"RightColumn\" style=\"#{display_modulesright}\">
            	#{write_modulesright}
            	</td>	              
            </tr>
			<tr>				
				<td colspan=\"3\" style=\"#{display_modulesbottom}\">
            	#{write_modulesbottom} 
				</td>				
			</tr>           
        </table>
		");
		
?>
