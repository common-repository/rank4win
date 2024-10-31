<div class="smj-content">
    <form method="post">
		<input type="hidden" name="r4w_method" value="r4w_box-keyword_secondary">
		<input type="hidden" name="authenticity_token" value="[@authenticity_token]">
		<div class="css-sfo82ac">
			{_('Add your secondary keywords')}
		</div>
		<div class="r4w_bullet_info">
			<div class="css-sd5r0fze5">
				[@svg_bullet_info]
			</div>
			<div class="css-df5r0grg">
				{_('Secondary keywords are variations of your main keyword. They are useful for enriching the semantics of your content, not to mention that they are the best way for Google to notice you and appreciate your news')}.
			</div>
		</div>
		<div id="r4w_error"></div>
		<div class="selectkeyword_box">
			<div id="keyword_select_list">
				<h3>{_('Suggestion of keywords')}</h3>
				<div id="r4w_sc_keyword_secondary" class="r4w_list_keyword">
                         <ul class="ui-choose css-sdf55fe0er" multiple="multiple" id="uc_03">
                              <div class="ph-item"> <div class="ph-box-keyword"> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> </div> </div>
                         </ul>
		    	     </div>
				<div>
				  <label for="r4w_keywords">{_('Your keyword select')}</label>
				  <input class="r4w_select_keywords" maxlength="255" type="text" size="255" name="r4w_keywords" id="r4w_keywords_secondary">
				</div>
			</div>
		</div>
		<div id="loading"><div class="dual-ring"></div></div>
		<button type="submit" class="r4w_form css-1g97g96">{_('Continue')}</button>
    </form>
</div>