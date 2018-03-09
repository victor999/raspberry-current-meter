<html>
  <head>
  
  <?php
        $dbhost = "localhost";
        $dbuser = "ina_user";
        $dbpass = "your_pass";
        $dbname = "ina_data";

        // Create connection
        $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
        // Check connection
        if (!$conn) 
        {
	        die("Connection failed: " . mysqli_connect_error());
        }
    	
        $sql = "SELECT * FROM ina_values ORDER BY id DESC LIMIT 1000";
        $result = mysqli_query($conn, $sql);
    	
        if (mysqli_num_rows($result) > 0) 
        {
            $rows = array();
            
            $table = array();

            $table['cols'] = array(
                array('id' => 'millisec', 'label' => 'time', 'type' => 'number'),
                array('id' => 'bus_voltage', 'label' => 'bus_voltage', 'type' => 'number'),
                array('id' => 'current', 'label' => 'current', 'type' => 'number')
            );

            foreach($result as $r) 
            {
                $temp = array();
                
                $temp[] = array('v' => floatval($r['millisec']));
                $temp[] = array('v' => floatval($r['bus_voltage']));
                $temp[] = array('v' => floatval($r['current']));
                $rows[] = array('c' => $temp);
            }
            
            $table['rows'] = $rows;
            
        }
        else 
        {
	        echo "0 results";
        }
    	
        mysqli_close($conn);
    ?>
  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', { 'packages': ['corechart'] });
        
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() 
        {
            var table = JSON.parse('<?php echo json_encode($table); ?>');
	        var data = new google.visualization.DataTable(table);

            var options = 
            {
                title: 'Power Consumption. Drag to zoom, right click to reset.',
                curveType: 'function',
                explorer: {actions: ['dragToZoom', 'rightClickToReset']},
                hAxis: 
                {
                    
                },
                series: 
                {
                    0: {targetAxisIndex: 0},
                    1: {targetAxisIndex: 1}
                },
                vAxes: 
                {
                    // Adds titles to each axis.
                    0: {title: 'Voltage (V)', viewWindow: {min: -1, max: 6}},
                    1: {title: 'Current (mA)', viewWindow: {min: -1, max: 6}}
                },
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('static_chart'));

            chart.draw(data, options);
        }

    </script>
	<script>
	function myFunction() 
	{
		<?php header("Refresh:0"); ?>
	}
	</script>
  </head>
  <body>
    <div id="static_chart" style="left: 60px; top: 100px; width: 2000px; height: 1000px"></div>
	<form><input id="b1" type="button" value="Update" onclick="myFunction()"/></form>
  </body>
</html>