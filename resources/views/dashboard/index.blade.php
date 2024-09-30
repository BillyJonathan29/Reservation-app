@extends('layouts.template')


@section('content')
    <div class="panel-header bg-danger-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="page-inner mt--5">
        <div class="row mt--2">
            <div class="col-lg-3 col-md-12">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fa fa-hotel text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category"> Total Room </p>
                                    <h4 class="card-title"> {{ App\Models\Room::totalRoom() }} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fa fa-bed text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Total Room Terisi</p>
                                    <h4 class="card-title"> 7 </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fa fa-credit-card text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Total Room Harus Checkout</p>
                                    <h4 class="card-title"> 10 </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-12">
                <div class="card card-stats card-round">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big text-center">
                                    <i class="fa fa-money-check text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-stats">
                                <div class="numbers">
                                    <p class="card-category">Total Room Akan CheckIn</p>
                                    <h4 class="card-title"> 10 </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table List Room --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">List Room Harus Check Out </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th> No.Room </th>
                                        <th> Room</th>
                                        <th width="100"> Aksi </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th> No.Room </th>
                                        <th> Room</th>
                                        <th width="100"> Aksi </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">List Room Akan Check In</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2">

                                <thead>
                                    <tr>
                                        <th> No.Room </th>
                                        <th> Room</th>
                                        <th width="100"> Aksi </th>
                                    </tr>
                                </thead>
    
                                <tfoot>
                                    <tr>
                                        <th> No.Room </th>
                                        <th> Room</th>
                                        <th width="100"> Aksi </th>
                                    </tr>
                                </tfoot>
    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        {{-- Grapic --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Grapik Room Terisi {{ date('Y') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(function() {
            $('#dataTable').DataTable();
            $('#dataTable2').DataTable();
        })

        $(function(){
            var lineChart = document.getElementById('lineChart').getContext('2d')

            var myLineChart = new Chart(lineChart, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                    datasets: [{
                        label: "Grapik Room Terisi {{ date('Y') }}",
                        borderColor: "#ea4d56",
                        pointBorderColor: "#FFF",
                        pointBackgroundColor: "#ea4d56",
                        pointBorderWidth: 2,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        pointRadius: 4,
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        data: [15, 15, 10, 20, 40, 30, 15, 25, 10, 30, 17, 10]
                    }]
                },
                options : {
                    responsive: true, 
                    maintainAspectRatio: false,
                    legend: {
                        position: 'bottom',
                        labels : {
                            padding: 10,
                            fontColor: '#ea4d56',
                        }
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode:"nearest",
                        intersect: 0,
                        position:"nearest",
                        xPadding:10,
                        yPadding:10,
                        caretPadding:10
                    },
                    layout:{
                        padding:{left:15,right:15,top:15,bottom:15}
                    }
                }
            });
        })
    </script>
@endsection
