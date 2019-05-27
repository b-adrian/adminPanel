<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Breadcrumbs -->
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a></li>
  <li class="breadcrumb-item"><a href="<?=base_url()?>categories">Categories</a></li>
  <li class="breadcrumb-item active">Add Category</li>
</ol>

<?php echo form_open('categories/add'); ?>
  <div class="form-group row">
    <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
  </div>
  <div class="form-group row">
    <label for="name" class="col-2 col-form-label">Category Name</label>
    <div class="col-3">
      <input class="form-control" type="text" value="" placeholder="" name="name" required=""  pattern=".{3,255}" title="3 to 255 characters">
    </div>
  </div>

  <div class="form-group row">
    <label for="parent" class="col-2 col-form-label">Parent Category</label>
    <div class="col-3">
      <select class="form-control" name="parent" required>
        <option value="0">Is Parent</option>
        <?php if(!empty($categories)):?>
          <?php foreach($categories as $item) :?>
            <option value="<?php echo $item['id']?>"><?php echo $item['name'];?></option>
          <?php endforeach;?>
        <?php endif;?>
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label for="status" class="col-2 col-form-label">Active</label>
    <div class="checkbox col-2">
      <input type="checkbox" value="1" checked="checked" name="status">
    </div>
  </div>

  <div class="form-group row">
    <div class="col-10">
      <input type="submit" value="Save" class="btn btn-primary">
    </div>
  </div>
<?php echo form_close(); ?>
