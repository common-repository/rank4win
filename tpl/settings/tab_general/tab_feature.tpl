<div id="r4w_st_page_feature" class="page_tab">
	<label class="css-gfejhyi850 title_gwp">
		{_('Feature')}
	</label>
	<div class="r4w_bullet_info">
		<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
		<div class="css-df5r0grg">
			{_('You can enable / disable features')}.
		</div>
	</div>
	<div class="input-field s12">
		[@rs_counter_links_txt]
		<div class="switch r4w_autosave_info">
			<label>
				<input type="checkbox" class="r4w_autosave" name="general_setting|feature|counter_links" [@counter_links]>
				<span class="lever"></span>
				{_('Internal link counter (outgoing / incoming)')}
			</label>
		</div>
		<div class="r4w_additional_info">
			{_('This option allows you to view the number of internal links (outbound and inbound) links for your articles / pages')}
		</div>
		<div class="switch r4w_autosave_info">
			<label>
				<input type="checkbox" class="r4w_autosave r4w_sitemaps_input" name="general_setting|feature|xml_sitemaps" [@xml_sitemaps]>
				<span class="lever"></span>
				{_('XML Sitemaps')}
			</label>
		</div>
		<div class="r4w_additional_info css-ge05zee0r">
			<div class="css-d5fgrety0">{_('This option allows you to generate an xml file of the site map, you can see the file by clicking on icon Eye')}</div>
			<div class="css-fre0yhhdf r4w_sitemaps_view [@sitemaps_active]"><a target="_blanc" href="/sitemap.xml">[@svg_eyes]</a></div>
		</div>
	</div>
</div>