<? front_header(); 
$edata = $this->db->get_where("tbl_schedule_dates",["id"=>$r->event_name])->row();
$streams = $this->db->from('tbl_streams')->where("status","Active")->like('events', $r->event_name)->get()->result();
?>
<style>

	.price-heading{
		text-align: center;
	}
	.price-heading h1{
		margin-top: 75px;
	  	color: #666;
	/*  margin: 0;*/
	  	padding: 0 0 15px 0;
		font-size: 32px;
	}
	.card-view{
		background: #fff;
		margin-bottom: 30px;
		border: none;
		border-radius: 0;
		box-shadow: 0px 1px 25px rgb(0 0 0 / 10%);
		padding: 35px;
	}
	
</style>

 <section class="white-background black" id="inpage">
 	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!--PRICE HEADING START-->
				<div class="price-heading clearfix">
					<h1>Participants</h1>
					<p style="text-align: center; margin-bottom: 10px;">(<? echo $edata->event_name ?>)</p>
				</div>
				<!--//PRICE HEADING END-->
			</div>
		</div>
	</div>
	<div class="container">
    	<div class="row">
    		<div class="panel-wrapper collapse in">
				<div class="card-view row" style="padding: 20px;">
					<div class="col-md-6 pull-left">
						<p>
							<? if($r->event_category == "Individual-Faculty" || $r->event_category == "Students"){ ?>
								<strong>Name</strong> : <? echo $r->ifsrp_fullName ?><br>
							<? }elseif($r->event_category == "Retired-Professional"){ ?>	
								<strong>Name</strong> : <? echo $r->rp_name ?><br>
							<? }else{ ?>	
								<strong>Name</strong> : <? echo $r->cpname ?><br>
							<? } ?>	
							
							<? if($r->event_category == "Institution" || $r->event_category == "Individual-Faculty" || $r->event_category == "Industry" || $r->event_category == "R&D-Labs"){ ?>
								<strong>Designation/Department</strong> : <? echo $r->contact_person_designation.", ".$r->contact_person_department; ?><br>
							<? }elseif($r->event_category == "Students"){ ?>
								<strong>Course & Specialization Studying/Studied</strong> : <? echo $r->student_course_specialization; ?><br>
							<? }elseif($r->event_category == "Retired-Professional"){ ?>
								<strong>Designation at the time of Retirement</strong> : <? echo $r->rp_designation_Retirement; ?><br>
							<? } ?>	
						</p>
					</div>
					<div class="col-md-6">
						<p>
							<? if($r->event_category == "Institution"){ ?>
								<strong>Name of the Institution</strong> : <? echo $r->institutionName; ?><br>
							<? }elseif($r->event_category == "Individual-Faculty"){ ?>
								<strong>Name of the Institution (If Working)</strong> : <? echo $r->if_nameoftheInstitution_working; ?><br>
							<? }elseif($r->event_category == "Industry"){ ?>
								<strong>Name of the  Industry</strong> : <? echo $r->name_of_the_industry; ?><br>
							<? }elseif($r->event_category == "R&D-Labs"){ ?>
								<strong>Name of the Organization</strong> : <? echo $r->rd_name_of_the_organization; ?><br>
							<? }elseif($r->event_category == "Retired-Professional"){ ?>
								<strong>Name of the last worked Organisation</strong> : <? echo $r->rp_name_organization_retirement; ?><br>
							<? } ?>	
							
							<? if($r->event_category == "Institution"){ ?>	
								<strong>Type of the Institution</strong> : <? echo $r->institution_type; ?><br>
							<? } ?>	
						</p>
					</div>
				</div>
   			</div>
    		
    		<div class="panel-wrapper collapse in">
						        
				<div class="container">

				 <form id="formdata" method="post">
				  <div class="form-content card-view">
				   <? echo $this->session->flashdata("emsg") ?>

				<div id="error"></div>
				<? $programs = json_decode($r->topic); 
				   foreach($programs as $k => $p){
					   
					   if($p != "all"){
				?>
					<br>
					<h3 style="text-align: center;margin-bottom: 10px"><? echo $p; ?></h3>
					<hr><br>
					<div class="row">
					
					  <div class="col-md-12">
						<?
							   $pcount = $r->participants;
							   for($i=0;$i<$pcount;$i++){
								   $pa =  $cparticipants = $this->db->order_by("id","asc")->get_where("tbl_ripf_participants",["inst_id"=>$r->id,"program"=>$p])->result()[$i]; 
						  ?>
							
								<label style="margin-bottom: 10px"><strong>Participant <? echo $i+1 ?></strong></label>
								<div class="row">
								  
									<div class="col-md-11">
									  <div class="col-md-4">
										<div class="form-group">
										  <input type="text" class="form-control vparticipant<? echo $k.$i ?>pname" name="pname<? echo $k ?>[]" placeholder="Name" value="<? echo $pa->pname ?>">
										</div>
									  </div>
									  <div class="col-md-4">
										<div class="form-group">
										  <input type="text" class="form-control vparticipant<? echo $k.$i ?>designation" name="designation<? echo $k ?>[]" placeholder="Designation" value="<? echo $pa->designation ?>">
										</div>
									  </div>
									  <div class="col-md-4">
										<div class="form-group">
										  <input type="text" class="form-control vparticipant<? echo $k.$i ?>department" name="department<? echo $k ?>[]" placeholder="Department" value="<? echo $pa->department ?>">
										</div>
									  </div>
									  <div class="col-md-4">
										<div class="form-group">
										  <input type="text" class="form-control vparticipant<? echo $k.$i ?>pmobile" name="pmobile<? echo $k ?>[]" placeholder=" Mobile" maxlength="10" autocomplete="off" onkeypress="return event.charCode >= 48 &amp;&amp; event.charCode <= 57" <? echo ($pa->verification_status != "Active") ? '' : 'readonly' ?> value="<? echo $pa->pmobile ?>">
										</div>
									  </div>
									  
									  <div class="col-md-4">
										<div class="form-group">
										  <input type="email" class="form-control vparticipant<? echo $k.$i ?>pemail" name="pemail<? echo $k ?>[]" placeholder="Email" value="<? echo $pa->pemail ?>" <? echo ($pa->verification_status != "Active") ? '' : 'readonly' ?>>
										  <input type="hidden" class="form-control" name="serial_number<? echo $k ?>[]" placeholder="Collage Name" value="<? echo $pa->serial_number ?>" >
										  <input type="hidden" class="form-control" name="verification_status<? echo $k ?>[]" placeholder="Collage Name" value="<? echo $pa->verification_status ?>" >
										  <input type="hidden" class="form-control vparticipant<? echo $k.$i ?>participant_id" name="participant_id<? echo $k ?>[]" placeholder="Collage Name" value="<? echo $pa->id ?>" >
										  <input type="hidden" class="form-control vparticipant<? echo $k.$i ?>program" name="program<? echo $k ?>[]" placeholder="Collage Name" value="<? echo $p ?>" >
										</div>
									  </div>
									  <div class="col-md-4">
										<div class="form-group">
										  	<select class="form-control vparticipant<? echo $k.$i ?>pstream" name="pstream<? echo $k ?>[]">
										  		<option value="">Select Stream</option>
										  		<? 
													foreach($streams as $s){
														if(in_array($edata->id,json_decode($s->events))){
															$ssel = ($pa->category_name == $s->category) ? 'selected' : '';
															echo '<option value="'.$s->category.'" '.$ssel.'>'.$s->category.'</option>';
														}
													}	
												?>
											</select>
										</div>
									  </div>
									  
									 </div>
									 <div class="col-md-1">
									 	<? if($pa->verification_status != "Active"){ ?>
									 		<button type="button" class="btn btn-primary verifynonParticipant" vp="vparticipant<? echo $k.$i ?>" style="margin-top: 24px;">Verify</button>
									 	<? } ?>		
									 </div>
								  <div class="clearfix"></div>
								</div>
								
						<? } ?>				
					  </div>


					</div>
					
				<? }} ?>	

					<input type="hidden" name="order_id" value="<? echo $r->order_id ?>">
					<input type="hidden" name="institution_id" value="<? echo $r->id ?>">

					<div class="row" align="center">	
						<button type="submit" class="btn btn-success btnSubmit" style="margin-top: 20px;">Update Participants</button>	
						<a href="<? echo base_url('webinar/joinevent/').$edata->id ?>" class="btn btn-primary" style="margin-top: 20px;"><i class="fa fa-chevron-left"></i> Back</a>	
					</div>	
					<div class="clearfix"></div>
				  </div>



				  </form>
				</div>
			</div>
		</div>
	</div>
