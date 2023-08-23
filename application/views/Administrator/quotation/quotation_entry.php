<style>
	.v-select {
		margin-bottom: 5px;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: 0px;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 2px 0px;
		white-space: nowrap;
		position: absolute;
		left: 0px;
	}

	.v-select .vs__actions {
		margin-top: -5px;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}

	#branchDropdown .vs__actions button {
		display: none;
	}

	#branchDropdown .vs__actions .open-indicator {
		height: 15px;
		margin-top: 7px;
	}
</style>

<div id="quotation" class="row">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
		<div class="row">
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> Invoice no </label>
				<div class="col-sm-2">
					<input type="text" class="form-control" v-model="quotation.invoiceNo" readonly />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right text-right"> Quote. By </label>
				<div class="col-sm-2">
					<input type="text" class="form-control" v-model="quotation.quotationBy" readonly />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right text-right"> Quote. From </label>
				<div class="col-sm-2">
					<v-select id="branchDropdown" v-bind:options="branches" label="Brunch_name" v-model="selectedBranch" disabled></v-select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-3">
					<input class="form-control" type="date" v-model="quotation.quotationDate" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> Ref. Number </label>
				<div class="col-sm-2">
					<input type="text" class="form-control" v-model="quotation.Ref_Number" placeholder="Ref number" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right text-right"> Currency </label>
				<div class="col-sm-2">
					<v-select v-bind:options="currencies" v-model="selectedCurrency" label="currency_name"></v-select>
					<!-- <input type="text" class="form-control" v-model="quotation.quotationBy" readonly /> -->
				</div>
			</div>

			<!-- <div class="form-group" style="display:none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}">
				<label class="col-sm-1 control-label no-padding-right text-right"> Con. Rate </label>
				<div class="col-sm-2">
					<input type="text" class="form-control" v-model="quotation.conversionRate" v-on:input="updateTotal" />
				</div>
			</div> -->
		</div>
	</div>


	<div class="col-xs-9 col-md-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Quotation Information</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">

					<div class="row">
						<div class="col-sm-5">
							<!-- <div class="form-group clearfix">
								<label class="col-sm-4 control-label no-padding-right"> Customer</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" v-model="quotation.customerName" placeholder="Customer/Company Name">
								</div>
							</div> -->
							<div class="form-group clearfix" style="margin-bottom: 8px;">
								<label class="col-xs-4 control-label no-padding-right"> Sales Type </label>
								<div class="col-xs-8">
									<input type="radio" name="salesType" value="retail" v-model="quotation.salesType" v-on:change="onSalesTypeChange"> Retail &nbsp;
									<input type="radio" name="salesType" value="wholesale" v-model="quotation.salesType" v-on:change="onSalesTypeChange"> Wholesale
								</div>
							</div>
							<div class="form-group">
								<label class="col-xs-4 control-label no-padding-right"> Customer </label>
								<div class="col-xs-7">
									<v-select v-bind:options="customers" label="display_name" v-model="selectedCustomer"></v-select>
								</div>
								<div class="col-xs-1" style="padding: 0;">
									<a href="<?= base_url('customer') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Customer"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right"> Mobile No </label>
								<div class="col-sm-8">
									<input type="text" placeholder="Mobile No" class="form-control" v-model="selectedCustomer.Customer_Mobile" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right"> Email </label>
								<div class="col-sm-8">
									<input type="text" placeholder="Email" class="form-control" v-model="selectedCustomer.Customer_Email" />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-4 control-label no-padding-right"> Address </label>
								<div class="col-sm-8">
									<textarea placeholder="Address" class="form-control" v-model="selectedCustomer.Customer_Address"></textarea>
								</div>
							</div>
						</div>

						<div class="col-sm-5">
							<form v-on:submit.prevent="addToCart">
								<div class="form-group">
									<label class="col-xs-3 control-label no-padding-right"> Brand </label>
									<div class="col-xs-9">
										<v-select v-bind:options="brands" v-model="selectedBrand" label="brand_name" v-on:input="brandOnChange"></v-select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Product </label>
									<div class="col-sm-8">
										<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="productOnChange"></v-select>
									</div>
									<div class="col-sm-1" style="padding: 0;">
										<a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>

								<div class="form-group" style="display: none;">
									<label class="col-sm-3 control-label no-padding-right"> Brand </label>
									<div class="col-sm-9">
										<input type="text" placeholder="Group" class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Sale Rate </label>
									<div class="col-sm-9">
										<input type="number" placeholder="Rate" class="form-control" v-model="selectedProduct.Product_SellingPrice" v-on:input="productTotal" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Quantity </label>
									<div class="col-sm-9">
										<input type="number" id="quantity" placeholder="Qty" class="form-control" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" autocomplete="off" required />
									</div>
								</div>

								<div class="form-group" style="display:none;">
									<label class="col-sm-3 control-label no-padding-right"> Discount</label>
									<div class="col-sm-9">
										<span>(%)</span>
										<input type="text" placeholder="Discount" class="form-control" style="display: inline-block; width: 90%" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> Amount </label>
									<div class="col-sm-9">
										<input type="text" placeholder="Amount" class="form-control" v-model="selectedProduct.total" readonly />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> </label>
									<div class="col-sm-9">
										<button type="submit" class="btn btn-default pull-right">Add to Cart</button>
									</div>
								</div>
							</form>

						</div>
						<div class="col-sm-2">
							<input type="password" ref="productPurchaseRate" v-model="selectedProduct.Product_Purchase_Rate" v-on:mousedown="toggleProductPurchaseRate" v-on:mouseup="toggleProductPurchaseRate" v-on:mouseout="$refs.productPurchaseRate.type = 'password'" readonly title="Purchase rate (click & hold)" style="font-size:12px;width:100%;text-align: center;">
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
					<thead>
						<tr class="">
							<th style="width:10%;color:#000;">Sl</th>
							<th style="width:25%;color:#000;">Category</th>
							<th style="width:20%;color:#000;">Product Name</th>
							<th style="width:7%;color:#000;">Qty</th>
							<th style="width:8%;color:#000;">Rate</th>
							<th style="width:15%;color:#000;display: none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}">Convert Rate</th>
							<th style="width:15%;color:#000;">Total Amount</th>
							<th style="width:15%;color:#000;">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart">
							<td>{{ sl + 1 }}</td>
							<td>{{ product.categoryName }}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.salesRate }}</td>
							<td style="display: none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}">
								<input type="number" step="0.01" min="0" class="form-control text-center" v-model="product.convertRate" v-on:input="updateTotal(sl)">
							</td>
							<td>{{ product.total }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>
						<tr>
							<td colspan="5">
								<textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="companyProfile.terms_condition"></textarea>
							</td>
							<td style="font-weight: 600;padding: 15px 0px;font-size: 20px;">{{ quotation.total }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">Amount Details</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Sub Total</label>
												<div class="col-sm-12">
													<input type="number" class="form-control" v-model="quotation.subTotal" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right"> Vat </label>
												<div class="col-sm-4">
													<input type="number" class="form-control" v-model="vatPercent" v-on:input="calculateTotal" />
												</div>
												<label class="col-sm-1 control-label no-padding-right">%</label>
												<div class="col-sm-7">
													<input type="number" id="vatTaka" class="form-control" v-model="quotation.vat" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr style="display:none;">
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Freight</label>
												<div class="col-sm-12">
													<input type="number" class="form-control" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Discount Persent</label>

												<div class="col-sm-4">
													<input type="number" class="form-control" v-model="discountPercent" v-on:input="calculateTotal" />
												</div>

												<label class="col-sm-1 control-label no-padding-right">%</label>

												<div class="col-sm-7">
													<input type="number" id="discount" class="form-control" v-model="quotation.discount" v-on:input="calculateTotal" />
												</div>

											</div>
										</td>
									</tr>

									<tr style="display:none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Transport Cost</label>
												<div class="col-xs-12">
													<input type="number" class="form-control" v-model="quotation.transportCost" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr style="display:none;">
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Round Of</label>
												<div class="col-sm-12">
													<input type="number" class="form-control" />
												</div>
											</div>
										</td>
									</tr>

									<tr style="display: none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Payment Method</label>
												<div class="col-xs-12">
													<select v-model="quotation.payment_method" id="" class="form-control" style="border-radius: 4px;padding:0px 4px;">
														<option value="" selected>Select</option>
														<option value="Cash">Cash</option>
														<option value="Bank">Bank</option>
													</select>
												</div>
											</div>
										</td>
									</tr>

									<tr style="display: none;" :style="{display: quotation.payment_method == 'Bank' ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Bank Name</label>
												<div class="col-xs-12">
													<select v-model="quotation.bank_name" id="" class="form-control" style="border-radius: 4px;padding:0px 4px;">
														<option value="" disabled selected>Select</option>
														<option v-for="bank in bankAccount" :value="bank.account_id">{{ bank.bank_name}} - {{bank.account_number}}</option>
													</select>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label no-padding-right">Total</label>
												<div class="col-sm-12">
													<input type="number" class="form-control" v-model="quotation.total" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr style="display:none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label no-padding-right">Paid</label>
												<div class="col-xs-12">
													<input type="number" id="paid" class="form-control" v-model="quotation.paid" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr style="display:none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-xs-12 control-label">Due</label>
												<div class="col-xs-6">
													<input type="number" id="due" class="form-control" v-model="quotation.due" readonly />
												</div>
												<div class="col-xs-6">
													<input type="number" id="previousDue" class="form-control" v-model="quotation.previousDue" readonly style="color:red;" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group text-center">
												<input style="display:none;width:30%" :style="{display: quotation.quotationId == '0' ? '' : 'none'}" type="button" class="btn btn-default" value="Save" v-on:click="saveQuotation" style="color:#fff;margin: 0px;">

												<input style="display:none;width:58%" :style="{display: quotation.quotationId == '0' ? '' : 'none'}" type=" button" class="btn btn-info" value="New Quotation" v-on:click="window.location = '/quotation'" style="color:#fff;margin: 0px;">

												<input style="display:none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}" type="button" class="btn btn-default" value="Sale" v-on:click="saleQuotation" style="color:#fff;margin-top: 0px;">

												<input style="display:none;" :style="{display: quotation.quotationId != '0' ? '' : 'none'}" type="button" class="btn btn-info" value="Update Quotation" v-on:click="saveQuotation" style="color:#fff;margin-top: 0px;">
											</div>
										</td>
									</tr>

								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#quotation',
		data() {
			return {
				quotation: {
					quotationId: parseInt('<?php echo $quotationId; ?>'),
					invoiceNo: '<?php echo $invoice; ?>',
					salesType: 'retail',
					payment_method: 'Cash',
					bank_name: '',
					Ref_Number: '',
					quotationBy: '<?php echo $this->session->userdata("FullName"); ?>',
					quotationFrom: '',
					quotationDate: '',
					subTotal: 0.00,
					discount: 0.00,
					vat: 0.00,
					total: 0.00,
					paid: 0.00,
					transportCost: 0.00,
					previousDue: 0.00,
					due: 0.00,
					conversionRate: 0,
				},
				bankAccount: [],
				vatPercent: 0,
				discountPercent: 0,
				cart: [],
				backCart: [],
				branches: [],
				selectedBranch: {
					brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
					Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
				},
				brands: [],
				selectedBrand: {
					brand_SiNo: '',
					brand_name: 'Select Brand'
				},
				customers: [],
				selectedCustomer: {
					Customer_SlNo: '',
					Customer_Code: '',
					Customer_Name: '',
					display_name: 'Select Customer',
					Customer_Mobile: '',
					Customer_Address: '',
					Customer_Type: ''
				},
				products: [],
				selectedProduct: {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: 0,
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					total: 0.00
				},
				currencies: [{
						symbol: '$',
						currency_name: 'Doller ($)'
					},
					{
						symbol: '€',
						currency_name: 'Euro (€)'
					},
					{
						symbol: '৳',
						currency_name: 'BDT (৳)'
					},
				],
				selectedCurrency: {
					symbol: '',
					currency_name: 'Select'
				},
				companyProfile: {
					terms_condition: '',
				}
			}
		},
		created() {
			this.quotation.quotationDate = moment().format('YYYY-MM-DD');
			this.getBranches();
			// this.getProducts();
			this.getCompanyProfile();
			this.getCustomers();
			this.getBrands();
			this.getBank();

			if (this.quotation.quotationId != 0) {
				this.getQuotations();
			}
		},
		methods: {
			updateTotal(sl) {
				this.cart[sl].total = (this.cart[sl].salesRate * this.cart[sl].convertRate) * this.cart[sl].quantity;
				this.calculateTotal();
			},
			getBank() {
				axios.get('/get_bank_accounts').then(res => {
					this.bankAccount = res.data;
				})
			},
			getBrands() {
				axios.get('/get_brands').then(res => {
					this.brands = res.data;
				})
			},
			brandOnChange() {
				if (this.selectedBrand.brand_SiNo == '') return;
				this.selectedProduct = {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: 0,
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					vat: 0.00,
					total: 0.00
				}
				this.getProducts();
			},
			async getCustomers() {
				await axios.post('/get_customers', {
					customerType: this.quotation.salesType
				}).then(res => {
					this.customers = res.data;
					this.customers.unshift({
						Customer_SlNo: 'C01',
						Customer_Code: '',
						Customer_Name: '',
						display_name: 'General Customer',
						Customer_Mobile: '',
						Customer_Address: '',
						Customer_Type: 'G'
					})
				})
			},
			async getCustomerDue() {
				await axios.post('/get_customer_due', {
					customerId: this.selectedCustomer.Customer_SlNo
				}).then(res => {
					if (res.data.length > 0) {
						this.quotation.previousDue = res.data[0].dueAmount;
					} else {
						this.quotation.previousDue = 0;
					}
				})
			},
			onSalesTypeChange() {
				this.selectedCustomer = {
					Customer_SlNo: '',
					Customer_Code: '',
					Customer_Name: '',
					display_name: 'Select Customer',
					Customer_Mobile: '',
					Customer_Address: '',
					Customer_Type: ''
				}
				this.getCustomers();

				this.clearProduct();
				this.getProducts();
			},
			getCompanyProfile() {
				axios.get('/get_company_profile').then(res => {
					this.companyProfile = res.data;
				})
			},
			getBranches() {
				axios.get('/get_branches').then(res => {
					this.branches = res.data;
				})
			},
			getProducts() {
				if (this.selectedBrand.brand_SiNo == '') return;
				axios.post('/get_products', {
					brandId: this.selectedBrand.brand_SiNo
				}).then(res => {
					this.products = res.data;
				})
			},
			productTotal() {
				this.selectedProduct.total = (parseFloat(this.selectedProduct.quantity) * parseFloat(this.selectedProduct.Product_SellingPrice)).toFixed(2);
			},
			productOnChange() {
				this.$refs.quantity.focus();
			},
			toggleProductPurchaseRate() {
				//this.productPurchaseRate = this.productPurchaseRate == '' ? this.selectedProduct.Product_Purchase_Rate : '';
				this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' : 'text';
			},
			addToCart() {
				let product = {
					productCode: this.selectedProduct.Product_Code,
					productId: this.selectedProduct.Product_SlNo,
					categoryName: this.selectedProduct.ProductCategory_Name,
					name: this.selectedProduct.Product_Name,
					salesRate: this.selectedProduct.Product_SellingPrice,
					quantity: this.selectedProduct.quantity,
					convertRate: 0,
					total: this.selectedProduct.total,
					vat: this.selectedProduct.vat,
					purchaseRate: this.selectedProduct.Product_Purchase_Rate,
				}

				if (product.productId == '') {
					alert('Select Product');
					return;
				}

				if (product.quantity == 0 || product.quantity == '') {
					alert('Enter quantity');
					return;
				}

				if (product.salesRate == 0 || product.salesRate == '') {
					alert('Enter sales rate');
					return;
				}

				let cartInd = this.cart.findIndex(p => p.productId == product.productId);
				if (cartInd > -1) {
					this.cart.splice(cartInd, 1);
				}

				this.cart.unshift(product);
				this.clearProduct();
				this.calculateTotal();
			},
			removeFromCart(ind) {
				this.cart.splice(ind, 1);
				this.calculateTotal();
			},
			clearProduct() {
				this.selectedProduct = {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					quantity: 0,
					Product_SellingPrice: 0.00,
					total: 0.00
				}
			},
			calculateTotal() {
				this.quotation.subTotal = this.cart.reduce((prev, curr) => {
					return prev + parseFloat(curr.total)
				}, 0).toFixed(2);

				// this.quotation.vat = ((parseFloat(this.quotation.subTotal) * parseFloat(this.vatPercent)) / 100).toFixed(2);

				if (event.target.id == 'vatTaka') {
					this.vatPercent = (parseFloat(this.quotation.vat) / parseFloat(this.quotation.subTotal) * 100).toFixed(2);
					// console.log('sohel');
				} else {
					this.quotation.vat = ((parseFloat(this.quotation.subTotal) * parseFloat(this.vatPercent)) / 100).toFixed(2);
				}

				if (event.target.id == 'discount') {
					this.discountPercent = (parseFloat(this.quotation.discount) / parseFloat(this.quotation.subTotal) * 100).toFixed(2);
				} else {
					this.quotation.discount = ((parseFloat(this.quotation.subTotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
				}

				this.quotation.total = ((parseFloat(this.quotation.subTotal) + parseFloat(this.quotation.vat)) - parseFloat(this.quotation.discount)).toFixed(2);

				if (this.selectedCustomer.Customer_Type == 'G') {
					this.quotation.paid = this.quotation.total;
					this.quotation.due = 0;
				} else {
					if (event.target.id != 'paid') {
						this.quotation.paid = 0;
					}
					this.quotation.due = (parseFloat(this.quotation.total) - parseFloat(this.quotation.paid)).toFixed(2);
				}
			},
			async saleQuotation() {
				if (this.selectedCustomer.Customer_SlNo == '') {
					alert('Select Customer');
					return;
				}
				if (this.cart.length == 0) {
					alert('Cart is empty');
					return;
				} else {
					this.cart.forEach((p) => {
						p.salesRate = p.salesRate * p.convertRate;
					})
				}

				if (this.quotation.payment_method == '') {
					alert('Select Payment method');
					return;
				}
				if (this.quotation.payment_method == 'Cash') {
					this.quotation.bank_name = '';
				}
				if (this.quotation.payment_method == 'Bank' && this.quotation.bank_name == '') {
					alert('Select bank account');
					return;
				}
				if (this.quotation.payment_method == 'Bank' && this.quotation.paid == 0) {
					alert('Paid amount is required');
					return;
				}

				// this.saleOnProgress = true;

				// await this.getCustomerDue();

				let url = "/add_sales";
				// if (this.quotation.salesId != 0) {
				// 	url = "/update_sales";
				// 	this.sales.previousDue = parseFloat((this.sales.previousDue - this.sales_due_on_update)).toFixed(2);
				// }

				if (parseFloat(this.selectedCustomer.Customer_Credit_Limit) < (parseFloat(this.quotation.due) + parseFloat(this.quotation.previousDue))) {
					alert(`Customer credit limit (${this.selectedCustomer.Customer_Credit_Limit}) exceeded`);
					// this.saleOnProgress = false;
					return;
				}

				if (this.selectedEmployee != null && this.selectedEmployee.Employee_SlNo != null) {
					this.quotation.employeeId = this.selectedEmployee.Employee_SlNo;
				} else {
					this.quotation.employeeId = null;
				}

				this.quotation.customerId = this.selectedCustomer.Customer_SlNo;
				this.quotation.salesFrom = this.selectedBranch.brunch_id;
				this.quotation.note = '';
				this.quotation.isService = 'false'

				let data = {
					sales: this.quotation,
					cart: this.cart
				}

				if (this.selectedCustomer.Customer_Type == 'G') {
					data.customer = this.selectedCustomer;
				}

				// console.log(data);
				// return;

				await axios.post(url, data).then(async res => {
					let r = res.data;
					if (r.success) {
						let conf = confirm('Sale success, Do you want to view invoice?');
						if (conf) {
							window.open('/sale_invoice_print/' + r.salesId, '_blank');
							await new Promise(r => setTimeout(r, 1000));
							window.location = '/quotation';
						} else {
							window.location = '/quotation';
						}
					} else {
						alert(r.message);
						// this.saleOnProgress = false;
					}
				})
			},
			saveQuotation() {
				if (this.selectedCustomer.Customer_SlNo == '') {
					alert('Select Customer');
					return;
				}
				if (this.cart.length == 0) {
					alert('Cart is empty');
					return;
				}

				let url = "/add_quotation";
				if (this.quotation.quotationId != 0) {
					url = "/update_quotation";
				}

				this.quotation.quotationFrom = this.selectedBranch.brunch_id;
				this.quotation.terms_condition = this.companyProfile.terms_condition;
				this.quotation.currency_name = this.selectedCurrency.symbol;
				this.quotation.customerId = this.selectedCustomer.Customer_SlNo;

				let data = {
					quotation: this.quotation,
					cart: this.cart
				}
				// console.log(data);
				// return;
				axios.post(url, data).then(async res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						let conf = confirm('Do you want to view invoice?');
						if (conf) {
							window.open('/quotation_invoice/' + r.quotationId, '_blank');
							await new Promise(r => setTimeout(r, 1000));
							window.location = '/quotation';
						} else {
							window.location = '/quotation';
						}
					}
				})
			},
			async getQuotations() {
				await axios.post('/get_quotations', {
					quotationId: this.quotation.quotationId
				}).then(async res => {
					let r = res.data;
					let quotation = r.quotations[0];
					this.quotation.quotationBy = quotation.AddBy;
					this.quotation.invoiceNo = quotation.SaleMaster_InvoiceNo;
					this.quotation.salesFrom = quotation.SaleMaster_branchid;
					this.quotation.salesDate = quotation.SaleMaster_SaleDate;
					this.quotation.subTotal = quotation.SaleMaster_SubTotalAmount;
					this.quotation.discount = quotation.SaleMaster_TotalDiscountAmount;
					this.quotation.vat = quotation.SaleMaster_TaxAmount;
					this.quotation.total = quotation.SaleMaster_TotalSaleAmount;
					this.quotation.due = quotation.SaleMaster_TotalSaleAmount;
					this.quotation.Ref_Number = quotation.Ref_Number;
					this.quotation.customerEmail = quotation.SaleMaster_customer_email;
					this.quotation.currency_name = quotation.currency_name;

					this.selectedCurrency = this.currencies.find(q => q.symbol == this.quotation.currency_name);

					this.vatPercent = parseFloat(this.quotation.vat) * 100 / parseFloat(this.quotation.subTotal);
					this.discountPercent = parseFloat(this.quotation.discount) * 100 / parseFloat(this.quotation.subTotal);

					r.quotationDetails.forEach(product => {
						let cartProduct = {
							productCode: product.Product_Code,
							productId: product.Product_IDNo,
							categoryName: product.ProductCategory_Name,
							name: product.Product_Name,
							salesRate: product.SaleDetails_Rate,
							quantity: product.SaleDetails_TotalQuantity,
							convertRate: product.convertRate,
							total: product.SaleDetails_TotalAmount,
							vat: product.vat,
							purchaseRate: product.Product_Purchase_Rate,
						}

						this.cart.push(cartProduct);
						this.backCart.push(cartProduct);
					})

					this.selectedCustomer = this.customers.find(c => c.Customer_SlNo == quotation.SalseCustomer_IDNo)
					// this.getProducts();

					await this.getCustomerDue();
				})
			}
		}
	})
</script>