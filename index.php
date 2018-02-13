<?php
    session_start();
    require_once 'calender/filter.php';
    require_once '../info.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/nv.d3.css">
    <link rel="stylesheet" href="calender/styles.css">
</head>

<body>
    
    <h2 id="page-title">Data Pie Charts</h2>

    <div class="filter-forms">
        <div class="calenderContainer">
            <!--<button class="calenderApp__toggle">Data Filter</button>-->
            <div class="calenderApp">
                <h1 class="calenderApp__main-title">Select a Date Range</h1>

                <div class="title-container">
                    <p class="calenderApp__title1">MONTH</p>
                    <p class="calenderApp__title2">YEAR</p>
                </div>
                <p class="calenderApp__message"></p>

                <p class="calenderApp__success"></p>
                <div class="calenderApp__calender">
                </div>

                <div class="calenderApp__dropdown">
                <?php
                    try {
                        filter($hostname, $db, $user, $pass);
                        $dbh2 = null;
                    }
                    catch(PDOException $e) {
                        echo $e -> getMessage();
                    }
                ?>
                </div>
                <input class="calenderApp__filterButton" type="button" value="Update"></input>
                <input class="calenderApp__clearButton calenderApp__clearButton--update" type="button" value="Clear"></input>
            </div>
        </div>
    </div>

    <section class="pieContainer">
        <div id="age">
            <h3>Age</h3>
            <svg></svg>
        </div>

        <div id="nationality">
            <h3>Nationality</h3>
            <svg></svg>
        </div>

        <div id="type">
            <h3>Relationship</h3>
            <svg></svg>
        </div>
    </section>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="assets/nv.d3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://code.jquery.com/jquery-3.1.0.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
    <script src="calender/scripts.js"></script>
</body>

<script>
    var url = "http://localhost/sai-xampp/charts+filter/pie/data/";

    function callD3Charts() {
        d3.json(" " + url + "age.php",
            function (error, data) {
                //Regular pie chart
                nv.addGraph(function () {
                    var chart = nv.models.pieChart()
                        .x(function (d) {
                            if (d.value == null) {
                                return "Unspecified"
                            } else {
                                return d.value
                            }
                        })
                        .y(function (d) {
                            return d.count
                        })
                        .labelType("percent")
                        .donut(true)
                        .donutRatio(0.35)
                        .showLabels(true);

                    d3.select("#age svg")
                        .datum(data)
                        .transition().duration(1200)
                        .call(chart);

                    d3.selectAll(".nv-legendWrap")
                        .attr("transform", "translate(0,350)");

                    d3.selectAll(".nv-pieWrap")
                        .attr("transform", "translate(0,-70)");

                    return chart;
                });
            }
        );

        d3.json(" " + url + "nationality.php",
            function (error, data) {
                //Regular pie chart
                nv.addGraph(function () {
                    var chart = nv.models.pieChart()
                        .x(function (d) {
                            if (d.value == null) {
                                return "Unspecified"
                            } else {
                                return d.value
                            }
                        })
                        .y(function (d) {
                            return d.count
                        })
                        .labelType("percent")
                        .donut(true)
                        .donutRatio(0.35)
                        .showLabels(true);

                    d3.select("#nationality svg")
                        .datum(data)
                        .transition().duration(1200)
                        .call(chart);

                    d3.selectAll(".nv-legendWrap")
                        .attr("transform", "translate(0,350)");

                    d3.selectAll(".nv-pieWrap")
                        .attr("transform", "translate(0,-70)");

                    return chart;
                });
            }
        );

        d3.json(" " + url + "relationship.php",
            function (error, data) {
                //Regular pie chart
                nv.addGraph(function () {
                    var chart = nv.models.pieChart()
                        .x(function (d) {
                            if (d.value == null) {
                                return "unspecified"
                            } else {
                                return d.value
                            }
                        })
                        .y(function (d) {
                            return d.count
                        })
                        .labelType("percent")
                        .donut(true)
                        .donutRatio(0.35)
                        .showLabels(true);

                    d3.select("#type svg")
                        .datum(data)
                        .transition().duration(1200)
                        .call(chart);

                    d3.selectAll(".nv-legendWrap")
                        .attr("transform", "translate(0,350)");

                    d3.selectAll(".nv-pieWrap")
                        .attr("transform", "translate(0,-70)");

                    return chart;
                });
            }
        );
    };

    callD3Charts();
</script>

</html>
