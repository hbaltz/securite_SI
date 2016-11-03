<div class="span8">
    <h3 class="title-bg">Résultats pour <?php echo $terms; ?></h3>
    
    <?php if($terms != '' AND $articles->num_rows() > 0) : ?>
        <?php foreach($articles->result() as $article) : ?>
            
            <article class="clearfix">
                <h4 class="title-bg"><a href="<?php echo base_url($article->cslug . '/' . $article->aslug); ?>"><?php echo htmlentities($article->titre); ?></a></h4>
            </article>
    
        <?php endforeach; ?>

    <?php else: ?>
        <p>Aucun résultat.</p>
    <?php endif ?>
    
</div>
