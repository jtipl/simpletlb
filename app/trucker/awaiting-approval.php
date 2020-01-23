 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("SimpleTLB - Awaiting Loads");

 ?>
        <div class="my-3 my-md-5">
          <div class="container">
			
 <div class="page-header">
          <h1 class="page-title">
<!--                 <i class="fe fe-rotate-ccw mr-2"></i> Awaiting Approval
 -->                <i class="fe fe-truck"></i> My Loads
              </h1>              
            </div> 
			
			
			  <div class="row  animated fadeIn">	  			  			                
              <div class="col-12 accordion"  id="accordionExample">
                <div class="card ">              
                  <div class="table-responsive"> 
                                          <h3 class="card-title" style="float: left; position: absolute;left: 20px; top: 20px;"> Awaiting Approval</h3>

                     <table id="awa_viewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th></th>
                            <th>Load-Id</th>
                            <th>Origin</th>
                            <th>Destination</th>
                            <th>Weight</th>
                            <th>Length</th>
                            <th>Price</th>
                            <th>Action</th>
                           
                        </tr>
                    </thead>
                </table>     
                  </div>
                </div>           
              </div>
			   </div>
            </div>
        </div>
      </div>
     
    
    


<!-- Modal -->


<?php $Global->Footer(); ?>

    
    
<!-- Modal -->
<div class="modal fade" id="load" tabindex="-1" role="dialog" aria-labelledby="load" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">   
	<div class="  text-center"><button type="button" class="close px-xl-3" data-dismiss="modal" aria-label="Close">
        </button>
        <img class=" " src="<?php echo SITEURL; ?>app/assets/images/load.jpg" alt="Your Load">
      </div>
      <div class="modal-body">      
       <div class="row">
          <div class="col-sm-12 col-md-12 text-center">
		    <h1 class="display-4 my-4">This load is yours!</h1>	
<h3 class="">			
<label class="load_origin ">Houston, TX </label> <i class="fa fa-long-arrow-right" data-toggle="tooltip" title="" data-original-title="fa fa-long-arrow-right"></i> <label class="load_destination "> Richmond, VA</label>			
</h3>		
		<p class=" text-center ">
			 Your trip is confirmed. You can find all the details in "My Loads" section
			</p>
<button type="button" class="btn btn-success">Go to My Loads</button>			
		   </div>	
       </div>  
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
     $('#awa_viewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for..." },
          "ajax": {
            url: LoadBoard.API+"trucker/awaiting-loads"
          },
            "bLengthChange": false, 
            "type": "POST",
            "processing": true,
            "serverSide": true,
            "bInfo": false,
              //"order": [[ 0, "desc" ]],
              "columns": [
                {"data": "id"},
                {"data": "load_id"},
                {"data": "origin"},
                {"data": "destination"},
                {"data": "weight"},
                {"data": "length"},
                {"data": "price" },
                {"data": "tripstatus" },
               
                
            ],
    columnDefs: [/*{
       targets: 4,
       render: function (data,type,row) {
                    if (data.status==1) {
                      return '<span class="label label-success">Active</span>';
                    } else {
                      return '<span class="status-icon bg-green"></span>Open';
                    }                    
                }
      },*/
       {
        targets: 2,
        render: function (data,type,row) {
               var orgt=row.origin.split(",");
               return orgt[0]+", "+orgt[1];

                }
      },
       {
        targets: 3,
        render: function (data,type,row) {
                 var dest=row.destination.split(",");
               return dest[0]+", "+dest[1];

                }
      },
       {
        targets: 6,
        render: function (data,type,row) {
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

                }
      },
        {
        targets: 7,
        render: function (data,type,row) {
                return '<a href="javascript:void(0)" onclick="mapcancel(\'' + window.btoa(row.id) + '\',\'' + window.btoa(row.tripid) + '\')"  class="btn btn-secondary text-danger btn-sm"> Cancel Load</a>';

                }
      },
       {
        targets: 0,
        render: function (data,type,row) {
       return '<a class="icon search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" ><i class="fe fe-external-link"></i></a>';

                }
      },
       {
        targets: 1,
        render: function (data,type,row) {
       return '<a class="search_modals" href="javascript:void(0)"  onclick="mapmodal(\'' + window.btoa(row.id) + '\')" >'+row.load_id+'</a>';

                }
      }



      
      

     
    ],

        }); 
  });

 
</script>
