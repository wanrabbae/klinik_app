@extends('templating.template_with_sidebar')

@section('content')
    <h1>Infografis</h1>
    <div class="separator mb-5"></div>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Line Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="salesChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="salesChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Bar Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="productChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="productChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Area Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="areaChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="areaChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Scatter Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="scatterChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="scatterChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Radar Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="radarChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="radarChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Polar Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="polarChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="polarChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Doughnut Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="categoryChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Pie Chart</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="pieChart"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-5">
                            <h6 class="mb-4">No Shadow</h6>
                            <div class="chart-container chart">
                                <canvas id="pieChartNoShadow"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
