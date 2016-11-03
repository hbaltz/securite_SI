<div class="span8 blog">
    <article>
        <h3 class="title-bg"><a href="#"><?php echo $title; ?></a></h3>
        <div class="post-content">
            <a href="#"><img src="<?php echo base_url("uploaded_files/" . $image); ?>" alt="Post Thumb"></a>

            <div class="post-body">
                <?php echo $a_content; ?>
            </div>

            <div class="post-summary-footer">
                <ul class="post-data">
                    <?php $jour  = date("d", strtotime($a_cdate)); ?>
                    <?php $mois  = date("m", strtotime($a_cdate)); ?>
                    <?php $annee = date("Y", strtotime($a_cdate)); ?>
                    <li><i class="icon-calendar"></i> <?php echo $jour . "/" . $mois . "/" . $annee; ?></li>
                    <li><i class="icon-user"></i> <a href="#"><?php echo $username; ?></a></li>
                    <li><i class="icon-comment"></i> <a href="#">5 Comments</a></li>
                    <li><i class="icon-tags"></i> <a href="<?php echo base_url($c_slug);?>"><?php echo $c_titre; ?></a></li>
                </ul>
            </div>
        </div>
        <?php foreach($comments as $comment): ?>

        <div><?php echo $comment['contenu']; ?></div>

    <?php endforeach; ?>
    </article>
</div>

