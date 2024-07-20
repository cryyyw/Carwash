document.addEventListener("DOMContentLoaded", function() {
    // Sample data
    const bookings = [
        {customer: 'John Doe', service: 'Full Wash', date: '2024-07-20', status: 'Completed'},
        {customer: 'Jane Smith', service: 'Interior Cleaning', date: '2024-07-19', status: 'Pending'},
        {customer: 'Michael Brown', service: 'Exterior Wash', date: '2024-07-18', status: 'Completed'}
    ];

    const notifications = [
        'New booking received from John Doe.',
        'Booking for Jane Smith has been updated to pending status.',
        'System maintenance scheduled for July 25th.'
    ];

    // Populate bookings
    const bookingsTable = document.getElementById('recent-bookings');
    bookings.forEach(booking => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${booking.customer}</td>
            <td>${booking.service}</td>
            <td>${booking.date}</td>
            <td>${booking.status}</td>
        `;
        bookingsTable.appendChild(row);
    });

    // Populate notifications
    const notificationsDiv = document.getElementById('notifications');
    notifications.forEach(notification => {
        const alert = document.createElement('div');
        alert.className = 'alert alert-info';
        alert.innerText = notification;
        notificationsDiv.appendChild(alert);
    });
});
