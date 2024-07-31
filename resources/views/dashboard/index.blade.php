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

        .card-stats{
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          border-radius: 10px;
          display: flex;
          margin: 10px 0;
        }

        .card-stats .card-icon{
          padding:10px 0 10px 20px;
          font-size: 32px; 
          color: white;
          display: flex;
        }

        .card-stats .card-content{
          padding:20px 0 10px 20px;
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
                                <h3 class="card-title mb-3">{{ $todayOrdersCount }}</h3>
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
                                <h3 class="card-title mb-3">{{ $todayRevenue }}</h3>
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
                                <p class="card-category">Total Bookings</p>
                                <h3 class="card-title mb-3">0</h3> 
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

              <!-- Monthly Revenue Chart -->
              <div class="row items-align-baseline">
                  <div class="col-md-12 mb-4">
                      <div class="card shadow">
                          <div class="card-body">
                            <div class="card-header">
                              <h4>Monthly Revenue<h4>
                            </div>
                              <div id="monthlyRevenueChart"></div>
                          </div> 
                      </div> 
                  </div>
              </div><!-- .row -->

           

                 <!-- line chart -->
                 <div class="row items-align-baseline">
                    <div class="col-md-12 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="total-revenue">
                                    <span id="totalThisMonth">This Month Total Revenue: </span><br>
                                    <span id="totalLastMonth">Last Month Total Revenue: </span>
                                </div>
                                <div id="lineChart1"></div>
                            </div>
                        </div> 
                    </div> 
                </div><!-- .row -->



            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
</main> <!-- main -->



<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Monthly Revenue Chart -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/monthly-revenue')
        .then(response => response.json())
        .then(data => {
            // Sort data by year and month
            data.sort((a, b) => {
                return (a.year - b.year) || (a.month - b.month);
            });

            const labels = data.map(item => {
                const date = new Date(item.year, item.month - 1); 
                return date.toLocaleString('default', { month: 'short' }) + ' ' + date.getFullYear().toString().slice(-2);
            });

            const revenue = data.map(item => item.monthly_revenue);

            var options = {
                series: [{
                    name: 'Monthly Revenue',
                    data: revenue
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false 
                    }
                },
                xaxis: {
                    categories: labels,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        rotate: -45 
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value;
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                grid: {
                    show: true, 
                    borderColor: '#e0e0e0', 
                },
                fill: {
                    type: 'solid',
                    colors: ['#21b0d3'] 
                },
                stroke: {
                    show: true,
                    curve: 'smooth',
                    colors: ['#21b0d3'], 
                    width: 2
                },
                dataLabels: {
                    enabled: false 
                },
                tooltip: {
                    enabled: true 
                }
            };

            var chart = new ApexCharts(document.querySelector("#monthlyRevenueChart"), options);
            chart.render();
        });
});
</script>



       


<!-- Line Chart -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('/api/daily-revenue-column-chart')
        .then(response => response.json())
        .then(data => {
            console.log('Fetched Data:', data); // Debugging line

            const categories = data.categories;
            const currentMonthSeries = data.currentMonth;
            const lastMonthSeries = data.lastMonth;

            // Update total revenue display
            document.getElementById('totalThisMonth').innerText = `This Month Total Revenue: ${data.totalCurrentMonthRevenue.toFixed(2)}`;
            document.getElementById('totalLastMonth').innerText = `Last Month Total Revenue: ${data.totalLastMonthRevenue.toFixed(2)}`;

            var options = {
                series: [{
                    name: 'This Month',
                    data: currentMonthSeries
                }, {
                    name: 'Last Month',
                    data: lastMonthSeries
                }],
                chart: {
                    type: 'line',
                    height: 350,
                    toolbar: {
                        show: false 
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                markers: {
                    size: 0
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: categories,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        rotate: -45
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return "" + value;
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return "" + value;
                        }
                    }
                },
                colors: ['#602082', '#f5991c']
            };

            var chart = new ApexCharts(document.querySelector("#lineChart1"), options);
            chart.render();
        })
        .catch(error => console.error('Error fetching daily revenue data:', error));
});
</script>






@endsection