</section>	

<!-- Modal -->
<div id="enterOtp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" style="font-size: 30px;color: black;margin-top: -8px;">&times;</button>
        <h4 class="modal-title" style="color: black">Verify Participant</h4>
      </div>
      <div class="modal-body">
          <form method="post" id="confirmOtp">
			  <div class="form-content"> 
			  <div class="pmsg"></div>
				  <div class="row">
					  <div class="col-md-6">
						<label style="color: black">Mobile OTP</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Enter mobile otp" value="" name="motp" required>
						</div>
					  </div>
					  <div class="col-md-6">
						<label style="color: black">Email OTP</label>
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Enter email otp" value="" name="eotp" required>
						</div>
					  </div>
				  </div>

				  <div class="row">

					<div class="col-md-3"></div>
					<div class="col-md-6" align="center" style="margin-top: 20px">
						<input type="hidden" name="mobile" id="prmobile">	
						<input type="hidden" name="email" id="premail">	
						<input type="hidden" name="pname" id="pname">	
						<input type="hidden" name="designation" id="designation">	
						<input type="hidden" name="department" id="department">	
						<input type="hidden" name="participant_id" id="participant_id">	
						<input type="hidden" name="program" id="program">	
						<input type="hidden" name="stream" id="stream">	
						<input type="hidden" name="institution_id" value="<? echo $r->id ?>">	
						<button type="submit" class="btnSubmit btn btn-info">Confirm</button>

					</div>
					<div class="col-md-3"></div>

				  </div>
			  </div>
		  </form>
      
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>-->
    </div>
   </div>
  </div>
