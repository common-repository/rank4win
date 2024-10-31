[@sub_reduction]
<div class="css-5fedf0e85f">
	<div id="acc_sub_date" class="css-sf5egf0ef">
		<div class="css-sfd5gf0e">[@sub_date_d]</div>
		<div class="css-fe0e5fge">[@sub_date_my]</div>
	</div>
	<div class="css-sf52d0fefe">
		<div id="acc_sub_title" class="css-f5e0fgegve">{_('Subscription')}</div>
		<div id="acc_sub_next_billing" class="css-sq65df6fdv">[@subscription_text]</div>
		<div class="css-f50f5efe">
			[@card]
		</div>
	</div>
</div>
<div id="acc_sub_btn" class="css-5fe0f5eze">
	<a href="#" id="cancelled_sub" class="css-df5e0fbv5rr">{_('Cancelled the subscription')}</a>
	<a id="update_payment" href="#" class="css-fd5e0fe5fe">{_('Update payment information')}</a>
</div>
<div class="SimpleModalJs" id="r4w_cancelled_sub">
	<div class="smj-header">
	    <div class="logo">
	      [@svg_rank4win_white]
	    </div>
	</div>
	<div id="r4w_box_manage_account" class="smj-content">
		<div class="css-sfo82ac">
			{_('Are you leaving us')} ?
		</div>
		<div class="r4w_bullet_info">
			<div class="css-sd5r0fze5">
				[@svg_bullet_info]
			</div>
			<div class="css-df5r0grg">
				[@time_before_expiration]
			</div>
		</div>
		<div class="css-gh7h0revd">
			<div class="css-g80rsh8reb">
				{_('What are the reasons for terminating your subscription')} ?
			</div>
			<textarea class="r4w_cancelled_reasons" name="name" rows="8" cols="80"></textarea>
		</div>
		<div class="css-5f0ze5gze">
			<a href="#" class="css-f50ef5zefze close_modal">{_('Keep my subscription')}</a>
			<div id="loading"><div class="dual-ring"></div></div>
			<button id="btn_cancelled_sub" class="css-f5e0f5ezgyujo">{_('Cancelled the subscription')}</button>
		</div>
	</div>
</div>
<div class="SimpleModalJs" id="r4w_update_payment">
	<div class="smj-header">
	    <div class="logo">
	      [@svg_rank4win_white]
	    </div>
	</div>
	<div class="smj-content">
		<div class="r4w_box_stripe_preview">
			
		</div>
	</div>
</div>