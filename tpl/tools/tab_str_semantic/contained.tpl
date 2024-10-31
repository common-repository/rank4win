<div id="r4w_tab_str_semantic" class="tab_content" style="display:none;">
	<div class="css-5egopr5540r">
	    <div class="box_cnt">
	    	<div class="css-df5dsf0effet">{_('Semantic structure')}</div>
	    	<div class="css-fds2f0eef">
	    		<div id="r4w_create_new_str_semantic" class="css-df5e0zfezt">{_('Create a new semantic structure')}</div>
	    		<div id="r4w_cancel_new_str_semantic" class="css-df5e0zfezt">{_('Cancel')}</div>
	    	</div>
		</div>
		[@tab_str_semantic_list]
	</div>
	<div class="SimpleModalJs" id="r4w_box_rename_str_semantic">
		<div class="smj-header">
		    <div class="logo">
		      [@svg_rank4win_white]
		    </div>
		</div>
		<div id="r4w_box_load_rename" class="smj-content">
			<div class="css-sfo82ac">
				{_('Rename your semantic structure')}
			</div>
			<div id="r4w_error"></div>
			<div>
			  <label for="r4w_str_structure_name">{_('Name of the stucture')}</label>
			  <input class="css-1rkhnpn" maxlength="255" type="text" size="255" name="r4w_str_structure_name">
			</div>
			<div id="loading"><div class="dual-ring"></div></div>
			<button id="btn_rename"class="r4w_form css-1g97g96" disabled="disabled">{_('Rename')}</button>
		</div>
	</div>
	<div class="SimpleModalJs" id="r4w_box_duplicate_str_semantic">
		<div class="smj-header">
		    <div class="logo">
		      [@svg_rank4win_white]
		    </div>
		</div>
		<div id="r4w_box_load_duplicate_str_semantic" class="smj-content">
			<div class="css-df5eg0hgr">
				<div class="box_info">
					<div>{_('Duplication of the semantic structure')}</div>
					<div>{_('Please wait while duplicating your semantic structure')}</div>
				</div>
				<div class="css-sd50dfzd9">
					<div class="css-df50rf8e">[@svg_page_semantic]</div>
					<div class="css-tuyt8z0re r4w_wait_signals">
				      <div class="dot first"></div>
				      <div class="dot second"></div>
				      <div class="dot third"></div>
					</div>
					<div class="css-re80tbv8er">[@svg_page_semantic]</div>
				</div>
			</div>
		</div>
	</div>
	<div class="SimpleModalJs" id="r4w_box_new_str_semantic">
		<div class="smj-header">
		    <div class="logo">
		      [@svg_rank4win_white]
		    </div>
		</div>
		<div id="r4w_box_load_new_str_semantic" class="smj-content">
			<div class="css-sfo82ac">
				{_('Create a new semantic structure')}
			</div>
			<div class="r4w_bullet_info">
				<div class="css-sd5r0fze5">
					[@svg_bullet_info]
				</div>
				<div class="css-df5r0grg">
					{_('Building a tree of pages with optimized contents answering a theme with keywords on the same subject, is the basis of the seo semantic cocoon')}.
				</div>
			</div>
			<div id="r4w_error"></div>
			<div>
			  <label for="r4w_str_structure_name">{_('Name of the stucture')}</label>
			  <input class="css-1rkhnpn" maxlength="255" type="text" size="255" name="r4w_str_structure_name">
			</div>
			<div class="css-gf5erg0z8z">
			  	<label for="r4w_str_structure_content">{_('Content of the structure')}</label>
				<select id="r4w_str_structure_content" class="browser-default r4w_autosave r4w_autosave_info r4wfix_wp_input" name="r4w_str_structure_content">
					<option value="a1787db4-59b4-4de5-9dd9-17d2cfbd8c35" selected="selected">{_('Empty structure')}</option>
					<option value="65696b7e-b217-4945-bff5-2bd43fe04d0a">{_('Wordpress-based structure')}</option>
				</select>
			</div>
			<div id="r4w_select_strategy" class="css-s5fez0fefe">
			  	<label for="r4w_str_structure_strategy">{_('Keyword Strategy')}</label>
			  	<div id="r4w_str_structure_select"> <div class="ph-item"> <div class="ph-line"> <div class="ph_select"></div> </div></div> </div>
			</div>
			<div id="loading"><div class="dual-ring"></div></div>
			<button id="btn_create"class="r4w_form css-1g97g96" disabled="disabled">{_('Create')}</button>
		</div>
	</div>
</div>
