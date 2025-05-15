document.addEventListener('DOMContentLoaded', function() {
    // Package selection
    const packageButtons = document.querySelectorAll('.package-btn');
    const packageInput = document.getElementById('selected_package');

    packageButtons.forEach(button => {
        button.addEventListener('click', function() {
            packageButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            packageInput.value = this.dataset.package;
        });
    });

    // Date selection
    const monthSelect = document.getElementById('month');
    const dateGrid = document.querySelector('.date-grid');
    const dateInput = document.getElementById('selected_date');

    function generateCalendar(month) {
        const year = new Date().getFullYear();
        const today = new Date();
        const firstDay = new Date(year, month - 1, 1);
        const lastDay = new Date(year, month, 0);
        const daysInMonth = lastDay.getDate();
        
        const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        let calendarHtml = '';
        
        for (let i = 1; i <= daysInMonth; i++) {
            const currentDate = new Date(year, month - 1, i);
            if (
                currentDate.getFullYear() > today.getFullYear() ||
                (currentDate.getFullYear() === today.getFullYear() && currentDate.getMonth() > today.getMonth()) ||
                (currentDate.getFullYear() === today.getFullYear() && currentDate.getMonth() === today.getMonth() && i >= today.getDate())
            ) {
                const dayName = dayNames[currentDate.getDay()];
                calendarHtml += `<button type="button" class="date-btn" data-date="${i}">
                    <span class="date">${i}</span>
                    <span class="day">${dayName}</span>
                </button>`;
            }
        }
        
        return calendarHtml;
    }

    // Set current month as default
    const currentMonth = new Date().getMonth() + 1;
    monthSelect.value = currentMonth;
    dateGrid.innerHTML = generateCalendar(currentMonth);

    monthSelect.addEventListener('change', function() {
        const selectedMonth = this.value;
        if (selectedMonth) {
            dateGrid.innerHTML = generateCalendar(selectedMonth);
            dateInput.value = '';
            attachDateButtonEvents();
        }
    });

    function attachDateButtonEvents() {
        const dateButtons = document.querySelectorAll('.date-btn');
        dateButtons.forEach(button => {
            button.addEventListener('click', function() {
                dateButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                const selectedDay = this.dataset.date;
                const selectedMonth = monthSelect.value;
                const selectedYear = new Date().getFullYear();
                dateInput.value = `${selectedYear}-${String(selectedMonth).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;
            });
        });
    }

    attachDateButtonEvents();
});


document.addEventListener('DOMContentLoaded', function() {
    const paymentRadios = document.querySelectorAll('input[name="paymentMethod"]');
    const paymentResult = document.getElementById('paymentResult');
    const cashResult = document.getElementById('cashResult');
    const qrisResult = document.getElementById('qrisResult');
    const bankTransferResult = document.getElementById('bankTransferResult');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            paymentResult.style.display = 'block';
            cashResult.style.display = 'none';
            qrisResult.style.display = 'none';
            bankTransferResult.style.display = 'none';

            if (this.value === 'cash') {
                cashResult.style.display = 'block';
            } else if (this.value === 'qris') {
                qrisResult.style.display = 'block';
            } else if (this.value === 'bankTransfer') {
                bankTransferResult.style.display = 'block';
            }
        });
    });
});