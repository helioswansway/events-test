<?php

    use App\Models\SiteConfiguration;
    use App\Models\Dealership;
    use App\Models\Appointment;
    use App\Models\Event;
    use App\Models\EventTime;
    use Illuminate\Support\Facades\Mail;

    use App\Book;
    use App\Exec;
    use App\Mail\ProspectAppointmentConfirmation;
    use App\Mail\NotifyExecAppointment;
    use App\Models\Admin;

        //Sends a booking confirmation to Customer/Prospect
    function emailExecAppointment($appointment_id) {

        //creates a new PHPMailer instance
        // $mail               = new PHPMailer();
        $appointment = Appointment::find($appointment_id);

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

        // Sends email to Exec
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

        // Sends Email to Brand manager
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
    function emailProspect($appointment_id){


        //creates a new PHPMailer instance
        // $mail               = new PHPMailer();
        $appointment = Appointment::find($appointment_id);

        $dealership = Dealership::where('id', $appointment->dealership_id)->first();

        //Email Subject
        $subject =  'Your Booking Confirmation ';

        $event = Event::find($appointment->event_id);
        $book = Book::find($appointment->book_id);
        $exec = Exec::find($appointment->exec_id);
        $time = EventTime::find($appointment->event_time_id);
        $dealership = Dealership::find($appointment->dealership_id);
        $config = SiteConfiguration::from_cache();

        // Only sends email confirmation to prospect if send_confirmation_email set to 1
        if($event->send_confirmation_email == 1){

            Mail::to($book->email, $book->name . " ". $book->surname)
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

        }


    }

    function emailAdmins($appointment_id) {

        //creates a new PHPMailer instance
        // $mail               = new PHPMailer();
        $appointment = Appointment::find($appointment_id);

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
        $subject =  'Event Booking Confirmation (' . date("d/m/Y") . ')';

        // Sends Email to Brand manager
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

