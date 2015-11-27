/**
 * Created by John on 10/29/2015.
 */
jQuery(document).ready(function() {

    /**
     * set single images to open with fancybox
     * use rel attributes to open images with same rel as gallery
     * social share buttons are set in beforeShow function
     */
    jQuery('a#single_image').fancybox({
        padding : [0,0,0,0],
        beforeShow : function () {

            this.title = '<style type="text/css">.fancybox-title{text-align:center}</style>';
            this.title += '<scr' + 'ipt type="text/javascript">function pinItPopup() {popupWindow = window.open("//www.pinterest.com/pin/create/button/?url=' + encodeURI(window.location.href) + '&media=' + encodeURI(this.href) + '","popUpWindow", "height=700,width=800,left=10,top=10,resizable=yes,scrollbars=no,toolbar=yes,menubar=no,location=no,directories=no,status=yes")}</scr' + 'ipt>';
            this.title += '<a data-pin-do="buttonBookmark" href="Javascript:pinItPopup();"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" /></a>';
            this.title += '<iframe width="49" scrolling="no" height="20" frameborder="0" style="border: medium none; margin: 1px 0 0 5px;" src="http://www.houzz.com/buttonWidget/1?url='+this.href+'&img='+this.href+'&title=Marlaina%20Teich%20Designs&hzid=9248&ref=http://mtdny.com"></iframe>';
        },
        openEffect : 'fade',
        closeEffect : 'fade',
        nextEffect : 'fade',
        prevEffect : 'fade',
        openSpeed : 'normal',
        closeSpeed : 'normal',
        helpers : {
            title : {
                type:"outside",
                position:"bottom"
            }
        }
    });

    //Center social buttons in title area
    jQuery('.fancybox-title').css('text-align', 'center');
});