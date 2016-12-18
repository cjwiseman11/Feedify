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

//Login click
$('.login-btn').on("click", function(){
	//$('#member-login > form').toggleClass('hidden-sm hidden-xs');
	//	$(this).text($('#member-login > form').hasClass("hidden-sm") ? "Login" : "Close");
	if($('#member-login > form').css('display') == 'none'){
		$('.login-btn').text("Close");
		$('#member-login > form').show();
	} else if($('#member-login > form').css('display') == 'block'){
		$('.login-btn').text("Log in");
		$('#member-login > form').hide();
	}
	//$('#member-login > form').slideToggle(300);
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

//For your feeds page
$('.show-feedlists').on("click", function(e){
	e.preventDefault();
	if($('.member-feedlist').hasClass('hidden')){
		$('.member-feedlist').removeClass('hidden');
	} else {
				$('.member-feedlist').addClass('hidden');
	}
});


//localStorage.removeItem('firstTime'); To Remove
