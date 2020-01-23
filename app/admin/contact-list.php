<?php
/*ini_set('display_errors',1);
error_reporting(E_ALL);*/
require_once("../../elements/Global.php");
$Global=new LoadBoard();
$Global->AfterAdminloginCheck();

$Global->admin_header("LoadBoard - Dashboard");



$contactlist_stmt = $Global->db->prepare( "SELECT id,name,user_type,email FROM users WHERE  status=1");
$contactlist_stmt->execute(array());
/*$contactlist_results = $contactlist_stmt->fetchAll(PDO::FETCH_ASSOC);
$aVars=array("status"=>1 , "data" =>$contactlist_results);*/



?>


<!-- Main Content -->
<div class="page-wrapper">
    <div class="container-fluid">
        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">contact</h5>
            </div>
            <!-- Breadcrumb -->
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index-2.html">Dashboard</a></li>
                    <li><a href="#"><span>apps</span></a></li>
                    <li class="active"><span>contact list</span></li>
                </ol>
            </div>
            <!-- /Breadcrumb -->
        </div>
        <!-- /Title -->

        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="contact-list">
                                <div class="row">
                                    <aside class="col-lg-2 col-md-4 pr-0">
                                        <div class="mt-20 mb-20 ml-15 mr-15">
                                            <a class="txt-success create-label  pa-15" href="javascript:void(0)" data-toggle="modal" data-target="#myModal_1">+ Create Label</a>
                                            <!-- Modal -->
                                            <div aria-hidden="true" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title" id="myModalLabel">Add New Contact</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal form-material">
                                                                <div class="form-group">
                                                                    <div class="col-md-12 mb-20">
                                                                        <input type="text" class="form-control" placeholder="Type name">
                                                                    </div>
                                                                    <div class="col-md-12 mb-20">
                                                                        <input type="text" class="form-control" placeholder="Email">
                                                                    </div>
                                                                    <div class="col-md-12 mb-20">
                                                                        <input type="text" class="form-control" placeholder="Phone">
                                                                    </div>
                                                                    <div class="col-md-12 mb-20">
                                                                        <input type="text" class="form-control" placeholder="Designation">
                                                                    </div>
                                                                    <div class="col-md-12 mb-20">
                                                                        <input type="text" class="form-control" placeholder="Age">
                                                                    </div>
                                                                    <div class="col-md-12 mb-20">
                                                                        <input type="text" class="form-control" placeholder="Date of joining">
                                                                    </div>
                                                                    <div class="col-md-12 mb-20">
                                                                        <input type="text" class="form-control" placeholder="Salary">
                                                                    </div>
                                                                    <div class="col-md-12 mb-20">
                                                                        <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Upload Contact Image</span>
                                                                            <input type="file" class="upload">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Save</button>
                                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                            <!-- /.modal -->
                                        </div>
                                        <ul class="inbox-nav mb-30">
                                            <li class="active">
                                                <a href="#">Work <span class="label label-warning ml-10">12</span></a>
                                            </li>
                                            <li>
                                                <a href="#">design <span class="label label-danger ml-10">20</span></a>
                                            </li>
                                            <li>
                                                <a href="#">family <span class="label label-warning ml-10">2</span></a>
                                            </li>
                                            <li>
                                                <a href="#">friends<span class="label label-info ml-10">30</span></a>
                                            </li>
                                            <li>
                                                <a href="#">office <span class="label label-success ml-10">2</span></a>
                                            </li>
                                        </ul>


                                        <div id="myModal_1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h5 class="modal-title" id="myModalLabel">Add Lable</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Name of Label</label>
                                                                <input type="text" class="form-control" placeholder="Type name">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label mb-10">Select Number of people</label>
                                                                <select class="form-control">
                                                                    <option>All Contacts</option>
                                                                    <option>10</option>
                                                                    <option>20</option>
                                                                    <option>30</option>
                                                                    <option>40</option>
                                                                    <option>Custom</option>
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">Save</button>
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </aside>

                                    <aside class="col-lg-10 col-md-8 pl-0">
                                        <div class="col-lg-12  col-md-12 col-xs-12">
                                            <div class="panel panel-default card-view pa-0">
                                                <div class="panel-wrapper collapse in">
                                                    <div  class="panel-body pb-0">
                                                        <div  class="tab-struct custom-tab-1">
                                                            <ul role="tablist" class="nav nav-tabs nav-tabs-responsive" id="myTabs_8">
                                                                <li class="active" role="presentation"><a  data-toggle="tab" id="profile_tab_8" role="tab" href="#profile_8" aria-expanded="false"><span>Broker</span></a></li>
                                                                <li  role="presentation" class="next"><a aria-expanded="true"  data-toggle="tab" role="tab" id="follo_tab_8" href="#follo_8"><span>Trucker</span></a></li>

                                                            </ul>
                                                            <div class="tab-content" id="myTabContent_8">
                                                                <div  id="profile_8" class="tab-pane fade active in" role="tabpanel">
                                                                    <div class="col-lg-12">
                                                                        <div id="broker_tab"></div>
                                                                    </div>
                                                                </div>


                                                                <div  id="follo_8" class="tab-pane fade" role="tabpanel">
                                                                    <div class="row"> 
                                                                        <div class="col-md-12">
                                                                            <div class="col-lg-12">
                                                                                <div id="truck_tab"></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </aside>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->
    </div>

    <?php  
    $Global->admin_footer();
    ?>
    <script src="http://192.168.1.215:81/loadboard/app/admin/dist/js/db.js"></script>
    <script src="http://192.168.1.215:81/loadboard/app/admin/dist/js/jsgrid.min.js"></script>

    <link href="http://192.168.1.215:81/loadboard/app/admin/vendors/bower_components/jsgrid/dist/jsgrid.min.css" rel="stylesheet" type="text/css"/>
    <link href="http://192.168.1.215:81/loadboard/app/admin/vendors/bower_components/jsgrid/dist/jsgrid-theme.min.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript">
        $(document).ready(function(){

            $(function() {
                "use strict";

                /*
                var source =
                    {
                        datatype: "json",
                        datafields: [
                            { name: 'id'},
                            { name: 'name'},
                            { name: 'user_type'},
                            { name: 'email'} 
                        ],
                        url: 'http://192.168.1.215:81/loadboard/api/admin/jsgrid-data',
                        root: 'Rows',
                        beforeprocessing: function(data)
                        {		
                            source.totalrecords = data[0].TotalRows;
                        }
                    };		

                var datasource = new $.jqx.dataAdapter(source);
                $("#jqxgrid").jqxGrid(
                    {
                        width: 600,
                        source: datasource,
                        theme: theme,
                        autoheight: true,
                        pageable: true,
                        virtualmode: true,
                        rendergridrows: function()
                        {
                            return datasource.records;     
                        },
                        columns: [
                            { text: 'Id', datafield: 'id', width: 250 },
                            { text: 'Name', datafield: 'name', width: 200 },
                            { text: 'User Type', datafield: 'user_type', width: 200 },
                            { text: 'email', datafield: 'Email', width: 180 } 
                        ]
                    });*/

                $("#broker_tab").jsGrid({
                    height: "450px",
                    width: "100%", 

                    filtering: true,
                    editing: true,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    shrinkToFit: false,
                    pageSize: 15,
                    pageButtonCount: 5,

                    deleteConfirm: "Do you really want to delete the client?",

                    controller: db,

                    fields: [
                        { name: "Name", type: "text", width: 150 },
                        { name: "Age", type: "number", width: 50 },
                        { name: "Address", type: "text", width: 200 },
                        { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
                        { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
                        { type: "control" }
                    ]
                }); 

                $("#truck_tab").jsGrid({
                    height: "450px",
                    width: "100%", 

                    filtering: true,
                    editing: true,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    shrinkToFit: false,

                    pageSize: 15,
                    pageButtonCount: 5,

                    deleteConfirm: "Do you really want to delete the client?",

                    controller: db,

                    fields: [
                        { name: "Name", type: "text", width: 150 },
                        { name: "Age", type: "number", width: 50 },
                        { name: "Address", type: "text", width: 200 },
                        { name: "Country", type: "select", items: db.countries, valueField: "Id", textField: "Name" },
                        { name: "Married", type: "checkbox", title: "Is Married", sorting: false },
                        { type: "control" }
                    ]
                }); 
            });



        });

        $('#myTabs_8').click(function(){
            $("#truck_tab,#broker_tab").jsGrid("refresh");
        });
    </script>>