<div id="r4w_system_message"></div>
<div id="r4w_auth_otp" data-type="[@type_otp]">
  <div class="css-100frqb">
    <div class="css-9388ij">
        <div class="css-gzb9kt">
            <div class="css-1rvpz4w">
              [@svg_rank4win_black]
            </div>
        </div>
        <div id="box_otp" class="css-8atqhb">
          <div class="css-2rg8e0">{_('Verification code')}</div>
          <p class="css-c320wn">[@otp_desc].</p>
          <div id="r4w_error"></div>
          <div class="css-4ywf4y">
               <div class="css-dfe0zae">
                    <form method="get" class="r4w_digit_otp" data-group-name="otp" data-autosubmit="false" autocomplete="off">
                         <input id="otp_1" name="otp_1" type="text" data-next="otp_2">
                         <input id="otp_2" name="otp_2" type="text" data-next="otp_3" data-previous="otp_1">
                         <input id="otp_3" name="otp_3" type="text" data-next="otp_4" data-previous="otp_2">
                         <input id="otp_4" name="otp_4" type="text" data-previous="otp_3">
                    </form>
               </div>
          </div>
          <div id="loading"><div class="dual-ring"></div></div>
          <button class="css-1g97g96 btn_submit">{_('Check your code')}</button>
        </div>
        <div id="box_password" class="css-8atqhb">
          <div class="css-2rg8e0">{_('New password')}</div>
          <div id="r4w_error"></div>
          <div class="css-4ywf4y">
              <div class="css-dfe0zae">
                    <div name="password" type="password" class="css-17maygl">
                        <label for="pwd" class="css-ya34dr">{_('New password')}</label>
                        <div>
                            <input id="pwd" name="pwd" placeholder="[@placeholder_password]" type="password" class="css-1rkhnpn" aria-autocomplete="list" autocomplete="new-password">
                        </div>
                    </div>
                    <div name="confirm" type="password" class="css-17maygl">
                        <label for="repwd" class="css-ya34dr">{_('Confirm new password')}</label>
                        <div>
                            <input id="repwd" name="repwd" placeholder="[@placeholder_confirm_password]" type="password" class="css-1rkhnpn">
                        </div>
                    </div>
              </div>
          </div>
          <div id="loading"><div class="dual-ring"></div></div>
          <button class="css-1g97g96 btn_submit">{_('Change your password')}</button>
        </div>
        <div class="css-1yuhvjn">
          <a target="_blanc" href="[@r4w_url_privacy]">
            {_('Terms of Service')}
            &amp;
            {_('Privacy Policy')}
          </a>
        </div>
    </div>
  </div>
</div>