/**
 * Created by Alena on 15.05.2017.
 */
<!--You've winked-->
$('#smile').on('click', function (event) {
    event.preventDefault();

    $(event.target).parent('.grg-tada_link').find('.smilePopupWindow').show(600, function (event) {
        var currentElem = $(this);

        setTimeout( function(){ currentElem.hide(); }, 800);
    });
});
