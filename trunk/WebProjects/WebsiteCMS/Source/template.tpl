#{start:module}
	#{start:default}
	    <!-- 
      This is the module default template, will be used everywhere if no other specified
      Here you have the following vars
      #{id} the modue id, its used for JavaScript and other Stuff, its a unique id
      #{cookie} this is a string wish contains the cookie name for collapse
      #{collapsed} true or falce if the mdule is colapsed or expanded, use iif with it eg <div style="display:#{iif:collapsed,none,block};">
      #{title} the title of the module
      #{content} the content of the module...
      -->		
	#{end:default}		
	#{start:left}	
    <!--
    It uses the same vars as :default
    only use this if you want to overide the default template on left collumn modules
    -->
	#{end:left}	
	#{start:right}	
    <!--
    It uses the same vars as :default
    only use this if you want to overide the default template on right collumn modules
    -->       		
	#{end:right}	
	#{start:center}		
    <!--
    It uses the same vars as :default
    only use this if you want to overide the default template on center collumn modules
    -->
	#{end:center}
	#{start:top}	
    <!--
    It uses the same vars as :default
    only use this if you want to overide the default template on top modules
    -->
	#{end:top}	
	#{start:bottom}	
    <!--
    It uses the same vars as :default
    only use this if you want to overide the default template on bottom modules
    -->			
	#{end:bottom}	
#{end:module}

#{start:page}	
	#{start:title}	
    <!--
    The header of the page, no var's yet
    -->
	#{end:title}	
	#{start:content}	
	  <!--
    The content of the page
    You can use the following vars
    #{display_modulestop}|
    #{display_modulesleft}|
    #{display_modulescenter}|
    #{display_modulesright}|
    #{display_modulesbottom}> Css shortcut 'none' or '' if that collumns are visible or not
    #{write_modulestop}|  
    #{write_modulesleft}|
    #{write_modulescenter}|
    #{write_modulesright}|
    #{write_modulesbottom}> the actualy content of the collums
    --> 
	#{end:content}	
#{end:page}			
