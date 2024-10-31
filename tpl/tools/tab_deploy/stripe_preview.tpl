<div id="box_card" class="r4w_stripe_card">
	<form method="post" id="payment-form">
		<div class="css-sd5sqd0qsd">
			<div class="css-5s5gf0dfdf">
				[@svg_credit_card]
			</div>
			<div class="form-row">
				<label for="card-element">{_('Credit or debit card')}</label>
				<div id="card-element"></div>
				<div id="card-errors" role="alert"></div>
			</div>
			<div id="error_payment">
				<div>[@svg_error_cross]</div>
				<div>{_('Please contact your bank or credit card issuer to find out why payment has not been made')}</div>
			</div>
		  	<div>
				<button id="submit_payment">{_('Submit Payment')}</button>
			</div>
			<div id="success_payment">
				<div class="thumbsup-icon"><svg class="stars star1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109"> <path d="M68.1 17.4l-4.3-.6-1.9-3.9c-.2-.3-.5-.5-.9-.5s-.7.2-.9.5l-1.9 3.9-4.3.6c-.4.1-.7.3-.8.7-.1.4 0 .8.3 1l3.1 3-.7 4.3c-.1.4.1.8.4 1 .3.2.7.3 1.1.1l3.9-2 3.9 2c.3.2.7.1 1.1-.1s.5-.6.4-1l-.7-4.3 3.1-3c.3-.3.4-.7.3-1-.5-.3-.8-.6-1.2-.7z"/> </svg> <svg class="stars star2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109"> <path d="M133.1 8.1l-6.6-1-2.9-6c-.3-.5-.8-.8-1.4-.8s-1.1.3-1.4.8l-2.9 6-6.6 1c-.6.1-1.1.5-1.2 1-.2.6 0 1.2.4 1.6l4.8 4.6-1.1 6.6c-.1.6.1 1.1.6 1.5.5.3 1.1.4 1.6.1l5.9-3.1 5.9 3.1c.5.3 1.1.2 1.6-.1s.7-.9.6-1.5l-1.1-6.6 4.8-4.6c.4-.4.6-1 .4-1.6-.4-.5-.8-.9-1.4-1z"/> </svg> <svg class="stars star3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109"> <path d="M92.9 97.7l-4.6-.7-2-4.1c-.2-.3-.6-.5-.9-.5a1 1 0 0 0-.9.5l-2 4.1-4.5.7c-.4.1-.7.3-.8.7-.1.4 0 .8.3 1.1l3.3 3.2-.8 4.5c-.1.4.1.8.4 1s.8.3 1.1.1l4-2.1 4 2.1c.4.2.8.2 1.1-.1.3-.2.5-.6.4-1l-.8-4.5 3.3-3.2c.3-.3.4-.7.3-1.1-.2-.4-.5-.7-.9-.7z"/> </svg> <svg class="stars star4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109"> <path d="M45.8 62l-5.7-.8-2.5-5.1c-.2-.4-.7-.7-1.2-.7s-.9.3-1.2.7l-2.5 5.1-5.6.8c-.5.1-.9.4-1.1.9-.2.5 0 1 .3 1.3l4.1 4-1 5.6c-.1.5.1 1 .5 1.3.4.3.9.3 1.4.1l5.1-2.7 5.1 2.7c.4.2 1 .2 1.4-.1.4-.3.6-.8.5-1.3l-1-5.6 4.1-4c.4-.3.5-.9.3-1.3-.1-.5-.5-.8-1-.9z"/> </svg> <svg class="stars star5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109"> <path d="M142.9 63.7l-2.8-.4-1.3-2.6c-.1-.2-.3-.3-.6-.3s-.5.1-.6.3l-1.3 2.6-2.8.4c-.2 0-.5.2-.5.4-.1.2 0 .5.2.7l2 2-.5 2.8c0 .2.1.5.3.6.2.1.5.2.7 0l2.5-1.3 2.5 1.3h.7c.2-.1.3-.4.3-.6l-.5-2.8 2-2c.2-.2.2-.4.2-.7 0-.2-.2-.4-.5-.4z"/> </svg> <svg class="thumbsup" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 187 109"> <path d="M55 66H33c-4.3 0-8.7-1-12.5-2.9l-7.1-3.5c-.5-.3-.9-.8-.9-1.4v-22c0-.4.1-.7.4-1l15.3-18.4v-12A4.7 4.7 0 0 1 35.3.7c5.4 3.1 5.6 11.1 5.6 16.6v7.9h17.3c4.3 0 7.9 3.5 7.9 7.8v.2L63 58.3a8.1 8.1 0 0 1-8 7.7z" fill="#FA6742" transform="translate(58 19)" /> <path d="M14.1 66H1.6C.7 66 0 65.3 0 64.4V29.9c0-.9.7-1.6 1.6-1.6h12.6c.9 0 1.6.7 1.6 1.6v34.6c-.1.8-.8 1.5-1.7 1.5z" fill="#444444" transform="translate(58 19)" /> </svg> </div>
			</div>
			<div id="loading_payment" class="payment-loader">
				<div class="pad">
					<div class="chip"></div>
					<div class="line line1"></div>
					<div class="line line2"></div>
				</div>
				<div class="loader-text">
					<P>{_('Authorization in progress')}...</P>
					<p>{_('Please wait a moment')}</p>
				</div>
			</div>
			<div class="css-sdfs5f0sq">
				<div class="css-f5e0f5fe">[@svg_padlock]</div>
				<div class="css-f5g0r5g06">
					{_('You can cancel your subscription at any time. By making the payment, you confirm that you have read and accept')}
					<a class="css-f5e0fere" href="https://rank4win.fr/politique-de-confidentialite-rank4win/" target="_blank">{_('our general terms and conditions of sale')}</a>.
				</div>
			</div>
		</div>
	</form>
</div>
<div id="box_features" class="r4w_stripe_features">
	<p class="price">[@amount] <small>{_('ttc')}</small></p>
	<p class="style-label">{_('Options')}</p>
	<div class="css-d2sd0sdd">
		<div>{_('Number of pages to deploy')}:</div>
		<div class="css-f5d0ef5efef">
			[@nbr_page]
		</div>
		<div class="css-sd5sd0qsdq">{_('This payment allows you to deploy your semantic srucuture only once')}</div>
	</div>
</div>