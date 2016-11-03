<div class="span8 blog">

    <?php if($articles->num_rows() > 0): ?>

        <?php if($page == 'categorie') : ?>
                <div class="page-header">
                    <h2 class="text-center"><?php echo $title; ?></h2>
                </div>
        <?php endif; ?>

        <?php foreach($articles->result() as $article): ?>

            <article class="clearfix">
                <a href="<?php echo base_url($article->cslug . '/' . $article->aslug); ?>"><img src="<?php echo base_url('get_uploaded_picture/' . $article->image); ?>" alt="Post Thumb" class="align-left article-image"></a>
                <h4 class="title-bg"><a href="<?php echo base_url($article->cslug . '/' . $article->aslug); ?>"><?php echo htmlentities($article->titre); ?></a></h4>
                <p><?php echo htmlentities(character_limiter($article->contenu, 450)); ?> <a href="<?php echo base_url($article->cslug) . '/' . $article->aslug; ?>">[More]</a></p>
                    <div class="post-summary-footer">
                        <ul class="post-data-3">
                            <?php $jour  = date("d", strtotime($article->cdate)); ?>
                            <?php $mois  = date("m", strtotime($article->cdate)); ?>
                            <?php $annee = date("Y", strtotime($article->cdate)); ?>
                            <li><i class="icon-calendar"></i> <?php echo $jour . "/" . $mois . "/" . $annee; ?></li>
                            <li><i class="icon-user"></i> <a href="#"><?php echo htmlentities($article->username); ?></a></li>
                            <li><i class="icon-comment"></i> <a href="#">5 Comments</a></li>
                            <li><i class="icon-tags"></i> <a href="<?php echo base_url($article->cslug); ?>"><?php echo htmlentities($article->ctitre); ?></a></li>
                        </ul>
                    </div>
            </article>

        <?php endforeach; ?>

        <?php echo $pagination; ?>

    <?php else: ?>
        <p>Aucun article n'est disponible pour le moment</p>
    <?php endif; ?>

</div>
