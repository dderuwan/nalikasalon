@extends('layouts.main.master')

@section('content')

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    #columnChart1 {
        height: 400px;
    }

    .total-revenue {
        font-size: 18px;
        margin-bottom: 10px;
        font-weight: bold;
    }
  
    .card-title {
        font-size: 24px;
        font-weight: bold;
        margin: 0;
    }

    .card-category {
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 6px; 
    }

    .card-stats {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        display: flex;
        margin: 10px 0;
    }

    .card-stats .card-icon {
        padding: 10px 0 10px 20px;
        font-size: 32px; 
        color: white;
        display: flex;
    }

    .card-stats .card-content {
        padding: 20px 0 10px 20px;
    }

    .bg-gradient-warning {
        background: linear-gradient(45deg, #FF9800, #FFC107);
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, #4CAF50, #81C784);
    }

    .bg-gradient-danger {
        background: linear-gradient(45deg, #F44336, #E57373);
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #00ACC1, #4DD0E1);
    }

    #monthlyRevenueChart {
        height: 500px; /* Adjust the height as needed */
    }
</style>

<main role="main" class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center mb-2">
                    <div class="col">
                        <h2 class="h5 page-title">Welcome!</h2>
                    </div>
                </div>
                <div class="row mb-4">
                    <!-- Today Orders -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-icon bg-gradient-warning">
                                <i class="material-icons">shopping_cart</i>
                            </div>
                            <div class="card-content">
                                <p class="card-category">Today Orders</p>
                                <h3 class="card-title mb-3">{{ $todayorders }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- Total Bookings -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-icon bg-gradient-danger">
                                <i class="material-icons">date_range</i>
                            </div>
                            <div class="card-content">
                                <p class="card-category">Today Bookings</p>
                                <h3 class="card-title mb-3">{{ $totalBookings }}</h3> 
                            </div>
                        </div>
                    </div>

                    <!-- Today Revenue -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-icon bg-gradient-success">
                                <i class="material-icons">attach_money</i>
                            </div>
                            <div class="card-content">
                                <p class="card-category">Today Revenue</p>
                                <h3 class="card-title mb-3">{{ $totalrevenue }}</h3>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Customers -->
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-icon bg-gradient-info">
                                <i class="material-icons">person</i>
                            </div>
                            <div class="card-content">
                                <p class="card-category">Total Customers</p>
                                <h3 class="card-title mb-3">{{ $totalCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row items-align-baseline">
                    <div class="col-md-12 mb-4">
                        <div class="card shadow" style="height: 500px;">
                            <div class="card-body">
                                <div class="card-header">
                                    <h4>Daily Revenue for the Month</h4>
                                </div>
                                <div id="monthlyRevenueChart"></div> <!-- Chart container -->
                            </div> 
                        </div> 
                    </div>
                </div>
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main> <!-- main -->

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
// Prepare data for the chart
var revenueData = @json($dailyRevenue);

// Extract dates and revenues for the chart
var dates = revenueData.map(item => item.date);
var revenues = revenueData.map(item => item.revenue);

// Create ApexCharts chart
var options = {
    chart: {
        type: 'line',
        height: 400 // Adjust the height here
    },
    series: [{
        name: 'Revenue',
        data: revenues
    }],
    xaxis: {
        categories: dates
    },
    title: {
        text: 'Daily Revenue for the Month',
        align: 'center'
    },
    plotOptions: {
        line: {
            curve: 'smooth' // Optional: smooth out the lines
        }
    },
    dataLabels: {
        enabled: false // Disable data labels if they are interfering
    },
    grid: {
        padding: {
            left: 0,
            right: 0,
            top: 0,
            bottom: 0
        }
    }
};

var chart = new ApexCharts(document.querySelector("#monthlyRevenueChart"), options);
chart.render();

</script>
@endsection
