<footer class="tm-bg-gray pt-5 pb-3 tm-text-gray tm-footer">
        <div class="container-fluid tm-container-small">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">About Catalog-Z</h3>
                    <p>Catalog-Z is free <a rel="sponsored" href="https://v5.getbootstrap.com/">Bootstrap 5</a> Alpha 2 HTML Template for video and photo websites. You can freely use this TemplateMo layout for a front-end integration with any kind of CMS website.</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                    <h3 class="tm-text-primary mb-4 tm-footer-title">Our Links</h3>
                    <ul class="tm-footer-links pl-0">
                        <li><a href="#">Advertise</a></li>
                        <li><a href="#">Support</a></li>
                        <li><a href="#">Our Company</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-5 mb-5">
                    <ul class="tm-social-links d-flex justify-content-end pl-0 mb-5">
                        <li class="mb-2"><a href="https://facebook.com"><i class="fab fa-facebook"></i></a></li>
                        <li class="mb-2"><a href="https://twitter.com"><i class="fab fa-twitter"></i></a></li>
                        <li class="mb-2"><a href="https://instagram.com"><i class="fab fa-instagram"></i></a></li>
                        <li class="mb-2"><a href="https://pinterest.com"><i class="fab fa-pinterest"></i></a></li>
                    </ul>
                    <a href="#" class="tm-text-gray text-right d-block mb-2">Terms of Use</a>
                    <a href="#" class="tm-text-gray text-right d-block">Privacy Policy</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-7 col-12 px-5 mb-3">
                    Copyright 2020 Catalog-Z Company. All rights reserved.
                </div>
                <div class="col-lg-4 col-md-5 col-12 px-5 text-right">
                    Designed by <a href="https://templatemo.com" class="tm-text-gray" rel="sponsored" target="_parent">TemplateMo</a>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="js/plugins.js"></script>
    <script>

        $(document).ready(function() {
            $('#pickup').css('display', 'none');
            $('#pick').css('display', 'none');

            $("#pic").click(function() {
                $('#delivery').css('display', 'none');
                $('#pay').css('display', 'none');
                $('#pickup').slideDown(1000);
                $('#pick').slideDown(1000);
            });

            $("#del").click(function() {
                $('#pickup').css('display', 'none');
                $('#pick').css('display', 'none');
                $('#delivery').slideDown(1000);
                $('#pay').slideDown(1000);
            });

// ----------------------------            ------------------------------------
            // var total = $('#total').html();
            // var qty = $('#mydiv #qtyNum');
            // if (qty.length > 0) {
            //     var result = '';
            //     var resultqty = qty.length;
            //     qty.change(function(){
            //         if (result == '') {
            //             result = total;
            //         }else {
            //             result = $(this).val() * total;
            //         }
            //         $('#total').html(result);
            //     });
            // }
        });


        var Image = document.getElementById('myDiv').getElementsByTagName('img');
         for(var i=0; i<Image.length; i++){
             Image[i].onmouseover = function (){
                 this.style.cursor = 'hand';
             }
             Image[i].onmouseout = function (){
                 this.style.cursor = 'pointer';
             }
         }
        function changeImage(event){
            event = event || window.event;
            var targetElement = event.target || event.srcElement;
            if(targetElement.tagName == 'IMG'){
                document.getElementById('mainImage').src = targetElement.getAttribute('src');
            }
        }
  // -----------------------------------------------  image show  --------------------------------------
        $(document).ready(function() {
        var btnStop = $('#btnStop img');
        var imageURL = new Array();
        var interValId ;
        $('#myDiv img').each(function(){
            imageURL.push($(this).attr('src'));
        })
        function setImage(){
            var mainImageElement = $('#mainImage');
            var currentImageURL = mainImageElement.attr('src');
            var currentImageIndex = $.inArray(currentImageURL,imageURL);
            if(currentImageIndex == (imageURL.length - 1)){
                currentImageIndex = - 1;
            }
            mainImageElement.attr('src',imageURL[currentImageIndex + 1]);
        }
        interValId = setInterval(setImage,5000);

        btnStop.click(function(){
            clearInterval(interValId);
        });
    });
        //-------------------------------- imgae slideshow  -----------------------------------
   
        $(document).ready(function() {
            $('#hiddenClass').css('display', 'none');

            $("input[type='checkbox']").click(function() {
                $('#hiddenClass').slideDown(1000);
            });
        });


        // --------------------------------------   massage box slidedown  --------------------


        $(document).ready(function() {
            $('#hidden').css('display', 'none');

            $('input[type="checkbox"]').click(function(){
                var result = $('input[type="checkbox"]:checked');
                if(result.length > 0){
                    var resultString = result.length;
                    $('#divBox input[value=""]').val(resultString);
                }
            });
        });
        // ------------------------------------ sum chackbox -----------------------------

        $(document).ready(function() {
            $('#declade').click(function(){
                var r = $('#cart_number').val();
                r = parseInt(r) - 1;
                $('#cart_number').val(r);
            });

            $('#include').click(function(){
                var r = $('#cart_number').val();
                r = parseInt(r) + 1;
                $('#cart_number').val(r);
            });
        });

        // ----------------------------------  Add cart  -----------------------------------

    </script>  

    <script>


        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>