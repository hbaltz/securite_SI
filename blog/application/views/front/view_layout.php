<?php $this->load->view('front/include/view_header.php'); ?>

<div class="container">
    
    <div class="row">
		<div class="col-md-8">
            <?php
            switch($page) :
                case 'home':
                case 'categorie':
                    $this->load->view('front/view_listing.php');
                    break;
                
                case 'content':
                    $this->load->view('front/view_content.php');
                    break;
                
                case 'search':
                    $this->load->view('front/view_search.php');
                    break;
                
                default:
                    break;
            endswitch;
            ?>
        </div>

		<?php $this->load->view('front/include/view_sidebar.php'); ?>

	</div>
</div>

<?php $this->load->view('front/include/view_footer.php'); ?>