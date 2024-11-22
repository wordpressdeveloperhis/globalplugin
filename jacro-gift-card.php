<title>Jacro Gift Card</title>
<?php get_header(); ?>
<?php wp_enqueue_script( 'jacro-iframe-resizer-min-js' ); ?>
  <div id="content" class="full-width">    
    <?php
      global $wp_query;
      $jacroArguments = $wp_query->query_vars;
      $jacroGoogleAnalyticsTrackingID = get_option('google-analytics-tracking-id');
      $googleAnalyticsCode = stripslashes(get_option('google_analytics_code'));
      $giftCode = $jacroArguments['jacro-gift-card']; $jacroGiftUrl = '';
      if($giftCode!='') {
        $jacroGiftUrl = GIFTURL.$giftCode.'/sell_giftcard';
      } ?>
      <div class="post-content">
        <iframe id="jacro-giftcard-iframe" width="100%" scrolling="no" frameborder="0"></iframe>
      </div>
    </div>
<script>
jQuery(document).ready(function (){
  var TaposId=readCookie("TaposContactId");
  if(TaposId==null || TaposId==undefined || TaposId=='') {
    TaposId = randomTaposID(24);
  }

  /** Google Code **/
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new 
    Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src = g;
    m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 
    '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', '<?php echo $googleAnalyticsCode; ?>', 'auto' , {
    'allowLinker': true
    });
    ga('require', 'ecommerce', 'ecommerce.js');
    ga('send', 'pageview');
  /*****************/
  ga(function(tracker) {
    clientId = tracker.get('clientId');
    var url='<?php echo $jacroGiftUrl; ?>&ga='+clientId+'&tapos_id='+TaposId;
    url = url.replace('http://','https://');
    url = url.replace(/\s/g, '');
    url = url.replace('&amp;', '&');
    jQuery('#jacro-giftcard-iframe').attr('src', url);
    window.addEventListener("DOMContentLoaded", function(e) {
      document.querySelector('iframe').addEventListener('load', function(e) {}, false);
    }, false);
    
    window.addEventListener( "message", CallJacroIframeListener, false );

    var ifrm = jQuery('#jacro-giftcard-iframe');
    iFrameResize({autoResize:true, checkOrigin:false, log:false, enablePublicMethods:true, resizedCallback: 
      function(messageData){ }
    });
  });
  /**********************************************************************************************************************************/
});
</script>
<?php get_footer(); ?>