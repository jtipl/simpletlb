 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("LoadBoard - Subscription");
 ?>
 <style type="text/css">
.tiles                            {display:block; margin:0 0 30px 0; overflow:hidden;}
.tiles .button                        {color:#fff; display:block; font-weight:bold; overflow:hidden; padding:20px 10px; text-align:center;}
.tiles .button.blue                     {background:#1f497d; border:2px solid #10253f;}
.tiles .button.orange                     {background:#f79646; border:2px solid #e46c0a;}
.tiles .button.green                    {background:#9bbb59; border:2px solid #4f6228;}

.panel-group .panel                     {margin-bottom:0; border-radius:0;}
.panel-group .panel+.panel                  {margin-top:0;}
.panel-default                        {border:none;}
.panel-heading                        {padding:10px 10px; border:none; border-radius:0; }
.panel-default>.panel-heading                 { background:none; border-top:1px solid rgba(0, 40, 100, 0.20 );}
.panel-default>.panel-heading+.panel-collapse>.panel-body   {border:none;}
/*.panel-heading .accordion-toggle:after            {content:"\e114"; float:right; color:grey;}
.panel-heading .accordion-toggle.collapsed:after      {content:"\e080";}*/
.accordion-toggle{
  font-weight: normal;
}

</style>
<link rel="stylesheet" href="<?php echo SITEURL; ?>app/assets/css/card-js.min.css">
<script src="<?php echo SITEURL; ?>app/assets/js/card-js.min.js"></script> 
<div class="my-3 my-md-5">
          <div class="container">
             <div class="page-header">
      <h1 class="page-title">
        <i class="fa fa-user-circle-o"></i> Complete Order
      </h1> 
    </div>   
            <div class="row">
            <div class="col-lg-8">
              <div class="card">
                <div class="card-header">
                  <h3 class="page-title">Billing Details</h3>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" placeholder="First Name" >
                  </div>
                  <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" >
                  </div>
                  <div class="form-group">
                    <label class="form-label">Company</label>
                    <input type="text" name="Company" class="form-control" placeholder="Company" >
                  </div>
                 
                  <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control"  placeholder="Address" >
                  </div>
                   <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" name="city" class="form-control"  placeholder="City" >
                  </div>

                   <div class="form-group">
                        <label class="form-label">Postal Code</label>
                        <input type="number" class="form-control" placeholder="ZIP Code">
                      </div>

                        <div class="form-group">
                        <label class="form-label">Country</label>
                        <select class="form-control custom-select">
                          <option value="">Germany</option>
                        </select>
                      </div>
               
   <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" placeholder="Phone">
                      </div>
                
                  <div class="form-group">
                        <label class="form-label">Fax</label>
                        <input type="text" class="form-control" placeholder="Fax">
                      </div>
                
                  <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="Email">
                      </div>
                
                  
                 


                </div>
              </div>
            
              
            </div>
            
            <div class="col-lg-4">
              <form class="card">
                <div class="card-header">
                  <h3 class="page-title">Order Confirmation</h3>
                </div>

                <div class="card-body">
                  <div class="row">
       <div class="card " style="min-height: 295px;">
        <div class="card-status bg-green"></div>
                  <div class="card-body text-center">
                    <div class="card-category">Trial</div>
                    <div class="display-3 my-4">$10</div>
                    <ul class="list-unstyled leading-loose">
                      <li><strong>30</strong> Days</li>
                   
                    </ul>
                  
                  </div>
                </div>
  
                   
                   <div class="panel">
          <div id="my-card-2 " class="card-js" data-capture-name="true">
            <input class="card-number my-custom-class card_number" name="card_number">
            <input class="name card_holders_name" id="the-card-name-id" name="card_holders_name" placeholder="Name on card">
            <input class="expiry_month" name="expiry_month">
            >
            <input class="expiry_year" name="expiry_year">
            <input class="cvc" name="cvc">

          </div>
            <!-- <div class="form-group mb15">
              <input type="text" class="form-control" name="billing_address" id="billing_address" value="" placeholder="Billing Address">
              </div> -->

          <!-- <div class=" text-right  p-2" style="margin:10px 0px 0px 0px;">     
         <button type="submit" class="btn btn-primary" >Make Payment</button>
           <div class="btn-wrapper">
        </div>

      </div> -->
        </div>
                   
                
                
                
                  
               
                 
                  </div>
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Make Payment</button>
                </div>
              </form>
              
            </div>



          </div>
        </div>
      </div>
  <?php $Global->Footer(); ?>
     