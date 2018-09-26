$('table.demo1').floatThead({
	position: 'fixed',
	scrollingTop:65
});

window.setTimeout(function() {
    $("#card-alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);