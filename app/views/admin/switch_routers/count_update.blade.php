<div class="row show_form{{$meter['id']}}" style="display:none;">
    <div class="col-xs-12">
		<div class="widget-box widget-color-blue2">
			<div class="widget-header">
				<h4 class="widget-title lighter smaller">Update</h4>
			</div>
			<div class="widget-body">
				<div class="widget-main padding-8">
					<div class="row">
					    <div class="col-xs-12">
							<input type="hidden" name='find_count' value="1" class="form-control find_count{{$meter['id']}}" readonly="true"/>
						    <div class="update_meter{{$meter['id']}}">
								<div class="col-sm-12">
									<h5 class="col-sm-2 blue">USED FOR</h5>
									<h5 class="col-sm-2 blue">CRF NO</h5>
									<h5 class="col-sm-2 blue">ACCOUNT ID</h5>
									<h5 class="col-sm-1 blue">ID</h5>
									<h5 class="col-sm-1 blue">TOTAL</h5>
								</div>
								<div class="form-group col-sm-12">
						               	<div class="col-sm-2" >
					                        <select name="used_type[]" class="form-control used_type{{$meter['id']}}1" onchange="UsedType({{$meter['id']}},1)">
					                            <option value="">Select Usage Type</option>
					                            <option value="new_customers">New customers</option>
					                            <option value="exist_customers">Exist customers</option>
					                            <option value="damage">damage</option>
					                            <option value="left_over">left over</option>
					                        </select>
						                </div>
										<div class="col-sm-2">
											<input type="text" name='crf_no[]'  placeholder='CRF NO' class="form-control crf_no{{$meter['id']}}1" readonly="true"/>
										</div>
										<div class="col-sm-2">
											<input type="text" name='account_id[]'  placeholder='Account id' class="form-control account_id{{$meter['id']}}1" readonly="true"/>
										</div>
										<div class="col-sm-1">
											<input type="text" name='id[]'  placeholder='ID' class="form-control id{{$meter['id']}}1"/>
										</div>
										<div class="col-sm-1">
											<input type="text" name='total[]' placeholder='Total Meter' class="form-control t_meter{{$meter['id']}}1" onchange="TotalCount({{$meter['id']}},1)"/>
										</div>
										<span class="btn btn-minier btn-primary" onclick="addMeter({{$meter['id']}},1)">ADD</span>
								</div>

						    </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
