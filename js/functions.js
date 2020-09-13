$(document).ready(function() {

  $(document).on("change", "#sel_reg", function () {
    
   var reg = $(this).val(); 
    $.ajax({
            url:window.location.href,
            dataType:"json",
            type:"POST",
            data:"ajax=getCities&reg_id="+reg,
            success:function(res) {
                if (res.status == 1) {
                    $("#sel_city").chosen('destroy');
                    $("#sel_city").html(res.content);
                    $('#sel_city').chosen();
                    $("#sel_city").trigger('change');
                }
            }
        });
  }); 
  
  $(document).on("change", "#sel_city", function () {
    
   var city = $(this).val(); 
   var reg = $("#sel_reg").val(); 
    $.ajax({
            url: window.location.href,
            dataType:"json",
            type:"POST",
            data:"ajax=getDistricts&city_id="+city+'&reg_id='+reg,
            success:function(res) {
                if (res.status == 1) {
                    $("#sel_distr").chosen('destroy');
                    $("#sel_distr").html(res.content);
                    $("#sel_distr").chosen();
                }
            }
        });
  });       
  
  $(document).on("click", ".js_validate button[type=submit]", function () {
        var _form = $(this).parents(".js_validate");
        var valid = validate(_form);
        if (valid) {
          $.ajax({
              url: window.location.href,
              method: 'POST',
              dataType: 'json',
              data: _form.serialize() + "&ajax=SaveForm",
              success: function (res) {
                   if (res.status == 1)
                   {
                       alert("Вы успешно зарегистрировались");
                       _form.find('input[type=text], input[type=email], textarea').val("");
                    }
                   else
                   {
                       alert("Пользователь с таким Email уже зарегистрирован !");
                       $(res.user).each(function() {
                          $('#username').val(this.name);
                          $('#user_id').val(this.id);
                        });
                      window.location = window.location.href;
                       
                   } 
                 }  
                });
                return false;
        }
   });                        
   
   $(document).on("click", "#lnk_out", function () {    
       document.cookie = "user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
       window.location = window.location.href;
   });                            

});        

function validate(form) {
    var error_class = "error";
    var norma_class = "pass";
    var item = form.find("[required]");
    var e = 0;
    var reg = undefined;
    var email = false;
    var phone = false;

    function mark(object, expression) {
        if (expression) {
            object.parents('.input-field').addClass(error_class).removeClass(norma_class).find('.error').show();
            e++;
        } else
            object.parents('.input-field').addClass(norma_class).removeClass(error_class).find('.error').hide();
    }

    form.find("[required]").each(function () {
        if ($(this).attr('disabled') != 'disabled') {
            switch ($(this).attr("data-validate")) {
                case undefined:
                    mark($(this), $.trim($(this).val()).length == 0);
                    break;
                case "email":
                    reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    mark($(this), !reg.test($.trim($(this).val())));
                    break;
                case "phone":
                    reg = /[0-9 -()+]{10}$/;
                    mark($(this), !reg.test($.trim($(this).val())));
                    break;
                 default:
                    reg = new RegExp($(this).attr("data-validate"), "g");
                    mark($(this), !reg.test($.trim($(this).val())));
                    break;
            }
        }
    });
    
    e += form.find("." + error_class).length;
    if (e == 0)
        return true;
    else {
        $('.js_alert_error').show();
        setTimeout(function () {
            $('.js_alert_error').hide();
        }, 4000);
        form.find('.error input:first').focus();
        return false;
    }
}

        