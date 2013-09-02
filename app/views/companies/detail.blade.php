@extends('layouts.front')


@section('content')

<h4>{{$company['companyName']}}</h4>

<div class="row-fluid">
    <div class="span4">
        <h6>Account Holder</h6>
        <dl>
            <dt>Full Name</dt>
            <dd>{{ $company['fullname']}}</dd>

            <dt>Email</dt>
            <dd>{{ $company['username']}}</dd>

            <dt>Designation</dt>
            <dd>{{ $company['designation']}}</dd>

        </dl>
    </div>
    <div class="span4">
        <h6>Company Info</h6>
        <dl>
            <dt>Company Name</dt>
            <dd>{{ $company['companyName']}}</dd>

            <dt>Company Category</dt>
            <dd>{{ $company['mainCategory']}}</dd>

            <dt>Country (HQ)</dt>
            <dd>{{ $company['countryHQ']}}</dd>

            <dt>Website</dt>
            <dd>{{ $company['website']}}</dd>

            <dt>Email (Main)</dt>
            <dd>{{ $company['email']}}</dd>
        </dl>
    </div>
    <div class="span4">
        <h6>&nbsp;</h6>
        <dl>
            <dt>Expertise & Skills</dt>
            <dd>{{ $company['expertise']}}</dd>

            <dt>About</dt>
            <dd>{{ $company['about']}}</dd>
        </dl>
    </div>
</div>

<div class="row-fluid">
    <div class="span16">

        <div class="tabbable"> <!-- Only required for left/right tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Products</a></li>
                <li><a href="#tab2" data-toggle="tab">Offices & Showrooms</a></li>
                <li><a href="#tab3" data-toggle="tab">Distributors & Agents</a></li>
                <li><a href="#tab4" data-toggle="tab">Events</a></li>
                <li><a href="#tab5" data-toggle="tab">Projects</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <span id="add_product" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Product</span>
                    <div class="clear"></div>

                        {{ View::make('tables.frame')
                                ->with('table','prodTable')
                                ->with('class','product-table')
                                ->with('id','table-product')
                                ->with('ajaxsource',URL::to('companies/products/'.$company['_id'] ) )
                                ->with('disablesort','0,1' )
                                ->with('ajaxdel',URL::to('products/del') )
                                ->with('ajaxupdate',URL::to('companies/updateproduct') )
                                ->with('updatedialog','addProductModal' )
                                ->with('updateframe','iframeAddProduct' )
                                ->with('heads',$productheads);
                         }}
                </div>
                <div class="tab-pane" id="tab2">
                    <span id="add_office" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Office or Showroom</span>
                    <div class="clear"></div>

                        {{ View::make('tables.frame')
                                ->with('table','offTable')
                                ->with('class','office-table')
                                ->with('id','table-office')
                                ->with('ajaxsource',URL::to('companies/offices/'.$company['_id'] ) )
                                ->with('disablesort','0,1' )
                                ->with('ajaxdel',URL::to('offices/del') )
                                ->with('ajaxupdate',URL::to('companies/updateoffice') )
                                ->with('updatedialog','addOfficeModal' )
                                ->with('updateframe','iframeAddOffice' )
                                ->with('heads',$officeheads);
                         }}

                </div>
                <div class="tab-pane" id="tab3">
                    <span id="add_distributor" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Distributor or Agent</span>
                    <div class="clear"></div>

                        {{ View::make('tables.frame')
                                ->with('table','agentTable')
                                ->with('class','distributor-table')
                                ->with('id','table-distributor')
                                ->with('ajaxsource',URL::to('companies/distributors/'.$company['_id'] ) )
                                ->with('disablesort','0,1' )
                                ->with('ajaxdel',URL::to('distributors/del') )
                                ->with('ajaxupdate',URL::to('companies/updateagent') )
                                ->with('updatedialog','addDistributorModal' )
                                ->with('updateframe','iframeAddAgent' )
                                ->with('heads',$agentheads);
                         }}

                </div>

                <div class="tab-pane" id="tab4">
                    <span id="add_event" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Event</span>
                    <div class="clear"></div>

                        {{ View::make('tables.frame')
                                ->with('table','eventTable')
                                ->with('class','event-table')
                                ->with('id','table-event')
                                ->with('ajaxsource',URL::to('companies/events/'.$company['_id'] ) )
                                ->with('disablesort','0,1' )
                                ->with('ajaxdel',URL::to('events/del') )
                                ->with('ajaxupdate',URL::to('companies/updateevent') )
                                ->with('updatedialog','addEventModal' )
                                ->with('updateframe','iframeAddEvent' )
                                ->with('heads',$eventheads);
                         }}

                </div>
                <div class="tab-pane" id="tab5">
                    <span id="add_project" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Project</span>
                    <div class="clear"></div>

                        {{ View::make('tables.frame')
                                ->with('table','projectTable')
                                ->with('class','project-table')
                                ->with('id','table-project')
                                ->with('ajaxsource',URL::to('companies/projects/'.$company['_id'] ) )
                                ->with('disablesort','0,1' )
                                ->with('ajaxdel',URL::to('projects/del') )
                                ->with('ajaxupdate',URL::to('companies/updateproject') )
                                ->with('updatedialog','addProjectModal' )
                                ->with('updateframe','iframeAddProject' )
                                ->with('heads',$projectheads);
                         }}

                </div>

            </div>
        </div>

    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#add_office').on('click',function(){
            $('#addOfficeModal').modal('show');
        });

        $('#add_product').on('click',function(){
            $('#addProductModal').modal('show');
        });

        $('#add_distributor').on('click',function(){
            $('#addDistributorModal').modal('show');
        });

        $('#add_event').on('click',function(){
            $('#addEventModal').modal('show');
        });

        $('#add_project').on('click',function(){
            $('#addProjectModal').modal('show');
        });

        /*
        $('#table-product').on('click',function(ev){
            $('#productImageModal').modal('show');
        });
        */

        /* after hide */
        $('#addOfficeModal').on('hidden', function () {
            offTable.fnDraw();
        });

        $('#addProductModal').on('hidden', function () {
            prodTable.fnDraw();
        });

        $('#addDistributorModal').on('hidden', function () {
            agentTable.fnDraw();
        });

        $('#addEventModal').on('hidden', function () {
            eventTable.fnDraw();
        });

        $('#addProjectModal').on('hidden', function () {
            projectTable.fnDraw();
        });


        $('div.dataTables_length select').wrap('<div class="ingrid styled-select" />');

    });

