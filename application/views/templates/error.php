<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="<?=base_url()?>categories">Categories</a></li>
  <li class="breadcrumb-item active">Add Category</li>
</ol>

<div class="alert alert-danger">
  <?php echo $error;?>
</div>