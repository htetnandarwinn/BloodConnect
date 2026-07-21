# Software Requirements Specification (SRS) for BloodConnect

## 1. Introduction

### 1.1 Purpose
The purpose of this document is to define the software requirements for the BloodConnect system — a web-based blood donor directory and request management platform. It aims to connect blood donors with patients in need, streamline blood request management, and provide administrative oversight for donation lifecycle tracking.

### 1.2 Scope
The System will:
- Allow users to register as a Patient or Donor, log in, and manage their profiles.
- Enable Patients to create, track, and cancel blood requests.
- Enable Donors to view matching blood requests, accept or decline them, and maintain a donation history.
- Automatically match donors to requests based on blood group and location hierarchy (same township → same region → any region).
- Allow Administrators to manage users, donors, blood requests, roles, permissions, and generate overview analytics.
- Send notifications for request assignments, profile updates, and system events.
- Integrate Google reCAPTCHA v2 for spam prevention on login and registration.
- Support Google OAuth 2.0 for social login.

### 1.3 Definitions
- **Admin / Administrator**: System administrator with full access (user_type_id = 1).
- **Donor**: Registered user who can donate blood (user_type_id = 2).
- **Patient**: Registered user who requests blood (user_type_id = 3).
- **Blood Request**: A request created by a Patient specifying blood group, hospital, urgency, and location.
- **RBAC**: Role-Based Access Control — permissions assigned per user type.
- **Activity Log**: A record of system events for audit and dashboard display.

---

## 2. Overall Description

### 2.1 Product Perspective
Standalone web-based system built on a modular PHP architecture (Clean Architecture + DDD), deployed via XAMPP on a local or secure server. Accessible via standard web browsers. Uses MySQL for persistence and Tailwind CSS for responsive UI.

### 2.2 User Classes
| Class | Description |
|---|---|
| **Guest** | Unauthenticated visitor — can view public pages, register, or log in. |
| **Patient** | Can create and manage blood requests, search donors, and view notifications. |
| **Donor** | Can view matching requests, accept/decline, complete donor profile, and view donation history. |
| **Administrator** | Full access to dashboard, user management, donor management, blood requests, roles, and permissions. |

### 2.3 Assumptions
- Users have basic browser and internet knowledge.
- Email infrastructure exists for OTP and notification delivery.
- The deployment environment supports PHP 8+, MySQL, and Apache/Nginx.
- SSL certificate may be required for production deployment.

---

## 3. System Modules and Features

### Module: Authentication & Registration

#### 1. User Registration
This sub-module allows guests to create an account as either a Patient or Donor.
- **Registration Form**: Collects full name, email, phone, password, blood group, address, and role selection (Patient or Donor).
- **Password Security**: Passwords stored using PHP `password_hash()` (bcrypt).
- **Email Verification**: OTP-based email verification before account activation.
- **CAPTCHA**: Google reCAPTCHA v2 integration to prevent automated registrations.
- **Duplicate Prevention**: Email uniqueness enforced at database and application level.

#### 2. User Login
Authenticates registered users and redirects based on role.
- **Credential Login**: Email + password with bcrypt verification.
- **Google OAuth 2.0**: Social login with auto-link for existing emails; role selection for new users.
- **Session Management**: PHP session-based authentication with `user_id`, `user_type_id`, and `username` stored in `$_SESSION`.
- **Error Handling**: Invalid credential messages, account locking on repeated failures.
- **Role-Based Redirect**: Patients → `/patient/dashboard`, Donors → `/donor/dashboard`, Admins → `/admin/dashboard`.

#### 3. Password Recovery
Allows users to reset forgotten passwords.
- **Forgot Password**: User enters email; system sends OTP.
- **OTP Verification**: Verify 6-digit code.
- **Password Reset**: Set new password after successful OTP verification.

#### 4. Email Verification
OTP-based email verification during registration.

---

### Module: Patient Dashboard & Request Management

#### 1. Patient Dashboard
Landing page for authenticated Patients showing an overview of their activity.
- Displays recent blood requests (last 6).
- Shows metrics: total requests, pending, accepted, and cancelled counts.

#### 2. Create Blood Request
Allows Patients to submit a new request for blood.
- **Form Fields**: Blood group needed, units required, hospital name, state/region, township, hospital address, urgency level (Critical/Urgent/Normal), contact phone.
- **System-Generated**: Unique `request_code` auto-generated.
- **Status**: Defaults to `PENDING` on creation.
- **Validation**: All required fields enforced server-side.

#### 3. View My Requests
Lists all blood requests created by the logged-in Patient.
- Filterable by status: All, Pending, Accepted, Cancelled.
- Each row shows request code, blood group, hospital, urgency, status, and creation date.

