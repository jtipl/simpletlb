 <!-- Export Excel & PDF  starts here -->                
  <div id="export">
    <label><h4>Export</h4></label>
    &nbsp;:
    <label> 
      <input type="radio" name="export_page" id="export_page" checked value="1" />  Current page 
    </label>
     &nbsp;
    <label><input type="radio" name="export_page" id="export_page" value="2" /> All Pages</label>
    <span class="export_csv">
      <i class="fa fa-file-excel-o" aria-hidden="true"></i> XLS  
    </span>
    &nbsp;&nbsp;
   <!--
    <span class="export_pdf">
      <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF  
    </span>
  -->
  <?php if(strpos($_SERVER['REQUEST_URI'], "/app/trucker/view-list")!=false ){ ?>
  <button style="float: right;
    margin: 0px 10px 10px 0px;" id="clear_loads" type="submit" class="btn btn-primary"> <i class="fe fe-trash" aria-hidden="true"></i>
 Clear Loads</button> 
<?php } ?>

  </div>
    <!-- Export Excel & PDF  ends here -->  

