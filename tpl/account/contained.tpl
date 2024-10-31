<div id="r4w_box_account">
	<div class="wrap">
		<div id="r4w_prevbox">
			<div class="css-sf50fe9ef">
			 	<div class="css-sdf50etgeeg">
			 		[@svg_account]
			 	</div>
			 	<div class="css-dge0hyut9e">
			 		<div class="css-dgf5y0rez">{_('Account and subscription management')} !</div>
			 		<div class="css-vd5e0rge">{_('Manage your account and this information, manage your subscription and recover your bills')}.</div>
		    		</div>
		    </div>
		</div>
		<div id="r4w_system_message"></div>
		<ul id="r4w-tabs" class="r4w-tabs"[@tab_open]>
			<li id="account" class="r4w_nav-tab">{_('Account')}</li>
			<li id="invoice" class="r4w_nav-tab">{_('Your invoices')}</li>
			<li id="wordpress" class="r4w_nav-tab">{_('Your wordpress')}</li>
			<a class="another_account" href="[@url_another_account]">{_('Sign in with another account')}</a>
		</ul>
		<div class="tab_container">
			[@tab_account]
			[@tab_invoice]
			[@tab_wordpress]
		</div>
	</div>
</div>
<div class="SimpleModalJs" id="r4w_manage_account">
	<div class="smj-header">
	    <div class="logo">
	      [@svg_rank4win_white]
	    </div>
	</div>
	<div id="r4w_box_manage_account" class="smj-content">
		<div class="css-sfo82ac">
			{_('Account Details')}
		</div>
		<div class="r4w_bullet_info">
			<div class="css-sd5r0fze5">
				[@svg_bullet_info]
			</div>
			<div class="css-df5r0grg">
				{_('Be sure to keep all your information up-to-date and rectify it at the slightest change')}
			</div>
		</div>
		<form id="r4w_account_update" method="post">
			<div class="css-gf5erg0z8z">
			  	<label for="r4w_acc_type_account">{_('Type of account')}</label>
				<select id="r4w_acc_type_account" class="browser-default r4wfix_wp_input" name="account|type">
					<option value="individual" selected="selected">{_('Individual')}</option>
					<option value="professional">{_('Professional')}</option>
				</select>
			</div>
			<div id="individual" class="css-5fde0f5ezfd acc_show_type">
				<div>
				  <label for="r4w_acc_firstname">{_('Firstname')}</label>
				  <input class="css-1rkhnpn r4wfix_wp_input" maxlength="255" type="text" size="255" name="account|individual|firstname" id="r4w_acc_firstname">
				</div>
				<div>
				  <label for="r4w_acc_lastname">{_('Lastname')}</label>
				  <input class="css-1rkhnpn r4wfix_wp_input" maxlength="255" type="text" size="255" name="account|individual|lastname" id="r4w_acc_lastname">
				</div>
			</div>
			<div id="professional" class="css-5fde0f5ezfd acc_show_type">
				<div>
				  <label for="r4w_acc_company">{_('Company Name')}</label>
				  <input class="css-1rkhnpn r4wfix_wp_input" maxlength="255" type="text" size="255" name="account|professional|company" id="r4w_acc_company">
				</div>
				<div>
				  <label for="r4w_acc_">{_('Address')}</label>
				  <input class="css-1rkhnpn r4wfix_wp_input" maxlength="255" type="text" size="255" name="account|professional|address" id="r4w_acc_address">
				</div>
				<div>
				  <label for="r4w_acc_">{_('Phone')}</label>
				  <input class="css-1rkhnpn r4wfix_wp_input" maxlength="255" type="text" size="255" name="account|professional|phone" id="r4w_acc_phone">
				</div>
			</div>
			<div id="loading"><div class="dual-ring"></div></div>
			<div id="btn_conflict" class="css-sf5s0fff">
				<button id="btn_take_hand" class="r4w_form css-1g97g96 css-s5ff0etge" type="submit">{_('Update')}</button>
			</div>
		</form>
	</div>
</div>