<?php
/**
 * Template part for displaying the live availability calendar
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<section class="live-calendar-section">
    <div class="container live-calendar-container">
        <div class="calendar-header">
            <h2 class="section-title">Live Booking Calendar</h2>
            <p class="calendar-subtitle">Schedule your dog's training session with our real-time availability</p>
        </div>

        <div class="calendar-grid">
            <!-- Calendar Side -->
            <div class="calendar-wrapper">
                <div class="calendar-nav">
                    <button class="calendar-arrow" id="prevMonth">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="calendar-month" id="currentMonth">August 2023</div>
                    <button class="calendar-arrow" id="nextMonth">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="calendar-days">
                    <div class="calendar-day-header">Sun</div>
                    <div class="calendar-day-header">Mon</div>
                    <div class="calendar-day-header">Tue</div>
                    <div class="calendar-day-header">Wed</div>
                    <div class="calendar-day-header">Thu</div>
                    <div class="calendar-day-header">Fri</div>
                    <div class="calendar-day-header">Sat</div>
                </div>

                <div class="calendar-dates" id="calendarDates">
                    <!-- Calendar dates will be dynamically generated -->
                </div>
            </div>

            <!-- Time Slots Side -->
            <div class="time-slots-container">
                <div class="time-slots-header">
                    <h3 class="time-slots-title">Available Times</h3>
                    <div class="selected-date" id="selectedDate">Select a date</div>
                </div>
                
                <div id="noDateSelected" class="time-slots-message">
                    <p>Please select a date on the calendar to view available time slots.</p>
                </div>
                
                <div id="timeSlotsList" style="display: none;">
                    <div class="time-slots-grid" id="timeSlotsGrid">
                        <!-- Time slots will be dynamically generated -->
                    </div>
                    
                    <div class="popular-times">
                        <h4 class="popular-times-title">Popular Times</h4>
                        <div class="popular-times-bar">
                            <div class="time-bar" style="height: 30%;">
                                <div class="time-bar-label">9am</div>
                                <div class="time-bar-tooltip">30% Booked</div>
                            </div>
                            <div class="time-bar" style="height: 50%;">
                                <div class="time-bar-label">10am</div>
                                <div class="time-bar-tooltip">50% Booked</div>
                            </div>
                            <div class="time-bar" style="height: 80%;">
                                <div class="time-bar-label">11am</div>
                                <div class="time-bar-tooltip">80% Booked</div>
                            </div>
                            <div class="time-bar" style="height: 90%;">
                                <div class="time-bar-label">12pm</div>
                                <div class="time-bar-tooltip">90% Booked</div>
                            </div>
                            <div class="time-bar" style="height: 70%;">
                                <div class="time-bar-label">1pm</div>
                                <div class="time-bar-tooltip">70% Booked</div>
                            </div>
                            <div class="time-bar" style="height: 60%;">
                                <div class="time-bar-label">2pm</div>
                                <div class="time-bar-tooltip">60% Booked</div>
                            </div>
                            <div class="time-bar" style="height: 85%;">
                                <div class="time-bar-label">3pm</div>
                                <div class="time-bar-tooltip">85% Booked</div>
                            </div>
                            <div class="time-bar" style="height: 40%;">
                                <div class="time-bar-label">4pm</div>
                                <div class="time-bar-tooltip">40% Booked</div>
                            </div>
                        </div>
                        <div class="popular-times-legend">
                            <span>Less busy</span>
                            <span>More busy</span>
                        </div>
                    </div>
                </div>
                
                <div id="bookingForm" class="booking-form" style="display: none;">
                    <h4 class="booking-form-title">Complete Your Booking</h4>
                    
                    <div class="form-group">
                        <label for="appointmentType">Appointment Type</label>
                        <select id="appointmentType">
                            <option value="initial">Initial Consultation (Free)</option>
                            <option value="private">Private Training Session</option>
                            <option value="evaluation">Behavior Evaluation</option>
                            <option value="followup">Follow-Up Session</option>
                        </select>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="clientName">Your Name</label>
                            <input type="text" id="clientName">
                        </div>
                        <div class="form-group">
                            <label for="clientEmail">Email Address</label>
                            <input type="email" id="clientEmail">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="clientPhone">Phone Number</label>
                            <input type="tel" id="clientPhone">
                        </div>
                        <div class="form-group">
                            <label for="dogName">Dog's Name</label>
                            <input type="text" id="dogName">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bookingNotes">Additional Notes</label>
                        <textarea id="bookingNotes" rows="3" placeholder="Tell us about your dog and what you're looking to accomplish..."></textarea>
                    </div>
                    
                    <div class="form-submit">
                        <button type="button" class="book-button" id="confirmBookingBtn">Confirm Booking</button>
                    </div>
                </div>
                
                <div class="booking-confirmation" id="bookingConfirmation">
                    <div class="confirmation-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3 class="confirmation-title">Booking Confirmed!</h3>
                    <p>Your appointment has been successfully scheduled. We've sent a confirmation email with all the details.</p>
                    
                    <div class="confirmation-details">
                        <div class="confirmation-detail">
                            <div class="detail-label">Date:</div>
                            <div class="detail-value" id="confirmDate">August 15, 2023</div>
                        </div>
                        <div class="confirmation-detail">
                            <div class="detail-label">Time:</div>
                            <div class="detail-value" id="confirmTime">2:00 PM</div>
                        </div>
                        <div class="confirmation-detail">
                            <div class="detail-label">Type:</div>
                            <div class="detail-value" id="confirmType">Initial Consultation</div>
                        </div>
                        <div class="confirmation-detail">
                            <div class="detail-label">Location:</div>
                            <div class="detail-value">Good Dogz KC Training Center</div>
                        </div>
                    </div>
                    
                    <div class="add-to-calendar">
                        <p>Add to your calendar:</p>
                        <div class="calendar-buttons">
                            <button class="calendar-button">
                                <i class="fab fa-google"></i> Google
                            </button>
                            <button class="calendar-button">
                                <i class="far fa-calendar-alt"></i> Apple
                            </button>
                            <button class="calendar-button">
                                <i class="fab fa-microsoft"></i> Outlook
                            </button>
                        </div>
                    </div>
                    
                    <div class="confirmation-actions">
                        <button class="book-button" id="newBookingBtn">Book Another Appointment</button>
                        <div class="reschedule-button" id="rescheduleBtn">Need to reschedule?</div>
                    </div>
                </div>
                
                <!-- Loading overlay -->
                <div class="booking-loader" id="bookingLoader">
                    <div class="loading-spinner"></div>
                </div>
            </div>
        </div>
        
        <div class="calendar-note">
            * Initial consultations are free and last approximately 30 minutes. We'll discuss your dog's needs and recommend the best training program.
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Calendar functionality
    const currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let selectedDate = null;
    let selectedTimeSlot = null;
    
    // Update calendar with current month
    updateCalendar(currentMonth, currentYear);
    
    // Previous month button
    $('#prevMonth').on('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar(currentMonth, currentYear);
    });
    
    // Next month button
    $('#nextMonth').on('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar(currentMonth, currentYear);
    });
    
    // Function to update calendar
    function updateCalendar(month, year) {
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Update month name
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $('#currentMonth').text(monthNames[month] + ' ' + year);
        
        // Clear calendar
        $('#calendarDates').empty();
        
        // Add empty cells for days before first day of month
        for (let i = 0; i < firstDay; i++) {
            $('#calendarDates').append('<div class="calendar-date disabled"></div>');
        }
        
        // Add days of month
        const today = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            
            // Check if this date is before today
            const isPastDate = date < new Date(today.getFullYear(), today.getMonth(), today.getDate());
            
            // Randomly determine availability for demo purposes
            const rand = Math.random();
            let availability = '';
            let availabilityClass = '';
            
            if (!isPastDate) {
                if (rand < 0.2) {
                    availability = '<div class="date-availability no-slots">Full</div>';
                    availabilityClass = 'disabled';
                } else if (rand < 0.5) {
                    availability = '<div class="date-availability limited-slots">Few slots</div>';
                } else {
                    availability = '<div class="date-availability available-slots">Available</div>';
                }
            }
            
            // Determine if this is today
            const isToday = date.getDate() === today.getDate() && 
                            date.getMonth() === today.getMonth() && 
                            date.getFullYear() === today.getFullYear();
            
            const todayClass = isToday ? 'today' : '';
            const disabledClass = isPastDate ? 'disabled' : availabilityClass;
            
            $('#calendarDates').append(`
                <div class="calendar-date ${todayClass} ${disabledClass}" data-date="${year}-${month+1}-${day}">
                    <span class="date-number">${day}</span>
                    ${availability}
                </div>
            `);
        }
        
        // Add click event to calendar dates
        $('.calendar-date:not(.disabled)').on('click', function() {
            // Remove selected class from all dates
            $('.calendar-date').removeClass('selected');
            
            // Add selected class to clicked date
            $(this).addClass('selected');
            
            // Get selected date
            const dateStr = $(this).data('date');
            const [year, month, day] = dateStr.split('-');
            selectedDate = new Date(year, month-1, day);
            
            // Update selected date display
            const formattedDate = selectedDate.toLocaleDateString('en-US', { 
                weekday: 'long', 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric' 
            });
            $('#selectedDate').text(formattedDate);
            
            // Show time slots
            showTimeSlots();
        });
    }
    
    // Function to show time slots for selected date
    function showTimeSlots() {
        // Hide no date selected message
        $('#noDateSelected').hide();
        
        // Show time slots list
        $('#timeSlotsList').show();
        
        // Hide booking form
        $('#bookingForm').hide();
        
        // Hide booking confirmation
        $('#bookingConfirmation').hide();
        
        // Generate time slots (for demo purposes)
        $('#timeSlotsGrid').empty();
        
        // Generate random time slots between 9am and 5pm
        const timeSlots = [];
        const startHour = 9;
        const endHour = 17;
        
        for (let hour = startHour; hour < endHour; hour++) {
            // Add :00 slot
            if (Math.random() > 0.3) {
                timeSlots.push({
                    hour: hour,
                    minute: 0,
                    available: Math.random() > 0.2
                });
            }
            
            // Add :30 slot
            if (Math.random() > 0.3) {
                timeSlots.push({
                    hour: hour,
                    minute: 30,
                    available: Math.random() > 0.2
                });
            }
        }
        
        // Sort time slots
        timeSlots.sort((a, b) => {
            if (a.hour !== b.hour) return a.hour - b.hour;
            return a.minute - b.minute;
        });
        
        // Add time slots to grid
        timeSlots.forEach(slot => {
            const hour12 = slot.hour > 12 ? slot.hour - 12 : slot.hour;
            const ampm = slot.hour >= 12 ? 'PM' : 'AM';
            const minute = slot.minute === 0 ? '00' : '30';
            const timeStr = `${hour12}:${minute} ${ampm}`;
            
            const unavailableClass = !slot.available ? 'unavailable' : '';
            
            $('#timeSlotsGrid').append(`
                <div class="time-slot ${unavailableClass}" data-time="${slot.hour}:${minute}">
                    <div class="slot-time">${timeStr}</div>
                    <div class="slot-availability">${slot.available ? '30 min session' : 'Unavailable'}</div>
                </div>
            `);
        });
        
        // Add click event to time slots
        $('.time-slot:not(.unavailable)').on('click', function() {
            // Remove selected class from all time slots
            $('.time-slot').removeClass('selected');
            
            // Add selected class to clicked time slot
            $(this).addClass('selected');
            
            // Get selected time
            selectedTimeSlot = $(this).data('time');
            
            // Show booking form
            $('#timeSlotsList').hide();
            $('#bookingForm').show();
        });
    }
    
    // Confirm booking button
    $('#confirmBookingBtn').on('click', function() {
        // Show loading overlay
        $('#bookingLoader').addClass('active');
        
        // In a real implementation, this would send the booking data to the server
        // For demo purposes, we'll just simulate a delay
        setTimeout(function() {
            // Hide loading overlay
            $('#bookingLoader').removeClass('active');
            
            // Hide booking form
            $('#bookingForm').hide();
            
            // Update confirmation details
            const formattedDate = selectedDate.toLocaleDateString('en-US', { 
                weekday: 'long', 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric' 
            });
            $('#confirmDate').text(formattedDate);
            
            // Format time for display
            const [hour, minute] = selectedTimeSlot.split(':');
            const hour12 = hour > 12 ? hour - 12 : hour;
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const timeStr = `${hour12}:${minute} ${ampm}`;
            $('#confirmTime').text(timeStr);
            
            // Get appointment type
            const appointmentType = $('#appointmentType option:selected').text();
            $('#confirmType').text(appointmentType);
            
            // Show booking confirmation
            $('#bookingConfirmation').show();
        }, 1500);
    });
    
    // New booking button
    $('#newBookingBtn').on('click', function() {
        // Reset selection
        $('.calendar-date').removeClass('selected');
        selectedDate = null;
        selectedTimeSlot = null;
        
        // Hide booking confirmation
        $('#bookingConfirmation').hide();
        
        // Show no date selected message
        $('#noDateSelected').show();
        $('#selectedDate').text('Select a date');
    });
    
    // Reschedule button
    $('#rescheduleBtn').on('click', function() {
        // Hide booking confirmation
        $('#bookingConfirmation').hide();
        
        // Show time slots (keeps the same date selected)
        showTimeSlots();
    });
});
</script>