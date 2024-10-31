<div id="r4w_msgprotected_str_semantic"></div>
<div id="r4w_system_message"></div>
<div id="r4w_box_editor">
	<div id="r4w_editor_name" class="css-d2d9c05240dc"></div>
	<div class="wrap">
		<div class="r4w_splitter-container">
			<div id="r4w_editor_left" class="r4w_splitter-left">
				[@str_editor]
			</div>
			<div id="r4w_splitter_bar" class="splitter"></div>
			<div id="r4w_editor_right" class="r4w_splitter-right">
				<div class="r4w_right_limit">
					<div class="ph_box">
						<div class="ph-item">
							<div class="ph-line">
								<div class="ph_search">
									<div class="ph_input"></div>
									<div class="ph_btn"></div>
								</div>
							</div>
						</div>
						<div class="ph-item">
							<div class="ph-line">
								<div class="ph_li">
									<div class="ph_btn"></div>
									<div class="ph_btn"></div>
									<div class="ph_btn"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="css-sfd5e0fze css-sf50ezf"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="SimpleModalJs" id="r4w_box-checkstr">
	<div class="smj-header">
	    <div class="logo">
	      [@svg_rank4win_white]
	    </div>
	</div>
	<div class="smj-content">
		<div id="str_checking">
			 <div class="css-sfo82ac">
				 {_('Verification of the structure')}
			 </div>
			 <div class="css-926b8c83e35a">
				 <p>{_('Before we move to the deployment stage we need to check your structure. Wait a few moments')}.</p>
			 </div>
			 <div id="loading_check">
				<div id="loading"><div class="dual-ring"></div></div>
			 </div>
		</div>
		<div id="str_inconclusive">
			<div class="css-77d6884f9a1e">[@svg_error_cross]</div>
			<div class="css-sfo82ac">
				{_('A few problems')}
			</div>
			<div class="css-926b8c83e35a">
				<p>{_('After analyzing your structure we have found that some pages do not have main keywords. Before deploying add the main keywords to your pages')}.</p>
				<p>{_('List of pages with missing main keywords')}:</p>
				<ul></ul>
			</div>
		</div>
		<div id="str_conclude">
			<div class="css-77d6884f9a1e">[@svg_str_done]</div>
			<div class="css-sfo82ac">
				{_('Your structure is ready for deployment')}
			</div>
			<div class="css-926b8c83e35a">
				<p>{_('After verification your structure is ready to be deployed on your wordpress')}.</p>
			</div>
			<a id="str_btn_deploy" class="r4w_form css-1g97g96" href="#">{_('Deploy')}</a>
		</div>
	 </div>
</div>
<div class="SimpleModalJs" id="r4w_box-synchronization">
	<div class="smj-header">
	    <div class="logo">
	      [@svg_rank4win_white]
	    </div>
	</div>
	<div class="smj-content">
		<form method="post">
			 <input type="hidden" name="r4w_method" value="r4w_box-keyword_main">
			 <input type="hidden" name="r4w_locale" value="[@r4w_locale]">
			 <div class="css-sfo82ac">
				 {_('The semantic structure is out of sync')}
			 </div>
			 <div class="css-8d936c0b7f1b">[@svg_synch_prb_wp]</div>
			 <div class="css-926b8c83e35a">
				 <p>{_('Currently, your diagram or semantic structure no longer corresponds to the physical tree structure of your WordPress pages. You may have changed a title or moved or even deleted pages physically')}.</p>
				 <p>{_('That leaves you two possibilities')}:</p>
				 <div class="css-e1ac03b9fa47">
					<div class="css-4c9fef1458fc">
						<div class="css-17bb6ba233f6">1</div>
						<div class="css-42dc08e64811">{_('Update your diagram to match your new current tree structure')}</div>
					</div>
					<div class="css-4c9fef1458fc">
						<div class="css-17bb6ba233f6">2</div>
						<div class="css-42dc08e64811">{_('Keep your diagram intact. In this case, remember that changes made to your pages will not be reflected in your diagram')}</div>
					</div>
				</div>
			 </div>
			 <div class="css-903064e073dd">
				<div id="loading"><div class="dual-ring"></div></div>
				<button id="r4w_desynchronized_replace" type="button" class="r4w_form css-1g97g96">{_('Update your diagram')}</button>
				<button id="r4w_desynchronized_close" type="button" class="r4w_form css-1g97g96">{_('Keeping your diagram intact')}</button>
			 </div>
		</form>
	 </div>
</div>
<div class="SimpleModalJs" id="r4w_box-keyword_main">
	<div class="smj-header">
	    <div class="logo">
	      [@svg_rank4win_white]
	    </div>
	</div>
	[@box_km]
</div>
<div class="SimpleModalJs" id="r4w_box-keyword_secondary">
	<div class="smj-header">
	    <div class="logo">
	      [@svg_rank4win_white]
	    </div>
	</div>
	[@box_ks]
</div>