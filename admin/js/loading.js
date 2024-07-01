
//loading screen
var div_box = "<div id='load-screen'><div id='loading'></div></div>";
$("body").prepend(div_box);

$('#load-screen').delay(300).fadeOut(300, function(){
    $(this).remove();
});
