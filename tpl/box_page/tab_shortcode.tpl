<div id="r4w_st_page_sn_shortcode" class="page_tab">
	<div class="css-dsf5e0ff">
		<label class="css-gfejhyi850 title_gwp">
			{_('Links of sister pages')}
		</label>
		<div class="r4w_bullet_info">
			<div class="css-sd5r0fze5">[@svg_bullet_info]</div>
			<div class="css-df5r0grg">{_('You can use a shortcode to display the links of the sister pages, when there are sister pages, you can change the display name of the links')}.</div>
		</div>
		<div class="r4w_atwho_box select-field athow_lg">
			<label for="bac_hom_description"> {_('Shortcode to use to display sister pages links')}</label>
			<div class="r4w_additional_info css-f5e0z8ffa">[[@sc_sister_pages_link]]</div>
		</div>
		<div class="switch r4w_autosave_info">
			<label>
				<input type="checkbox" class="r4w_autosave r4w_input_custom_shortcode" name="shortcode|customize|display"  [@shortcode_customize_display]>
				<span class="lever"></span>
				{_('Customize the text above the links')}
			</label>
		</div>
		<div class="r4w_additional_info">
			{_('This option allows you to customize which will be displayed before the links. If you do not want to display anything before the links, just check this box without indicating any text')}.
		</div>
		<div class="r4w_atwho_box select-field ck_custom [@shortcode_customize_box_contenteditable]">
			<label for="bac_hom_description"> {_('Text above the links')} </label>
			<div class="r4w_autosave_info r4w_progress_div ck_custom dsgn_input_athow">
				<input class="athow_input r4w_autosave" name="shortcode|customize|title"></input>
				<div contenteditable="[@shortcode_customize_contenteditable]" class="[@shortcode_customize_athow]">[@shortcode_customize_title]</div>
			</div>
		</div>
		[@shortcode_customize_links]
	</div>
</div> 