@extends("layouts.staff-master")

@section("pageTitle","Home")

@section("headerTitle","Home")

@section('content')
    <div class="row">
        <div class="col-xl-4 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-content">
                    <div class="media align-items-stretch bg-info text-white rounded">
                        <div class="bg-info bg-darken-2 p-2 media-middle">
                            <i class="la la-user font-large-2 text-white"></i>
                        </div>
                        <div class="media-body p-2">
                            <h4 class="text-white">Total Accounts Created</h4>
                            <span>All Time</span>
                        </div>
                        <div class="media-right p-2 media-middle">
                            <h1 class="text-white">{{$userCount[0]->users_count}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-content">
                    <div class="media align-items-stretch bg-warning text-white rounded">
                        <div class="bg-warning bg-darken-2 p-2 media-middle">
                            <i class="la la-user font-large-2 text-white"></i>
                        </div>
                        <div class="media-body p-2">
                            <h4 class="text-white">Total Registrations Completed</h4>
                            <span>All Time Registrations</span>
                        </div>
                        <div class="media-right p-2 media-middle">
                            <h1 class="text-white">{{$totalCompletedRegistrations[0]->Update_Completed}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch bg-danger text-white rounded">
                        <div class="bg-danger bg-darken-2 p-2 media-middle">
                            <i class="la la-user-plus font-large-2 text-white"></i>
                        </div>
                        <div class="media-body p-2">
                            <h4 class="text-white">Daily Average Registrations</h4>
                            <span>Based on Past 7 days</span>
                        </div>
                        <div class="media-right p-2 media-middle">
                            <h1 class="text-white">{{floor($dailyAverageRegistrations[0]->avg_done)}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Enrolments By Department</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        <div id="enrolmentPieChart" style="overflow:hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Students Enrolled (Past 7 Days)</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        <div id="studentsEnrolledp7Chart" style="overflow:hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Profile Updates Completed (Past 7 days)</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">

                    <div class="card-body">
                        <div id="profile-update-chart" style="overflow:hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-head">
                    <div class="card-header">
                        <h4 class="card-title">Population At Each Stage</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                        <div class="heading-elements">

                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div id="stagePopulationBarChart" style="overflow:hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageJavascript')
    <script src="https://www.google.com/jsapi" type="text/javascript"></script>

    <script>
        // Load the Visualization API and the corechart package.
        google.load('visualization', '1.0', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawRegistrationCompleteChart);

        google.setOnLoadCallback(drawStageQuantity);

        google.setOnLoadCallback(drawEnrolmentPieChart);

        google.setOnLoadCallback(drawEnrolmentsPerDayChart);

        // Callback that creates and populates a data table, instantiates the pie chart, passes in the data and draws it.
        function drawStageQuantity() {

            // Create the data table.
            let data = google.visualization.arrayToDataTable([
                ['Stage', 'Students'],
                    @foreach($stageQuantities as $stageQuantity)
                ['Stage {{$stageQuantity->stage}}',  {{$stageQuantity->students_count}}],
                @endforeach
            ]);


            // Set chart options
            let options_column = {
                height: 400,
                fontSize: 12,
                colors: ['#2494be'],
                chartArea: {
                    left: '5%',
                    width: '90%',
                    height: 350
                },
                vAxis: {
                    gridlines: {
                        color: '#e9e9e9',
                        count: 10
                    },
                    minValue: 0
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        fontSize: 12
                    }
                }
            };

            // Instantiate and draw our chart, passing in some options.
            let bar = new google.visualization.ColumnChart(document.getElementById('stagePopulationBarChart'));
            bar.draw(data, options_column);

        }

        function drawEnrolmentPieChart() {

            var data = google.visualization.arrayToDataTable([
                ['Department', 'Students'],
                    @foreach($enrolledCountByDepartments as $enrolledCountByDepartment)
                ['{{$enrolledCountByDepartment->name}}', {{$enrolledCountByDepartment->count}}],
                @endforeach
            ]);

            var options = {
                title: 'Students Enrolled in Department',
                height: 400,
            };

            var chart = new google.visualization.PieChart(document.getElementById('enrolmentPieChart'));

            chart.draw(data, options);
        }

        // Callback that creates and populates a data table, instantiates the line chart, passes in the data and draws it.
        function drawEnrolmentsPerDayChart() {

            // Create the data table.
            let data = google.visualization.arrayToDataTable([
                ['Day', 'Students Enrolled'],
                    @foreach($enrolmentPerDays as $enrolmentPerDay)
                ['{{$enrolmentPerDay->days}}', {{$enrolmentPerDay->enrolled}}],
                @endforeach
            ]);


            // Set chart options
            let options_line = {
                height: 400,
                fontSize: 12,
                curveType: 'function',
                colors: ['#DA4453'],
                pointSize: 5,
                chartArea: {
                    left: '5%',
                    width: '90%',
                    height: 350
                },
                vAxis: {
                    gridlines: {
                        color: '#e9e9e9',
                        count: 10
                    },
                    minValue: 0
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        fontSize: 12
                    }
                }
            };

            // Instantiate and draw our chart, passing in some options.
            let line = new google.visualization.LineChart(document.getElementById('studentsEnrolledp7Chart'));
            line.draw(data, options_line);

        }

        function drawRegistrationCompleteChart() {

            // Create the data table.
            let data = google.visualization.arrayToDataTable([
                ['Day', 'Registration Completed'],
                    @foreach($completedByDays as $completedByDay)
                ['{{$completedByDay->days}}', {{$completedByDay->Update_Completed}}],
                @endforeach
            ]);


            // Set chart options
            let options_line = {
                height: 400,
                fontSize: 12,
                curveType: 'function',
                colors: ['#DA4453'],
                pointSize: 5,
                chartArea: {
                    left: '5%',
                    width: '90%',
                    height: 350
                },
                vAxis: {
                    gridlines: {
                        color: '#e9e9e9',
                        count: 10
                    },
                    minValue: 0
                },
                legend: {
                    position: 'top',
                    alignment: 'center',
                    textStyle: {
                        fontSize: 12
                    }
                }
            };

            // Instantiate and draw our chart, passing in some options.
            let line = new google.visualization.LineChart(document.getElementById('profile-update-chart'));
            line.draw(data, options_line);

        }


        // Resize chart
        // ------------------------------

        $(function () {

            // Resize chart on menu width change and window resize
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);

            // Resize function
            function resize() {
                drawRegistrationCompleteChart();
            }
        });
    </script>
@endpush


