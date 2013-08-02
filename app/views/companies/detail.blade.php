@extends('layouts.front')


@section('content')

<h4>{{$company['companyName']}}</h4>

<div class="row">
    <div class="span6">
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
    <div class="span6">
        <dl>
            <dt>Expertise & Skills</dt>
            <dd>{{ $company['expertise']}}</dd>

            <dt>About</dt>
            <dd>{{ $company['about']}}</dd>
        </dl>
    </div>
</div>

<div class="row">

    <div class="span6">


        <div class="accordion" id="accordionLeft">
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionLeft" href="#collapseOneLeft">
                 <h5>Offices & Showrooms</h5>
              </a>
            </div>
            <div id="collapseOneLeft" class="accordion-body collapse in">
              <div class="accordion-inner">
                <span id="add_office" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Office or Showroom</span>
                <div class="clear"></div>
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Website</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionLeft" href="#collapseTwoLeft">
                <h5>Distributors & Agents</h5>
              </a>
            </div>
            <div id="collapseTwoLeft" class="accordion-body collapse">
              <div class="accordion-inner">
                <span id="add_distributor" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Distributor or Agent</span>
                <div class="clear"></div>
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Website</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

    </div>
    <div class="span6">

        <div class="accordion" id="accordionRight">
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionRight" href="#collapseOneRight">
                 <h5>Events</h5>
              </a>
            </div>
            <div id="collapseOneRight" class="accordion-body collapse">
              <div class="accordion-inner">
                <span id="add_event" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Event</span>
                <div class="clear"></div>
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Website</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="accordion-group">
            <div class="accordion-heading">
              <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionRight" href="#collapseTwoRight">
                <h5>Projects</h5>
              </a>
            </div>
            <div id="collapseTwoRight" class="accordion-body collapse">
              <div class="accordion-inner">
                <span id="add_project" class="add-btn btn pull-right"><i class="icon-plus-sign"></i> Add Project</span>
                <div class="clear"></div>
                <table class="table dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Country</th>
                            <th>Website</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


    </div>
</div>

{{ View::make('companies.products')
            ->with('ajaxsource',URL::to('products') )
            ->with('disablesort','0,1' )
            ->with('ajaxdel',URL::to('products/del') )
            ->with('heads',$heads);
 }}


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

        $('.dataTable .products').dataTable({
            'bProcessing': true,
            'bServerSide': true,
            'sAjaxSource': '{{ URL::to('products') }}',
            'sDom': 'Tpit',

        });

        //$('div.dataTables_length select').wrap('<div class="ingrid styled-select" />');

    });

</script>

<!-- Modal -->
<div id="addOfficeModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Office or Showroom</h3>
  </div>
  <div class="modal-body">

   </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>

<div id="addDistributorModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Distributor or Agent</h3>
  </div>
  <div class="modal-body">

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>

<div id="addProductModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add Product</h3>
  </div>
  <div class="modal-body">

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary">Save changes</button>
  </div>
</div>


@stop