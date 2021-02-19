<?php

$title = "Stock Form";
include_once "header.php";

$stock_id = $_GET['stock_id'];
$query = mysqli_query($link, "select * from gb_item where id='$stock_id'");
$res = mysqli_fetch_array($query);
$symbol = $res['item'];
$param = explode(',', $res['recom_type']);
$options = array('EY', 'TXT', 'BREAK Thru');

$query1 = mysqli_query($link, "select * from gb_item_transactions where stock_id='$stock_id'");
$qnty_hand = 0;
$total_price = 0;
$sum_price = 0;
$cnt = 0;

$query2 = mysqli_query($link, "select * from gb_item_rating where stock_id='$stock_id'");
$query3 = mysqli_query($link, "select * from gb_item_ed where stock_id='$stock_id'");
$query4 = mysqli_query($link, "select * from gb_item_notes where stock_id='$stock_id'");
?>

<!--begin::Container-->
<div class="container">
	<div class="card card-custom gutter-b">
		<div class="card-body">
			<form action="add-stock.php" method="post">
				<div class="form-group d-flex">
					<label class="mx-2 p-2">ITEM</label>
					<input type="text" class="form-control" value="<?=$symbol ?>" readonly/>
				</div>
			</form>
		</div>
	</div>
	<!--begin::Card-->
	<div class="card card-custom gutter-b">
		<div class="card-header flex-wrap border-0 pt-6 pb-0">
			<div class="card-title">
				<h3 class="card-label">Transactions</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				<a href="javascript:;" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#transactionModal">
				<span class="svg-icon svg-icon-md">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24" />
							<circle fill="#000000" cx="9" cy="15" r="6" />
							<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>Add New</a>
				<!--end::Button-->
				<!-- Modal-->
				<div class="modal fade" id="transactionModal" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Add Transactions</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true" class="ki ki-close"></i>
								</button>
							</div>
							<form action="add-transaction.php" method="post">
								<input name="stockid" value="<?=$stock_id?>" hidden />
								<div class="modal-body">
									<div class="form-group">
										<label class="mx-2 p-2">Type</label>
										<select class="form-control" name="type">
											<option value="Bought">Buy</option>
											<option value="Sold">Sell</option>
										</select>
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">Qnty</label>
										<input type="text" name="qnty" class="form-control" />
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">Price</label>
										<input type="text" name="price" class="form-control" />
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">Date</label>
										<div class="input-group date mb-2">
											<input type="text" class="form-control kt_datepicker_4_2" name="date" placeholder="mm/dd/yyyy" value="<?=date('m/d/Y')?>"/>
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-clock-o"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End Modal -->
			</div>
		</div>
		<div class="card-body">
			<!--begin: Datatable-->
			<table class="table table-separate table-head-custom table-checkable kt_datatable1">
				<thead>
					<tr>
						<th>ID</th>
						<th>Type</th>
						<th>Qnty</th>
						<th>Price</th>
						<th>Total</th>
						<th>Date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_array($query1)) { 
						if ($row['trans_type'] == 'Bought') {
							$qnty_hand += $row['qnty'];
							$sum_price += $row['qnty']*$row['price'];
						} else {
							$qnty_hand -= $row['qnty'];
							$sum_price -= $row['qnty']*$row['price'];
						}
						$cnt++;
						$total_price += $row['price'];
					?>
						<tr>
							<td><?=$row['id']?></td>
							<td><?=$row['trans_type']?></td>
							<td><?=$row['qnty']?></td>
							<td>$<?=$row['price']?></td>
							<td>$<?=$row['total']?></td>
							<td><?=$row['trans_date']?></td>
							<td nowrap="nowrap">
								<div class="dropdown dropdown-inline">
									<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details" data-toggle="modal" data-target="#transactionModal<?=$row['id']?>">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
													<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
												</g>
											</svg>
										</span>
									</a>
									<a href="add-transaction.php?tid=<?=$row['id']?>" class="btn btn-sm btn-clean btn-icon" title="Delete">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
													<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
												</g>
											</svg>
										</span>
									</a>
								</div>
							</td>
							<div class="modal fade" id="transactionModal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="transactionModalLabel<?=$row['id']?>" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Add Transactions</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i aria-hidden="true" class="ki ki-close"></i>
											</button>
										</div>
										<form action="add-transaction.php" method="post">
											<input name="stockid" value="<?=$stock_id?>" hidden />
											<input name="transactionid" value="<?=$row['id']?>" hidden />
											<div class="modal-body">
												<div class="form-group">
													<label class="mx-2 p-2">Type</label>
													<select class="form-control" name="type">
														<option value="Bought" <?php if($row['trans_type'] == 'Bought'){?> selected <?php }?>>Buy</option>
														<option value="Sold" <?php if($row['trans_type'] == 'Sold'){?> selected <?php }?>>Sell</option>
													</select>
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">Qnty</label>
													<input type="text" name="qnty" class="form-control" value="<?=$row['qnty']?>" />
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">Price</label>
													<input type="text" name="price" class="form-control" value="<?=$row['price']?>" />
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">Date</label>
													<div class="input-group date mb-2">
														<input type="text" class="form-control kt_datepicker_4_2" name="date" placeholder="mm/dd/yyyy" value="<?=$row['trans_date']?>"/>
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-clock-o"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</tr>
					<?php } ?>
				</tbody>
				<tr class="total">
					<td></td>
					<td></td>
					<td>Total: <?=$qnty_hand?></td>
					<td>AVG: $<?=$cnt === 0 ? 0 : round($total_price/$cnt, 2)?></td>
					<td>Total: $<?=$sum_price?></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			<!--end: Datatable-->
		</div>
	</div>
	<!--end::Card-->
	<div class="card card-custom gutter-b">
		<div class="card-body">
			<form action="update-stock.php" method="post">
				<input name="stockid" value="<?=$stock_id?>" hidden />
				<div class="form-group">
					<label class="mx-2 p-2">Trigger Price</label>
					<input type="text" name="trigger_price" class="form-control" value="<?=$res['trigger_price']?>"/>
				</div>
				<div class="form-group">
					<label class="mx-2 p-2">Projection Price</label>
					<input type="text" name="projection_price" class="form-control" value="<?=$res['projection_price']?>"/>
				</div>
				<div class="form-group">
					<label class="mx-2 p-2">Recommended</label>
					<label class="checkbox checkbox-square checkbox-primary">
						<input type="checkbox" <?php if($res['recommended'] == 'Y') { ?> checked <?php }?> name="recommended" />
						<span></span>
					</label>
				</div>
				<div class="form-group">
					<label class="mx-2 p-2">Date Recommended</label>
					<div class="input-group date mb-2">
						<input type="text" class="form-control kt_datepicker_4_2" name="recom_date" placeholder="mm/dd/yyyy" value="<?=$res['recom_date'] == '' ? date('m/d/Y') : $res['recom_date']?>"/>
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-clock-o"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="mx-2 p-2">Recommended Type</label>
					<div>
						<select class="form-control select2" id="kt_select2_3" name="param[]" multiple="multiple" value="">
							<?php foreach($options as $item) {
								if(in_array($item, $param)){?>
									<option value="<?=$item?>" selected><?=$item?></option>
								<?php } else { ?>
									<option value="<?=$item?>" ><?=$item?></option>
								<?php }
							} ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="mx-2 p-2">Date Created</label>
					<div class="input-group date mb-2">
						<input type="text" class="form-control kt_datepicker_4_2" name="date_created" placeholder="mm/dd/yyyy" value="<?=$res['date_created'] == '' ? date('m/d/Y') : $res['date_created']?>"/>
						<div class="input-group-append">
							<span class="input-group-text">
								<i class="la la-clock-o"></i>
							</span>
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
			</form>
		</div>
	</div>
	<!--begin::Card-->
	<div class="card card-custom gutter-b">
		<div class="card-header flex-wrap border-0 pt-6 pb-0">
			<div class="card-title">
				<h3 class="card-label">Rating(listing)</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				<a href="javascript:;" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#ratingsModal">
				<span class="svg-icon svg-icon-md">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24" />
							<circle fill="#000000" cx="9" cy="15" r="6" />
							<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>Add New</a>
				<!--end::Button-->
				<!-- Modal-->
				<div class="modal fade" id="ratingsModal" tabindex="-1" role="dialog" aria-labelledby="ratingsModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Rating</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true" class="ki ki-close"></i>
								</button>
							</div>
							<form action="add-rating.php" method="post">
								<input name="stockid" value="<?=$stock_id?>" hidden />
								<div class="modal-body">
									<div class="form-group">
										<label class="mx-2 p-2">Company</label>
										<input type="text" name="company" class="form-control" />
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">Rating</label>
										<select class="form-control" name="rating">
											<option value="Good">Good</option>
											<option value="Very Good">Very Good</option>
											<option value="Excellent">Excellent</option>
											<option value="Poor">Poor</option>
										</select>
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">Price target</label>
										<input type="text" name="price_target" class="form-control" />
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">Date</label>
										<div class="input-group date mb-2">
											<input type="text" class="form-control kt_datepicker_4_2" name="date" placeholder="mm/dd/yyyy" value="<?=date("m/d/Y")?>"/>
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-clock-o"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End Modal -->
			</div>
		</div>
		<div class="card-body">
			<!--begin: Datatable-->
			<table class="table table-separate table-head-custom table-checkable kt_datatable1">
				<thead>
					<tr>
						<th>Company</th>
						<th>Rating</th>
						<th>Price Target</th>
						<th>Date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_array($query2)) { 
					?>
						<tr>
							<td><?=$row['company']?></td>
							<td><?=$row['rating']?></td>
							<td><?=$row['price_target']?></td>
							<td>$<?=$row['rate_date']?></td>
							<td nowrap="nowrap">
								<div class="dropdown dropdown-inline">
									<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details" data-toggle="modal" data-target="#ratingsModal<?=$row['id']?>">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
													<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
												</g>
											</svg>
										</span>
									</a>
									<a href="add-rating.php?ratingid=<?=$row['id']?>" class="btn btn-sm btn-clean btn-icon" title="Delete">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
													<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
												</g>
											</svg>
										</span>
									</a>
								</div>
							</td>
							<div class="modal fade" id="ratingsModal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="ratingsModalLabel<?=$row['id']?>" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Rating</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i aria-hidden="true" class="ki ki-close"></i>
											</button>
										</div>
										<form action="add-rating.php" method="post">
											<input name="stockid" value="<?=$stock_id?>" hidden />
											<input name="ratingid" value="<?=$row['id']?>" hidden />
											<div class="modal-body">
												<div class="form-group">
													<label class="mx-2 p-2">Company</label>
													<input type="text" name="company" class="form-control" value="<?=$row['company']?>" />
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">Rating</label>
													<select class="form-control" name="rating">
														<option value="Good" <?php if($row['rating'] == 'Good'){?> selected <?php }?>>Good</option>
														<option value="Very Good" <?php if($row['rating'] == 'Very Good'){?> selected <?php }?>>Very Good</option>
														<option value="Excellent" <?php if($row['rating'] == 'Excellent'){?> selected <?php }?>>Excellent</option>
														<option value="Poor" <?php if($row['rating'] == 'Poor'){?> selected <?php }?>>Poor</option>
													</select>
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">Price target</label>
													<input type="text" name="price_target" class="form-control" value="<?=$row['price_target']?>" />
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">Date</label>
													<div class="input-group date mb-2">
														<input type="text" class="form-control kt_datepicker_4_2" name="date" placeholder="mm/dd/yyyy" value="<?=$row['rate_date']?>" />
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-clock-o"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<!--end: Datatable-->
		</div>
	</div>
	<!--end::Card-->
	<!--begin::Card-->
	<div class="card card-custom gutter-b">
		<div class="card-header flex-wrap border-0 pt-6 pb-0">
			<div class="card-title">
				<h3 class="card-label">ED(listing)</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				<a href="javascript:;" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#edsModal">
				<span class="svg-icon svg-icon-md">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24" />
							<circle fill="#000000" cx="9" cy="15" r="6" />
							<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>Add New</a>
				<!--end::Button-->
				<!-- Modal-->
				<div class="modal fade" id="edsModal" tabindex="-1" role="dialog" aria-labelledby="edsModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">ED</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true" class="ki ki-close"></i>
								</button>
							</div>
							<form action="add-ed.php" method="post">
								<input name="stockid" value="<?=$stock_id?>" hidden />
								<div class="modal-body">
									<div class="form-group">
										<label class="mx-2 p-2">ED Date</label>
										<div class="input-group date mb-2">
											<input type="text" class="form-control kt_datepicker_4_2" name="ed_date" placeholder="mm/dd/yyyy" value="<?=date('m/d/Y')?>"/>
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-clock-o"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">ED Price</label>
										<input type="text" name="ed_price" class="form-control" />
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">ED Chg%</label>
										<input type="text" name="ed_chg" class="form-control" />
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End Modal -->
			</div>
		</div>
		<div class="card-body">
			<!--begin: Datatable-->
			<table class="table table-separate table-head-custom table-checkable kt_datatable1">
				<thead>
					<tr>
						<th>ED Date</th>
						<th>ED Price</th>
						<th>ED Chg %</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_array($query3)) { 
					?>
						<tr>
							<td><?=$row['ed_date']?></td>
							<td><?=$row['ed_price']?></td>
							<td><?=$row['ed_chg']?></td>
							<td nowrap="nowrap">
								<div class="dropdown dropdown-inline">
									<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details" data-toggle="modal" data-target="#edsModal<?=$row['id']?>">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
													<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
												</g>
											</svg>
										</span>
									</a>
									<a href="add-ed.php?edid=<?=$row['id']?>" class="btn btn-sm btn-clean btn-icon" title="Delete">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
													<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
												</g>
											</svg>
										</span>
									</a>
								</div>
							</td>
							<div class="modal fade" id="edsModal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="edsModalLabel<?=$row['id']?>" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">ED</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i aria-hidden="true" class="ki ki-close"></i>
											</button>
										</div>
										<form action="add-ed.php" method="post">
											<input name="stockid" value="<?=$stock_id?>" hidden />
											<input name="edid" value="<?=$row['id']?>" hidden />
											<div class="modal-body">
												<div class="form-group">
													<label class="mx-2 p-2">ED Date</label>
													<div class="input-group date mb-2">
														<input type="text" class="form-control kt_datepicker_4_2" name="ed_date" placeholder="mm/dd/yyyy" value="<?=$row['ed_date']?>"/>
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-clock-o"></i>
															</span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">ED Price</label>
													<input type="text" name="ed_price" class="form-control" value="<?=$row['ed_price']?>" />
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">ED Chg%</label>
													<input type="text" name="ed_chg" class="form-control" value="<?=$row['ed_chg']?>" />
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<!--end: Datatable-->
		</div>
	</div>
	<!--end::Card-->
	<!--begin::Card-->
	<div class="card card-custom gutter-b">
		<div class="card-header flex-wrap border-0 pt-6 pb-0">
			<div class="card-title">
				<h3 class="card-label">Note</h3>
			</div>
			<div class="card-toolbar">
				<!--begin::Button-->
				<a href="javascript:;" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#notesModal">
				<span class="svg-icon svg-icon-md">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24" />
							<circle fill="#000000" cx="9" cy="15" r="6" />
							<path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
						</g>
					</svg>
					<!--end::Svg Icon-->
				</span>Add New</a>
				<!--end::Button-->
				<!-- Modal-->
				<div class="modal fade" id="notesModal" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Notes</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i aria-hidden="true" class="ki ki-close"></i>
								</button>
							</div>
							<form action="add-note.php" method="post">
								<input name="stockid" value="<?=$stock_id?>" hidden />
								<div class="modal-body">
									<div class="form-group">
										<label class="mx-2 p-2">Date</label>
										<div class="input-group date mb-2">
											<input type="text" class="form-control kt_datepicker_4_2" name="notes_date" placeholder="mm/dd/yyyy" value="<?=date('m/d/Y')?>"/>
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="la la-clock-o"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="mx-2 p-2">Notes</label>
										<textarea type="text" rows="5" name="notes" class="form-control"></textarea>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- End Modal -->
			</div>
		</div>
		<div class="card-body">
			<!--begin: Datatable-->
			<table class="table table-separate table-head-custom table-checkable kt_datatable1">
				<thead>
					<tr>
						<th>Date</th>
						<th>Note</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php while($row = mysqli_fetch_array($query4)) { 
					?>
						<tr>
							<td><?=$row['notes_date']?></td>
							<td><?=$row['notes']?></td>
							<td nowrap="nowrap">
								<div class="dropdown dropdown-inline">
									<a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details" data-toggle="modal" data-target="#notesModal<?=$row['id']?>">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
													<rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
												</g>
											</svg>
										</span>
									</a>
									<a href="add-note.php?noteid=<?=$row['id']?>" class="btn btn-sm btn-clean btn-icon" title="Delete">
										<span class="svg-icon svg-icon-md">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24"/>
													<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
													<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
												</g>
											</svg>
										</span>
									</a>
								</div>
							</td>
							<div class="modal fade" id="notesModal<?=$row['id']?>" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel<?=$row['id']?>" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Notes</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<i aria-hidden="true" class="ki ki-close"></i>
											</button>
										</div>
										<form action="add-note.php" method="post">
											<input name="stockid" value="<?=$stock_id?>" hidden />
											<input name="noteid" value="<?=$row['id']?>" hidden />
											<div class="modal-body">
												<div class="form-group">
													<label class="mx-2 p-2">Date</label>
													<div class="input-group date mb-2">
														<input type="text" class="form-control kt_datepicker_4_2" name="notes_date" placeholder="mm/dd/yyyy" value="<?=$row['notes_date']?>" />
														<div class="input-group-append">
															<span class="input-group-text">
																<i class="la la-clock-o"></i>
															</span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="mx-2 p-2">Notes</label>
													<textarea type="text" rows="5" name="notes" class="form-control"><?=$row['notes']?></textarea>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary font-weight-bold">Save</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</tr>
					<?php } ?>
				</tbody>
			</table>
			<!--end: Datatable-->
		</div>
	</div>
	<!--end::Card-->
</div>
<!--end::Container-->
</div>
<!--end::Entry-->
</div>
<!--end::Content-->
<?php
include_once "footer.php";
?>