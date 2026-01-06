<?php
require '../db.php';

// Set headers to download as CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename=booking_data.csv');

// Open output stream
$output = fopen('php://output', 'w');

// Write column headers
fputcsv($output, [
    'Full Name', 'Email', 'Phone', 'Staff ID',
    'Lecture Title', 'Date of PFQ', 'School/Department', 'Booking Date'
]);

// Get all bookings
$query = "
    SELECT s.full_name, s.email, s.phone, s.staff_id, 
           b.lecture_title, b.pfq_date, b.school, b.booking_date
    FROM bookings b
    JOIN staff_users s ON b.staff_id = s.staff_id
    ORDER BY b.created_at DESC
";
$result = $mysqli->query($query);

// Write rows
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
