<?php include_once 'header.php';?>
			
			<!-- Middle section -->
			<div id="mid_wrap">
				<!-- Title & Date -->
				<div class="mid_tier_1">
					<!-- Title -->
					<div id="viewport_title" class="float_left">
						<div class="float_left"><img src="<?php echo PUBLIC_SITE ?>images/log.png" /></div>
						<div id="section_title" class="float_left">Call Log</div>
						<br class="clearfloat"/>
					</div>
					
					<!-- Date -->
					<div id="date_select" class="float_right">
						<form id="config_form">
						<div class="float_left" style='border-right: solid 1px #CCC; padding-right: 10px; margin-right: 10px;'>
							<div class="float_left">
								<b style="display:block; padding-top:6px; padding-right:8px;">Date: </b>
							</div>
							<div class="float_left">
								<div class="float_left">
									<div class="float_left">
										<input type="text" id="datepick_start" name="start_date" value="<?php echo $today ?>">
									</div>
									<div class="float_left">
										<input type="text" id="datepick_end" name="end_date" value="<?php echo $today ?>">
									</div>
									<br class="clearfloat"/>
								</div>
								<div class="float_left">
									<input type="button" id="submit_date" name="apply_date" value="Apply" onclick="javascript:get_data();">
								</div>
								<br class="clearfloat"/>
							</div>
							<br class="clearfloat"/>
						</div>
						
						<div class="float_left" style='height:26px;'>
							<input type="button" value="Download" onclick="javascript:download_data(null);">
						</div>
						<br class="clearfloat"/>
						</form>
					</div>

					<br class="clearfloat"/>
				</div>
				
				<!-- Report Viewport -->
				<div>
					<!-- Data Summary -->
					<div id="report_summary">
						<div id="inbound_summary">
							<div class="viewport_title">Inbound Calls</div>
							<div class="canvas">
								<table dir="ltr">
									<thead>
										<tr>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Total Calls</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Answered</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">No Answer</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Busy</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Failed</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Inbound Call Duration</td>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($total) ? $total : 0 ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($answered) ? $answered : 0 ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($not_answered) ? $not_answered : 0 ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($busy) ? $busy : 0  ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($failed) ? $failed : 0  ?></td>
											
											<?php 
												$minsec = gmdate("i:s", $total_call);
												$hours = gmdate("d", $total_call)*24 + gmdate("H", $total_call);
												$total_call = $hours.':'.$minsec;
											?>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($total_call) ? $total_call : 0  ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<!-- Data Graph -->
					<div id="report">
						<div id="report_graph" class="float_left">
							<div class="viewport_title">Performance Graph</div>
							<div class="viewport_canvas graph_viewport">
								<div id="graph"></div>
							</div>
						</div>
						<div id="top_msisdn" class="float_right">
							<div class="viewport_title">Monthly Reports</div>
							<div class="viewport_canvas">
								<h2><?php echo date('M') ?></h2>
								<h2><?php echo floor($month_total_call/60) . ' min ' . $month_total_call%60 .' s'?></h2>
							</div>
						</div>
						<br class="clearfloat"/>
					</div>
				</div>
			</div>
			
			<!-- Bottom section -->
			<div id="btm_wrap"></div>
		</div>
	</body>


	<?php
		$y = date('Y');
		$m = date('m');
	 ?>
	<script>
	$(function() {

	  // handles AJAX requests for Graph Data
	  function requestData(){
	    $.ajax({
	      type: "GET",
	      url: "<?php echo $host . '/api/call-graph/'. $y .'-'. $m. '-01/' . date('Y-m-d')?>", // This is the URL to the API
	    }).done(function( data ) {
	      // When the response to the AJAX request comes back render the chart with new data
	      console.log(data);
	      chart.setData(JSON.parse(data));
	    })
	    .fail(function() {
	      // If there is no communication between the server, show an error
	      alert( "error occured" );
	    });
	  }

	  // Initializes Morris Line Graph with empty dataset
	  var chart = Morris.Line({
	    element: 'graph',
	    data: [],
	    xkey: 'period',
	    ykeys: ['inbound', 'outbound'],
	    labels: ['Inbound Calls', 'Outbound Calls']
	  });


	  // Request initial data for the past 5 days:
	  requestData();
	 
	});

	

	</script>

	<?php include_once 'footer.php';?>