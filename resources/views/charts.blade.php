<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Charts</title>

    
</head>
<body>
    <h1 style="text-align: center; color:red;">Bar Chart Dashboard</h1>
    <div style="width:500px;">
    <canvas id="chart"></canvas>
</div>

    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var userChart = new Chart(ctx,{
            type:'bar',
            data:{
                labels: {!! json_encode($labels)!!},
                datasets: {!! json_encode($datasets)!!}
            },
        });
    </script>

</body>
</html>