$(document).ready(function(){
    $('.form-control').keypress(function(e) {
            if(e.which == 10 || e.which == 13) {
                this.form.submit();
            }
        });
});

