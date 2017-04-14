<div class="box">
    <article class="media">
        <div class="media-left">
        <figure class="image is-128x128">
            <img src="<?php echo "https://peppertech.co.uk/feedify/thumbnails/" . $row['imgSrc']; ?>" alt="Image">
        </figure>
        </div>
        <div class="media-content">
        <div class="content">
            <p><strong><a href="<?php echo $row['link']?>"><?php echo $row['title']?></a></strong></p>
            <p><?php echo $row['metDesc']; ?><p>
            <p><small><?php echo $row['feedsrc'] ?> | <?php echo $row['date'] ?> </small></p>
        </div>
        <nav class="level is-mobile">
            <div class="level-left">
            <a class="level-item">
                <span class="icon is-small"><i class="fa fa-reply"></i></span>
            </a>
            <a class="level-item">
                <span class="icon is-small"><i class="fa fa-retweet"></i></span>
            </a>
            <a class="level-item">
                <span class="icon is-small"><i class="fa fa-heart"></i></span>
            </a>
            </div>
        </nav>
        </div>
    </article>
</div>