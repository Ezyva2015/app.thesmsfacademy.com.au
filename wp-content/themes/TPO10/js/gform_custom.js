(function($){ 
     
   $( "#input_73_213" ).keyup(function() {  

        // setTimeout(explode, 2000);

      

        setTimeout(function(){
            // alert("test"); 
            // console.log($(this).val());
//             $('.ui-helper-hidden-accessible').text($(this).val());    
            // alert($('.ui-helper-hidden-accessible').text());


            // var str = "Hello world, welcome to the universe.";
            var n = $('.ui-helper-hidden-accessible').text().indexOf("No search results.");
    
           // alert(n);
              
            
            if(n >= 0) {
                $('.ui-helper-hidden-accessible').text($(this).val());
            } else {

            }


        
        },1000);
    }); 



})(jQuery);