#### 4. View Request Detail
Shows full details of a specific blood request.
- Includes patient info, hospital details, urgency, status.
- Displays assigned donor information (if accepted).

#### 5. Cancel Blood Request
Patient can cancel a pending blood request.
- Only requests with `PENDING` status can be cancelled.
- Sets status to `CANCELLED`.

#### 6. Search Donors
Search page for Patients to find available donors.
- Search by blood group and location (township/state).
- Returns eligible donors who match the criteria.

---

### Module: Donor Dashboard & Request Management

#### 1. Complete Donor Profile
First-time Donors must complete their profile before accessing the dashboard.
- **Fields**: Date of birth, weight (kg), state/region, township.
- **Eligibility Check**: Automatically evaluates donor eligibility based on age (18-65) and weight (>50kg).
- **Availability**: Tracks `next_available_date` for donation frequency compliance.

#### 2. Donor Dashboard
Landing page showing matching requests and personal stats.
- Pending blood request count for badge notification.
- Recent activity feed.

#### 3. View Matching Requests
Lists blood requests matching the Donor's blood group.
- Tiered matching: same township > same region > any region.
- Each request shows patient name, hospital, urgency, blood group needed, and creation date.
- Badge count for unread/viewed requests.

#### 4. Accept Blood Request
Donor can accept a pending request assigned to them or matching their blood group.
- System updates request status to `ACCEPTED`.
- Donor recorded as the assigned donor.

#### 5. Decline Blood Request
Donor can decline a request.
- System records declination.
- Request remains available for other donors.

#### 6. View Donation History
Lists all past completed donations for the Donor.
- Shows hospital name, patient, blood group, and completion date.
- Detailed view of each donation record.

---

### Module: Admin Dashboard & Management

#### 1. Admin Dashboard
Central overview page for administrators.
- **Summary Cards**: Total Donors, Total Patients, Pending Requests, Accepted Requests (with animated counters).
- **Line Chart**: Blood Requests Over Time — pending vs accepted vs cancelled (configurable: 7/30/90/365 days).
- **Doughnut Chart**: Donors by Blood Group with percentage legend.
- **Recent Blood Requests**: Last 6 requests with blood group, hospital, and date.
- **Recent System Activity**: Live feed of platform events with time-ago timestamps.

#### 2. User Management
Full CRUD for all system users.
- **List View**: All users with search and filter by role/status.
- **View Detail**: Complete user profile including role, contact, and activity.
- **Edit User**: Update username, email, role, and active status.
- **Delete User**: Soft-delete (sets `deleted_at`).

#### 3. Donor Management
List and filter donors.
- Filter by availability status.
- Shows donor eligibility, blood group, and location.

#### 4. Blood Request Management
Full oversight of all blood requests.
- **List View**: All requests with status filter (pending/accepted/completed/cancelled).
- **View Detail**: Full request info, matching donors (tiered), competing requests, assigned/accepted donor info.
- **Assign Donor**: Manually assign a donor to a request.
- **Bulk Assign**: Select and assign multiple donors.
- **Complete Request**: Mark request as fulfilled.
- **Delete Request**: Remove a request (cascading delete of related records).
- **Notify Donors**: Send notifications to selected donors.

#### 5. Roles & Permissions Management
RBAC configuration.
- **Roles List**: View all user types.
- **Edit Role Permissions**: Toggle permissions per role, grouped by module category.
- Changes notify other admins.

#### 6. Admin Profile
Profile viewing and editing (username, email, phone).
- Password change with confirmation.
- Profile update notifications sent to all admins.

---

### Module: Notifications

#### 1. Email Notifications
- **Donor Assignment**: Notified when assigned to a request.
- **Profile Updates**: Admins notified when another admin updates their profile.
- **System Events**: Activity log entries for dashboard display.

#### 2. In-App Notifications
- Store notifications in `notification` table with type, message, action, and read status.
- **Unread Count**: AJAX endpoint for badge polling.
- **Mark Read**: Single notification or mark all as read.
- **View All**: Notification page with history.

#### 3. Activity Logging
- Logs key system events (user updates, request actions, role changes).
- Displayed in Admin Dashboard and potentially other views.

---

### Module: System & Security

#### 1. Google reCAPTCHA v2
- Integrated on Login and Registration pages.
- Server-side verification via single cURL call with `SSL_VERIFYPEER => false`.
- Prevents automated bot registrations and brute-force login attempts.

#### 2. Google OAuth 2.0
- Social login option on login page.
- Auto-links to existing email accounts.
- New users prompted to select role and complete registration.

