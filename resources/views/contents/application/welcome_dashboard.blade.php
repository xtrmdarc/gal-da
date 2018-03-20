@extends('layouts.application.master')

@section('content')

        <!-- Page wrapper  -->
<div class="page-wrapper">
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Dashboard</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary p-20">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-bag f-s-40"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2 class="color-white">278</h2>
                            <p class="m-b-0">New Posts</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-pink p-20">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-comment f-s-40"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2 class="color-white">278</h2>
                            <p class="m-b-0">New Comment</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success p-20">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-vector f-s-40"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2 class="color-white">$27647</h2>
                            <p class="m-b-0">Bounce Rate</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger p-20">
                    <div class="media widget-ten">
                        <div class="media-left meida media-middle">
                            <span><i class="ti-location-pin f-s-40"></i></span>
                        </div>
                        <div class="media-body media-text-right">
                            <h2 class="color-white">278</h2>
                            <p class="m-b-0">Total Visitor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-title">
                        <h4>Sales</h4>
                    </div>
                    <div class="sales-chart">
                        <div class="ct-bar-chart" style="height:350px"></div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
            <!-- /# column -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-title">
                        <h4>Visitor in Device</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead>
                                <tr>
                                    <th>Device</th>
                                    <th>Visits</th>
                                    <th>Avg. time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Unknown</td>
                                    <td>2,456</td>
                                    <td>00:02:36</td>
                                </tr>
                                <tr>
                                    <td>Apple iPad</td>
                                    <td>1,006</td>
                                    <td>00:03:41</td>
                                </tr>
                                <tr>
                                    <td>Apple iPhone</td>
                                    <td>68</td>
                                    <td>00:04:10</td>
                                </tr>
                                <tr>
                                    <td>HTC Desire</td>
                                    <td>38</td>
                                    <td>00:01:40</td>
                                </tr>
                                <tr>
                                    <td>Samsung</td>
                                    <td>20</td>
                                    <td>00:04:54</td>
                                </tr>
                                <tr>
                                    <td>Apple iPad</td>
                                    <td>1,006</td>
                                    <td>00:03:41</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card nestable-cart">
                    <div class="card-title">
                        <h4>World Map</h4>

                    </div>
                    <div class="datamap">
                        <div id="world-datamap"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Visitor</h4>
                        <div class="ct-svg-chart" style="height:420px"></div>
                    </div>
                </div>
            </div>
            <!-- /# column -->
        </div>
        <!-- /# row -->

        <div class="row">

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4>Project</h4>
                    </div>
                    <div class="card-body">
                        <div class="current-progress">
                            <div class="progress-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="progress-text">Website</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="current-progressbar">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary w-40" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                    40%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="progress-text">Android</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="current-progressbar">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                    60%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="progress-text">Ios</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="current-progressbar">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary w-70" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                                    70%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="progress-text">Mobile</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="current-progressbar">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary w-90" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                    90%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="progress-text">Android</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="current-progressbar">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                                                    60%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="progress-text">Ios</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="current-progressbar">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary w-70" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">
                                                    70%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="progress-content">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="progress-text">Mobile</div>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="current-progressbar">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary w-90" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
                                                    90%
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
            <!-- /# column -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4>Messages</h4>
                    </div>
                    <div class="card-body">
                        <div class="recent-meaasge">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#"><img alt="..." src="images/avatar/1.jpg" class="media-object"></a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">john doe</h4>
                                    <div class="meaasge-date">15 minutes Ago</div>
                                    <p class="f-s-12">We are happy about your service </p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-left">
                                    <a href="#"><img alt="..." src="images/avatar/2.jpg" class="media-object"></a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">Mr. John</h4>
                                    <div class="meaasge-date">40 minutes ago</div>
                                    <p class="f-s-12">Quick service and good serve </p>
                                </div>
                            </div>
                            <div class="media">
                                <div class="media-left">
                                    <a href="#"><img alt="..." src="images/avatar/3.jpg" class="media-object"></a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">Mr. Michael</h4>
                                    <div class="meaasge-date">1 minutes ago</div>
                                    <p class="f-s-12">We like your birthday cake </p>
                                </div>
                            </div>
                            <div class="media no-border">
                                <div class="media-left">
                                    <a href="#"><img alt="..." src="images/avatar/2.jpg" class="media-object"></a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">Mr. John</h4>
                                    <div class="meaasge-date">40 minutes ago</div>
                                    <p class="f-s-12">Quick service and good serve </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-title">
                        <h4>Todo</h4>
                    </div>
                    <div class="todo-list">
                        <div class="tdl-holder">
                            <div class="tdl-content">
                                <ul>
                                    <li class="color-primary">
                                        <label>
                                            <input type="checkbox"><i class="bg-primary"></i><span>Post three to six times on Twitter.</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                    <li class="color-success">
                                        <label>
                                            <input type="checkbox" checked><i class="bg-success"></i><span>Post one to two times on Facebook.</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                    <li class="color-warning">
                                        <label>
                                            <input type="checkbox" checked><i class="bg-warning"></i><span>Follow back those who follow you</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                    <li class="color-danger">
                                        <label>
                                            <input type="checkbox" checked><i class="bg-danger"></i><span>Connect with one new person</span>
                                            <a href='#' class="ti-close"></a>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <input type="text" class="tdl-new form-control" placeholder="Type here">
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->



@endsection('content')