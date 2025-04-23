<div id="divAuthorizeNetPopup" class="AuthorizeNetPopupGrayFrameTheme d-none">
    <div class="AuthorizeNetPopupOuter">
        <div class="AuthorizeNetPopupTop">
            <div class="AuthorizeNetPopupClose">
                <a href="javascript:;" onclick="AuthorizeNetPopup.closePopup();" title="Close"> </a>
            </div>
        </div>
        <div class="AuthorizeNetPopupInner">
            <iframe name="iframeAuthorizeNet" id="iframeAuthorizeNet" src="{{ route('anet.empty') }}" frameborder="0"
                data-billing-countries="CA, US">
            </iframe>
        </div>
        <div class="AuthorizeNetPopupBottom">
            <div class="AuthorizeNetPopupLogo" title="Powered by Authorize.net"></div>
        </div>
        <div id="divAuthorizeNetPopupScreen"></div>
    </div>
</div>
