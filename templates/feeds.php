	<div class="container">
	<?php
    if(!isset($_SESSION['feedifyusername'])): ?>
		<p>Oi Login!</p>
		<p>Submitting feeds and creating channels is only allowed by members</p>
  <?php else : ?>
		<script type="text/javascript" src="js/rssreaderscript.js"></script>
		<div class="submit-search-rss-section columns">
	    <div class="column submit-section <?php if($_GET['error'] == 'exists'){ echo 'has-error'; }?>">
	      <form action="statements/send_feed_channel.php" method="post" onsubmit="return sendRSS();" class="form col-sm-8">
	      <div class="field">
	        <label class="label" for="feed_link">Please input a full RSS Link including HTTP, or <a href="#search-area" id="search-area-link">use the search area</a></label>
	        <input type="text" value="<?php echo $_GET['feed']; ?>" name="feed_link" class="input" id="rssfeedsubmit" placeholder="RSS URL" required>
	        <span class='help-block' id='rssresponse-helpblock'>Valid Feed Detected! Yay!</span>
	      </div>
				<div class="field">
					<span class="select">
						<select id="channel-selector" name="channel-selector" >
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
							</optgroup>
						</select>
					</span>
				</div>
				<div class="field">
					<input type="text" name="new-channel" class="input" id="new-channel-entry" placeholder="New channel here">
					<span class='help-block' id='new-channel-message'>This channel already exists.</span>
				</div>
				<div class="field">
					<div id="private-channel-radio" class="radio">
						<p class="label">Would you like this channel to be hidden or public?</p>
						<div class="field">
							<div class="radio">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios1" value="1">
									Keep this channel hidden please
								</label>
							</div>
						</div>
						<div class="field">
							<div class="radio">
								<label>
									<input type="radio" name="optionsRadios" id="optionsRadios2" value="0" checked>
									Make the channel public, for all to see
								</label>
							</div>
						</div>
					</div>
				</div>
				<?php if($_GET['error'] == "exists"){
					echo "<div class='exists-error'><p><strong>This feed already exists in this channel</strong></p></div>";
				}?>
	      <input type="submit" class="button is-primary">
	      <div class="notification is-danger col-sm-12 hide" role="alert">
	      <p>You must submit an RSS feed.</p>
	      </div>
	      </form>
			</div>
	    <div id="search-area" class="column search">
	      <div class="field">
	        <label class="label" for="feed_link">Please input an RSS Link or a web URL:</label>
	        <input type="text" name="feed_link" class="input" id="feedLink" placeholder="RSS URL">
	      </div>
	      <div class="search-results">
	        <p>Start typing to search...</p>
	      </div>
	    </div>
		</div>
  <?php endif; ?>
  </div>