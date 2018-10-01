	
		<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Логистика</title>
<link rel="shortcut icon" href="/favicon.ico"/>
<script src="/js/jquery-1.11.3.js"></script>
<link rel="stylesheet" type="text/css" href="/skins/skyblue/dhtmlx.css"/>
<link href="/jsmodules/dist/jsoneditor.min.css" rel="stylesheet" type="text/css">
<!--<script src="/jsmodules/dist/jsoneditor.min.js"></script>-->
<script src="/jsmodules/src-min_/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
var item_id;

  $(document).keydown(function(e) {

    var key = undefined;
    var possible = [ e.key, e.keyIdentifier, e.keyCode, e.which ];

    while (key === undefined && possible.length > 0)
    {
        key = possible.pop();
    }

    if (key && (key == '115' || key == '83' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
    {
			        e.preventDefault();
			      //  alert("Ctrl-s pressed");
      
			    //  console.log(editor.getValue(),"Ctr+S");
			      
			save();
			      
			     

			        return false;
    }
    if (key && (key == '112' || key == '80' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
    {
		        e.preventDefault();

		         if(active_win && active_win.print) {
		       active_win.print();
		      console.log(active_win,"Ctr+P");
		      }  else {

		       var print_obj = contentBlock.getAttachedObject();
		           print_obj.print();

		      }


		        return false;
    }

     if (key && (key == '105' || key == '73' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
    {
			        e.preventDefault();
			      alert("Ctrl-I pressed");



			        return false;
    }
 /*    if (key && (key == '113' || key == '81' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
    {
			        e.preventDefault();
			       if(active_win && active_win.close) {
		       active_win.close();
		      console.log(active_win,"Ctr+Q");
		      }


			        return false;
    }


    if (key && (key == '111' || key == '79' ) && (e.ctrlKey || e.metaKey) && !(e.altKey))
    {
			        e.preventDefault();
			       if(active_win && active_win.close) {
		       active_win.OpenItem();
		      console.log(active_win,"Ctr+O");
		      } else {

		       var open_obj = contentBlock.getAttachedObject();
		           open_obj.OpenItem();

		      }


			        return false;
    }
    
 */   
     if (key && key == '27')
    {
			        e.preventDefault();
                   if(active_win && active_win.close) {
		       active_win.close();
		      console.log(active_win,"ESC");
		      }
			       return false;
	}

	//if (key && key == '13')
    //{
	//		        e.preventDefault();

         //   if(active_win && active_win.enter) {
		   //    active_win.enter();
		  //     return false;
		   //   		      }
		     // 		      console.log(active_win,"Enter");
			      //

	//		      return true;
	//}

    return true;
});
</script>
<script src="/codebase/dhtmlx.js"></script>
<script src="/MydhtmlxGrid.js"></script>
<script src="/MydhtmlXForm.js"></script>
<script src="/MydhtmlXToolbarObject.js"></script>
<script src="/MydhtmlXWindows.js"></script>
<script src="/MydhtmlXList.js"></script>
<style>
html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			background-color: #ebebeb;
			overflow: hidden;
		}
		
		.icon_tree_application {
			background-image: url(/common/dhxtoolbar/application21818.png);
		}
				
		.icon_tree_module {
		background-image: url(/common/dhxtoolbar/module1818.png);
		}
		
</style> 
<body>


<script>
var  mainInterface = new dhtmlXLayoutObject({parent: document.body,pattern: "2U",cells: [{id: "a", text: "dhtmlxTreeView"}]});
	    		var MenuBlock = mainInterface.cells("a");
	            	MenuBlock.setWidth(200);
	            	MenuBlock.hideHeader();
	            
	            contentBlock = mainInterface.cells("b");
            contentBlock.hideHeader();
	            
/*


 var list = MenuBlock.attachList({
            	template:"<span><b>#item_name#</b> (#inn#)</span><br><span style='font: 8pt sans-serif;'>#post_address#</span>",
				type:{ height:"auto" }
				});
            
				
				
	 list.Myload("/application/list",{});
	 
*/


var tree = MenuBlock.attachTreeView({json: "/application/tree"});	 
	
	/* 
	 list.attachEvent("onItemClick", function (id, ev, html){
				  var list_item = this.get(id);
				  
				  item_id = list_item.item_id;
				
			
			fetch("/application/get_app_code?item_id=" + item_id)
			.then(function(response) {  
                                if(response.status != 200){                                     
                                    response.text().then((data)=>{ 	dhtmlx.message({ type: "error",  text: data});  console.log(data); });
                               	}
                    
                        		return response.json();
        	})
            .then(function(data) {
            	
            	editor.setValue("");
            	
            	if(data.code)
	        		editor.setValue(data.code);
	        	else
	        		editor.setValue("");
	        			
	        			
	        			
	        			toolbar.setListOptionSelected("code_type", data.code_type);
     					editor.session.setMode({path:"ace/mode/" + data.code_type, inline:true}); 
           })
                       
           .catch(function (error) {  
                        console.log('Request failed', error);
                        	dhtmlx.message({ type: "error",  text: error.toString()});  
           });
			
			
			
			
			
			
			
			
			
			
			
			

				    return true;
				});
	 */
	 
	 tree.attachEvent("onSelect",function(id,mode)
					     {

					 item_id = id;

                           if(mode) {
                           	
                      fetch("/application/get_app_code?item_id=" + id)
			.then(function(response) {  
                                if(response.status != 200){                                     
                                    response.text().then((data)=>{ 	dhtmlx.message({ type: "error",  text: data});  console.log(data); });
                               	}
                    
                        		return response.json();
        	})
            .then(function(data) {
            	
            	editor.setValue("");
            	
            	if(data.code)
	        		editor.setValue(data.code);
	        	else
	        		editor.setValue("");
	        			
	        			
	        			
	        			toolbar.setListOptionSelected("code_type", data.code_type);
     					editor.session.setMode({path:"ace/mode/" + data.code_type, inline:true}); 
           })
                       
           .catch(function (error) {  
                        console.log('Request failed', error);
                        	dhtmlx.message({ type: "error",  text: error.toString()});  
           });   	
                           	
                           	
							}
		
	});
	 
	 
	 
	 
	 var toolbar  = contentBlock.attachToolbar();
			
			toolbar.setIconsPath("common/dhxtoolbar/");
			
			toolbar.loadStruct([
					{
	id:      "save",
	type:    "button",
	img:     "save.gif",
	imgdis:  "save_dis.gif",
	text:    "Save",
	title:   "Tooltip here"
	
},
				
				{id: "code_type",	type: "buttonSelect",text:"<span  style=\"color:#2fd52b;font-weight: bold;\">Javascript</span>",title: "Tooltip here",
				width:        100,
	mode:         "select",		
	width:        70,	
	maxOpen:      5,	

	options: [
			{	id: "php",type: "button",text:    "<span  style=\"color:#0a27f3;font-weight: bold;\">PHP</span>"},
			{	id: "javascript",type: "button",text:    "<span  style=\"color:#2fd52b;font-weight: bold;\">Javascript</span>"}
			]
	
	
	
		}			
				
				
			]);
	toolbar.setWidth("code_type", 80);		
	toolbar.attachEvent("onClick", function(id){
    console.log(id);
	
	if(id == "php" || id == "javascript")
	editor.session.setMode({path:"ace/mode/" + id, inline:true});
	
	if(id == "save") 	save(); 
	
		
		});		
			
			
			
			
	 var container = document.createElement("div");
	 container.setAttribute("style","width: 100%; height:100%");
	 contentBlock.attachObject(container);
	 
	
    var editor = ace.edit(container,{
   // mode: "ace/mode/php",
    selectionStyle: "text"
});
    editor.setTheme("ace/theme/xcode");
    //editor.session.setMode("ace/mode/php");
    
    //editor.session.setMode("ace/mode/javascript");
	editor.session.setMode({path:"ace/mode/php", inline:true}); 
	
	function save(){
		
		
		       window.dhx.ajax.post("/application/set_app_code","item_id=" + item_id + "&app_code=" + encodeURIComponent(editor.getValue()) + "&code_type=" + toolbar.getListOptionSelected("code_type"), function(data){
	        			
	        			
	        			var data_json = window.dhx.s2j(data.xmlDoc.responseText);
	        			
	        			if(data_json.status) 
	        					dhtmlx.message({ text: data_json.info});
						else 
							    dhtmlx.message({ type: "error", text: data_json.info});
					
			
			});
		
		
		
	}
	
	
	 			            
	
</script>	
</body>
</html>