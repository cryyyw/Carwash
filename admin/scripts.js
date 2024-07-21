document.addEventListener("DOMContentLoaded", function() {
    loadBookings();
    loadServices();
    loadReports();

    document.getElementById('add-booking-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const customerName = document.getElementById('customer-name').value;
        const service = document.getElementById('service').value;
        const date = document.getElementById('date').value;
        const status = document.getElementById('status').value;

        fetch('api/bookings.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ customer_name: customerName, service, date, status })
        }).then(response => response.json())
        .then(data => {
            alert(data.message);
            loadBookings();
        });
    });

    document.getElementById('add-service-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const serviceName = document.getElementById('service-name').value;
        const price = document.getElementById('price').value;

        fetch('api/services.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ service_name: serviceName, price })
        }).then(response => response.json())
        .then(data => {
            alert(data.message);
            loadServices();
        });
    });
});

function loadBookings() {
    fetch('api/bookings.php')
    .then(response => response.json())
    .then(data => {
        const bookingsTable = document.getElementById('recent-bookings');
        bookingsTable.innerHTML = '';
        data.forEach((booking, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${booking.customer_name}</td>
                <td>${booking.service}</td>
                <td>${booking.date}</td>
                <td>${booking.status}</td>
                <td><button class="btn btn-danger btn-sm" onclick="deleteBooking(${booking.id})">Delete</button></td>
            `;
            bookingsTable.appendChild(row);
        });
    });
}

function loadServices() {
    fetch('api/services.php')
    .then(response => response.json())
    .then(data => {
        const serviceList = document.getElementById('service-list');
        const serviceDropdown = document.getElementById('service');
        serviceList.innerHTML = '';
        serviceDropdown.innerHTML = '';
        data.forEach((service, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${service.service_name}</td>
                <td>$${service.price}</td>
                <td><button class="btn btn-danger btn-sm" onclick="deleteService(${service.id})">Delete</button></td>
            `;
            serviceList.appendChild(row);

            const option = document.createElement('option');
            option.value = service.service_name;
            option.innerText = service.service_name;
            serviceDropdown.appendChild(option);
        });
    });
}

function loadReports() {
    fetch('api/bookings.php')
    .then(response => response.json())
    .then(bookings => {
        fetch('api/services.php')
        .then(response => response.json())
        .then(services => {
            const totalRevenue = bookings.reduce((total, booking) => {
                const service = services.find(s => s.service_name === booking.service);
                return total + (service ? parseFloat(service.price) : 0);
            }, 0);

            const reportsDiv = document.getElementById('reports');
            reportsDiv.innerHTML = `
                <h5>Total Revenue: $${totalRevenue}</h5>
                <h5>Total Bookings: ${bookings.length}</h5>
                <h5>Total Customers: ${new Set(bookings.map(b => b.customer_name)).size}</h5>
                <h5>Total Services: ${services.length}</h5>
            `;
        });
    });
}

function deleteBooking(id) {
    fetch(`api/bookings.php?id=${id}`, { method: 'DELETE' })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadBookings();
    });
}

function deleteService(id) {
    fetch(`api/services.php?id=${id}`, { method: 'DELETE' })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadServices();
    });
}
