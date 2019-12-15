<h3>Dear <?php echo $booking->mentor->firstname ?> <?php echo $booking->mentor->lastname ?></h3>
<p>Additional information for your new booking request</p>
<br />
<p>Program: <?php echo $booking->program->name ?></p>
<p>Mentee: <?php echo $booking->mentee->firstname ?> <?php echo $booking->mentee->lastname ?> (Email: <?php echo $booking->mentee->email ?> | Phone Number: <?php echo $booking->mentee->phone_no ?>)</p>
<p>Date: <?php echo date('D, Y-M-d', strtotime($booking->booking_time)) ?></p>
<p>Start Time: <?php echo date('h:i a', strtotime($booking->booking_time)) ?></p>
<p>Duration: <?php echo $booking->length ?> mins</p>
<p>Timezone: <?php echo date('T', strtotime($booking->booking_time)) ?></p>
<p>Mode of Communication: <?php echo ucwords(str_replace(array('-', '_'), ' ', $booking->session_method)) ?> - <?php echo $booking->renderContactInfo() ?></p>
<br />
<?php if(!empty($enquiry) || !empty($companyName)): ?>
<p>From Startup/Company: <?php echo $companyName ?></p>
<p>Enquiry: <?php echo nl2br($enquiry) ?></p>
<br />
<?php endif; ?>
<br />
<p>This booking has been automatically accepted on behalf of you. If you CANNOT make it, please go to Futurelab and cancel it.</p>
<b>The booking request can be found in your mentor dashboard under "bookings":</b>
<br />
<a href="<?php echo $urlManage ?>">View My Bookings</a>