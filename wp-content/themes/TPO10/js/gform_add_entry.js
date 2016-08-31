(function($){
    $.fn.serializeFormData = function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    $.fn.gform_add_entry = function(options){

        var defaults = {
            form_id     :   null,
            selector    :   '',
            thank_you_page : '',
            ajx_url     :   '/api/gform_add_entry.php'
        };

        var opts = $.extend(defaults, options);

        var $this = $(this);



        var add_entry_success = function(entry_id){
            //if(opts.thank_you_page){
            //    add_preloader();
              //  window.location.href = opts.thank_you_page;
           // }else{
                $success = bootbox.dialog({
                    message: "Your form data has successfully been saved. Order ID: " + JSON.stringify(entry_id) +
                             ". <br/>You can view your saved orders in the 'Saved' tab under 'Documents', or click <a href='https://app.thesmsfacademy.com.au/saved/documents/'>here</a>.",
                    title: "Success",
                    button:{
                        success: {
                            label: "OK",
                            className: "btn-success",
                            callback: function(){
                                alert('foo');
                            }
                        }
                    }
                });
                return $success;
           // }
        };

        var add_entry_fail = function(error){
            $error = bootbox.dialog({
                message: 'Error: '+ JSON.stringify(error),
                title: "Fail",
                button:{
                    success: {
                        label: "OK",
                        className: "btn-danger",
                        callback: function() {}
                    }
                }
            });
            return $error;
        };

        var add_preloader = function(){
             $('body').append('<div class="modal-backdrop fade in" style="background-color: transparent!important; opacity: 1;">' +
                '<img src="/wp-content/themes/TPO10/img/loader.GIF" alt="loading..." style="z-index: -1; position: absolute;top: 40%;left: 46%;"/></div>');

        };
         var remove_preloader = function(){
            $(".modal-backdrop.fade.in").remove();
        };

        var QueryStringToJSON =function(qs) {
            var pairs = qs.split('&');

            var result = {};
            pairs.forEach(function(pair) {
                pair = pair.split('=');
                result[pair[0]] = decodeURIComponent(pair[1] || '');
            });

            return JSON.parse(JSON.stringify(result));
        };

        var get_form_id = function(){
            id = $this.find('input#gform_form_id').val() || $this.find('input[name="gform_submit"]').val();
            return id;
        };


        var get_form_data = function(){
            $return = {};
            $return =  $('form#gform_'+get_form_id()).serializeFormData();
            $return.form_id = get_form_id();
            return $return;
        };

        var add_entry = function(){
            $output = '';

            add_preloader();

            $.ajax({
                url      :  opts.ajx_url,
                dataType :  'json',
                data     :  {action:1,entry: get_form_data()},
                type     :  'POST',
                success  :  function(data){

                    remove_preloader();

                    $add_entry = data;
                    if($add_entry.success){
                        add_entry_success($add_entry.success)
                    }else{
                        add_entry_fail($add_entry.error)
                    }
                }
            });
        };

        var output = function(){
            return bootbox.dialog({
                message: '<h5>Are you sure you want to save it?</h5>',
                title: "Confirm Action - Save form data",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-success",
                        callback: function(){
                            add_entry();
                        }
                    },
                    danger: {
                        label: "No",
                        className: "btn-danger",
                        callback: function() {}
                    }
                }
            });
        };

        return this.each(function(){
            if(opts.selector){
                $(this).on('click', opts.selector,function(e){

                    output();
                    return false;
                })
            }else{
                $(this).on('click', function(e){
                    output();
                    return false;
                })
            }
        })
    };

})(jQuery);