</div>

  </div>
</div>

<? front_footer() ?>

<script type="text/javascript">
		
	$(".verifynonParticipant").click(function(){
		
		var ref = $(this).attr("vp");
		$(".pmsg").html("");
		var email = $("."+ref+"pemail").val();
		var mobile = $("."+ref+"pmobile").val();
		var pname = $("."+ref+"pname").val();
		var designation = $("."+ref+"designation").val();
		var department = $("."+ref+"department").val();
		var participant_id = $("."+ref+"participant_id").val();
		var program = $("."+ref+"program").val();
		var stream = $("."+ref+"pstream").val();
		
		if(mobile == ""){
			swal("Error","Please Enter Mobile Number","error")
			return false;
		}
		if(email == ""){
			swal("Error","Please Enter Email","error")
			return false;
		}
		
		$.ajax({
			type : "post",
			data : {email:email,mobile:mobile},
			url : "<? echo base_url('ripf/verifyParticipant') ?>",
			success : function(data){
				$(".pmsg").html('<div class="alert alert-success">OTP successfully sent to participant email('+email+') & mobile number('+mobile+').</div>');
				$("#prmobile").val(mobile);
				$("#premail").val(email);
				$("#pname").val(pname);
				$("#designation").val(designation);
				$("#department").val(department);
				$("#participant_id").val(participant_id);
				$("#program").val(program);
				$("#stream").val(stream);
				$("#enterOtp").modal("show");
				console.log(data);
			},
			error : function(data){
				$(".pmsg").html("");
			}
		})
		
	})
	
	$("#confirmOtp").submit(function(e){
		$(".pmsg").html("");
		e.preventDefault();
		var fdata = $(this).serialize();
//		console.log(fdata);
//		return false;
		$.ajax({
			type : "post",
			data : fdata,
			dataType : "JSON",
			url : "<? echo base_url('ripf/confirmOtp') ?>",
			success : function(data){
				if(data.status == "success"){
					$(".pmsg").html(data.emsg);
					setTimeout(function(){location.reload()},3000);
					
				}else{
					$(".pmsg").html(data.emsg);
				}
				console.log(data);
			},
			error : function(data){
				$(".pmsg").html("");
				console.log(data);
			}
		})
	})

	$("#formdata").on("submit",function(e){
	
		e.preventDefault();
		
		var data = $("#formdata").serialize();
		
		$.ajax({
			
			"type" : "post",
			data : data,
			url : "<? echo base_url('ripf/updateParticipants') ?>",
			success : function(data){
				console.log(data);
				
				if(data == "success"){
					
					location.reload();
					
				}else{
					
					$("#error").html(data);
					return false;
					
				}
				
			},
			error : function(data){
				
				console.log(data);
				
			}
			
		});
		
	});

</script>
