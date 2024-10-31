<div id="r4w_st_page_sa_basic_config" class="page_tab">
	<div id="r4w_box_subtabs" class="box_subtab">
		<ul>
			<li id="subpage_setting" class="btn_subtab">{_('Setting')}</li>
			<li id="subpage_title" class="btn_subtab">{_('Title separator')}</li>
			<li id="subpage_homepage" class="btn_subtab">{_('Home page')}</li>
			<li id="subpage_knowledge" class="btn_subtab">{_('Knowledge Graph / Schema.org')}</li>
		</ul>
	</div>
	<div id="r4w_box_subpages">
		<div id="r4w_sst_subpage_setting" class="page_subtab">
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
		<div id="r4w_sst_subpage_title" class="page_subtab">
			<label class="css-gfejhyi850 title_gwp">
				{_('Title separator')}
			</label>
			<div class="r4w_bullet_info">
				<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
				<div class="css-df5r0grg">
					{_('You can use a separator between the title of your publication and the name of your site')}.
				</div>
			</div>
			<div class="input-tis s12 r4w_autosave_info r4w_progress_center">
				<div class="css-sd5r0ef8">
					[@title_separator]	
				</div>
			</div>
		</div>
		<div id="r4w_sst_subpage_homepage" class="page_subtab">
			<label class="css-gfejhyi850 title_gwp">
				{_('Home page')}
			</label>
			<div class="r4w_bullet_info">
				<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
				<div class="css-df5r0grg">
					{_('You can customize your meta title and description for the home page')}.
				</div>
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave" name="seo_settings|basic_configuration|home_page|editing_meta" [@home_page_editing_meta]>
					<span class="lever"></span>
					{_('Allow editing the meta tag in homepage')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows you to manually edit the meta title and description in the edition of the page')}.
			</div>
			<div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave" name="seo_settings|basic_configuration|home_page|index" [@home_page_index]>
					<span class="lever"></span>
					{_('Allow search engines to index this home page')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows you to ask the search engines to index the home page')}
				</div>
		    <div class="switch r4w_autosave_info">
				<label>
					<input type="checkbox" class="r4w_autosave" name="seo_settings|basic_configuration|home_page|follow" [@home_page_follow]>
					<span class="lever"></span>
					{_('Allow search engines to follow the links in the home page')}
				</label>
			</div>
			<div class="r4w_additional_info">
				{_('This option allows search engine robots to follow links from the home page')}
			</div>
			<div class="r4w_atwho_box select-field">
				<label for="bac_hom_title">{_('Meta Title')}</label>
				<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
				<div class="r4w_autosave_info r4w_progress_div">
					<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|home_page|meta_title"></input>
					<div contenteditable="true" data-tag="[@tag_data_home_title]" class="athow_content">[@home_page_meta_title]</div>
				</div>
			</div>
			<div class="r4w_atwho_box select-field athow_lg">
				<label for="bac_hom_description"> {_('Meta Description')}</label>
				<div class="btn_add_tag"><div class="css-25c58628966c">[@svg_add_more]</div></div>
				<div class="r4w_autosave_info r4w_progress_div">
					<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|home_page|meta_description"></input>
					<div contenteditable="true" data-tag="[@tag_data_home_description]" class="athow_content" >[@home_page_meta_description]</div>
				</div>
			</div>
		</div>
		<div id="r4w_sst_subpage_knowledge" class="page_subtab">
			<label class="css-gfejhyi850 title_gwp">
				{_('Knowledge Graph / Schema.org')}
			</label>
			<div class="r4w_bullet_info">
				<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
				<div class="css-df5r0grg">
					{_('This feature provides users with easier access to information in search engines. This data will be displayed as metadata on your site')}.
				</div>
			</div>
			<div class="select-field s12">
				<select tabindex="-1" class="browser-default r4w_autosave_info r4w_autosave knowledge_box_tab" name="seo_settings|basic_configuration|knowledge_graph|type">
					<option value="" disabled selected>{_('Choose a type')}</option>
					[@knowledge_graph_type_option]
				</select>
				<div class="r4w_additional_info">
					{_('This option allows you to specify the type of your site')}.
				</div>
			</div>
			<div class="knowledge_page">
				<div id="knowledge_Person" class="knowledge_page_tab">
					<label class="css-gfejhyi850 title_gwp">
						{_('Person')}
					</label>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Name')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|name"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_name]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Job title')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|jobTitle"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_jobTitle]</div>
						</div>
					</div>
					<div class="r4w_img_box select-field">
						<div class="r4w_box_preview css-sd5z05re8g5">
							<label for="bac_rss_after">{_('Image')}</label>
							<div class="cnt_picture upload" [@kg_person_image]>
								<div class="r4w_remove_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 348.333 348.334"><path d="M336.559,68.611L231.016,174.165l105.543,105.549c15.699,15.705,15.699,41.145,0,56.85 c-7.844,7.844-18.128,11.769-28.407,11.769c-10.296,0-20.581-3.919-28.419-11.769L174.167,231.003L68.609,336.563 c-7.843,7.844-18.128,11.769-28.416,11.769c-10.285,0-20.563-3.919-28.413-11.769c-15.699-15.698-15.699-41.139,0-56.85 l105.54-105.549L11.774,68.611c-15.699-15.699-15.699-41.145,0-56.844c15.696-15.687,41.127-15.687,56.829,0l105.563,105.554 L279.721,11.767c15.705-15.687,41.139-15.687,56.832,0C352.258,27.466,352.258,52.912,336.559,68.611z"></path></svg></a>
								</div>
								<div class="r4w_add_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 52 52" xml:space="preserve"><path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M38.5,28H28v11c0,1.104-0.896,2-2,2  s-2-0.896-2-2V28H13.5c-1.104,0-2-0.896-2-2s0.896-2,2-2H24V14c0-1.104,0.896-2,2-2s2,0.896,2,2v10h10.5c1.104,0,2,0.896,2,2  S39.604,28,38.5,28z"></path></svg></a>
								</div>
							</div>
							<div class="r4w_autosave_info"><input class="r4w_picture_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|image"></div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('URL')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|url"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_url]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Address')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|address|streetAddress"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_address_streetAddress]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Zip/Postal Code')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|address|postalCode"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_address_postalCode]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('City')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|address|addressLocality"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_address_addressLocality]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Country')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|address|addressCountry"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_address_addressCountry]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Email')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|email"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_email]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Phone')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|telephone"></input>
							<input class="intl_tel athow_content" value="[@kg_person_telephone]" data-intl-tel-input-id="1"></input>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Birth Date')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Person|birthDate"></input>
							<div contenteditable="true" class="athow_content">[@kg_person_birthDate]</div>
						</div>
					</div>
				</div>
				<div id="knowledge_Organization" class="knowledge_page_tab">
					<label class="css-gfejhyi850 title_gwp">
						{_('Organization')}
					</label>
					<div class="select-field s12">
						<select tabindex="-1" class="browser-default r4w_autosave_info r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|type">
							<option value="" disabled selected>{_('Choose a organization')}</option>
							[@knowledge_graph_organization_option]
						</select>
						<div class="r4w_additional_info">
							{_('This option allows you to specify the type of organization')}.
						</div>
					</div>

					<div class="r4w_img_box r4w_50_box select-field">
						<div class="r4w_box_preview css-sd5z05re8g5">
							<label for="bac_rss_after">{_('Logo')}</label>
							<div class="cnt_picture upload" [@kg_organization_logo]>
								<div class="r4w_remove_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 348.333 348.334"><path d="M336.559,68.611L231.016,174.165l105.543,105.549c15.699,15.705,15.699,41.145,0,56.85 c-7.844,7.844-18.128,11.769-28.407,11.769c-10.296,0-20.581-3.919-28.419-11.769L174.167,231.003L68.609,336.563 c-7.843,7.844-18.128,11.769-28.416,11.769c-10.285,0-20.563-3.919-28.413-11.769c-15.699-15.698-15.699-41.139,0-56.85 l105.54-105.549L11.774,68.611c-15.699-15.699-15.699-41.145,0-56.844c15.696-15.687,41.127-15.687,56.829,0l105.563,105.554 L279.721,11.767c15.705-15.687,41.139-15.687,56.832,0C352.258,27.466,352.258,52.912,336.559,68.611z"></path></svg></a>
								</div>
								<div class="r4w_add_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 52 52" xml:space="preserve"><path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M38.5,28H28v11c0,1.104-0.896,2-2,2  s-2-0.896-2-2V28H13.5c-1.104,0-2-0.896-2-2s0.896-2,2-2H24V14c0-1.104,0.896-2,2-2s2,0.896,2,2v10h10.5c1.104,0,2,0.896,2,2  S39.604,28,38.5,28z"></path></svg></a>
								</div>
								<div class="r4w_autosave_info"><input class="r4w_picture_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|logo"></div>
							</div>
						</div>
						<div class="r4w_box_preview css-sd5z05re8g5">
							<label for="bac_rss_after">{_('Image')}</label>
							<div class="cnt_picture upload" [@kg_organization_image]>
								<div class="r4w_remove_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 348.333 348.334"><path d="M336.559,68.611L231.016,174.165l105.543,105.549c15.699,15.705,15.699,41.145,0,56.85 c-7.844,7.844-18.128,11.769-28.407,11.769c-10.296,0-20.581-3.919-28.419-11.769L174.167,231.003L68.609,336.563 c-7.843,7.844-18.128,11.769-28.416,11.769c-10.285,0-20.563-3.919-28.413-11.769c-15.699-15.698-15.699-41.139,0-56.85 l105.54-105.549L11.774,68.611c-15.699-15.699-15.699-41.145,0-56.844c15.696-15.687,41.127-15.687,56.829,0l105.563,105.554 L279.721,11.767c15.705-15.687,41.139-15.687,56.832,0C352.258,27.466,352.258,52.912,336.559,68.611z"></path></svg></a>
								</div>
								<div class="r4w_add_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 52 52" xml:space="preserve"><path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M38.5,28H28v11c0,1.104-0.896,2-2,2  s-2-0.896-2-2V28H13.5c-1.104,0-2-0.896-2-2s0.896-2,2-2H24V14c0-1.104,0.896-2,2-2s2,0.896,2,2v10h10.5c1.104,0,2,0.896,2,2  S39.604,28,38.5,28z"></path></svg></a>
								</div>
							</div>
							<div class="r4w_autosave_info"><input class="r4w_picture_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|image"></div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Name')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|name"></input>
							<div contenteditable="true" class="athow_content">[@kg_organization_name]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('URL')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|url"></input>
							<div contenteditable="true" class="athow_content">[@kg_organization_url]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Description')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|description"></input>
							<div contenteditable="true" class="athow_content">[@kg_organization_description]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Address')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|address|streetAddress"></input>
							<div contenteditable="true" class="athow_content">[@kg_organization_address_streetAddress]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('City')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|address|addressLocality"></input>
							<div contenteditable="true" class="athow_content">[@kg_organization_address_addressLocality]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Zip/Postal Code')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|address|postalCode"></input>
							<div contenteditable="true" class="athow_content">[@kg_organization_address_postalCode]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Country')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|address|addressCountry"></input>
							<div contenteditable="true" class="athow_content">[@kg_organization_address_addressCountry]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Phone')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|contactPoint|telephone"></input>
							<input class="intl_tel athow_content" value="[@kg_organization_contactPoint_telephone]" data-intl-tel-input-id="2"></input>
						</div>
					</div>
					<div class="select-field s12">
						<select tabindex="-1" class="browser-default r4w_autosave_info r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|contactPoint|contactType">
							<option value="" disabled selected>{_('Choose a contact type')}</option>
							[@kg_organization_contacPtoint_contacttype]
						</select>
						<div class="r4w_additional_info">
							{_('This option allows you to specify the contact type')}.
						</div>
					</div>
				</div>
				<div id="knowledge_Product" class="knowledge_page_tab">
					<label class="css-gfejhyi850 title_gwp">
						{_('Product')}
					</label>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Brand')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Product|brand"></input>
							<div contenteditable="true" class="athow_content">[@kg_product_brand]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Name')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Product|name"></input>
							<div contenteditable="true" class="athow_content">[@kg_product_name]</div>
						</div>
					</div>
					<div class="r4w_img_box select-field">
						<div class="r4w_box_preview css-sd5z05re8g5">
							<label for="bac_rss_after">{_('Image')}</label>
							<div class="cnt_picture upload" [@kg_product_image]>
								<div class="r4w_remove_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 348.333 348.334"><path d="M336.559,68.611L231.016,174.165l105.543,105.549c15.699,15.705,15.699,41.145,0,56.85 c-7.844,7.844-18.128,11.769-28.407,11.769c-10.296,0-20.581-3.919-28.419-11.769L174.167,231.003L68.609,336.563 c-7.843,7.844-18.128,11.769-28.416,11.769c-10.285,0-20.563-3.919-28.413-11.769c-15.699-15.698-15.699-41.139,0-56.85 l105.54-105.549L11.774,68.611c-15.699-15.699-15.699-41.145,0-56.844c15.696-15.687,41.127-15.687,56.829,0l105.563,105.554 L279.721,11.767c15.705-15.687,41.139-15.687,56.832,0C352.258,27.466,352.258,52.912,336.559,68.611z"></path></svg></a>
								</div>
								<div class="r4w_add_img_button">
									<a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 52 52" xml:space="preserve"><path d="M26,0C11.664,0,0,11.663,0,26s11.664,26,26,26s26-11.663,26-26S40.336,0,26,0z M38.5,28H28v11c0,1.104-0.896,2-2,2  s-2-0.896-2-2V28H13.5c-1.104,0-2-0.896-2-2s0.896-2,2-2H24V14c0-1.104,0.896-2,2-2s2,0.896,2,2v10h10.5c1.104,0,2,0.896,2,2  S39.604,28,38.5,28z"></path></svg></a>
								</div>
							</div>
							<div class="r4w_autosave_info"><input class="r4w_picture_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Product|image"></div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Description')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Product|description"></input>
							<div contenteditable="true" class="athow_content">[@kg_product_description]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Rating')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Product|aggregateRating|ratingValue"></input>
							<div contenteditable="true" class="athow_content">[@kg_product_ratingValue]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Based on how many reviews')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Product|aggregateRating|reviewCount"></input>
							<div contenteditable="true" class="athow_content">[@kg_product_reviewCount]</div>
						</div>
					</div>
				</div>
				<div id="knowledge_Event" class="knowledge_page_tab">
					<label class="css-gfejhyi850 title_gwp">
						{_('Event')}
					</label>
					<div class="select-field s12">
						<select tabindex="-1" class="browser-default r4w_autosave_info r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|type">
							<option value="" disabled selected>{_('Choose a event')}</option>
							[@knowledge_graph_event_option]
						</select>
						<div class="r4w_additional_info">
							{_('This option allows you to specify the type of event')}.
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Name')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|name"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_name]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('URL')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|url"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_url]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Description')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|description"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_description]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Venue Name')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|location|name"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_location_name]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Venue URL')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|location|sameAs"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_location_sameAs]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Address')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|location|address|streetAddress"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_address_streetAddress]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('City')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|location|address|addressLocality"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_address_addressLocality]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Zip/Postal Code')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|location|address|postalCode"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_address_postalCode]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Country')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|location|address|addressCountry"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_address_addressCountry]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Offer Description')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|offers|description"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_offers_description]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Offer URL')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|offers|url"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_offers_url]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Offer Price')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Event|offers|price"></input>
							<div contenteditable="true" class="athow_content">[@kg_event_offers_price]</div>
						</div>
					</div>
				</div>
				<div id="knowledge_Website" class="knowledge_page_tab">
					<label class="css-gfejhyi850 title_gwp">
						{_('Website')}
					</label>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Name')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Website|name"></input>
							<div contenteditable="true" class="athow_content">[@kg_website_name]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('Alternate Name')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Website|alternateName"></input>
							<div contenteditable="true" class="athow_content">[@kg_website_alternatename]</div>
						</div>
					</div>
					<div class="r4w_atwho_box select-field">
						<label for="bac_rss_after">{_('URL')}</label>
						<div class="r4w_autosave_info r4w_progress_div dsgn_input_athow">
							<input class="athow_input r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Website|url"></input>
							<div contenteditable="true" class="athow_content">[@kg_website_url]</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 