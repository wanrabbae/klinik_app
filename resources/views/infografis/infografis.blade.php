@extends('templating.template_with_sidebar', ['isActiveInfografis' => 'active'])

@section('content')
    <h1>Infografis</h1>
    <div class="separator mb-5"></div>

    <div class="row">
        <div class="col-12">
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

        </div>
    </div>
@endsection
