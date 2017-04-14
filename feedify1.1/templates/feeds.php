	<div class="container">
        <?php
    if(!isset($_SESSION['feedifyusername'])): ?>
		<p>Oi Login!</p>
		<p>Submitting feeds and creating channels is only allowed by members</p>
  <?php else : ?>
		<div id="feed-section" class="col-sm-12">
	    <h2><small>Submit Feeds and Create Channels</small></h2>
	    <p>Hello <?php echo $_SESSION['feedifyusername']; ?>, here you can create your very own channels for Feedify and submit news feeds to each one</p>
	    <p>You can choose to make your channel private, which will mean it won't appear in "All" or as a public channel</p>
	    <p>Below you can also find a list of feeds already found on the site, which you can add to your channels or a public channel if appropriate</p>
	    <hr>
	  </div>
		<div class="submit-search-rss-section col-sm-12">
	    <div class="col-sm-6 submit-section <?php if($_GET['error'] == 'exists'){ echo 'has-error'; }?>">
	      <form action="php/send_feed_channel.php" method="post" onsubmit="return sendRSS();" class="form col-sm-8">
	      <div class="form-group">
	        <label class="control-label" for="feed_link">Please input a full RSS Link including HTTP, or <a href="#search-area" id="search-area-link">use the search area</a></label>
	        <input type="text" value="<?php echo $_GET['feed']; ?>" name="feed_link" class="form-control" id="rssfeedsubmit" placeholder="RSS URL" required>
	        <span class='help-block' id='rssresponse-helpblock'>Valid Feed Detected! Yay!</span>
	      </div>
				<select name="channel-selector" id="channel-selector" class="form-control">
				  <option>Choose a channel</option>
				  <option id="create-channel">Create your own...</option>
				 	<optgroup label="Your Channels">
						<?php foreach(getMembersChannels($_SESSION['feedifyusername']) as $row){
							if($row['channame'] == $_GET['chan']){
								echo "<option selected>" . $row['channame'] . "</option>";
							} else {
								echo "<option>" . $row['channame'] . "</option>";
							}
						}?>
					</optgroup>
				 	<optgroup label="All Channels">
						<?php foreach(getChannelsList() as $row){
							if($row['channame'] == $_GET['chan']){
								echo "<option selected>" . $row['channame'] . "</option>";
							} else {
								echo "<option>" . $row['channame'] . "</option>";
							}
						}?>
					</select>
				</optgroup>
				<input type="text" name="new-channel" class="form-control" id="new-channel-entry" placeholder="New channel here">
				<span class='help-block' id='new-channel-message'>This channel already exists.</span>
				<div id="private-channel-radio" class="radio-selection">
					<br>
					<p>Would you like this channel to be hidden or public?</p>
		      <div class="radio">
		        <label>
		          <input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
		          Keep this channel hidden please
		        </label>
		      </div>
		      <div class="radio">
		        <label>
		          <input type="radio" name="optionsRadios" id="optionsRadios2" value="0" checked>
		          Make the channel public, for all to see
		        </label>
		      </div>
				</div>
				<br>
				<?php if($_GET['error'] == "exists"){
					echo "<div class='exists-error'><p><strong>This feed already exists in this channel</strong></p></div>";
				}?>
	      <input type="submit" class="btn btn-default">
	      <div class="alert alert-danger col-sm-12 hide" role="alert">
	      <p>You must submit an RSS feed.</p>
	      </div>
	      </form>
			</div>
	    <div id="search-area" class="col-sm-6 search">
	      <div class="form-group">
	        <p>Please input an RSS Link or a web URL:</p>
	        <input type="text" name="feed_link" class="form-control" id="feedLink" placeholder="RSS URL">
	      </div>
	      <div class="search-results">
	        <p>Start typing to search...</p>
	      </div>
	    </div>
		</div>
  <?php endif; ?>
  </div>