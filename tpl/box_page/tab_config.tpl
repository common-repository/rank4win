<div id="r4w_st_page_sa_basic_config" class="page_tab">
	<input type="hidden" name="wp_post_title" value="[@wp_post_title]">
	<input type="hidden" name="wp_post_description" value="[@wp_post_content]">
	<div class="css-dsf5e0ff">
		<label class="css-gfejhyi850 title_gwp">
			{_('Configuration')}
		</label>
		<div class="r4w_bullet_info">
			<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
			<div class="css-df5r0grg">
				{_('You can configure the page for search engines')}.
			</div> 
		</div>
		<div class="switch r4w_autosave_info">
			<label>
				<input type="checkbox" class="r4w_autosave" name="page|index" [@index]>
				<span class="lever"></span>
				{_('Allow search engines to index this page')}
			</label>
		</div>
		<div class="r4w_additional_info">
			{_('This option allows you to ask search engines to index this page')}
		</div>
		<div class="switch r4w_autosave_info">
			<label>
				<input type="checkbox" class="r4w_autosave" name="page|follow" [@follow]>
				<span class="lever"></span>
				{_('Allow search engines to follow the links in the page')}
			</label>
		</div>
		<div class="r4w_additional_info">
			{_('This option provides a guideline for links to search engine robots')}
		</div>
		<div class="switch r4w_autosave_info">
			<label>
				<input type="checkbox" class="r4w_autosave r4w_input_custom_robots" name="page|robots|custom" [@robots_custom]>
				<span class="lever"></span>
				{_('Customize meta robots')}
			</label>
		</div>
		<div class="r4w_checkbox r4w_checkbox_custom_robots">
			<label>
				<input type="checkbox" class="r4w_autosave" name="page|robots|no_archive" [@robots_no_archive] />
				<span>{_('No archive')}</span>
			</label>
			<label>
				<input type="checkbox" class="r4w_autosave" name="page|robots|no_image" [@robots_no_image]/>
				<span>{_('No index for images')}</span>
			</label>
			<label>
				<input type="checkbox" class="r4w_autosave" name="page|robots|no_meta" [@robots_no_meta]/>
				<span>{_('No meta data')}</span>
			</label>
		</div>
		<div class="r4w_atwho_box select-field">
			<label for="bac_hom_description"> {_('Canonical URL')}</label>
			<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
				<input class="athow_input r4w_autosave" name="page|canonical">
				<div contenteditable="true" class="athow_content" >[@canonical]</div>
			</div>
		</div>
	</div>
</div>