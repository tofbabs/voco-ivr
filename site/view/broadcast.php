<?php include_once 'header.php';?>
			
			<!-- Middle section -->
			<div id="mid_wrap">
				<!-- Title & Date -->
				<div class="mid_tier_1">
					<!-- Title -->
					<div id="viewport_title" class="float_left">
						<div class="float_left"><img src="<?php echo PUBLIC_SITE ?>images/log.png" /></div>
						<div id="section_title" class="float_left">Broadcast</div>
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
							<div class="viewport_title">Outbound Calls</div>
							<div class="canvas">
								<table dir="ltr">
									<thead>
										<tr>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Total Calls</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Answered</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">No Answer</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Busy</td>
											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Failed</td>
<!-- 											<td style="width:16.666666666666668%;" class="summary_table_head_elem">Outbound Call Duration</td> -->
										</tr>
									</thead>
									<tbody>
										<tr>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($total) ? $total : 0 ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($answered) ? $answered : 0 ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($not_answered) ? $not_answered : 0 ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($busy) ? $busy : 0  ?></td>
											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($failed) ? $failed : 0  ?></td>
<!-- 											<td style="width:16.666666666666668%;" class="summary_table_body_elem"><?php echo isset($total_call) ? gmdate("H:i:s", $total_call)  : 0  ?></td> -->
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>

					
					<!-- Data Graph -->
					<!-- <div id="report"> -->
						<div class="float_left">
							<div class="viewport_title">New Broadcast</div>

								<form method="post" action="./broadcast">

									<p id="textarea">
										<label for="comment">Phone Numbers:</label>
										<textarea class="form-control" name="msisdn" cols="50" rows="5" id="msisdn"></textarea>
									</p> <!-- / .tab-pane -->

									<!-- <p>
										<label for="file">Select Recording: </label>
										<input type="file" name="recording" title="Select Recording">
									</p> -->

									<p>
										<input type="submit" class="btn" name="startCampaignBtn" value="Push Broadcast">
									</p>

								</form>
								
						</div>

						<br class="clearfloat"/>
					<!-- </div> -->
				</div>
			</div>
			
			<!-- Bottom section -->
			<div id="btm_wrap"></div>
		</div>
	</body>

	<?php include_once 'footer.php';?>