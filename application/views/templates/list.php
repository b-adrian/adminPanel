<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo base_url()?>">Dashboard</a></li>
  <li class="breadcrumb-item"><?php echo ucfirst(controller())?></li>
  <li class="breadcrumb-item active">List</li>
</ol>
<div class="card mb-3">
    <div class="card-header">
      <i class="fa fa-table"></i> <?php echo ucfirst(controller())?> <a href="<?php echo base_url().controller()?>/add"><button class="btn btn-primary">+</button></a>
    </div>
    <div class="card-block">
        <div class="table-responsive">
          <table class="table table-bordered js-datatable" width="100%" cellspacing="0" data-base-url="<?php echo base_url().controller()?>">
              <thead>
                <tr>
                  <th>ID</th>
                  <?php foreach($dtFields as $field):?>
                  	<th><?php echo $field?></th>
                	<?php endforeach;?>
                  <th>Actions</th>
                </tr>
              </thead>

          </table>
        </div>
    </div>
</div>