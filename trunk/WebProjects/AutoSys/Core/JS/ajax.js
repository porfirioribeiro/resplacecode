
var QuickSearch = {
    validateSubmit: function(){
        var form = $("QuickSearchForm").form;
        var canGo = true;
        if (!form.Make.selectedIndex > 0) {
            canGo = false;
            $("QuickSearchForm.Make.error").setVisible(!canGo);
        }
        return canGo;
    },
    getModels: function(){
        var form = $("QuickSearchForm").form;
		$A(form.Model.options).each(function(opt){
			$(opt).remove();
		});
        /*for (var i = 0; i < form.Model.options.length; i++) {
            $(form.Model.options[i]).remove();
        }*/
        if (form.Make.selectedIndex > 0) {
            new Ajax.Request(Site.path + 'srv.php', {
                method: 'post',
                parameters: "?fn=getModels&model=" + form.Make.value,
                onSuccess: function(transport){
                    var json = transport.responseText.evalJSON();
                    if (Object.isArray(json)) {
                        for (j = 0; j < json.length; j++) {
                            form.Model.appendChild(new Option(json[j], json[j]));
                        }
						form.Model.selectedIndex=0;
                    }
                }
            });
            form.Model.disabled = false;
        }
        else {
        	
            form.Model.disabled = true;
        }
    }
};
