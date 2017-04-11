  
  <div class="box">
    <article class="media">
        <div class="media-left">
        <figure class="image is-64x64">
            <img src="thumbnails/<?php echo $row['imgSrc']; ?>" alt="Image">
        </figure>
        </div>
        <div class="media-content">
        <div class="content">
            <p>
            <strong><?php echo $row['title']?></strong> <small><?php echo $row['date'] ?></small>
            <br>
            <?php echo $row['metDesc']; ?>
            <br>
            <small><?php echo $row['feedsrc'] ?></small>
            </p>
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