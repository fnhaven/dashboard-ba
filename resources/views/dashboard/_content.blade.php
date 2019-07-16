@extends('template')

@section('title', $title)

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">
            Dashboard
            </h1>
        </div>
        <div class="row row-cards">
            <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="text-right text-green">
                    6%
                    <i class="fe fe-chevron-up"></i>
                </div>
                <div class="h1 m-0">43</div>
                <div class="text-muted mb-4">New Tickets</div>
                </div>
            </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="text-right text-red">
                    -3%
                    <i class="fe fe-chevron-down"></i>
                </div>
                <div class="h1 m-0">17</div>
                <div class="text-muted mb-4">Closed Today</div>
                </div>
            </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="text-right text-green">
                    9%
                    <i class="fe fe-chevron-up"></i>
                </div>
                <div class="h1 m-0">7</div>
                <div class="text-muted mb-4">New Replies</div>
                </div>
            </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="text-right text-green">
                    3%
                    <i class="fe fe-chevron-up"></i>
                </div>
                <div class="h1 m-0">27.3K</div>
                <div class="text-muted mb-4">Followers</div>
                </div>
            </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="text-right text-red">
                    -2%
                    <i class="fe fe-chevron-down"></i>
                </div>
                <div class="h1 m-0">$95</div>
                <div class="text-muted mb-4">Daily Earnings</div>
                </div>
            </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="text-right text-red">
                    -1%
                    <i class="fe fe-chevron-down"></i>
                </div>
                <div class="h1 m-0">621</div>
                <div class="text-muted mb-4">Products</div>
                </div>
            </div>
            </div>
            <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Invoices</h3>
                      </div>
                      <div class="table-responsive">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="DataTables_Table_0"></label></div><table class="table card-table table-vcenter text-nowrap datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                          <thead>
                            <tr role="row"><th class="w-1 sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="No.: activate to sort column descending" style="width: 45px;">No.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Invoice Subject: activate to sort column ascending" style="width: 171px;">Invoice Subject</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Client: activate to sort column ascending" style="width: 130px;">Client</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="VAT No.: activate to sort column ascending" style="width: 81px;">VAT No.</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Created: activate to sort column ascending" style="width: 103px;">Created</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 146px;">Status</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Price: activate to sort column ascending" style="width: 54px;">Price</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 175px;"></th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label=": activate to sort column ascending" style="width: 29px;"></th></tr>
                          </thead>
                          <tbody>
                          <tr role="row" class="odd">
                              <td class="sorting_1"><span class="text-muted">001401</span></td>
                              <td><a href="invoice.html" class="text-inherit">Design Works</a></td>
                              <td>
                                Carlson Limited
                              </td>
                              <td>
                                87956621
                              </td>
                              <td>
                                15 Dec 2017
                              </td>
                              <td>
                                <span class="status-icon bg-success"></span> Paid
                              </td>
                              <td>$887</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="even">
                              <td class="sorting_1"><span class="text-muted">001402</span></td>
                              <td><a href="invoice.html" class="text-inherit">UX Wireframes</a></td>
                              <td>
                                Adobe
                              </td>
                              <td>
                                87956421
                              </td>
                              <td>
                                12 Apr 2017
                              </td>
                              <td>
                                <span class="status-icon bg-warning"></span> Pending
                              </td>
                              <td>$1200</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="odd">
                              <td class="sorting_1"><span class="text-muted">001403</span></td>
                              <td><a href="invoice.html" class="text-inherit">New Dashboard</a></td>
                              <td>
                                Bluewolf
                              </td>
                              <td>
                                87952621
                              </td>
                              <td>
                                23 Oct 2017
                              </td>
                              <td>
                                <span class="status-icon bg-warning"></span> Pending
                              </td>
                              <td>$534</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="even">
                              <td class="sorting_1"><span class="text-muted">001404</span></td>
                              <td><a href="invoice.html" class="text-inherit">Landing Page</a></td>
                              <td>
                                Salesforce
                              </td>
                              <td>
                                87953421
                              </td>
                              <td>
                                2 Sep 2017
                              </td>
                              <td>
                                <span class="status-icon bg-secondary"></span> Due in 2 Weeks
                              </td>
                              <td>$1500</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="odd">
                              <td class="sorting_1"><span class="text-muted">001405</span></td>
                              <td><a href="invoice.html" class="text-inherit">Marketing Templates</a></td>
                              <td>
                                Printic
                              </td>
                              <td>
                                87956621
                              </td>
                              <td>
                                29 Jan 2018
                              </td>
                              <td>
                                <span class="status-icon bg-danger"></span> Paid Today
                              </td>
                              <td>$648</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="even">
                              <td class="sorting_1"><span class="text-muted">001406</span></td>
                              <td><a href="invoice.html" class="text-inherit">Sales Presentation</a></td>
                              <td>
                                Tabdaq
                              </td>
                              <td>
                                87956621
                              </td>
                              <td>
                                4 Feb 2018
                              </td>
                              <td>
                                <span class="status-icon bg-secondary"></span> Due in 3 Weeks
                              </td>
                              <td>$300</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="odd">
                              <td class="sorting_1"><span class="text-muted">001407</span></td>
                              <td><a href="invoice.html" class="text-inherit">Logo &amp; Print</a></td>
                              <td>
                                Apple
                              </td>
                              <td>
                                87956621
                              </td>
                              <td>
                                22 Mar 2018
                              </td>
                              <td>
                                <span class="status-icon bg-success"></span> Paid Today
                              </td>
                              <td>$2500</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="even">
                              <td class="sorting_1"><span class="text-muted">001408</span></td>
                              <td><a href="invoice.html" class="text-inherit">Icons</a></td>
                              <td>
                                Tookapic
                              </td>
                              <td>
                                87956621
                              </td>
                              <td>
                                13 May 2018
                              </td>
                              <td>
                                <span class="status-icon bg-success"></span> Paid Today
                              </td>
                              <td>$940</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="odd">
                              <td class="sorting_1"><span class="text-muted">001409</span></td>
                              <td><a href="invoice.html" class="text-inherit">Design Works</a></td>
                              <td>
                                Carlson Limited
                              </td>
                              <td>
                                87956621
                              </td>
                              <td>
                                15 Dec 2017
                              </td>
                              <td>
                                <span class="status-icon bg-success"></span> Paid
                              </td>
                              <td>$887</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr><tr role="row" class="even">
                              <td class="sorting_1"><span class="text-muted">001410</span></td>
                              <td><a href="invoice.html" class="text-inherit">UX Wireframes</a></td>
                              <td>
                                Adobe
                              </td>
                              <td>
                                87956421
                              </td>
                              <td>
                                12 Apr 2017
                              </td>
                              <td>
                                <span class="status-icon bg-warning"></span> Pending
                              </td>
                              <td>$1200</td>
                              <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-secondary btn-sm">Manage</a>
                                <div class="dropdown">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Actions</button>
                                </div>
                              </td>
                              <td>
                                <a class="icon" href="javascript:void(0)">
                                  <i class="fe fe-edit"></i>
                                </a>
                              </td>
                            </tr></tbody>
                        </table><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">Showing 1 to 10 of 16 entries</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous">Previous</a><span><a class="paginate_button current" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">1</a><a class="paginate_button " aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0">2</a></span><a class="paginate_button next" aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0" id="DataTables_Table_0_next">Next</a></div></div>
                        <script>
                          require(['datatables', 'jquery'], function(datatable, $) {
                                  $('.datatable').DataTable();
                                });
                        </script>
                      </div>
                    </div>
                  </div>
        </div>
    </div>
</div>
@endsection