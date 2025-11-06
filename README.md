# Ashesi_WT_AMS
Step By Step To Building the Attendence Management System

attendance-system/
│
├── index.php                     # Landing page (e.g., login/register portal)
│
├── config/
│   └── db.php                    # Database connection file
│
├── includes/
│   ├── header.php                # Common header (meta tags, nav)
│   ├── footer.php                # Common footer
│   ├── sidebar.php               # Sidebar (dashboard navigation)
│   └── functions.php             # Reusable PHP helper functions
│
├── public/
│   ├── css/
│   │   ├── style.css
│   │   ├── dashboard.css
│   │   └── forms.css
│   │
│   ├── js/
│   │   ├── main.js
│   │   └── ajax.js
│   │
│   ├── images/
│   │   └── logo.png
│   │
│   └── uploads/
│       ├── profile_pics/
│       └── course_materials/
│
├── auth/
│   ├── login.php                 # Handles login logic
│   ├── register.php              # Handles student/faculty registration
│   ├── logout.php
│   └── verify_role.php           # Restricts access based on role
│
├── admin/
│   ├── dashboard.php             # Admin main page
│   ├── manage_courses.php        # Create/delete departments/courses
│   ├── manage_users.php          # Approve students/faculty, manage roles
│   └── approve_requests.php      # Approve course enrollment requests
│
├── faculty/
│   ├── dashboard.php             # Faculty dashboard
│   ├── create_session.php        # Create attendance/assessment sessions
│   ├── view_students.php         # View enrolled students
│   ├── record_attendance.php     # Faculty marks attendance
│   └── record_grades.php         # Faculty enters grades
│
├── student/
│   ├── dashboard.php             # Student dashboard
│   ├── view_courses.php          # Browse and request to join courses
│   ├── attendance.php            # See current/past attendance
│   ├── assessments.php           # See grades
│   └── join_request.php          # Submit course join request
│
├── api/
│   ├── submit_attendance.php     # Handles AJAX for student marking attendance
│   ├── get_sessions.php          # Returns list of sessions
│   ├── submit_request.php        # Student sends course join request
│   └── approve_request.php       # Admin approves request via AJAX
│
├── database/
│   └── migrations.sql            # SQL script for creating tables
│
└── README.md
