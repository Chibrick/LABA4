function zero_first_format(value)
{
    if (value < 10)
    {
        value='0'+value;
    }
    return value;
}
function date_time()
{
    var current_datetime = new Date();
    var day = zero_first_format(current_datetime.getDate());
    var month = zero_first_format(current_datetime.getMonth()+1);
    var year = current_datetime.getFullYear();
    var hours = zero_first_format(current_datetime.getHours());
    var minutes = zero_first_format(current_datetime.getMinutes());
    var seconds = zero_first_format(current_datetime.getSeconds());

    return year+"."+month+"."+day+" "+hours+":"+minutes+":"+seconds;
}
document.getElementById('datenow').innerHTML = date_time();
setInterval(function () {
    document.getElementById('datenow').innerHTML = date_time();
}, 1000);

function LogOrReg(visual, unvisual){
    document.getElementById(visual).setAttribute("style", "display: block");
    document.getElementById(unvisual).setAttribute("style", "display: none");
}
function WorkWithNews(visual, unvisual1, unvisual2){
    document.getElementById(visual).setAttribute("style", "display: block");
    document.getElementById(unvisual1).setAttribute("style", "display: none");
    document.getElementById(unvisual2).setAttribute("style", "display: none");
}