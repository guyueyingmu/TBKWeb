function leftMove(){
    var choose_sel = document.getElementById("choose_sel");

    var taobaoSelect = $(".select_cates").eq(0);
    var parentValue = taobaoSelect.val();
    var taobaoSubSelect = $(".select_cates_sub select").eq(0);
    var val = taobaoSubSelect.val();
    var txt = taobaoSelect.find("option:selected").text();
    if(val){
        remove(choose_sel,parentValue);
        txt = taobaoSubSelect.find("option:selected").text();
    }else {
        val= parentValue;
    }

    var t_type = "";
    var options = choose_sel.options;
    for(var i=0;i<options.length;i++){
        if(options[i].value == val){
            return;
        }
        t_type+=options[i].value+",";
    }

    $('#choose_sel').append("<option value="+val+" ondblclick='delLeft()' selected='selected'>"+txt+"</option>");
    t_type+=val;
    $("#t_type").val(t_type);

    console.log(t_type);
}
function delLeft(){
    var obj = document.getElementById("choose_sel");
    var index = obj.selectedIndex;
    $("#choose_sel>option").eq(index).remove();

    var t_type = "";
    var options = obj.options;
    for(var i=0;i<options.length;i++){
        if(i != 0){
            t_type+=",";
        }
        t_type+=options[i].value;
    }
    $("#t_type").val(t_type);
    console.log(t_type);
}

function clean(){

    $("#choose_sel>option").each(function(){
        $(this).remove();
    });
    $("#t_type").val("");
}
function  contains(obj_sel,v){
    var options = obj_sel.options;
    for(var i=0;i<options.length;i++){
        if(options[i].value == v){
            return true;
        }
    }
    return false;
}

function  remove(obj_sel,v){
    var options = obj_sel.options;
    for(var i=0;i<options.length;i++){
        if(options[i].value == v){
            options.remove(options[i])
            break
        }
    }
    return false;
}