/*price range*/
$ = jQuery.noConflict();
 $('#sl2').slider();

	var RGBChange = function() {
	  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
	};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});

$(document).ready(function () {
    $("#selSize").change(function () {
        var idSize = $(this).val();
        if(idSize == ""){
        	return false;
		}
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'get-product-price',
            data:{idSize:idSize},
            success:function(resp) {
                var arr = resp.split('#');
                $("#getPrice").html("Rs. "+ arr[0]);
                $("#price").val(arr[0]);

                //Send the updated price based on size of the product
                if (arr[1] == 0){
                    $("#cartButton").hide();
                    $("#availability").text(" Out of Stock").css('color', 'red');
                    $("#emptySize").text('The product is out of stock').css('color', 'red');
                }else {
                    $("#cartButton").show();
                    $("#availability").text(" In Stock").css('color', 'green');
                    $("#emptySize").text('').css('color', 'red');
                }
            },error:function (resp) {

            }
        });
    });
});
// Replace Main Image with aleternate Image

$(document).ready(function(){

    $(".changeImage").click(function () {
        var image = $(this).attr('src');
        $(".mainImage").attr("src", image);
    });
});


// Instantiate EasyZoom instances
var $easyzoom = $('.easyzoom').easyZoom();

// Setup thumbnails example
var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

$('.thumbnails').on('click', 'a', function(e) {
    var $this = $(this);

    e.preventDefault();

    // Use EasyZoom's `swap` method
    api1.swap($this.data('standard'), $this.attr('href'));
});

// Setup toggles example
var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

$('.toggle').on('click', function() {
    var $this = $(this);

    if ($this.data("active") === true) {
        $this.text("Switch on").data("active", false);
        api2.teardown();
    } else {
        $this.text("Switch off").data("active", true);
        api2._init();
    }
});
