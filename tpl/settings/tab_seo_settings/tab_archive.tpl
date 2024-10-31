<div id="r4w_st_page_sa_archive" class="page_tab">
	<div id="r4w_box_subtabs" class="box_subtab">
		<ul>
			<li id="subpage_author" class="btn_subtab">{_('Author archives')}</li>
			<li id="subpage_data" class="btn_subtab">{_('Date archives')}</li>
		</ul>
	</div>
	<div id="r4w_box_subpages">
		<div id="r4w_sst_subpage_author" class="page_subtab">
			<label class="css-gfejhyi850 title_gwp">
				{_('Author archives')}
			</label>
			<div class="r4w_bullet_info">
				<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
				<div class="css-df5r0grg">
					{_('If a single author administers the site, we recommend that you do not display the archive, its archive page will be exactly the same as your home page')}.
				</div>
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_input_custom_archive" name="seo_settings|archive|author_archives|display" [@author_archives_display]>
					<span class="lever"></span>
					{_('View authors archives')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows you to view the authors archives')}.
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_archive" name="seo_settings|archive|author_archives|index_have_post" [@author_archives_index_have_post]>
					<span class="lever"></span>
					{_('Allow search engines to index the archives with publications')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows you to ask search engines to index the archives who have posts')}.
			</div>
		    <div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_archive" name="seo_settings|archive|author_archives|follow_have_post" [@author_archives_follow_have_post]>
					<span class="lever"></span>
					{_('Allow search engines to follow the links in the archives who have posts')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows search engine robots to follow links from the archives who have posts')}
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_archive" name="seo_settings|archive|author_archives|index_no_post" [@author_archives_index_no_post]>
					<span class="lever"></span>
					{_('Allow search engines to index the archives without publications')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows you to ask the search engines to index the archives who have no posts')}.
			</div>
		    <div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_archive" name="seo_settings|archive|author_archives|follow_no_post" [@author_archives_follow_no_post]>
					<span class="lever"></span>
					{_('Allow search engines to follow the links in the archives who have no posts')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows search engine robots to follow links from the archives who have no posts')}
			</div>
			<div class="r4w_atwho_box select-field [@author_archives_box_contenteditable]">
				<label for="bac_hom_title">{_('Meta Title')}</label>
				<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
				<div class="r4w_autosave_info r4w_progress_div">
					<input class="athow_input r4w_autosave" name="seo_settings|archive|author_archives|meta_title"></input>
					<div contenteditable="[@author_archives_contenteditable]" data-tag="[@author_archives_tag_data_title]" class="[@author_archives_metatag]">[@author_archives_meta_title]</div>
				</div>
			</div>
			<div class="r4w_atwho_box select-field athow_lg [@author_archives_box_contenteditable]">
				<label for="bac_hom_description"> {_('Meta Description')}</label>
				<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
				<div class="r4w_autosave_info r4w_progress_div">
					<input class="athow_input r4w_autosave" name="seo_settings|archive|author_archives|meta_description"></input>
					<div contenteditable="[@author_archives_contenteditable]" data-tag="[@author_archives_tag_data_description]" class="[@author_archives_metatag]" >[@author_archives_meta_description]</div>
				</div>
			</div>
		</div>
		<div id="r4w_sst_subpage_data" class="page_subtab">
			<label class="css-gfejhyi850 title_gwp">
				{_('View archives by dates')} 
			</label>
			<div class="r4w_bullet_info">
				<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
				<div class="css-df5r0grg">
					{_('Date-based archives could, in some cases, also be considered duplicate content')}.
				</div>
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_input_custom_archive" name="seo_settings|archive|date_archives|display"  [@date_archives_display]>
					<span class="lever"></span>
					{_('Date archives')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows you to view the archive by date')}
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_archive" name="seo_settings|archive|date_archives|index" [@date_archives_index]>
					<span class="lever"></span>
					{_('Allow search engines to index archive by dates')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows you to ask search engines to index archives by dates')}.
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave r4w_archive" name="seo_settings|archive|date_archives|follow" [@date_archives_follow]>
					<span class="lever"></span>
					{_('Allow search engines to follow the links in archive by dates')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows search engine robots to follow links archive by dates')}
			</div>
			<div class="r4w_atwho_box select-field [@date_archives_box_contenteditable]">
				<label for="bac_hom_title">{_('Meta Title')}</label>
				<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
				<div class="r4w_autosave_info r4w_progress_div">
					<input class="athow_input r4w_autosave" name="seo_settings|archive|date_archives|meta_title"></input>
					<div contenteditable="[@date_archives_contenteditable]" data-tag="[@date_archives_tag_data_title]" class="[@date_archives_metatag]">[@date_archives_meta_title]</div>
				</div>
			</div>
			<div class="r4w_atwho_box select-field athow_lg [@date_archives_box_contenteditable]">
				<label for="bac_hom_description"> {_('Meta Description')}</label>
				<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
				<div class="r4w_autosave_info r4w_progress_div">
					<input class="athow_input r4w_autosave" name="seo_settings|archive|date_archives|meta_description"></input>
					<div contenteditable="[@date_archives_contenteditable]" data-tag="[@date_archives_tag_data_description]" class="[@date_archives_metatag]" >[@date_archives_meta_description]</div>
				</div>
			</div>
		</div>
	</div>
</div>