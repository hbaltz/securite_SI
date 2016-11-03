<?php $this->load->view('front/include/view_header.php'); ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?> <a class="close" data-dismiss="alert" href="#">×</a>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('error'); ?> <a class="close" data-dismiss="alert" href="#">×</a>
    </div>
<?php endif; ?>

<h2>Administration <?php echo (isset($adminPage)) ? ' - ' . $adminPage : ''; ?></h2>

<div class="container">
    
    <div class="row">
        <div class="span12">
            <?php switch ($page) {
                case 'home':
                    $this->load->view('admin/dashboard/view_dashboard_home');
                    break;
                                
                case 'articles':
                    $this->load->view('admin/dashboard/view_listing_articles');
                    break;

                case 'add_article':
                case 'edit_article':
                    $this->load->view('admin/dashboard/view_manage_articles');
                    break;

                case 'categories':
                    $this->load->view('admin/dashboard/view_listing_categories');
                    break;

                case 'add_category':
                case 'edit_category':
                    $this->load->view('admin/dashboard/view_manage_categories');
                    break;

                default:
                    break;
            }
            ?>
        </div>
    </div>
</div>

<?php $this->load->view('front/include/view_footer.php'); ?>