<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <br />
    
    <div class="container">
        <a href="{{ url('/', []) }}"><button type="button" class="btn btn-warning">Return</button></a>
        <br/><br/>
        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fastest Astroid</h5>
                        <p> ID : <b><span class="card-text" id="fastest_id">{{ $fastest_astroid['id'] }}</span></b></p>
                        <p> KMPH : <b><span class="card-text" id="fastest_kmph">{{ $fastest_astroid['kilometers_per_hour'] }}</span></b></p>
                        <p> Distance : <b><span class="card-text" id="fastest_distance">{{ $fastest_astroid['kilometers'] }}</span></b></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Closest Astroid</h5>
                    <p> ID : <b><span class="card-text" id="closest_id">{{ $closest_astroid['id'] }}</span></b></p>
                        <p> KMPH : <b><span class="card-text" id="closest_kmph">{{ $closest_astroid['kilometers_per_hour'] }}</span></b></p>
                        <p> Distance : <b><span class="card-text" id="closest_distance">{{ $closest_astroid['kilometers'] }}</span></b></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Average Size</h5>
                        <b><p class="card-text" id="average_size">{{ $average_size }}</p></b>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="graphData">

    </div>
</body>
<script src = "https://code.highcharts.com/highcharts.js" >
</script>
<script>
    
var dates = {!! json_encode($dates) !!}
var counts = {!! json_encode($counts)  !!}
console.log(counts);
Highcharts.chart('graphData', {
        title: {
            text: 'NEO STATS'
        },
        subtitle: {
            text: 'Source: https://api.nasa.gov/planetary/apod'
        },
         xAxis: {
            categories: dates
        },
        yAxis: {
            title: {
                text: 'Count'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: '',
            data: counts
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});

</script>

</html>
