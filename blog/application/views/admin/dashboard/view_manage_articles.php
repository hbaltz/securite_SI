<p>&nbsp;</p>

<?php 
	if (validation_errors()):
		echo validation_errors('<div class="alert alert-danger">', ' <a class="close" data-dismiss="alert" href="#">×</a></div>');
	endif;
    
    if(isset($error)) {
    ?>
    <div class="alert alert-danger"><?php echo $error; ?><a class="close" data-dismiss="alert" href="#">×</a></div>
    <?php
    }
?>

<div class="row">
    
    <div class="span10 offset1">

        <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>

            <div class="control-group">
                <label class="control-label" for="titre">Titre de l'article</label>
                <div class="controls">
                    <input type="text" class="span8" id="titre" name="titre" value="<?php if(isset($titre)): echo $titre; else: echo set_value('titre'); endif; ?>" required />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="contenu">Contenu de l'article</label>
                <div class="controls">
                    <textarea id="contenu" class="span8 contenu-article" name="contenu" required><?php if(isset($contenu)): echo $contenu; else: echo set_value('contenu'); endif; ?></textarea>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="categorie">Catégorie</label>
                <div class="controls">
                    <?php foreach ($categories->result() as $cat): ?>
                    <label class="radio">
                        <input type="radio" name="categorie" id="<?php echo $cat->titre ;?>" value="<?php echo $cat->id ;?>" <?php if( $page == 'edit_article' and isset($categories) and $cat->id == $cat_id or set_value('categorie') == $cat->id ){ echo 'checked="checked"'; } ?> required />
                        <?php echo $cat->titre; ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label" for="image">Image de l'article</label>
                <div class="controls">
                    <?php if($page == 'edit_article') : ?>
                    <img src="<?php echo base_url('assets/uploads/270_220_' . $image); ?>" />
                    <?php endif; ?>
                    <input id="image" type="file" name="image" <?php echo ($page == 'add_article') ? 'required' : '' ?>/>
                </div>
            </div>

            <input type="submit" class="btn btn-inverse right" value="<?php if ($page == 'add_article'){ echo 'Ajouter';} else{ echo 'Modifier'; }; ?>" />
            
        </form>
    
    </div>

</div>
