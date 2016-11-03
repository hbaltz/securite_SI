<?php $this->load->view('front/include/view_header.php'); ?>

    <div class="row"><!--Container row-->

        <?php if(validation_errors()): ?>

        <div class="span6 offset3">
            <?php echo validation_errors('<div class="alert alert-danger">', ' <a class="close" data-dismiss="alert" href="#">×</a></div>'); ?>
            </div>
        <?php endif; ?>

        <div class="span6 offset3 contact"><!--Begin page content column-->

            <h2>S'enregistrer</h2>

            <?php echo form_open(base_url('register'), array('id' => 'contact-form')); ?>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    <input class="span6" id="prependedInput" name="username" required size="16" type="text" placeholder="Nom d'utilisateur">
                </div>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-envelope"></i></span>
                    <input class="span6" id="prependedInput" name="email" required size="16" type="email" placeholder="Adresse email">
                </div>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input class="span6" id="prependedInput" name="password" required size="16" type="password" placeholder="Mot de passe">
                </div>
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    <input class="span6" id="prependedInput" name="password1" required size="16" type="password" placeholder="Confirmation Mot de passe">
                </div>
                <div class="row">
                    <div class="span2">
                        <input type="submit" class="btn btn-inverse" value="Login">
                    </div>
                </div>
            <?php echo form_close(); ?>

        </div>
    </div>



<?php $this->load->view('front/include/view_footer.php'); ?>

