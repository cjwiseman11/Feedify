<div class="post-container box dont-break-out">
    <div class="columns">
        <div class="column is-3-desktop is-4-tablet ">
            <div class="media-left">
                <figure class="image is-16by10">
                    <a href="<?php echo "thumbnails/full/" . $row['imgSrc']; ?>"><img src="<?php echo "thumbnails/" . $row['imgSrc']; ?>" alt="Image"></a>
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