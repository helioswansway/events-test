<?php
    use App\Models\SiteConfiguration;
    use App\Models\Dealership;
    use App\Models\Appointment;
    use App\Models\Brand;
    use App\Models\Event;
    use App\Models\EventTime;
    use Illuminate\Support\Facades\Mail;

    use PHPMailer\PHPMailer\PHPMailer;

    use App\Book;
    use App\Exec;
    use App\Mail\ProspectAppointmentConfirmation;
    use App\Mail\NotifyExecAppointment;
    use App\Models\Admin;

    //###########################################################
    //Functions used to dend the specifics emails
    //###########################################################

    //Notifies Execs if Customer makes a Booking
    // function notifyExec($customer_id, $exec_id){
    //     //creates a new PHPMailer instance
    //     $mail = new PHPMailer();
    //     $exec = Exec::find($exec_id);
    //     $dealership = Dealership::where('code', $exec->dealership_code)->first();

    //     //Checks the email credetials
    //     phpMailer($mail);

    //     //Email Subject
    //     $mail->Subject =  $dealership->name . ' Customer Booking Confirmation (' . date("d/m/Y") . ')';

    //     // HTML body function
    //     // Customer/Book ID needs to passed so the currect information displays on the template
    //     $body = htmlBodyExec($customer_id, $exec->id);
    //     $mail->msgHTML($body);

    //     $mail->setFrom('noreply@swanswaygarages.com', "Events Booking System");

    //     //Query to to send emails to admin with notify-role role
    //     $admins   =  DB::table('admins')
    //                     ->join('admin_role', 'admin_role.admin_id', 'admins.id')
    //                     ->join('roles', 'roles.id', 'admin_role.role_id')
    //                     ->where('roles.name', 'super')
    //                     ->orWhere('roles.name', 'notify-booking')
    //                     ->get();

    //     //Loops through the Admins and sends the email notification
    //     foreach($admins as $admin){
    //         $mail->addAddress($admin->email, $admin->name);

    //         $mail->isHTML(true);                                  // Set email format to HTML
    //         $mail->send();
    //         $mail->clearAddresses();
    //         $mail->clearAttachments();
    //     }

    //     //Sends email to the Exec selected
    //     $mail->addAddress($dealership->brand_manager_email, $dealership->brand_manager);

    //     //Sends email to the Exec selected
    //     $mail->addAddress($exec->email, $exec->name);
    //     //$mail->addAddress($exec->email, $exec->name);

    //     //Content
    //     $mail->isHTML(true);
    //     $mail->send();                               // Set email format to HTML

    //     $mail->clearAddresses();
    //     $mail->clearAttachments();

    // }

    //Notifies Execs if Customer makes a Booking
    // function notifyBookedByExec($customer_id, $exec_id){
    //     //creates a new PHPMailer instance
    //     $mail = new PHPMailer();
    //     $exec = Exec::find($exec_id);
    //     $dealership = Dealership::where('code', $exec->dealership_code)->first();


    //     //Checks the email credetials
    //     phpMailer($mail);

    //     //Email Subject
    //     $mail->Subject =  $dealership->name . ' Booking Confirmation by Exec (' . $exec->name . ") - (" . date("d/m/Y") . ')';

    //     // HTML body function
    //     // Customer/Book ID needs to passed so the currect information displays on the template
    //     $body = htmlBodyByExec($customer_id, $exec->id);
    //     $mail->msgHTML($body);

    //     $mail->setFrom('noreply@swanswaygarages.com', "Events Booking System");

    //     //Query to to send emails to admin with notify-role role
    //     $admins   =  DB::table('admins')
    //                     ->join('admin_role', 'admin_role.admin_id', 'admins.id')
    //                     ->join('roles', 'roles.id', 'admin_role.role_id')
    //                     ->where('roles.name', 'super')
    //                     ->orWhere('roles.name', 'notify-booking')
    //                     ->get();

    //     //Loops through the Admins and sends the email notification
    //     foreach($admins as $admin){
    //         $mail->addAddress($admin->email, $admin->name);

    //         $mail->isHTML(true);                                  // Set email format to HTML
    //         $mail->send();
    //         $mail->clearAddresses();
    //         $mail->clearAttachments();
    //     }

    //     //Sends email to the Exec selected
    //     $mail->addAddress($dealership->brand_manager_email, $dealership->brand_manager);

    //     //$mail->addAddress($exec->email, $exec->name);

    //     //Content
    //     $mail->isHTML(true);
    //     $mail->send();                               // Set email format to HTML

    //     $mail->clearAddresses();
    //     $mail->clearAttachments();

    // }

    //Sends a booking confirmation to Customer/Prospect
    function notifyExecAppointment($appointment_id) {

        //creates a new PHPMailer instance
        // $mail               = new PHPMailer();
        $appointment = Appointment::find($appointment_id);
        $customer = Book::find($appointment->book_id);

        $dealership = Dealership::where('id', $appointment->dealership_id)->first();

        //Checks the email credetials

        $appointment = Appointment::find($appointment_id);
        $event = Event::find($appointment->event_id);
        $book = Book::find($appointment->book_id);
        $exec = Exec::find($appointment->exec_id);
        $time = EventTime::find($appointment->event_time_id);
        $dealership = Dealership::find($appointment->dealership_id);
        $config = SiteConfiguration::from_cache();

        //Email Subject
        $subject = $dealership->name . ' Booking Confirmation for ' .$exec->name . ' ' . $appointment->date;

        Mail::to($exec->email, $exec->name)
                ->queue(new NotifyExecAppointment(
                    $subject,
                    $appointment,
                    $event,
                    $book,
                    $exec,
                    $time,
                    $dealership,
                    $config
                ));

        //Sends Email to Brand manager
        Mail::to($dealership->brand_manager_email, $dealership->brand_manager)
                ->queue(new NotifyExecAppointment(
                    $subject,
                    $appointment,
                    $event,
                    $book,
                    $exec,
                    $time,
                    $dealership,
                    $config
                ));


        //Sends Email to Admins with notify-booking role
        $admins = Admin::join('admin_role', 'admin_role.admin_id', 'admins.id')
                        ->join('roles', 'roles.id', 'admin_role.role_id')
                        ->where('roles.name', 'super')
                        ->orWhere('roles.name', 'notify-booking')
                        ->groupBy('admins.name')
                        ->get();

        //Loops through the Admins and sends the email notification
        foreach($admins as $admin){
            Mail::to($admin->email, $admin->name)
            ->queue(new NotifyExecAppointment(
                $subject,
                $appointment,
                $event,
                $book,
                $exec,
                $time,
                $dealership,
                $config
            ));
        }


    }

    //Sends a booking confirmation to Customer/Prospect
    function notifyBook($appointment_id){


        //creates a new PHPMailer instance
        // $mail               = new PHPMailer();
        $appointment = Appointment::find($appointment_id);
        $customer = Book::find($appointment->book_id);

        $dealership = Dealership::where('id', $appointment->dealership_id)->first();

        //Email Subject
        $subject =  'Your Booking Confirmation ';

        $appointment = Appointment::find($appointment_id);
        $event = Event::find($appointment->event_id);
        $book = Book::find($appointment->book_id);
        $exec = Exec::find($appointment->exec_id);
        $time = EventTime::find($appointment->event_time_id);
        $dealership = Dealership::find($appointment->dealership_id);
        $config = SiteConfiguration::from_cache();

        Mail::to($customer->email, $customer->name . " ". $customer->surname)
                ->queue(new ProspectAppointmentConfirmation(
                    $subject,
                    $appointment,
                    $event,
                    $book,
                    $exec,
                    $time,
                    $dealership,
                    $config
                ));

        // Mail::to($customer->email, $customer->name . " ". $customer->surname)
        //         ->queue(new ProspectAppointmentConfirmation(
        //             $subject,
        //             $appointment,
        //             $event,
        //             $book,
        //             $exec,
        //             $time,
        //             $dealership,
        //             $config
        //         ));


    }

    //Sends CRM Team Notification if Customer/prospect makes changes
    function notifyCRM($customer_id){
        //creates a new PHPMailer instance
        $mail = new PHPMailer();
        $customer = Book::find($customer_id);

        //Checks the email credetials
        phpMailer($mail);

        //Email Subject
        $mail->Subject =  'Customer updated details on Event Booking System ';

        // HTML body function (Located at Helpers/Helper.php)
        // Customer/Book ID needs to passed so the currect information displays on the template
        $body = htmlBodyCRM($customer->id);
        $mail->msgHTML($body);

        //$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

        $mail->setFrom('noreply@swanswaygarages.com', " Customer Details Updated");

        //Query to to send emails to admin with notify-role role
        $admins   =  DB::table('admins')
                        ->join('admin_role', 'admin_role.admin_id', 'admins.id')
                        ->join('roles', 'roles.id', 'admin_role.role_id')
                        ->where('roles.name', 'crm-team')
                        ->get();

        //Loops through the Admins and sends the email notification
        foreach($admins as $admin){
            $mail->addAddress($admin->email, $admin->name);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
        }

    }

    //Notifies Admins
    function notifyAdmin($appointment_id){
        //creates a new PHPMailer instance
        $mail = new PHPMailer();

        $appointment = Appointment::find($appointment_id);
        $dealership = Dealership::where('id', $appointment->dealership_id)->first();
        $admin_brand_managers = DB::table('admins')
                                ->select('admins.*')
                                ->join('admin_dealership', 'admin_dealership.admin_id', 'admins.id')
                                ->join('admin_role', 'admin_role.admin_id', 'admins.id')
                                ->join('roles', 'roles.id', 'admin_role.role_id')
                                ->where('admin_dealership.dealership_id', $dealership->id)
                                ->where('roles.name', 'brand-manager')
                                ->get();

        //Checks the email credetials
        phpMailer($mail);

        //Email Subject
        $mail->Subject =  'Booking Confirmation (' . date("d/m/Y") . ')';

        // HTML body function
        // Customer/Book ID needs to passed so the currect information displays on the template
        $body = htmlBodyAdmin($appointment->id);
        $mail->msgHTML($body);

        $mail->setFrom('noreply@swanswaygarages.com', "Events Booking System");

        //Query to to send emails to admin with notify-role role
        $admins   =  DB::table('admins')
                        ->join('admin_role', 'admin_role.admin_id', 'admins.id')
                        ->join('roles', 'roles.id', 'admin_role.role_id')
                        ->where('roles.name', 'super')
                        ->orWhere('roles.name', 'super-admin')
                        ->get();

        //Loops through the Admins and sends the email notification
        foreach($admins as $admin){
            $mail->addAddress($admin->email,  $admin->name);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
        }

        //Sends an email to the Admin with brand manager role
        foreach($admin_brand_managers as $manager){
            $mail->addAddress($manager->email, $manager->name);
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->send();
            $mail->clearAddresses();
            $mail->clearAttachments();
        }

        //Sends an email to the brand manager set on the dealership
        $mail->addAddress($dealership->brand_manager_email, $dealership->brand_manager);

        $mail->isHTML(true);
        $mail->send();                               // Set email format to HTML

        $mail->clearAddresses();
        $mail->clearAttachments();

    }

    //###########################################################
    //HTML email Body Templates
    //###########################################################

    //HTML Body sent to the Exec
    function htmlBodyExec($customer_id, $exec_id){
        $config         =   SiteConfiguration::from_cache();
        $book           =   Book::find($customer_id);
        $exec           =   Exec::find($exec_id);
        $appointment    =   Appointment::where('book_id', $book->id)->first();
        $event          =   Event::find($appointment->event_id);
        $time           =   EventTime::find($appointment->event_time_id);
        $dealership     =   Dealership::find($appointment->dealership_id);

        return view('admin.email-templates.exec-booking-confirmation')
                    ->with('book', $book)
                    ->with('appointment', $appointment)
                    ->with('exec', $exec)
                    ->with('time', $time)
                    ->with('event', $event)
                    ->with('dealership', $dealership)
                    ->with('config', $config);

    }

    //HTML Body sent to the Exec
    function htmlBodyByExec($customer_id, $exec_id){
        $config         =   SiteConfiguration::from_cache();
        $book           =   Book::find($customer_id);
        $exec           =   Exec::find($exec_id);
        $appointment    =   Appointment::where('book_id', $book->id)->first();
        $event          =   Event::find($appointment->event_id);
        $time           =   EventTime::find($appointment->event_time_id);
        $dealership     =   Dealership::find($appointment->dealership_id);

        return view('admin.email-templates.booking-by-exec')
                    ->with('book', $book)
                    ->with('appointment', $appointment)
                    ->with('time', $time)
                    ->with('exec', $exec)
                    ->with('event', $event)
                    ->with('dealership', $dealership)
                    ->with('config', $config);

    }

    //HTML Body For the Prospect
    function htmlBodyBook($appointment_id){
        $config = SiteConfiguration::from_cache();
        $appointment = Appointment::find($appointment_id);
        $event = Event::find($appointment->event_id);
        $book = Book::find($appointment->book_id);
        $exec = Exec::find($appointment->exec_id);
        $time = EventTime::find($appointment->event_time_id);
        $dealership = Dealership::find($appointment->dealership_id);

        return view('admin.email-templates.customer-booking-confirmation')
                    ->with('book', $book)
                    ->with('exec', $exec)
                    ->with('time', $time)
                    ->with('event', $event)
                    ->with('appointment', $appointment)
                    ->with('dealership', $dealership)
                    ->with('config', $config);

    }



    //HTML Body For the Exec
    function htmlBodyAdmin($appointment_id){
        $config         =   SiteConfiguration::from_cache();
        $appointment    =   Appointment::find($appointment_id);
        $event          =   Event::find($appointment->event_id);
        $exec           =   Exec::find($appointment->exec_id);
        $book           =   Book::find($appointment->book_id);
        $time           =   EventTime::find($appointment->event_time_id);
        $dealership     =   Dealership::find($appointment->dealership_id);

        return view('admin.email-templates.admin-body')
                    ->with('book', $book)
                    ->with('time', $time)
                    ->with('exec', $exec)
                    ->with('event', $event)
                    ->with('appointment', $appointment)
                    ->with('dealership', $dealership)
                    ->with('config', $config);

    }

    //HTML Body For the Exec
    function htmlBodyCRM($customer_id){
        $config         =   SiteConfiguration::from_cache();
        $customer       =   Book::find($customer_id);

        return view('admin.email-templates.customer-details-updated')
                    ->with('customer', $customer)
                    ->with('config', $config);

    }

    //###########################################################
    //phpmailer settings
    //###########################################################
    function phpMailer($mail){
        //return env('MAIL_HOST') . " - " . env('MAIL_USERNAME') . " - " . env('MAIL_PASSWORD') . " - " . env('MAIL_ENCRYPTION') . " - " . env('MAIL_PORT');
        //Server settings
        $mail->SMTPDebug    = 0;                        // Enable verbose debug output
        $mail->isSMTP();                                // Set mailer to use SMTP
        $mail->Host         = env('MAIL_HOST');         // Specify main and backup SMTP servers
        $mail->SMTPAuth     = true;                     // Enable SMTP authentication
        $mail->Username     = env('MAIL_USERNAME');     // SMTP username
        $mail->Password     = env('MAIL_PASSWORD');     // SMTP password
        $mail->SMTPSecure   = env('MAIL_ENCRYPTION');   // 'tls'; // Enable TLS encryption, `ssl` also accepted
        $mail->Port         = env('MAIL_PORT');         //

    }
