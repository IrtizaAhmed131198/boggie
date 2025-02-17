<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <title>Dashboard</title>

    @yield('css')

    <style></style>


</head>
    <body class="responsive">


        @yield('content')
        <!-- Optional JavaScript; choose one of the two! -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>

        @yield('js')

        <script>
            // Sample data for different dates
            // var dateWiseData = {
            //     "2024-09-01": [12, 19],
            //     "2024-09-02": [15, 22],
            //     "2024-09-03": [3, 5],
            //     "2024-09-04": [17, 8],
            //     "2024-09-05": [28, 30],
            //     "2024-09-06": [24, 12],
            //     "2024-09-07": [7, 10]
            // };

            // // Initial chart setup
            // var ctx = document.getElementById("barChart").getContext('2d');
            // var barChart = new Chart(ctx, {
            //     type: 'bar',
            //     data: {
            //         labels: ["data-1", "data-2"], // Label for the datasets
            //         datasets: [{
            //             label: 'Selected Date Data',
            //             data: [], // Data will be set based on date selection
            //             backgroundColor: ["#ee7a1b", "#355e3b"]
            //         }]
            //     },
            //     options: {
            //         scales: {
            //             y: {
            //                 beginAtZero: true
            //             }
            //         }
            //     }
            // });

            // Function to update chart when date is selected
            // function updateChart(selectedDate) {
            //     if (dateWiseData[selectedDate]) {
            //         barChart.data.datasets[0].data = dateWiseData[selectedDate];
            //         barChart.update();
            //     } else {
            //         alert("No data available for the selected date.");
            //     }
            // }

            // Event listener for date picker
            // document.getElementById("datePicker").addEventListener("change", function() {
            //     var selectedDate = this.value;
            //     updateChart(selectedDate);
            // });
        </script>

        <script>
            //     $(document).ready(function() {
            //         $('#openbar').click(function() {
            //             $('#openshow').fadeToggle()
            //         })
            //     })
            //
        </script>
        @if (Session::has('message'))
            <script type="text/javascript">
                toastr.success("{{ Session::get('message') }}");
            </script>
        @endif

        @if (Session::has('success'))
            <script type="text/javascript">
                toastr.success("{{ Session::get('success') }}");
            </script>
        @endif

        @if (Session::has('error'))
            <script type="text/javascript">
                toastr.error("{{ Session::get('error') }}");
            </script>
        @endif

    </body>
</html>
