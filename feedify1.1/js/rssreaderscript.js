function sendRSS() {
	if($('#rssfeedsubmit').val() == ""){
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

	$('.search-results').on("click", ".result-item", function(e){
		e.preventDefault();
		$('#rssfeedsubmit').val($(e.target).text());
		$('#rssfeedsubmit').parent().addClass("has-success");
	});

		$('#feedLink').on("change keyup paste", function(){
			if(!($('#feedLink').val().length < 2)){
				$.get("php/search.php?type=rows&val=" + $('#feedLink').val(), function(response){
						if(response.length == 0){
							$.get("php/search.php?type=url&val=" + $('#feedLink').val(), function(urlresponse){
								if(urlresponse == "false"){
									$('.search-results').html("<p>We do not currently have a match for this feed.</p><p>If you enter a full URL, we can try and find it for you and add it!</p>");
								} else {
									$('.search-results').html("<a href class='rss-search'>Click here to search " + $('#feedLink').val() + " for feed</a>");
									$('.rss-search').on("click",function(e){
										e.preventDefault();
										$.get("php/search.php?type=rss&val=" + $('#feedLink').val(), function(rssresponse){
											if(!(rssresponse.length == 0)){
												$('.search-results').html(rssresponse);
											} else {
												$('.search-results').html("No Results");
											}
										});
									});
								}
							});
						} else {
							$('.search-results').html(response);
						}
				});
			} else {
				$('.search-results').html("Please type more than 1 character.");
			}
		});

		//RSS Live checker
		$('#rssfeedsubmit').on("change keyup paste", function(){
			$.get("php/search.php?type=url&val=" + $('#rssfeedsubmit').val(), function(urlresponse){
				if(!(urlresponse == "false")){
					$.get("php/rss-validator.php?val=" + $('#rssfeedsubmit').val(), function(rssresponse){
						if(rssresponse == "true"){
							$('#rssresponse-helpblock').show();
							$('#rssfeedsubmit').parent().addClass("has-success");
						} else {
							$('#rssresponse-helpblock').hide();
							$('#rssfeedsubmit').parent().removeClass("has-success");
						}
					});
				} else {
					$('#rssresponse-helpblock').hide();
					$('#rssfeedsubmit').parent().removeClass("has-success");
				}
			});
		});
		$('#rssfeedsubmit, #channel-selector').on("change", function(){
			$('.submit-section').removeClass("has-error");
			$('.exists-error').remove();
		});
		//Channel selector
		$('#channel-selector').on("change", function(){
			if ($(this).val() === 'Create your own...') {
				$('#private-channel-radio').show();
				$('#new-channel-entry').show();
				$('#new-channel-entry').focus();
				$('#new-channel-entry').attr("required", "");
			} else {
				$('#private-channel-radio').hide();
				$('#new-channel-entry').hide();
				$('#new-channel-entry').val("");
				$('#new-channel-message').hide();
				$('#new-channel-message').parent().removeClass("has-error");
				$('#new-channel-entry').removeAttr("required");
			}
		});

		//Channel live checker
		$('#new-channel-entry').on("change keyup paste", function(){
			$.get("php/search.php?type=channel&val=" + $('#new-channel-entry').val(), function(channelresponse){
				if(channelresponse == "fail"){
					$('#new-channel-message').show();
					$('#new-channel-message').parent().addClass("has-error");
				} else {
					$('#new-channel-message').hide();
					$('#new-channel-message').parent().removeClass("has-error");
				}
			});
		});

		$('#search-area-link').on("click",function(e){
			e.preventDefault();
			$('#feedLink').focus();
			$('#feedLink').select();
		});

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
