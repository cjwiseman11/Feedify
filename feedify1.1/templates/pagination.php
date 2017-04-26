<div class="container">
    <nav class="pagination is-centered"> 
        <a href="?p=<?php echo $page-1; ?>&lim=<?php echo $lim;?>&chan=<?php echo $chan;?>" class="pagination-previous"<?php if($page < 2) :?>disabled<?php endif; ?>>Previous</a>
        <a href="?p=<?php echo $page+1; ?>&lim=<?php echo $lim;?>&chan=<?php echo $chan;?>" class="pagination-next">Next</a>
        <ul class="pagination-list">
        <li>
        <span class="pagination-link">Page <?php echo $page ?></span>
        </li>
    </ul>
    </nav>
</div>
