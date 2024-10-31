<div id="r4w_tab_deploy" class="tab_content" style="display:none;">
	<div class="css-5egopr5540r">
	    <div class="box_cnt">
	    	<div class="css-df5dsf0effet">{_('Your deployments')}</div>
	    	<div class="css-fds2f0eef">
	    		<div id="r4w_create_new_str_semantic" class="css-df5e0zfezt">{_('Create a new semantic structure')}</div>
	    		<div id="r4w_cancel_new_str_semantic" class="css-df5e0zfezt">{_('Cancel')}</div>
	    	</div>
		</div>
		[@tab_list_deploy]
	</div>
	<div class="SimpleModalJs" id="r4w_box_deploy_str_semantic">
		<div class="smj-header">
		    <div class="logo">
		      [@svg_rank4win_white]
		    </div>
		</div>
		<div id="r4w_box_load_deploy_select" class="smj-content">
			<div class="css-sfo82ac">
				{_('Deploy the semantic structure on wordpress')}
			</div>
			<div class="r4w_bullet_info">
				<div class="css-sd5r0fze5">
					[@svg_bullet_info]
				</div>
				<div class="css-df5r0grg">
					{_('You can deploy your semantic structure on your wordpress, the pages will be created with an editorial template')}.
				</div>
			</div>
			<div id="r4w_error"></div>
			<div class="css-sd5sd5s2d">
				<label for="r4w_str_how_deploy">{_('Structure to be deployed')}</label>
				<div class="css-gf5erg0z8z">
					<div id="r4w_select_deploy_list"></div>
				</div>
			</div>
			<div class="css-gf5erg0z8z">
			  	<label for="r4w_str_how_deploy">{_('How to deploy your structure')}</label>
				<select id="r4w_str_how_deploy" class="browser-default r4wfix_wp_input" name="r4w_str_how_deploy">
					<option value="160513a9-dc4d-48f9-821d-a047206b2913" selected="selected">{_('Delete and create new page')}</option>
					<option value="e92f58c6-c94d-4768-8536-72f1e6f3dd69">{_('Rearrange and create new page')}</option>
				</select>
			</div>
			<div id="r4w_str_deploy_info" class="css-s5dfg5s0z5zae">
				<div id="160513a9-dc4d-48f9-821d-a047206b2913" class="deploy_info" style="display:block">
					<div class="css-d5zd0zg">
						<div class="css-fef5ez0f">[@svg_warning]</div>
						<div class="css-fd5ef0gt">{_('Delete existing pages and their contents before creating the pages of your semantic structure')}</div>
					</div>
				</div>
				<div id="e92f58c6-c94d-4768-8536-72f1e6f3dd69" class="deploy_info">
					<div class="css-d5zd0zg">
						<div class="css-fef5ez0f">[@svg_warning]</div>
						<div class="css-fd5ef0gt">{_('Rearrange existing pages without changing their content, new page pages will be created')}</div>
					</div>
				</div>
				<div id="b0f16ff5-eb9b-4571-b485-76668f5c0312" class="deploy_info">
					<div class="css-d5zd0zg">
						<div class="css-fef5ez0f">[@svg_warning]</div>
						<div class="css-fd5ef0gt">{_('Create only the pages of your semantic structure, the existing pages will not delete or rearrange')}</div>
					</div>
				</div>
			</div>
			<div id="box_prview_order" class="css-sd5sd5s2d">
				<label for="r4w_str_how_deploy">{_('Order details')}</label>
				<div class="css-g50rdsg5feg">
					<div class="css-sd20zdfefe">
						<div class="css-f50ef5ege">{_('Price per page')}</div>
						<div id="r4w_price_by_page" class="css-f5e0g5egt"></div>
					</div>
					<div class="css-sd20zdfefe">
						<div class="css-f50ef5ege">{_('Number of pages')}</div>
						<div id="r4w_deploy_page" class="css-f5e0g5egt"></div>
					</div>
					<div class="css-sd20zdfefe">
						<div class="css-f50ef5ege">{_('Deployment price')}</div>
						<div id="r4w_deploy_price" class="css-f5e0g5egte"></div>
					</div>
				</div>
			</div>
			<div id="loading"><div class="dual-ring"></div></div>
			<button id="btn_deploy"class="r4w_form css-1g97g96">{_('Pay and deploy')}</button>
		</div>
	</div>
	<div class="SimpleModalJs" id="r4w_box_stripe_preview">
		<div class="smj-header">
		    <div class="logo">
		      [@svg_rank4win_white]
		    </div>
		</div>
		<div id="r4w_box_stripe" class="smj-content">
			<div id="box_card" class="r4w_stripe_card">
				<div class="ph-item"> <div class="ph-line"> <div class="ph_svglogo"></div> <div class="ph_card_title"></div> <div class="ph_card_number"></div> <div class="ph_card_btn"></div> <div class="ph_card_cvg_1"></div> <div class="ph_card_cvg_2"></div> </div> </div>
			</div>
			<div id="box_features" class="r4w_stripe_features">
				<div class="ph-item"> <div class="ph-line"> <div class="ph_features_price"></div> <div class="ph_features_title"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> <div class="ph_features_liste"></div> </div> </div>
			</div>
		</div>
	</div>
	<div class="SimpleModalJs" id="r4w_box_wait">
		<div class="smj-header">
		    <div class="logo">
		      [@svg_rank4win_white]
		    </div>
		</div>
		<div id="r4w_wait" class="smj-content">
			<div id="loading" class="css-5f0zeg5fe6fze"><div class="dual-ring"></div></div>
		</div>
	</div>
	<div class="SimpleModalJs" id="r4w_box_deploy_being">
		<div class="smj-header">
		    <div class="logo">
		      [@svg_rank4win_white]
		    </div>
		</div>
		<div id="r4w_deploy_being" class="smj-content">
			[@svg_wait]
			<div class="css-sfo82ac">{_('A deployment in progress')}</div>
			<div class="css-ds50ezfd5">{_('A semantic structure is being deployed on this wordpress. To avoid conflict, you must wait until the deployment is complete or stop the deployment to perform a new deployment')}.</div>
			<a id="stop_deploy" href="#" class="btn_stop">{_('Stop the deployment')}</a>
		</div>
	</div>
	[@r4w_javascript]
</div>
