<p>&nbsp;</p>

<?php 
	if (validation_errors()):
		echo validation_errors('<div class="alert alert-danger">', ' <a class="close" data-dismiss="alert" href="#">×</a></div>');
	endif;
?>

<div class="row">
    
    <div class="span10 offset1">

        <?php echo form_open(current_url(), array('class' => 'form-horizontal')); ?>

            <div class="control-group">
                <label class="control-label" for="titre">Titre</label>
                <div class="controls">
                    <input type="text" class="span8" id="titre" name="titre" value="<?php if(isset($titre)): echo $titre; else: echo set_value('titre'); endif; ?>" required />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="description">Description</label>
                <div class="controls">
                    <textarea id="description" class="span8 description-categorie" name="description" required><?php if(isset($description)): echo $description; else: echo set_value('description'); endif; ?></textarea>
                </div>
            </div>

            <input type="submit" class="btn btn-inverse right" value="<?php if ($page == 'add_category'){ echo 'Ajouter';} else{ echo 'Modifier'; }; ?>" />
            
        </form>
    
    </div>

</div>