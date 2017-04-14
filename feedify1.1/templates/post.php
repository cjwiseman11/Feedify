<div class="post-container box">
    <div class="columns">
        <div class="column is-3-desktop is-4-tablet ">
            <div class="media-left">
                <figure class="image is-16by9">
                    <img src="<?php echo "https://peppertech.co.uk/feedify/thumbnails/" . $row['imgSrc']; ?>" alt="Image">
                </figure>
            </div> 
        </div>
        <div class="column">
            <div class="content">
                <p><strong><a href="<?php echo $row['link']?>"><?php echo $row['title']?></a></strong></p>
                <p><?php echo $row['metDesc']; ?></p>
                <p><small><?php echo $row['feedsrc'] ?> | <?php echo $row['date'] ?> </small></p>
            </div>
        </div>
    </div>
</div>