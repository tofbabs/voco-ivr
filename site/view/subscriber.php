<?php include_once 'header.php'; ?>
			<!-- Middle section -->
			<div id="mid_wrap">

				<!-- Title & Date -->
				<div class="mid_tier_1">
					<!-- Title -->
					<div id="viewport_title" class="float_left">
						<div class="float_left"><img src="<?php echo PUBLIC_SITE ?>images/log.png" /></div>
						<div id="section_title" class="float_left">Subscribers</div>
						<br class="clearfloat"/>
					</div>
					
					<!-- Date -->
					<!-- <div id="date_select" class="float_right">
						<form id="config_form">
						<div class="float_left" style='border-right: solid 1px #CCC; padding-right: 10px; margin-right: 10px;'>
							<div class="float_left">
								<b style="display:block; padding-top:6px; padding-right:8px;">Date: </b>
							</div>
							<div class="float_left">
								<div class="float_left">
									<div class="float_left">
										<input type="text" id="datepick_start" name="start_date">
									</div>
									<div class="float_left">
										<input type="text" id="datepick_end" name="end_date">
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
					</div> -->

					<br class="clearfloat"/>
				</div>

				<!-- Report Viewport -->
				<div>
					<!-- Data Summary -->
					<div id="report_summary">
						<div id="inbound_summary">
							<div class="viewport_title">Summary</div>
							<div class="canvas">
								<table dir="ltr">
									<thead>
										<tr>
											<td class="summary_table_head_elem">Total Subscriber</td>
											<td  class="summary_table_head_elem">Generic</td>
											<td  class="summary_table_head_elem">Christian</td>
											<td  class="summary_table_head_elem">Muslim</td>
											<td  class="summary_table_head_elem">Inbound Call Duration</td>
										</tr>
									</thead>
									<tbody>
										<tr><td  class="summary_table_body_elem"><?php echo $total?></td>
											<td  class="summary_table_body_elem"><?php echo $generic?></td>
											<td  class="summary_table_body_elem"><?php echo $christian?></td>
											<td  class="summary_table_body_elem"><?php echo $muslim?></td>
											<td  class="summary_table_body_elem"><?php echo isset($total_call) ? gmdate("H:i:s", $total_call)  : 0  ?></td>
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
							<div class="viewport_title">Add New</div>
							<div class="viewport_canvas">
								<form id="login" enctype="multipart/form-data" action="<?php echo $host?>/subscriber" method="POST">
									

									<p class="form_element">
										
										<label><b>State: </b></label>
										<input list="state" name="state">
										<datalist id="state" name="state">
										  <option value="Anambra">
										  <option value="Enugu">
										  <option value="Akwa Ibom">
										  <option value="Adamawa">
										  <option value="Abia">
										  <option value="Bauchi">
										  <option value="Bayelsa">
										  <option value="Benue">
										  <option value="Borno">
										  <option value="Cross River">
										  <option value="Delta">
										  <option value="Ebonyi">
										  <option value="Edo">
										  <option value="Ekiti">
										  <option value="Gombe">
										  <option value="Imo">
										  <option value="Jigawa">
										  <option value="Kaduna">
										  <option value="Kano">
										  <option value="Katsina">
										  <option value="Kebbi">
										  <option value="Kogi">
										  <option value="Kwara">
										  <option value="Lagos">
										  <option value="Nasarawa">
										  <option value="Niger">
										  <option value="Ogun">
										  <option value="Ondo">
										  <option value="Osun">
										  <option value="Oyo">
										  <option value="Plateau">
										  <option value="Rivers">
										  <option value="Sokoto">
										  <option value="Taraba">
										  <option value="Yobe">
										  <option value="Zamfara">
										</datalist>
									</p>
									
									<p class="form_element">
										<label><b>Category: </b></label>
										<input type="radio" name="cat" value="generic" checked="checked" /> Generic
										<input type="radio" name="cat" value="muslim" /> Muslim
										<input type="radio" name="cat" value="christian" /> Christian
									</p> 

									<p class="form_element">
										<input type="hidden" name="MAX_FILE_SIZE" value="100000" />	
										<label><b>Choose a file to upload: </b></label> 
										<input name="file" type="file" /><br />
									</p>
									

									<div class="form_element">
										<input type="submit" class="btn" name="uploadSubBtn" />
									</div>
									
								</form>
							</div>
						</div>

						<!-- <div id="top_msisdn" class="float_right">
							<div class="viewport_title">Beep Subscribers</div>
							<div class="viewport_canvas">
								<form action="<?php echo $host?>/subscriber/beep" method="POST">
		
									<div class="form_element">
										<input type="submit" class="btn" value="Beep Now" />
									</div>
									
								</form>
							</div>
						</div> -->

						<br class="clearfloat"/>
					</div>
					
				</div>

				
			</div>
			
			<!-- Bottom section -->
			<div id="btm_wrap">

			</div>
		</div>
	</body>

	<script>

	$(function() {

		function formatDate(date) {
		    var d = new Date(date),
		        month = '' + (d.getMonth() + 1),
		        day = '' + d.getDate(),
		        year = d.getFullYear();

		    if (month.length < 2) month = '0' + month;
		    if (day.length < 2) day = '0' + day;

		    return [year, month, day].join('-');
		}

		formatDate('Sun Aug 08,2015') ;

		<?php
			$y = date('Y');
			$m = date('m');
		 ?>

	  // handles AJAX requests for Graph Data
	  function requestData(){
	    $.ajax({
	      type: "GET",
	      url: "<?php echo $host . '/api/sub-graph/'. $y .'-'. $m. '-01/' . date('Y-m-d')?>" // This is the URL to the API
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
	    ykeys: ['generic', 'christian', 'muslim'],
	    labels: ['Generic','Christian', 'Muslim']
	  });


	  // Request initial data for the past 5 days:
	  requestData();
	 
	});

	</script>

<?php include_once 'footer.php'; ?>