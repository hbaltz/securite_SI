<div class="span4 sidebar">

    <section>
        <div class="input-append">
            <form action="<?php echo base_url('search'); ?>" method="GET">
                <input id="appendedInputButton" size="16" type="text" name="terms" placeholder="Rechercher">
                <button class="btn" type="submit"><i class="icon-search"></i></button>
            </form>
        </div>
    </section>


    <h5 class="title-bg">A propos</h5>
	<p>Lorem ipsum Eiusmod irure sint Ut magna incididunt ut esse eu enim consequat et mollit cupidatat irure veniam laborum veniam dolore amet in et aliqua deserunt occaecat laborum proident Ut officia sunt laboris laborum adipisicing reprehenderit anim proident quis.</p>
    
    <br />
    
	<?php if($categories->num_rows > 0): ?>

        <h5 class="title-bg">Categories (<?php echo $categories->num_rows(); ?>)</h5>
        <ul class="post-category-list">
        <?php foreach ($categories->result() as $categorie): ?>
            <li><a href="<?php echo base_url($categorie->slug); ?>" <?php if ($this->uri->segment(1) == $categorie->slug): echo 'title="Categorie actuelle"'; endif; ?>><i class="icon-plus-sign"></i><?php echo $categorie->titre; ?></a></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</div>
