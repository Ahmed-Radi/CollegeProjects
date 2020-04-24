<!DOCTYPR html>
<html>
    <head>
        
        <meta charset="UTF-8">
	<!--translate html5 in Edge -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--translate html5 in phone -->
	<meta name="viewport" content="width=device-width, intial-scale=1">

	<link rel='stylesheet' href='css/bootstrap.css'>
	<link rel='stylesheet' href='css/style.css'>	<!-- your css -->
        <title>Inventory Model</title>
        
    </head>
    <body class="container-fluid" style="padding: 0px;background-image: url(math-background-design-hd-7.jpg);background-size: cover">
        
        <div class="col-lg-6 col-lg-push-3 col-md-6 col-md-push-3 QUES">
            <h2>Inventory Model</h2>
            <p style="margin-top: 30px;">Enter Values Of Items In The Next Table</p>
	    <p style="">Enter Frequancy Or Probability Not Both</p>

            <form action="solution.php" method="get">

		<!--Demand Table-->
                <table>
                    <caption class="caption1">Demand Table</caption>
                    <tr>
                        <th>Demand</th>
                        <th>Frequency</th>
			<th>Probability</th>
                        <th>RandomNum</th>
                    </tr>
                    <tr>
                        <td> <textarea name="Demand" rows="10" ></textarea> </td>
                        <td> <textarea name="D-Freq" rows="10" ></textarea> </td>
			<td> <textarea name="D-Prob" rows="10" ></textarea> </td>
                        <td> <textarea name="D-RN" rows="10" ></textarea> </td>
                    </tr>
                </table>
		<!-- End -->

		<!-- LeadTime table< -->
                <table>
                    <caption class="caption1">LeadTime table</caption>
                    <tr>
                        <th>LeadTime</th>
                        <th>Frequency</th>
			<th>Probability</th>
                        <th>RandomNum</th>
                    </tr>
                    <tr>
                        <td> <textarea name="LeadTime" rows="10" ></textarea> </td>
                        <td> <textarea name="L-Freq" rows="10" ></textarea> </td>
			<td> <textarea name="L-Prob" rows="10" ></textarea> </td>
                        <td> <textarea name="L-RN" rows="10" ></textarea> </td>
                    </tr>
                </table>
		<!-- End -->

		<!-- Inventory Data -->
                <div class="container-fluid" style="margin-top: 20px;">
                    <div class="col-lg-6">
                        <label>Number of days to simulate* </label><br>
                        <input type="number" name="NOD" min="0" max="100" style="width: 100%"><br>
                    </div>
                    <div class="col-lg-3">
                        <label>Order Quantity* </label><br>
                        <input type="number" name="OQ" min="0" max="100" style="width: 100%"><br>
                    </div>
                    <div class="col-lg-3">
                        <label>Reorder Point* </label><br>
                        <input type="number" name="RP" min="0" max="100" style="width: 100%"><br>
                    </div>
                </div>
		<!-- End -->

                <div class="container-fluid" style="margin-top: 30px; text-align: center;">
                    <input type="submit" class="submit" value="solve">
                </div>

            </form>
            
        </div>

    </body>
</html>
