<div id="r4w_sst_subpage_[@taxonomy_slug]" class="page_subtab">
	<label class="css-gfejhyi850 title_gwp">
		{_('Taxonomy')}
	</label>
	<div class="r4w_bullet_info">
		<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
		<div class="css-df5r0grg">
			{_('You can customize your meta-title and the default description')}
		</div>
	</div>
	<div class="switch r4w_autosave_info">
		<label>
			<input type="checkbox" class="r4w_autosave" name="seo_settings|taxonomies|[@taxonomy_slug]|editing_meta" [@editing_meta]>
			<span class="lever"></span>
			[@taxonomy_txt_editing_meta]
		</label>
	</div>
	<div class="r4w_additional_info">
		{_('This option allows you to manually edit the meta title and description while writing')}
	</div>	
	<div class="switch r4w_autosave_info">
		<label>
			<input type="checkbox" class="r4w_autosave" name="seo_settings|taxonomies|[@taxonomy_slug]|index" [@index]>
			<span class="lever"></span>
			[@taxonomy_text_index]
		</label>
	</div>
	<div class="r4w_additional_info">
		[@taxonomy_additional_info_index]
	</div>	
    <div class="switch r4w_autosave_info">
		<label>
			<input type="checkbox" class="r4w_autosave" name="seo_settings|taxonomies|[@taxonomy_slug]|follow" [@follow]>
			<span class="lever"></span>
			[@taxonomy_text_follow]
		</label>
	</div>
	<div class="r4w_additional_info">
		[@taxonomy_additionnal_info_follow]
	</div>
	<div class="r4w_atwho_box select-field">
		<label for="bac_hom_title">{_('Meta Title')}</label>
		<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
		<div class="r4w_autosave_info r4w_progress_div">
			<input class="athow_input r4w_autosave" name="seo_settings|taxonomies|[@taxonomy_slug]|meta_title"></input>
			<div class="athow_content" contenteditable="true" data-tag="[@tag_data_title]">[@meta_title]</div>
		</div>
	</div>
	<div class="r4w_atwho_box select-field athow_lg">
		<label for="bac_hom_description">{_('Meta Description')}</label>
		<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
		<div class="r4w_autosave_info r4w_progress_div">
			<input class="athow_input r4w_autosave" name="seo_settings|taxonomies|[@taxonomy_slug]|meta_description"></input>
			<div class="athow_content" contenteditable="true" data-tag="[@tag_data_description]">[@meta_description]</div>
		</div>
	</div>
</div>