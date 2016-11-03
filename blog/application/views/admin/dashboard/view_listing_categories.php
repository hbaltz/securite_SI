<div class="container">
    
    <div class="row">
        <div class="span12">
            <button onClick="window.location.href='<?php echo base_url('dashboard/categories/add'); ?>'" class="btn btn-inverse right">
                <i class="icon-plus icon-white"></i> Ajouter une catégorie
            </button>
        </div>
    </div>
    
</div>

<?php if($categories->num_rows() > 0) : ?>
    
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Description</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach($categories->result() as $category) : ?>
        <tr>
            <td><?php echo $category->id; ?></td>
            <td><?php echo $category->titre; ?></td>
            <td><?php echo $category->description; ?></td>
            <td><a href="<?php echo base_url('dashboard/categories/edit/' . $category->id); ?>"><i class="icon-pencil"></i></a></td>
            <td><a href="<?php echo base_url('dashboard/categories/delete/' . $category->id); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer cette catégorie ?'));"><i class="icon-trash"></i></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php endif; ?>
