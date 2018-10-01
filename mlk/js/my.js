function server(DATA,callback)
{
//$.getJSON('/server.php',{DATA:json_str(DATA)},callback);

$.post('/server.php', {DATA:json_str(DATA)}, callback, "json");


}

function json_str(data)
{
 var str = "{";
 var arr = new Array();
for(index in data){
  if(typeof data[index] === "object")
  arr[arr.length] = '"' + index + '":' + json_str(data[index]);
  else
  arr[arr.length] = '"' + index + '":"' + data[index] + '"';
    }
 str += arr.join(',');
 str += "}";
 return str;
}


function form_send(form_obj,app_name,callback,ext_params)
{
  var out = new Array();


  if(form_obj)
  $.each($(form_obj).serializeArray(), function(i,data1) { out[data1.name]  = encodeURIComponent(data1.value); });

  if(ext_params)
  var out2 = $.extend(out,ext_params);
  else
  out2 = out;


  var data = {0:{"APP":app_name,"ARGS":out2}};
  server(data,callback);

}



function roundNumber(rnum, rlength) {
  var newnumber = Math.round(rnum*Math.pow(10,rlength))/Math.pow(10,rlength);
  return parseFloat(newnumber);
}


$(document).ready(function(){

Windows = new dhtmlXWindows({image_path:"codebase/imgs/",  skin:"dhx_blue"});

});



// _____________________________________________________________________________
// Преобразует число в строку формата 1_separator000_separator000._decimal
function sdf_FTS(_number,_decimal,_separator)
// сокращение переводится как Float To String
// sd_ - понятно и так почему :)
// _number - число любое, целое или дробное не важно
// _decimal - число знаков после запятой
// _separator - разделитель разрядов
{
// определяем, количество знаков после точки, по умолчанию выставляется 2 знака
var decimal=(typeof(_decimal)!='undefined')?_decimal:2;

// определяем, какой будет сепаратор [он же разделитель] между разрядами
var separator=(typeof(_separator)!='undefined')?_separator:'';

// преобразовываем входящий параметр к дробному числу, на всяк случай, если вдруг
// входящий параметр будет не корректным
var r=parseFloat(_number)

// так как в JavaScript нет функции для фиксации дробной части после точки
// то выполняем своеобразный fix
var exp10=Math.pow(10,decimal);// приводим к правильному множителю
r=Math.round(r*exp10)/exp10;// округляем до необходимого числа знаков после запятой

// преобразуем к строгому, фиксированному формату, так как в случае вывода целого числа
// нули отбрасываются не корректно, то есть целое число должно
// отображаться 1.00, а не 1
rr=Number(r).toFixed(decimal).toString().split('.');

// разделяем разряды в больших числах, если это необходимо
// то есть, 1000 превращаем 1 000
b=rr[0].replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g,"\$1"+separator);

// можно использовать r=b+'.'+rr[1], но при 0 после запятой выходит ошибка undefined,
// поэтому применяем костыль
r=(rr[1]?b+'.'+rr[1]:b);

// возвращаем результат
return r;
}


function arr_to_qstring(data)
	{	 var q_arr = Array();
        for(key in data){
         q_arr.push(key + '=' + encodeURIComponent(data[key]));
        }
        return q_arr.join('&');
	}


function get_date(ofset){	var ofset_arr,value,unit,dt = new Date(),month,day,year;

      if(ofset)
      {
      ofset_arr = ofset.split(" ");
      value = parseInt(ofset_arr[0]);
      unit  = ofset_arr[1];
      }
	              //
	if(ofset && (unit == "month" || unit == "months"))
	dt.setMonth(dt.getMonth() + value);
    if(ofset && (unit == "day" || unit == "days"))
	dt.setDate(dt.getDate() + value);
	if(ofset && (unit == "year" || unit == "years"))
	dt.setFullYear(dt.getFullYear() + value);


    month = dt.getMonth()+1;
	day = dt.getDate();
	year = dt.getFullYear();
	//var hour = dt.getHours();
	//var minute = dt.getMinutes();

	if(day < 10) day = '0' + day;
	if(month < 10) month = '0' + month;
	//if(hour < 10) hour = '0' + hour;
	//if(minute < 10) minute = '0' + minute;
	var current_date_time = day + '.' +  month + '.' + year;
	// hour + ':' + minute;

	return  current_date_time;
}


function ToMoney(_number,_decimal,_separator)
// сокращение переводится как Float To String
// sd_ - понятно и так почему :)
// _number - число любое, целое или дробное не важно
// _decimal - число знаков после запятой
// _separator - разделитель разрядов
{
// определяем, количество знаков после точки, по умолчанию выставляется 2 знака
var decimal=(typeof(_decimal)!='undefined')?_decimal:2;

// определяем, какой будет сепаратор [он же разделитель] между разрядами
var separator=(typeof(_separator)!='undefined')?_separator:'';

// преобразовываем входящий параметр к дробному числу, на всяк случай, если вдруг
// входящий параметр будет не корректным
var r=parseFloat(_number)

// так как в JavaScript нет функции для фиксации дробной части после точки
// то выполняем своеобразный fix
var exp10=Math.pow(10,decimal);// приводим к правильному множителю
r=Math.round(r*exp10)/exp10;// округляем до необходимого числа знаков после запятой

// преобразуем к строгому, фиксированному формату, так как в случае вывода целого числа
// нули отбрасываются не корректно, то есть целое число должно
// отображаться 1.00, а не 1
rr=Number(r).toFixed(decimal).toString().split('.');

// разделяем разряды в больших числах, если это необходимо
// то есть, 1000 превращаем 1 000
b=rr[0].replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g,"\$1"+separator);

// можно использовать r=b+'.'+rr[1], но при 0 после запятой выходит ошибка undefined,
// поэтому применяем костыль
r=(rr[1]?b+'.'+rr[1]:b);

// возвращаем результат
return r;
}