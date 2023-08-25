<form class="mx-make-donation-wrap" action="?donation=1" method="POST">
	<input type="hidden" name="invoice_number" value="<?php echo time(); ?>">

	<ul>

		<li>
			<div>
				<label for="customer_name">Your Name</label>
				<div>
					<input type="text" id="customer_name" name="customer_name" value="" required />
				</div>
			</div>
		</li>
		<li>
			<div>
				<label for="customer_email">Email Address</label>
				<div>
					<input type="email" id="customer_email" name="customer_email" value="" required />
				</div>
			</div>
		</li>
		<li>
			<div>
				<label for="mx_bill_amount">Amount</label>
				<div>
					<input type="number" id="mx_bill_amount" name="mx_bill_amount" value="100" required />
				</div>
			</div>
		</li>

		<li>
			<div>
				<label for="mx_currency">Currency</label>
				<div>
					<select name="mx_currency" id="mx_currency">
						<option value="gbp">GBP</option>
						<option value="usd">USD</option>
						<option value="eur">EUR</option>
					</select>
				</div>
			</div>
		</li>
	</ul>

	<button class="mx-make-donation mx-button">Donate</button>

</form>