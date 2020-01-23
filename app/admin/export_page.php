 <!-- Export Excel & PDF  starts here -->
 <style>
.export_csv ,.export_pdf{
  cursor: pointer;
}
.export_csv{color:green;}
.export_pdf{color:red;}
h4{font-weight: bold;}
label{font-weight: normal;}
img {width:16px;height: 16px;}
 </style>                
  <div id="export">
    <label><h4>Export</h4></label>
    &nbsp;:
    <label> 
      <input type="radio" name="export_page" id="export_page" checked value="1" />  Current page 
    </label>
     &nbsp;
    <label><input type="radio" name="export_page" id="export_page" value="2" /> All Pages</label>
     &nbsp;&nbsp;
    <span class="export_csv">
      <img src="excel.jpg" title="Excel" />
      XLS  
    </span>
    &nbsp;&nbsp;
   <!--
    <span class="export_pdf">
      <i class="fa fa-file-pdf-o label label-danger" aria-hidden="true"></i> PDF  
    </span>
    -->
  </div>
    <!-- Export Excel & PDF  ends here -->  

