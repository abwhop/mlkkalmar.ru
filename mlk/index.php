<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Дата в прошлом
header("Content-Type: text/html; charset=utf-8");
require_once("auth.php");
//header("Location: http://calmar-net.ru");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf8">
<title>Личный кабинет</title>
<link rel="shortcut icon" href="favicon.ico"/>
<script src="js/jquery-1.11.3.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<link rel="stylesheet" type="text/css" href="codebase/dhtmlx.css"/>
<script src="codebase/dhtmlx.js"></script>
<script src="js/my.js"></script>
<style>
		html, body {
			width: 100%;
			height: 100%;
			margin: 0px;
			padding: 0px;
			overflow: hidden;
		}
	</style>
<script>
  $(document).ready(function(){


var dt = new Date();
var month = dt.getMonth()+1;
var day = dt.getDate();
var year = dt.getFullYear();
var hour = dt.getHours();
var minute = dt.getMinutes();
if(day < 10) day = '0' + day;
if(month < 10) month = '0' + month;
var current_date = day + '.' +  month + '.' + year;
var dt = new Date();
dt.setDate(dt.getDate() - 14);
var month = dt.getMonth()+1;
var day = dt.getDate();
var year = dt.getFullYear();
var hour = dt.getHours();
var minute = dt.getMinutes();
if(day < 10) day = '0' + day;
if(month < 10) month = '0' + month;
var last_week_date = day + '.' +  month + '.' + year;

			var MainSidebar = new dhtmlXSideBar({
				parent: "sidebarObj",
				icons_path: "../common/icons_material/",
				width: 185,
				items: [
					{id: "requests", text: "Поручения экпедитору", icon: "requests.png", selected: true},
					//{id: "cargo", text: "Грузы", icon: "cargo.png"},

					{type: "separator"},
					//{id: "tariffs", text: "Тарифы", icon: "tariff.png"},
					{id: "invoices", text: "Счета", icon: "invoice.png"},
					{id: "pays", text: "Платежи", icon: "pays.png"},
				//	{id: "claims", text: "Претензии", icon: "claim.png"},

					{type: "separator"},
                    {id: "claims", text: "Выход", icon: "claim.png"},
				]
			});
            var ReqToolBar = MainSidebar.cells("requests").attachToolbar();
            ReqToolBar.setIconsPath("/codebase/imgs/dhxtoolbar_skyblue/");
            ReqToolBar.getItemsValue = function(){
    		var tollbar = this;
    		var values = new Array();
		    tollbar.forEachItem(function(itemId){

		        	if(tollbar.getType(itemId) == "buttonInput")
		    		values[itemId] = tollbar.getValue(itemId);

		    		if(tollbar.getType(itemId) == "buttonTwoState")
		    		values[itemId] = tollbar.getItemState(itemId);

				});
    		return values;
			}

            ReqToolBar.item_id = 0;

            ReqToolBar.addButton("reload", (this.item_id++), '', 'reload.png', 'reload.png');

		 /*
		   ReqToolBar.addButton("edit", (item_id++), '', 'edit.png', 'edit_dis.png');
		    ReqToolBar.addButton("print", (item_id++), '', 'print.gif', 'print_dis.gif');
		    //ReqToolBar.addButton("createinvoice", (item_id++), '', 'rur.png', 'rur.png');
		    ReqToolBar.addButton("xlsexport", (item_id++), '', 'exel.png', 'exel.png');
		 */
           ReqToolBar.addSeparator("sep1", (this.item_id++));
           ReqToolBar.addText("rq_index_text", (this.item_id++), "Маркировка груза или номер поручения:");
           ReqToolBar.addInput("rq_index",(this.item_id++),"",30);
           ReqToolBar.addText("contragent_name_text", (this.item_id++), "Контрагент:");
           ReqToolBar.addInput("contragent_name",(this.item_id++),"",110);


           	ReqToolBar.addText("start_period_text", (this.item_id++), "Период с");
			ReqToolBar.addInput("start_period",(this.item_id++),last_week_date,55);
			ReqToolBar.addText("end_period_text", (this.item_id++), "по");
			ReqToolBar.addInput("end_period",(this.item_id++),current_date,55);
            ReqToolBar.addSeparator("sep1", (this.item_id++));
   			ReqToolBar.addButtonTwoState("t+", (this.item_id++),"<span style='color:#FF0000;font-weight:bold;'>Т</span>", "", null);
			ReqToolBar.setItemState("t+", true);
            ReqToolBar.addButtonTwoState("t-", (this.item_id++),"<span style='color:#00FFFF;font-weight:bold;'>Х</span>", "", null);
			ReqToolBar.setItemState("t-", true);

            ReqToolBar.attachEvent("onEnter", function(id, value){
			  		ReqTable.ReqTableReload();
				});

			ReqToolBar.attachEvent("onStateChange", function(id, state){
			 	ReqTable.ReqTableReload();
			});
            ReqToolBar.attachEvent("onClick", function(id) {            	switch(id){            		case "reload": ReqTable.ReqTableReload(); break;            	}            });
            var ReqTable = MainSidebar.cells("requests").attachGrid();

            ReqTable.ReqTableReload = function (action,target_id){
     				var args = ReqToolBar.getItemsValue();
        			var table = this;
        			server({"APP":"show_requests_lk","ARGS":args},function(data){                  		if(data){
			       				ReqTable.clearAll();
			    				ReqTable.parse(data[0]["RESULTS"],"json");
			    				ReqTable.sumColumn();
			    				ReqTable.markCells();
    							}
                     });
            }
             ReqTable.sumColumn = function(){
		    	var table = this;
		    	var weight = 0;
		        var volume = 0;
		        var tariff = 0;
		        var quantity = 0;
		          var i = 0;
		    	  table.forEachRow(function(id){
						quantity+=parseInt(table.cells(id,9).getValue());
						weight+= parseFloat(table.cells(id,10).getValue());
						volume+= parseFloat(table.cells(id,11).getValue());
						tariff+= parseFloat(table.cells(id,12).getValue());
						//obj.cells(id,13).setValue(i++);
						i++;
					});
		             document.getElementById("rq").innerHTML = i;
		             document.getElementById("quantity").innerHTML = quantity;
					 document.getElementById("weight").innerHTML = weight;
					 document.getElementById("volume").innerHTML = volume;
		             document.getElementById("tariff").innerHTML = sdf_FTS(tariff,2," ");
		    }

			ReqTable.markCells = function(){
                   var table = this;
			 table.forEachRow(function(row_id){
                						//ReqTable.cells(row_id,3).setBgColor(dest_colors[ReqTable.cells(row_id,3).getValue()]);

                                      // if(ReqTable.cells(row_id,2).getValue() == 'Склад')
									//	     ReqTable.cells(row_id,2).setBgColor('#D8D8D8');
									//	else
									//		ReqTable.cells(row_id,2).setBgColor('#CEFFE7');

                                     //  if(ReqTable.getUserData(row_id,"day_flag") == '1')
									//	     ReqTable.cells(row_id,1).setBgColor('#FF80FF');


									//	if(ReqTable.getUserData(row_id,"payd") == '1')
									//	     ReqTable.cells(row_id,13).setBgColor('#00FF40');
									//	else if(ReqTable.getUserData(row_id,"payd") == '2')
                                     //         ReqTable.cells(row_id,13).setBgColor('#7DBEFF');

                                        if(ReqTable.getUserData(row_id,"strg_cond_id") == '1')
										     ReqTable.cells(row_id,8).setBgColor('#A4FFFF');
										else if(ReqTable.getUserData(row_id,"strg_cond_id") == '2')
                                              ReqTable.cells(row_id,8).setBgColor('#FFB0B0');

                                        if(ReqTable.getUserData(row_id,"speed") == '1')
										     ReqTable.cells(row_id,0).setBgColor('#A0FEAC');
										else if(ReqTable.getUserData(row_id,"speed") == '2')
                                              ReqTable.cells(row_id,0).setBgColor('#DCBABA');
                                        //else if(ReqTable.getUserData(row_id,"speed") == '3')
                                        //      ReqTable.cells(row_id,0).setBgColor('#DCBABA');
                                       //if(ReqTable.cells(row_id,3).getValue() == 'пассажирская')
                                       // ReqTable.cells(row_id,3).setBgColor('#A0FEAC');
                                       //else if(ReqTable.cells(row_id,3).getValue() == 'грузовая')
                                       //     ReqTable.cells(row_id,3).setBgColor('#DCBABA');

                						//if(ReqTable.cells(row_id,4).getValue() == 'тепло')
                                       // ReqTable.cells(row_id,4).setBgColor('#FFB0B0');
                                       // if(ReqTable.cells(row_id,4).getValue() == 'холод')
                                       // ReqTable.cells(row_id,4).setBgColor('#A4FFFF');
								    });


	     }


            ReqTable.setHeader("ID,Дата,Отправлен,Направлние,Плательщик,Отправитель,Получатель,Наименовение,#,Мест,Вес,Объем,Стоимость,Счет");
		    ReqTable.setInitWidths("50,80,80,100,110,*,*,90,30,50,50,55,75,45");
		    ReqTable.setColAlign("ceter,center,center,left,left,left,left,left,left,center,center,center,center,center");
		    ReqTable.setColTypes("ron,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ro,ron,ro");
		    ReqTable.setColSorting("int,str,str,str,str,str,str,str,str,str,str,str,int,int");
		    ReqTable.setNumberFormat("0,000.00",12,"."," ");
		    ReqTable.setColumnIds("rq_id,rq_date,location_name,dest_name,contragent_payer,contragent_sender,contragent_reciver,cargo_name,rq_index,cargo_quantity,cargo_weigth,cargo_volume,sum_pay,doc_num");
		    ReqTable.init();
		    ReqTable.attachFooter(["<div id='rq'>E</div>","#cspan","#cspan","#cspan","#cspan","#cspan","#cspan","#cspan","#cspan","<div id='quantity'>E</div>","<div id='weight'>E</div>","<div id='volume'>F</div>","<div id='tariff'>G</div>","#cspan"]);
            ReqTable.ReqTableReload();



});
</script>


</head>

<body>

 <div id="sidebarObj" style="width: 185; height:100%;"></div>

</body>

</html>