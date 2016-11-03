<div class="container">
    
    <div class="row">
        <div class="span12">
            <button onClick="window.location.href='<?php echo base_url('dashboard/articles/add'); ?>'" class="btn btn-inverse right">
                <i class="icon-plus icon-white"></i> Ajouter un article
            </button>
        </div>
    </div>
    
</div>

<?php if($articles->num_rows() > 0) : ?>
    
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Contenu</th>
            <th>Catégorie</th>
            <th>Date de création</th>
            <th>Mise à jour</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($articles->result() as $article) : ?>
        <tr>
            <td><?php echo $article->id; ?></td>
            <td><?php echo htmlentities($article->titre); ?></td>
            <td><?php echo htmlentities(character_limiter($article->contenu, 40)); ?></td>
            <td><?php echo htmlentities($article->ctitre); ?></td>
            <td><?php echo $article->cdate; ?></td>
            <td><?php echo $article->udate; ?></td>
            <td><a href="<?php echo base_url('dashboard/articles/edit/' . $article->id); ?>"><i class="icon-pencil"></i></a></td>
            <td><a href="<?php echo base_url('dashboard/articles/delete/' . $article->id); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cet article ?'));"><i class="icon-trash"></i></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php endif; ?>
