<div class="smj-content">
    <form method="post">
		<input type="hidden" name="r4w_method" value="r4w_box-keyword_lexical">
		<input type="hidden" name="authenticity_token" value="[@authenticity_token]">
		<div class="css-sfo82ac">
			{_('Add your lexical keywords')}
		</div>
		<div class="r4w_bullet_info">
			<div class="css-sd5r0fze5">
				[@svg_bullet_info]
			</div>
			<div class="css-df5r0grg">
				{_('Lexical keywords are terms related to your primary and secondary keywords, which are intended only to show search engines that you understand all the vocabulary surrounding the topic')}.
			</div>
		</div>
		<div id="r4w_error"></div>
		<div class="selectkeyword_box">
               <div id="keyword_select_list">
               <div id="r4w_sc_keyword_lexical" class="r4w_list_keyword" data-simplebar data-simplebar-auto-hide="false">
                    <ul class="ui-choose css-sdf55fe0er" multiple="multiple" id="uc_03">
                         <div class="ph-item"> <div class="ph-box-keyword"> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> <div class="ph_keyword"></div> </div> </div>
                    </ul>
               </div>
               <div>
                    <label for="r4w_keywords">{_('Your keyword select')}</label>
                    <input class="r4w_select_keywords" maxlength="255" type="text" size="255" name="r4w_keywords" id="r4w_keywords_lexical">
               </div>
               </div>
		</div>
		<div id="loading"><div class="dual-ring"></div></div>
		<button type="submit" class="r4w_form css-1g97g96">{_('Continue')}</button>
    </form>
</div>