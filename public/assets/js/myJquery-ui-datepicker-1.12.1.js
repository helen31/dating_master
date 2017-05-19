/**
 * Created by Alena on 11.05.2017.
 */
$( function() {
    //$.fn.datepicker.noConflict();/**to remove conflict with bootstrap-datepicker**/
    /**client/profile/adit.blade.php**/
    $( "#datepicker-birthday1" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-pass_date1" ).datepicker({
            dateFormat: "yy-mm-dd"
    });
    var dateVal = $( "#datepicker-pass_date1" ).val();
    $( "#datepicker-pass_date1" ).datepicker( "setDate", dateVal );

   /**admin girls/create.blade.php**/
    $( "#datepicker-birthday2" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-pass_date2" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin men/edit.blade.php**/
    $( "#datepicker-birthday3" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin girls/edit.blade.php**/
    $( "#datepicker-birthday4" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin/finances/client/refunds.blade.php**/
    $( "#datepicker-finances-startDate1" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-finances-endDate1" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin/finances/client/expenses.blade.php**/
    $( "#datepicker-finances-startDate2" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-finances-endDate2" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin/finances/client/deposits.blade.php**/
    $( "#datepicker-finances-startDate3" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-finances-endDate3" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin/finances/partners/fines.blade.php**/
    $( "#datepicker-finances-startDate4" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-finances-endDate4" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin/finances/partners/detail-stat.blade.php**/
    $( "#datepicker-finances-startDate5" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-finances-endDate5" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    /**admin/finances/clients/detail-stat.blade.php**/
    $( "#datepicker-finances-startDate6" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $( "#datepicker-finances-endDate6" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

} );