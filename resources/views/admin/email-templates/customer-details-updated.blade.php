<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width" />
        <meta name="bal" content="width=device-width" />

        <title>Customer Booking Confirmation</title>
            <style>
                .mobile-show{
                    display: none !important;
                }

            @media  only screen and (max-width: 599px) {
                body {
                    width: 100% !important;
                    min-width: 100% !important;
                }
                .ddw_email_footer table {
                     width: 100%;
                     margin: 0;
                     height: auto;
                }
                .ddw_container_wrapper,
                .ddw_email_footer > table {
                     width: 90%;
                     margin: 0 5%;
                     height: auto;
                }
                .ddw_border_container {
                     width: 100%;
                     margin: 0;
                }
                .ddw_container_wrapper table {
                    table-layout:fixed;
                    width:100%;
                }
                .ddw_container_wrapper tbody,
                .ddw_container_wrapper tr,
                .ddw_container_wrapper td {
                     display: block;
                     width: auto;
                     height:auto;
                     margin: 0;
                     -webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                         -ms-box-sizing: border-box;
                          -o-box-sizing: border-box;
                             box-sizing: border-box;
                }
                .ddw_component_header_footer img {
                     float: none;
                     height: auto;
                     max-width: 100%;
                     margin-left: auto;
                     margin-right: auto;
                }
                .ddw_component_paragraph img {
                     float: none !important;
                     margin-bottom: 20px;
                     height: auto;
                     max-width: 100%;
                     margin-left: auto;
                     margin-right: auto;
                }
                .ddw_component_only_image img {
                     float: none !important;
                     height: auto;
                     max-width: 100%;
                     margin-left: auto;
                     margin-right: auto;
                }
                .ddw_component_no_padding {
                    padding: 0 !important;
                }
                .ddw_component_button td {
                    text-align: center;
                }
                .ddw_component_button a {
                    max-width: 100%;
                }

                .mobile-hide{
                    display: none !important;
                }

                .mobile-show{
                    display: block !important;
                }

                .mobile-td{
                    padding:5px;
                    border-bottom: 1px solid #fff;
                }

                h1{
                    font-size: 26px!important;
                    line-height: 30px !important
                }

                h1 span{
                    font-size: 20px!important;
                }

            }
            </style>



    </head>
            <!-- Body -->
    <body style="font-family: Arial, sans-serif; margin-top:0;margin-bottom:0;margin-left:0;margin-right:0; padding-top:0;padding-bottom:0;padding-left:0;padding-right:0; min-width:100%; background: #efefef; text-align:center; yahoo="fix">
        <table class="em_message_main_wrapper" style="font-family: Arial, sans-serif; color: #60686f; width: 600px" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                    <!--Wrapping Table-->

                        <!--It will give a border if width greater than 0 is applied Table-->
                        <table class="ddw_container_wrapper" cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr>
                                    <td class="ddw_container_wrapper" valign="top">
                                        <table style="border-collapse: collapse; border-spacing: 0; width: 100%; background-color: #ffffff;"><!--Top Logo-->
                                            <tbody>

                                            <!--End Top Logo-->

                                                    <!--Body Message Content Table-->
                                                    <tr>
                                                        <td class="ddw_container_wrapper" valign="top">
                                                            <table class="body" style="width: 600px !important; background-color: #ffffff;" width="600">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="background-color: #003158; padding:30px 20px; margin-top: 0px; margin-bottom: 0px;">
                                                                            <table cellspacing="0" cellpadding="0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                                                <tr>
                                                                                    <td style="text-align:left; width: 600px;"><a href="{{url('/admin')}}" ><img src="{{asset('assets/images/public/general/')}}/{{$config->filename_contrast}}" alt="{{$config->company_name}}" width="180" title="{{$config->company_name}}"></a></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="text-align: left; padding: 20px; color: #003158; font-family: verdana, arial; line-height: 22px; font-size:14px" valign="top">
                                                                            <p>Hello,</p>

                                                                            <p>You're receiving this email because a customer/prospect details have updated in the Events Booking System, either by the customer or an Exec.</p>
                                                                            <p> <u>Updated details below:</u>  <br><br>
                                                                                <strong>Name:</strong> {{$customer->name}} <br>
                                                                                <strong>Surname:</strong> {{$customer->surname}} <br>
                                                                                <strong>Email:</strong> {{$customer->email}} <br>
                                                                                <strong>Home Phone:</strong> {{$customer->home_phone}} <br>
                                                                                <strong>Mobile:</strong> {{$customer->mobile}} <br>
                                                                                <strong>Address 1:</strong> {{$customer->address_1}} <br>
                                                                                <strong>Address 2:</strong> {{$customer->address_2}} <br>
                                                                                <strong>Address 3:</strong> {{$customer->address_3}} <br>
                                                                                <strong>Address 4:</strong> {{$customer->address_4}} <br>
                                                                                <strong>Address 5:</strong> {{$customer->address_5}} <br>
                                                                                <strong>Post Code:</strong> {{$customer->post_code}} <br>
                                                                            </p>

                                                                            <p style="font-size:13px;">
                                                                                <em>
                                                                                    If you received this email by mistake please contact <a href="mailto:h.pinto@swanswaygarages.com" style="color:#ec672c;">h.pinto@swanswaygarages.com</a>
                                                                                </em>
                                                                            </p>

                                                                            <p>
                                                                                Regards,<br>
                                                                                {{$config->company_name}}
                                                                            </p>


                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <!--End Body Message Content Table--> <!--Social Icons Table-->
                                                    <tr>
                                                        <td style="width: 100%; background-color: #adcee1; font-family: verdana, arial; padding: 15px 20px; ">
                                                            <div style="color: #ffffff; font-size: 16px; width: 100%;"> {{$config->company_name}} - Events Booking System </div>
                                                        </td>
                                                    </tr>

                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    <!-- End Body -->
</html>
