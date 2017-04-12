<div class="container">
    <nav class="pagination is-right"> 
        <a href="?p=<?php echo $page-1; ?>" class="pagination-previous"<?php if($page < 2) :?>disabled<?php endif; ?>>Previous</a>
        <a href="?p=<?php echo $page+1; ?>" class="pagination-next">Next</a>
        <ul class="pagination-list">
        <li>
        <a class="pagination-link is-current">Page <?php echo $page ?></a>
        </li>
    </ul>
    </nav>
</div>
