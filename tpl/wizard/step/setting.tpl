<div class="materialize">
	<div class="css-df5e0f5zef">
		<div class="css-z5fze0f5ez"></div>
		<div class="css-s4df0ez4fe">{_('Settings')}</div>
	</div>
	<div class="css-s5d0efeezg">
		<div id="step1" class="css-sdf5e0f85ez">
			<div id="r4w_st_page_language">
				<label class="css-gfejhyi850 title_gwp">
					{_('Language')}
				</label>
				<div class="r4w_bullet_info">
					<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
					<div class="css-df5r0grg">{_('The choice of the language and the country must correspond to your essays, our analysis will be based on these two criteria to optimize the results')}.</div>
				</div>
				<div class="select-field s12">
					<select id="r4w_settings_country" tabindex="-1" class="browser-default r4w_autosave r4w_autosave_info" name="general_setting|language">
					  <option value="" disabled selected>{_('Choose language and country')}</option>
					  [@list_language]
					</select>
				</div>
			</div>
			<div id="r4w_sst_subpage_setting">
				<label class="css-gfejhyi850 title_gwp">
					{_('Setting')}
				</label>
				<div class="r4w_bullet_info">
					<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
					<div class="css-df5r0grg">
						{_('Be careful, it is possible that some search engines decide to index your wordpress even if you block indexing')}.
					</div>
				</div>
				<div class="switch r4w_autosave_info">
					<label>
						<input type="checkbox" class="r4w_autosave" name="seo_settings_noindex" [@seo_settings_noindex]>
						<span class="lever"></span>
						{_('Wordpress indexing')}
					</label>
				</div>
				<div class="r4w_additional_info">
					{_('This option allows you to ask the search engines to index your entire wordpress')}
				</div>
			</div>
		</div>
	</div>
</div>
<div class="SimpleModalJs" id="r4w_box-cloud">
	<div class="smj-header">
	    <div class="logo">
	    	[@svg_rank4win_white]
	    </div>
	</div>
    <div class="smj-content">
    	<div class="css-sfo82ac">{_('Different backup on the cloud')}</div>
        <div class="css-ds50ezfd5">
        	{_('The backup of your settings in the cloud is different from your settings stored on this wordpress')}.
        </div>
        <div>
			[@svg_cloud_setting]
        </div>
        <form method="post">
			<input type="hidden" name="_method" value="backupcloud">
			<input type="hidden" name="authenticity_token" value="[@]">
			<input type="hidden" id="backup_cloud_use" name="backup_cloud_use">
			<div id="loading"><div class="dual-ring"></div></div>
			<a id="btn_use_cloud" href="#" class="css-d3f24ef4">
				<div class="css-sfjdsj66526">
					<div class="css-d5uyr66">
						[@svg_cloud_download]
					</div>
					<div>
						<div class="css-opdeki582ed">{_('Use cloud data')}</div>
						<div>{_('Deletes the data on this wordpress and replace it with the data stored in the cloud')}</div>
						<div class="css-d5f8ze2fg">{_('Last backup')} : [@cloud_last_backup]</div>
					</div>
				</div>
			</a>
			<a id="btn_use_wp" href="#" class="css-d3f24ef4">
				<div class="css-sfjdsj66526">
					<div class="css-d5uyr66">
						[@svg_cloud_send]
					</div>
					<div>
						<div class="css-opdeki582ed">{_('Use the data of this wordpress')}</div>
						<div>{_('Delete your backup in the cloud and replace it with the data stored on this wordpress')}</div>
						<div class="css-d5f8ze2fg">
							{_('Last backup')} :
							{_('new installation')}
						</div>
					</div>
				</div>
			</a>
        </form>
    </div>
</div>
[@javascript_modal]
