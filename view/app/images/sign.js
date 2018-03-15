var cookiepre = 'ttae_';
function getcookie(name) {
	var result = null;
    var myCookie = ""+document.cookie+";";
    var searchName = cookiepre+name+"=";
    var satrt = myCookie.indexOf(searchName);
    var end;
    if(satrt != -1){
        satrt += searchName.length;
        end = myCookie.indexOf(";",satrt);
       result = unescape(myCookie.substring(satrt,end));
    }
    return result;
}


var calendar_box = $('.calendar-main');
var day_list = calendar_box.attr('data-data_list')
if(day_list){
	var list = day_list.split(',');
	calendar.init(list)
}else{
	calendar.init([])
}
$(".sign").click(function(){
	sing_start();
	return false;
});

function sing_start(){
	var auth = getcookie('auth');
	var url = calendar_box.attr('data-url');
	$.getJSON(url,'',function(s){
		if(s.status == 'error'){
			alert(s.msg);
		}else{
			show_pop();
		}
	})
}
function show_pop(){
	$(".pop").show();
}

$(".pop-btn-confirm").click(function() {
    $(".pop").hide();
    location.href = location.href;
});



