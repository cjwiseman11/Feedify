//wait for page to load

function getParameterByName(name) {
name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	results = regex.exec(location.search);
return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function setWindowLocationSearch() {
	window.location.search = "?p=" + pageSet + '&lim=' + lim + "&chan=" + chan;
}

//Set Page QString
$(function(){
	id = getParameterByName('id');
	if(id){
		$('#feed-section').hide();
	} else {
		pageSet = getParameterByName('p');
		if(pageSet){
			newPage = parseInt(pageSet);
			newPage = newPage + 1;
			oldPage = pageSet - 1;
			lim = getParameterByName('lim');
			chan = getParameterByName('chan');

			//lim and pageset valid checking
			if(pageSet==="0" || isNaN(pageSet)){
				pageSet = "1";
				setWindowLocationSearch();
			}
			if(lim=="0" || lim=="" || isNaN(lim)){
				lim = "10";
				setWindowLocationSearch();
			}
			if(chan==""){
				chan = "all";
				setWindowLocationSearch();
			}
		}else{
			pageSet = "1";
			newPage = "2";
			lim = "10";
			chan = "all";
			//window.location = window.location + '?p=' + pageSet + '&lim=' + lim + "&chan=" + chan;
		}

		if(lim > 20) {
			lim = "20";
			setWindowLocationSearch();
		}

		$('.nxtPg').on("click", function(e){
			event.preventDefault();
			window.location.search = "?p=" + newPage + '&lim=' + lim + "&chan=" + chan;
			});

		$('.prevPg').on("click", function(e){
			event.preventDefault();
			window.location.search = "?p=" + oldPage + '&lim=' + lim + "&chan=" + chan;
			});

		$('.firstPg').on("click", function(e){
			event.preventDefault();
			window.location.search = "?p=1" + '&lim=' + lim + "&chan=" + chan;
			});

			function setLim(limNum){
				event.preventDefault();
				lim = limNum;
				setWindowLocationSearch();
			}

		$('#lim5').on("click", function(e){
			setLim("5");
		});

		$('#lim10').on("click", function(e){
			setLim("10");
		});

		$('#lim15').on("click", function(e){
			setLim("15");
		});

		$('#lim20').on("click", function(e){
			setLim("20");
		});
	}
});
