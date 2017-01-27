$("form").submit(function(e) {

    var ref = $(this).find("[rrequired]");

    $(ref).each(function(){
        if ( $(this).val() == '' )
        {
            alert("Please fill out the required information.");

            $(this).focus();

            e.preventDefault();
            return false;
        }
    });  return true;
});