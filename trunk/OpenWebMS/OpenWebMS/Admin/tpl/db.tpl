#{start:dbList}
	#{start:addDB}
	<div>/#{category} <img onclick="$('DB_CATEGORY_#{category}').toggle();" alt="Add Database" title="Add Database" border="0" style="vertical-align:middle;cursor:pointer;" src="icons/add.png"></div>
	<form action="index.php" id="DB_CATEGORY_#{category}" style="display: none;margin: 0px 0px 0px 10px;">
		<input type="hidden" name="manage" value="db">
		<input type="hidden" name="action" value="addDB">
		<input type="hidden" name="category" value="#{category}">
		<img alt="Cancel" title="Cancel" src="icons/button_cancel.png" style="cursor: pointer;" onclick="$('DB_CATEGORY_#{category}').hide();return false;">
		<input type="text" name="db" size="10" title="The name of the database" style="height: 13px;">
		<input type="checkbox" name="tabled" title="Check this if you want that the created Database becames a Tabled Database">
		<img alt="Submit" title="Create the database" src="icons/button_ok.png" style="cursor: pointer;" onclick="$('DB_CATEGORY_#{category}').submit();">
	</form>	
	#{end:addDB}
#{end:dbList}