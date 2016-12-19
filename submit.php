<h2><small>Submit RSS:</small></h2>
<form action="php/send_feed_channel.php" method="post" onsubmit="return sendRSS();" class="form-inline">
<div class="form-group">
  <input type="text" name="feed_link" class="form-control" id="feedLink" placeholder="RSS URL">
</div>
<div class="form-group">
  <input type="text" name="feed_channel" class="form-control" value="<?php echo  $chan ?>" placeholder="Channel">
</div>
<input type="submit" class="btn btn-default">
<div class="alert alert-danger col-sm-12 hide" role="alert">
<p>You must submit an RSS feed.</p>
</div>
</form>
