@extends("backend.template.layout")

@section('per_page_css')
<style>
    .small-box .inner h3 {
        font-size: 18px;
    }
</style>
@endsection

@section('body-content')
<div class="br-mainpanel">
    <div class="br-pagetitle">
    </div>

    <div class="br-pagebody">
        <div class="row row-sm">

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #127383">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total Order</span>
                        </div>
                    </div>
                    <div id="ch1" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #6c6c6c">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1</p>
                            <span class="tx-11 tx-roboto tx-white-8">Todays Order Collection</span>
                        </div>
                    </div>
                    <div id="ch2" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #703146">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1</p>
                            <span class="tx-11 tx-roboto tx-white-8">Todays Order Delivery</span>
                        </div>
                    </div>
                    <div id="ch3" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->

            <!-- item card start -->
            <div class="col-sm-6 col-xl-3">
                <div class="rounded overflow-hidden" style="background: #4f52a7">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <div class="mg-l-20">
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1</p>
                            <span class="tx-11 tx-roboto tx-white-8">Total Earning</span>
                        </div>
                    </div>
                    <div id="ch4" class="ht-50 tr-y-1"></div>
                </div>
            </div>
            <!-- item card end -->
            
        </div>

        <div class="row row-sm charts mt-5">


            <div class="col-md-12 pr-2 mb-5">
                <div class="card">
                    <div class="card-header">
                        Last 6 month order progress
                    </div>
                    <div class="card-body" id="order-progress">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section("per_page_js")
<script src="{{ asset('backend/js/apexcharts/apexcharts.js') }}"></script>
<script>

    $.ajax({
        url: "{{ route('order.progress') }}",
        method: 'GET',
        data: {},
        success: function(data) {
            var total_order = Array();
            var total_income = Array();
            var possible_income = Array();
            var time = Array();

            $.each(data.data, (key, value) => {
                total_income.push(value.total_income)
                possible_income.push(value.possible_income)
                total_order.push(value.total_order)
                time.push(value.time)
            })

            var options = {
                series: [
                    {
                        name: 'Total Income',
                        data: total_income,
                    },
                    {
                        name: 'Possible Income',
                        data: possible_income,
                    },
                    {
                        name: 'Total Order',
                        data: total_order,
                    },
                ],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            position: 'top', // top, center, bottom
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val + "";
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '11px',
                        colors: ["#0951a0"]
                    }
                },
                xaxis: {
                    categories: time,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#0951a0',
                                colorTo: '#0951a0',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function(val) {
                            return val + "";
                        }
                    }
                },
                title: {
                    text: '',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#order-progress"), options);
            chart.render();
        }
    })
    
</script>
@endsection