</script>

<!-- Modal -->
<div id="addProductModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add Product</h3>
    </div>
    <div class="modal-body">
        <iframe src="{{ URL::to('companies/addproduct/'.$company['_id'] ) }}" class="dialog-frame" id="iframeAddProduct" name="iframeAddProduct"></iframe>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <button class="btn btn-primary">Save changes</button>
    </div>
</div>

<div id="addOfficeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add Office or Showroom</h3>
    </div>
    <div class="modal-body">
        <iframe src="{{ URL::to('companies/addoffice/'.$company['_id'] ) }}" class="dialog-frame" id="iframeAddOffice" name="iframeAddOffice"></iframe>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>

<div id="addDistributorModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add Distributor or Agent</h3>
    </div>
    <div class="modal-body">
        <iframe src="{{ URL::to('companies/addagent/'.$company['_id'] ) }}" class="dialog-frame" id="iframeAddAgent" name="iframeAddAgent"></iframe>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>

<div id="addEventModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add Event</h3>
    </div>
    <div class="modal-body">
        <iframe src="{{ URL::to('companies/addevent/'.$company['_id'] ) }}" class="dialog-frame" id="iframeAddEvent" name="iframeAddAgent"></iframe>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>

<div id="addProjectModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add Project</h3>
    </div>
    <div class="modal-body">
        <iframe src="{{ URL::to('companies/addproject/'.$company['_id'] ) }}" class="dialog-frame" id="iframeAddProject" name="iframeAddAgent"></iframe>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>

<div id="productImageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">View Images</h3>
    </div>
    <div class="modal-body">
        <iframe src="{{ URL::to('products/viewpics/'.$company['_id'] ) }}" class="dialog-frame" id="iframeAddAgent" name="iframeAddAgent"></iframe>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>

@stop