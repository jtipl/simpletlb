 <?php 
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterloginCheck();
$Global->Header("LoadBoard - In Progress Trips");

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
                                          <h3 class="card-title" style="float: left; position: absolute;left: 20px; top: 20px;"> In-Progress Trips</h3>

                     <table id="proviewloads" class="table pag table-hover card-table table-vcenter text-nowrap " cellspacing="0" width="100%">
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
<div class="modal fade " id="por_upcom_status"  tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-header bg-dark">
        <h5 class="modal-title h2" id="mySmallModalLabel">Status Change</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">         
        </button>
      </div>
    <div class="modal-body text-center">
     <div class="avatar avatar-lime avatar-xxl my-2   animated headShake  ">
     <i class="fe fe-package"  ></i>
     </div>
        <h2 class="text-cyan ">Load Delivered</h2>
        <p>Are you sure you want to change Status <strong>Load Delivered?</strong></p>       
        </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary pro_tripca">Save changes</button>      </div>
    
    </div>
  </div>
</div>


<script type="text/javascript">
  var tripvar=0;
  $(document).ready(function(){
    var pickedtable= $('#proviewloads').DataTable({
         language: { search: "",searchPlaceholder: "Search for..." , "emptyTable": "No records found"},
          "ajax": {
            url: LoadBoard.API+"trucker/inprogress-trips"
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

             if(row.suggest_price==0)
                return "$"+row.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
              else
                return  "$"+row.suggest_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
              

                }
      },
        {
        targets: 7,
        render: function (data,type,row) {
                 return '<a href="javascript:void(0)" class="btn btn-success btn-sm pro_trip_pick" data-tr="'+window.btoa(row.tripid)+'"  >Set status as Delivered</a>';

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

     $( document ).on("click", ".pro_trip_pick", function(){
        tripvar=$(this).attr("data-tr");
        $("#por_upcom_status").modal("show");
    });

       $(document).on("click",".pro_tripca",function(){
             $(".pro_tripca").attr("disabled", true);
           $.ajax({
              type: 'post',
              url: LoadBoard.API+'trucker/trip-delivered',
              dataType: "json",
              data: {
                "tripid": window.atob(tripvar),
                "token":LoadBoard.token
              },
            success: function (result) {
             $(".pro_tripca").attr("disabled", false);
              if(result.status==1){
                toastr.success(result.msg); 
                $("#por_upcom_status").modal("hide");
                pickedtable.ajax.reload();
              }else if(result.status==2){
                 window.location.href = LoadBoard.APP+'logout';                   
            }
        }
        
        });       });


  });



 
</script>
