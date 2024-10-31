<div class="r4w_checkbox r4w_business_hours">
	<div class="css-sdf5e0er8e">
		<label>
			<input type="checkbox" class="r4w_autosave r4w_input_custom_business_hours" name="seo_settings|basic_configuration|knowledge_graph|Organization|openingHours|[@day_slug]|checked" [@day_checked] />
			<span>[@day_name]</span>
		</label>
	</div>
	<div class="r4w_openingHours css-oazjez509 [@hours_disabled]">
		<div class="css-tyuz5ze0z">
			<div class="css-aope5892ndu">{_('Opening time')}</div>
			<select tabindex="-1" class="browser-default r4w_autosave_info r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|openingHours|[@day_slug]|open" [@hours_disabled]>
				<option value="" selected>--</option>
				[@hours_open]
			</select>
		</div>
		<div class="css-tyuz5ze0z">
			<div class="css-aope5892ndu">{_('Closing times')}</div>
			<select tabindex="-1" class="browser-default r4w_autosave_info r4w_autosave" name="seo_settings|basic_configuration|knowledge_graph|Organization|openingHours|[@day_slug]|close" [@hours_disabled]>
				<option value="" selected>--</option>
				[@hours_close]
			</select>
		</div>
	</div>
</div>