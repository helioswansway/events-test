$(document).ready(function(){
    $("#search").focus(function() {
        $(".search-box").addClass("border-searching");
        $(".search-icon").addClass("si-rotate");
    });

    $("#search").blur(function() {
        $(".search-box").removeClass("border-searching");
        $(".search-icon").removeClass("si-rotate");
    });

    $("#search").keyup(function() {
        if($(this).val().length > 0) {
        $(".go-icon").addClass("go-in");
        }
        else {
        $(".go-icon").removeClass("go-in");
        }
    });

    $(".go-icon").click(function(){
        $(".search-form").submit();
    });


    //date Search
    //Sale Date Calendar
    $( "#sale_date_first, #sale_date_last" ).datepicker({
        dateFormat: 'dd-mm-yy',
        showOn: "button",
        buttonImage: "/assets/images/calendar-icon-blue.png",
        buttonImageOnly: true,
        buttonText: "Select date"
    });



    $("#sale_date_first").on("change",function(){

        var campaign_id = $("#campaign_id").val();
        var dealership_id = $("#dealership_id").val();
        var first_date= $("#sale_date_first").val();
        var last_date= $("#sale_date_last").val();

        if($("#sale_date_first").val() != ""  && $("#sale_date_last").val() != ""){

            var url = '/dashboard/search-vehicles/sale-date?campaign_id=' +campaign_id+'&first_sale_date='+first_date+ '&last_sale_date='+last_date+'&dealership_id='+dealership_id;
            window.location.href = url;

        }

    });

    $("#sale_date_last").on("change",function(){

        var campaign_id = $("#campaign_id").val();
        var dealership_id = $("#dealership_id").val();
        var first_date= $("#sale_date_first").val();
        var last_date= $("#sale_date_last").val();

        if($("#sale_date_first").val() != ""  && $("#sale_date_last").val() != ""){
            var url = '/dashboard/search-vehicles/sale-date?campaign_id=' +campaign_id+'&first_sale_date='+first_date+ '&last_sale_date='+last_date+'&dealership_id='+dealership_id;
            window.location.href = url;
        }

    });
    //END

    //Last work Date Calendar
    $( "#last_work_date_start, #last_work_date_end" ).datepicker({
        dateFormat: 'dd-mm-yy',
        showOn: "button",
        buttonImage: "/assets/images/calendar-icon-orange.png",
        buttonImageOnly: true,
        buttonText: "Select date"
    });

    $("#last_work_date_start").on("change",function(){

        var campaign_id = $("#campaign_id").val();
        var dealership_id = $("#dealership_id").val();
        var start_date= $("#last_work_date_start").val();
        var end_date= $("#last_work_date_end").val();

        if($("#last_work_date_start").val() != ""  && $("#last_work_date_end").val() != ""){

            var url = '/dashboard/search-vehicles/last-work-date?campaign_id=' +campaign_id+'&start_date='+start_date+ '&end_date='+end_date+'&dealership_id='+dealership_id;
            window.location.href = url;

        }

    });

    $("#last_work_date_end").on("change",function(){

        var campaign_id = $("#campaign_id").val();
        var dealership_id = $("#dealership_id").val();
        var start_date= $("#last_work_date_start").val();
        var end_date= $("#last_work_date_end").val();

        if($("#last_work_date_start").val() != ""  && $("#last_work_date_end").val() != ""){
            var url = '/dashboard/search-vehicles/last-work-date?campaign_id=' +campaign_id+'&start_date='+start_date+ '&end_date='+end_date+'&dealership_id='+dealership_id;
            window.location.href = url;
        }

    });
    //END





});
