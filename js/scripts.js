function sendRSS() {
	if($('#feedLink').val() == ""){
		$('.alert-danger').removeClass('hide');
		return false;
	}else{
		$('.alert-danger').addClass('hide');
		return true;
	}
}

//FB Share Button Click JS
$('.btnShare').click(function(){
	elem = $(this);
	postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));
	return false;
});

//Click Tracking for articles
$('.articlelink').click(function(){
	var link = $(this).attr("href");
	$.get("php/linkClickTrack.php?link=" + link);
});

//Toggle feed list in/out
$('#seefeedlist').click(function(){
   $('#feedlist').toggle(500);
});

//Save for later button
$('.save-for-later').click(function(e){
	e.preventDefault();
	var id = $(this).parent().closest('div[id]').attr("id");
	$.get("php/saveforlater.php?id=" + id);
	$(this).after("Saved");
	$(this).remove();
});

$('.remove-from-saved').click(function(e){
	e.preventDefault();
	var id = $(this).parent().closest('div[id]').attr("id");
	$.get("php/removefromsaved.php?id=" + id);
	$('#'+id).text("Removed");
});

//Random Button Logic
$('#randomify').click(function(){
    var randomLink = "";
    var oReq = new XMLHttpRequest(); //New request object
    oReq.onload = function() {
        randomLink = this.responseText; //Will alert: 42
        window.location.href = JSON.parse(randomLink);
    };
    oReq.open("get", "php/randomArticle.php", true);
    $(this).text('Loading...');
    oReq.send();
    return false;
});

//Check FirstTime Var
$(document).ready(function(){

    var firstTime = localStorage.getItem('firstTime');

    if(firstTime === 'true' || firstTime === null){
        //Close button for FirstTime
        $('#ft-close').click(function(){
            $('#first-time').hide(500);
        });
         $('#first-time').show();
         localStorage.setItem('firstTime', 'false'); //store state in localStorage
    }
    //Get "last seen" post ID
    var lastSeenPostId = localStorage.getItem('lastSeenPostId');

    //Get the latest post's ID
    var newsestPostId = $('div.article-container:first').attr("id");


    console.log("Newest Post: " + newsestPostId);

    $('div.article-container').each(function(){
        if($(this).attr("id") > lastSeenPostId && lastSeenPostId !=null) {
            $(this).addClass("new-post");
        }
    });

    localStorage.setItem('lastSeenPostId', newsestPostId);
    console.log("Last Seen Post: " + lastSeenPostId);

});
//localStorage.removeItem('firstTime'); To Remove
