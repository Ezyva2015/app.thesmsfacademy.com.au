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

    $.fn.gform_edit_entry = function(options){

        var defaults = {
            form_id         :   null,
            selector        :   '',
            thank_you_page  :   '',
            post            :   '',
            ajx_url         :   '/api/gform_edit_entry.php'
        };

        var opts = $.extend(defaults, options);

        var $this = $(this);



        var edit_entry_success = function(entry_id){
            if(opts.thank_you_page){
                edit_preloader();
                window.location.href = opts.thank_you_page;
            }else{
                $success = bootbox.dialog({
                    message: "Your form data has been successfully updated. Entry ID: " + JSON.stringify(entry_id) +
                        ". <br/>You can view your saved entries in the 'Stored Data' tab in your My Account area",
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
            }
        };

        var edit_entry_fail = function(error){
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

        var edit_preloader = function(){
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
            $return.form_id =   opts.post.input_form_id || get_form_id();
            return $return;
        };

        var get_postData = function(){
            $return = {};
            $return.gform_unique_id   =   opts.post.gform_unique_id;
            $return.gform_edit_mode   =   opts.post.gform_edit_mode;
            $return.form_id           =   opts.post.input_form_id || get_form_id();
            $return.id                =   opts.post.input_id;
            $return.ip                =   opts.post.input_ip;
            $return.created_by        =   opts.post.input_created_by;
            $return.currency          =   opts.post.input_currency;
            $return.date_created      =   opts.post.input_date_created;
            $return.gform_edit_id     =   opts.post.input_gform_edit_id;
            $return.is_fulfilled      =   opts.post.input_is_fulfilled;
            $return.is_read           =   opts.post.input_is_read;
            $return.is_starred        =   opts.post.input_is_starred;
            $return.payment_amount    =   opts.post.input_payment_amount;
            $return.payment_date      =   opts.post.input_payment_date;
            $return.payment_method    =   opts.post.input_payment_method;
            $return.post_id           =   opts.post.input_post_id;
            $return.source_url        =   opts.post.input_source_url;
            $return.status            =   opts.post.input_status;
            $return.transaction_id    =   opts.post.input_transaction_id;
            $return.transaction_type  =   opts.post.input_transaction_type;
            $return.user_agent        =   opts.post.input_user_agent;
            $return.internalAction    =   opts.post.internalAction;
            return $return
        };

        var edit_entry = function(){
            $output = '';

            edit_preloader();

            $entry_id = $this.find('input#gform_edit_id').val();

            $.ajax({
                url      :  opts.ajx_url,
                dataType :  'json',
                data     :  {action:1,entry_id:$entry_id,entry: get_form_data(),postData:get_postData()},
                type     :  'POST',
                success  :  function(data){

                    remove_preloader();

                    $edit_entry = data;
                    if($edit_entry.success){
                        edit_entry_success($edit_entry.success)
                    }else{
                        edit_entry_fail($edit_entry.error)
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
                            edit_entry();
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