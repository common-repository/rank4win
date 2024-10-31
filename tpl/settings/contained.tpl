<div id="r4w_notificationBlock"><div class="notificatorWrapper"></div></div>
<div id="r4w_box_settings">
	<div class="wrap materialize">
		<div id="r4w_prevbox">
			<div class="css-sf50fe9ef">
			 	<div class="css-sdf50etgeeg">
			 		[@svg_settings]
			 	</div>
			 	<div class="css-dge0hyut9e">
			 		<div class="css-dgf5y0rez">{_('Set up the plugin according to your needs')} !</div>
			 		<div class="css-vd5e0rge">{_('You can set the plugin according to your needs, enable or disable certain functionality')}.</div>
		    	</div>
		    	<div class="css-d5s0fgze0ev">
		    		<div class="css-df5e0iov0"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 21.9 21.9"><path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0 c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4 s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3 s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7 s-0.1-0.5-0.3-0.7L14.1,11.3z"></path></svg></div>
		    	</div>
		    </div>
		</div>
		<div id="r4w_system_message"></div>
		<ul id="r4w-tabs" class="r4w-tabs">
			<li id="general" class="r4w_nav-tab">{_('General settings')}</li>
			<li id="seo_settings" class="r4w_nav-tab">{_('Seo settings')}</li>
			<li id="social_networks" class="r4w_nav-tab">{_('Social networks')}</li>
			<li id="tools" class="r4w_nav-tab">{_('Tools')}</li>
		</ul>
		<div class="tab_container">
			[@tab_general]
			[@tab_seo_settings]
			[@tab_social_networks]
			[@tab_tool]
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