#### 3. Role-Based Access Control (RBAC)
- Permissions defined per user type: `dashboard.view`, `blood_request.create`, `user.manage`, etc.
- Middleware checks permissions on every protected route.
- Dynamic permission management via admin interface.

#### 4. Session Security
- PHP sessions with `session_regenerate_id()` on login.
- Logout destroys session.
- Role verification on every protected request.

---

## 4. Functional Requirements

| ID | Requirement |
|---|---|
| FR1 | The system shall allow guests to register as a Patient or Donor with name, email, phone, password, blood group, and address. |
| FR2 | The system shall verify email via OTP before activating new accounts. |
| FR3 | The system shall integrate Google reCAPTCHA v2 on registration and login forms. |
| FR4 | The system shall authenticate users via email/password with bcrypt hashing. |
| FR5 | The system shall support Google OAuth 2.0 login. |
| FR6 | The system shall redirect authenticated users to their role-specific dashboard. |
| FR7 | The system shall allow Patients to create blood requests specifying blood group, hospital, urgency, and location. |
| FR8 | The system shall allow Patients to view, filter, and cancel their own requests. |
| FR9 | The system shall allow Donors to complete a profile (DOB, weight, location) before using the system. |
| FR10 | The system shall display blood requests matching the Donor's blood group. |
| FR11 | The system shall allow Donors to accept or decline blood requests. |
| FR12 | The system shall maintain a donation history for each Donor. |
| FR13 | The system shall match donors to requests using a location hierarchy: same township → same region → any region. |
| FR14 | The system shall provide an Admin dashboard with summary stats, charts (requests over time, donors by blood group), recent requests, and activity feed. |
| FR15 | The system shall allow Admins to create, read, update, and soft-delete users. |
| FR16 | The system shall allow Admins to manage all blood requests — view, assign donors, complete, and delete. |
| FR17 | The system shall allow Admins to manage roles and permissions dynamically. |
| FR18 | The system shall notify users via in-app notifications for assignments, updates, and system events. |
| FR19 | The system shall allow users to mark notifications as read. |
| FR20 | The system shall allow Admins to view system activity logs. |
| FR21 | The system shall allow users to update their profile (name, email, phone, password). |
| FR22 | The system shall evaluate donor eligibility based on age and weight. |

---

## 5. Non-Functional Requirements

| ID | Requirement |
|---|---|
| NFR1 | **Performance**: The system shall handle concurrent access by multiple users across all roles without significant latency. |
| NFR2 | **Scalability**: The modular Clean Architecture (Repository pattern, DI) supports easy addition of new features and modules. |
| NFR3 | **Security**: Passwords hashed with bcrypt; session-based authentication; RBAC enforced via middleware; SQL injection prevented via prepared statements. |
| NFR4 | **Usability**: Responsive UI via Tailwind CSS; mobile-compatible layouts; interactive charts (Chart.js); animated stat counters. |
| NFR5 | **Availability**: Expected 99.9% uptime in production deployment. |
| NFR6 | **Maintainability**: Separation of concerns (Domain, Infrastructure, Presentation layers); dependency injection; PSR-4 autoloading. |
| NFR7 | **Reliability**: OTP-based email verification ensures valid user contacts; foreign key constraints maintain data integrity. |

---

## 6. External Interfaces

### 6.1 Hardware Interfaces
- **Client**: Standard PC, laptop, tablet, or smartphone with a modern web browser (Chrome, Firefox, Edge, Safari).
- **Server**: XAMPP stack (Apache, MySQL, PHP 8+) on Windows or Linux.

### 6.2 Software Interfaces
| Component | Technology |
|---|---|
| **Frontend** | HTML5, Tailwind CSS (CDN), Chart.js 4.4.7 (local), Font Awesome 6 |
| **Backend** | PHP 8.2+ with Clean Architecture / DDD |
| **Database** | MySQL (InnoDB, UTF-8) |
| **Web Server** | Apache 2.4+ (mod_rewrite enabled) |
| **Email** | PHP `mail()` or SMTP for OTP delivery |
| **External APIs** | Google reCAPTCHA v2 API, Google OAuth 2.0 |
| **Build Tools** | Composer (PSR-4 autoloading), npm (Chart.js asset) |

### 6.3 Database Tables (Key)
| Table | Purpose |
|---|---|
| `users` | All system users with role, blood group, and soft-delete |
| `donors` | Donor-specific fields (DOB, weight, location) |
| `blood_requests` | Blood request records with status, donor assignment |
| `request_donors` | Many-to-many: requests ↔ donors with response status |
| `master_data` | Lookup table for statuses, types, and labels |
| `activity_logs` | System event audit trail |
| `notification` | In-app user notifications |
| `password_resets` | Password reset OTP tokens |
| `email_verifications` | Email verification OTP tokens |
