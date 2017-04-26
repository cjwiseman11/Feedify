//Save for later button
$('.save-for-later').click(function(e){
	e.preventDefault();
	var id = $(this).parent().closest('div[id]').attr("id");
	$.get("statements/saveforlater.php?id=" + id);
	$(this).after("Saved");
	$(this).remove();
});

$('.remove-from-saved').click(function(e){
	e.preventDefault();
	var id = $(this).parent().closest('div[id]').attr("id");
	$.get("statements/removefromsaved.php?id=" + id);
	$('#'+id).text("Removed");
});

$(document).ready(function(){

	$('.search-results').on("click", ".result-item", function(e){
		e.preventDefault();
		$('#rssfeedsubmit').val($(e.target).text());
		$('#rssfeedsubmit').parent().addClass("has-success");
	});

		$('#feedLink').on("change keyup paste", function(){
			if(!($('#feedLink').val().length < 2)){
				$.get("statements/search.php?type=rows&val=" + $('#feedLink').val(), function(response){
						if(response.length == 0){
							$.get("statements/search.php?type=url&val=" + $('#feedLink').val(), function(urlresponse){
								if(urlresponse == "false"){
									$('.search-results').html("<p>We do not currently have a match for this feed.</p><p>If you enter a full URL, we can try and find it for you and add it!</p>");
								} else {
									$('.search-results').html("<a href class='rss-search'>Click here to search " + $('#feedLink').val() + " for feed</a>");
									$('.rss-search').on("click",function(e){
										e.preventDefault();
										$.get("statements/search.php?type=rss&val=" + $('#feedLink').val(), function(rssresponse){
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
			$.get("statements/search.php?type=url&val=" + $('#rssfeedsubmit').val(), function(urlresponse){
				if(!(urlresponse == "false")){
					$.get("statements/rss-validator.php?val=" + $('#rssfeedsubmit').val(), function(rssresponse){
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
			$.get("statements/search.php?type=channel&val=" + $('#new-channel-entry').val(), function(channelresponse){
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
