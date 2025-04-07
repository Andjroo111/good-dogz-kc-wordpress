<?php
/**
 * Template part for displaying the training progress tracker
 *
 * @package Good_Dogz_KC
 * @subpackage Twenty_Twenty_Four_Child
 * @since 1.0.0
 */
?>

<section class="training-progress-section">
    <div class="container training-progress-container">
        <div class="progress-header">
            <h2 class="section-title">Training Progress Tracker</h2>
            <p class="progress-subtitle">Monitor your dog's training journey and celebrate achievements</p>
        </div>

        <div class="progress-tabs">
            <button class="progress-tab active" data-tab="dashboard">Dashboard</button>
            <button class="progress-tab" data-tab="milestones">Training Milestones</button>
            <button class="progress-tab" data-tab="tasks">Training Tasks</button>
            <button class="progress-tab" data-tab="logs">Training Logs</button>
            <div class="progress-tab-indicator"></div>
        </div>

        <!-- Dashboard Tab -->
        <div class="progress-content active" data-tab="dashboard">
            <div class="dashboard-grid">
                <div class="progress-chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Training Progress</h3>
                        <div class="chart-filters">
                            <button class="chart-filter active" data-period="week">Week</button>
                            <button class="chart-filter" data-period="month">Month</button>
                            <button class="chart-filter" data-period="all">All</button>
                        </div>
                    </div>
                    <div class="chart-wrapper">
                        <div class="chart-placeholder">
                            Interactive progress chart will display here when you start tracking your dog's training
                        </div>
                    </div>
                </div>

                <div class="metrics-card">
                    <h3 class="metrics-title">Training Metrics</h3>
                    <div class="metrics-grid">
                        <div class="metric-item">
                            <div class="metric-value">7</div>
                            <div class="metric-label">Training Sessions</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">14</div>
                            <div class="metric-label">Hours Trained</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">5</div>
                            <div class="metric-label">Skills Mastered</div>
                        </div>
                        <div class="metric-item">
                            <div class="metric-value">68%</div>
                            <div class="metric-label">Program Complete</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tasks-container">
                <div class="tasks-header">
                    <h3 class="tasks-title">Upcoming Training Tasks</h3>
                </div>
                <ul class="task-list">
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task1">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Practice "Stay" Command</div>
                            <div class="task-description">Work on increasing duration to 2 minutes with moderate distractions</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Today</div>
                            <div class="task-priority priority-high">High Priority</div>
                        </div>
                    </li>
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task2">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Leash Walking Practice</div>
                            <div class="task-description">10-minute sessions focusing on loose leash walking</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Tomorrow</div>
                            <div class="task-priority priority-medium">Medium Priority</div>
                        </div>
                    </li>
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task3">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Review Training Video</div>
                            <div class="task-description">Watch and implement techniques from last session's video</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Aug 15</div>
                            <div class="task-priority priority-low">Low Priority</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Milestones Tab -->
        <div class="progress-content" data-tab="milestones">
            <div class="milestone-container">
                <div class="milestone-header">
                    <h3 class="milestone-title">Training Journey</h3>
                </div>
                <div class="milestone-list">
                    <div class="milestone-timeline"></div>
                    
                    <div class="milestone-item">
                        <div class="milestone-marker completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="milestone-card">
                            <h4 class="milestone-name">Phase 1: Foundation Skills</h4>
                            <div class="milestone-date">Completed on July 15, 2023</div>
                            <p>Basic commands and attention training for everyday situations</p>
                            <div class="milestone-progress">
                                <div class="milestone-progress-bar">
                                    <div class="milestone-progress-indicator" style="width: 100%"></div>
                                </div>
                                <div class="milestone-progress-text">
                                    <span>0%</span>
                                    <span>100%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="milestone-item">
                        <div class="milestone-marker completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="milestone-card">
                            <h4 class="milestone-name">Phase 2: Intermediate Training</h4>
                            <div class="milestone-date">Completed on July 29, 2023</div>
                            <p>Advanced commands and beginning leash manners in various environments</p>
                            <div class="milestone-progress">
                                <div class="milestone-progress-bar">
                                    <div class="milestone-progress-indicator" style="width: 100%"></div>
                                </div>
                                <div class="milestone-progress-text">
                                    <span>0%</span>
                                    <span>100%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="milestone-item">
                        <div class="milestone-marker">
                            <span>3</span>
                        </div>
                        <div class="milestone-card">
                            <h4 class="milestone-name">Phase 3: Advanced Training</h4>
                            <div class="milestone-date">In Progress (Due August 20, 2023)</div>
                            <p>Off-leash reliability and behavior in high-distraction environments</p>
                            <div class="milestone-progress">
                                <div class="milestone-progress-bar">
                                    <div class="milestone-progress-indicator" style="width: 65%"></div>
                                </div>
                                <div class="milestone-progress-text">
                                    <span>0%</span>
                                    <span>65% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="milestone-item">
                        <div class="milestone-marker">
                            <span>4</span>
                        </div>
                        <div class="milestone-card">
                            <h4 class="milestone-name">Phase 4: Real-World Application</h4>
                            <div class="milestone-date">Coming Soon</div>
                            <p>Applying all learned skills in various real-world scenarios and environments</p>
                            <div class="milestone-progress">
                                <div class="milestone-progress-bar">
                                    <div class="milestone-progress-indicator" style="width: 0%"></div>
                                </div>
                                <div class="milestone-progress-text">
                                    <span>0%</span>
                                    <span>Not Started</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Tab -->
        <div class="progress-content" data-tab="tasks">
            <div class="tasks-container">
                <div class="tasks-header">
                    <h3 class="tasks-title">Training Tasks</h3>
                </div>
                <ul class="task-list">
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task4">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Practice "Stay" Command</div>
                            <div class="task-description">Work on increasing duration to 2 minutes with moderate distractions</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Today</div>
                            <div class="task-priority priority-high">High Priority</div>
                        </div>
                    </li>
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task5">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Leash Walking Practice</div>
                            <div class="task-description">10-minute sessions focusing on loose leash walking</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Tomorrow</div>
                            <div class="task-priority priority-medium">Medium Priority</div>
                        </div>
                    </li>
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task6">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Review Training Video</div>
                            <div class="task-description">Watch and implement techniques from last session's video</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Aug 15</div>
                            <div class="task-priority priority-low">Low Priority</div>
                        </div>
                    </li>
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task7">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Socialization Practice</div>
                            <div class="task-description">Visit a pet-friendly store or park to practice greetings</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Aug 16</div>
                            <div class="task-priority priority-medium">Medium Priority</div>
                        </div>
                    </li>
                    <li class="task-item">
                        <div class="task-checkbox">
                            <input type="checkbox" id="task8">
                            <span class="checkbox-custom"></span>
                        </div>
                        <div class="task-content">
                            <div class="task-title">Recall Practice</div>
                            <div class="task-description">Work on "Come" command in backyard with mild distractions</div>
                        </div>
                        <div class="task-meta">
                            <div class="task-due">Due: Aug 18</div>
                            <div class="task-priority priority-high">High Priority</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Logs Tab -->
        <div class="progress-content" data-tab="logs">
            <div class="training-logs">
                <div class="log-header">
                    <h3 class="log-title">Training History</h3>
                </div>
                <div class="log-list">
                    <div class="log-item">
                        <div class="log-date">Aug 10, 2023</div>
                        <div class="log-content">
                            <div class="log-title">Leash Training Session</div>
                            <div class="log-description">30-minute session focusing on loose leash walking around the neighborhood. Buddy did great with passing cars but still struggles with squirrels.</div>
                            <div class="log-photo">
                                <img src="https://placedog.net/500/281" alt="Leash training photo">
                            </div>
                        </div>
                    </div>
                    <div class="log-item">
                        <div class="log-date">Aug 8, 2023</div>
                        <div class="log-content">
                            <div class="log-title">Stay Command Practice</div>
                            <div class="log-description">Worked on "Stay" for 20 minutes. Buddy can now hold a stay for 45 seconds with mild distractions. Big improvement!</div>
                        </div>
                    </div>
                    <div class="log-item">
                        <div class="log-date">Aug 5, 2023</div>
                        <div class="log-content">
                            <div class="log-title">Training Session with Trainer</div>
                            <div class="log-description">Had our weekly session with trainer Sarah. Focused on off-leash recall and proper greeting behavior. Got homework to practice daily.</div>
                            <div class="log-photo">
                                <img src="https://placedog.net/500/282" alt="Training session photo">
                            </div>
                        </div>
                    </div>
                    <div class="log-item">
                        <div class="log-date">Aug 3, 2023</div>
                        <div class="log-content">
                            <div class="log-title">Socialization at the Park</div>
                            <div class="log-description">Took Buddy to the park for 45 minutes of socialization practice. Met 3 new dogs and practiced polite greetings. Showed improvement with meeting small dogs.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="video-sessions">
                <h3 class="log-title">Training Videos</h3>
                <div class="video-grid">
                    <div class="video-card">
                        <div class="video-thumbnail">
                            <img src="https://placedog.net/501/282" alt="Training video thumbnail">
                            <div class="video-play">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-info">
                            <div class="video-title">Leash Training Techniques</div>
                            <div class="video-date">Aug 5, 2023</div>
                        </div>
                    </div>
                    <div class="video-card">
                        <div class="video-thumbnail">
                            <img src="https://placedog.net/501/283" alt="Training video thumbnail">
                            <div class="video-play">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-info">
                            <div class="video-title">Stay Command Tutorial</div>
                            <div class="video-date">Jul 29, 2023</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    // Tab functionality
    $('.progress-tab').on('click', function() {
        const tab = $(this).data('tab');
        
        // Update active tab
        $('.progress-tab').removeClass('active');
        $(this).addClass('active');
        
        // Update tab indicator position
        const tabPos = $(this).position();
        const tabWidth = $(this).outerWidth();
        $('.progress-tab-indicator').css({
            left: tabPos.left,
            width: tabWidth
        });
        
        // Show corresponding content
        $('.progress-content').removeClass('active');
        $(`.progress-content[data-tab="${tab}"]`).addClass('active');
    });
    
    // Initialize tab indicator position
    const activeTab = $('.progress-tab.active');
    const tabPos = activeTab.position();
    const tabWidth = activeTab.outerWidth();
    $('.progress-tab-indicator').css({
        left: tabPos.left,
        width: tabWidth
    });
    
    // Chart filter functionality
    $('.chart-filter').on('click', function() {
        $('.chart-filter').removeClass('active');
        $(this).addClass('active');
        
        // In a real implementation, this would update the chart data
        // For demo purposes, we'll just show a "loading" effect
        const period = $(this).data('period');
        const chartPlaceholder = $('.chart-placeholder');
        
        chartPlaceholder.html('<div class="loading-spinner"></div>');
        
        setTimeout(function() {
            chartPlaceholder.html(`Interactive progress chart for ${period} period will display here when you start tracking your dog's training`);
        }, 800);
    });
    
    // Task checkbox functionality
    $('.task-checkbox input').on('change', function() {
        const taskItem = $(this).closest('.task-item');
        
        if ($(this).is(':checked')) {
            taskItem.css('opacity', '0.6');
        } else {
            taskItem.css('opacity', '1');
        }
    });
    
    // Video play button functionality
    $('.video-play').on('click', function() {
        const videoCard = $(this).closest('.video-card');
        
        // In a real implementation, this would open a video player
        // For demo purposes, just show a "playing" effect
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        videoCard.css('opacity', '0.7');
        
        setTimeout(function() {
            $(this).html('<i class="fas fa-play"></i>');
            videoCard.css('opacity', '1');
            alert('Video would play in a real implementation.');
        }.bind(this), 800);
    });
});
</script>