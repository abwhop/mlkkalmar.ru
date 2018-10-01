define(['jquery','mydhtmlx','mymqtt','localforage.min'],function ($,mydhtmlx,mymqtt,localforage) {
      return function(callback){

	var store = localforage.createInstance();
		store.config({driver: localforage.INDEXEDDB,name: 'logistic',version: 1.0,size: 4980736,storeName: "auth",description : 'some description'});

		store.getItem('token', function (err, token) {
             //  console.log(value);

			 $.post( "/login", { token: token},function(data){

                if(data.status == "success")
                     	callback();
                else
                  		login_form();

	        }, "json");




		});




 function login_form(){



    $( window ).resize(toCenter);
 	var login_page = $("<div id=\"login_page\" style=\"width: 100%;height: 100%;margin: 0px;overflow: hidden;background: url(logo.png) repeat;\"></div>");
	var login_block = $("<div id=\"login_block\" style=\"width: 335px;height: 175px;margin: 5px;overflow: hidden;border: 1px solid #ADADAD;position: absolute;display: none;background-color: #F5F5F5;\"></div>");

	login_page.append(login_block);
	$("body").append(login_page);


		function toCenter(){

			var win_width = $( window ).width();
			var win_height = $( window ).height();
			var block_width = login_block.width();
			var block_height = login_block.height();

		    login_block.css({ top: (win_height/2 - block_height/2 ), left: ( win_width/2 - block_width/2 )});

		    login_block.show(100);

			//console.log(win_width,win_height,block_width,block_height);

		}

	var myForm = new dhtmlXForm("login_block",[
				{type: "settings", position: "label-left", labelWidth: 110, inputWidth: 140},
				{type: "fieldset", label: "Авторизация", inputWidth: 324, offsetLeft:5 , list:[
				{type: "input", label: "Имя пользователя:", name:"username", value: ""},
				{type: "password", label: "Пароль:", value: "",name:"userpass"},
				{type: "checkbox", label: "Запомнить меня:", checked: false},
				{type: "button", value: "Войти"}
				]}

				]
				);
	myForm.setItemFocus("username");
	function form_send (){
		this.send("/login", function(loader, response){
			var resp = JSON.parse(response);

			console.log(resp);

			if(resp !== null)
			if(resp.status == "success"){
				login_page.remove();
				store.setItem('token', resp.token);
				 callback();
						} else {

                   dhtmlx.alert({
								title:"Ошибка",
								type:"alert-error",
								text:"Не верные имя пользователя или  пароль!"
							});
						}

					});
			}
    myForm.attachEvent("onButtonClick", form_send);
	myForm.attachEvent("onEnter", form_send);
	toCenter();


 }



       };
});