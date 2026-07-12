# Software Requirements Specification (SRS) for BloodConnect

## 1. Introduction

### 1.1 Purpose
The purpose of this document is to define the software requirements for the BloodConnect system. It aims to automate all core blood donation management functions including patient registration, donor matching, blood request lifecycle management, and communication between all parties.

### 1.2 Scope
The System will:
- Allow users to register as patients or donors, log in, and manage their profiles.
- Enable patients to create blood requests specifying blood group, hospital, urgency, contact phone, and units.
- Allow donors to view matching blood requests and accept or decline them.
- Enforce donor eligibility rules including the 3-month cooldown period between donations.
- Track blood request status throughout its lifecycle (Pending → Accepted → Completed / Cancelled / Declined).
- Enable admins to manage users, blood requests, donor assignments, and roles/permissions.
- Send notifications to relevant parties on every request status change.
- Use email OTP verification for secure registration and password reset.
- Support Google OAuth social login.

### 1.3 Definitions
- **Admin**: System manager with full access to user/request/role management.
- **Donor**: User who donates blood and accepts blood requests.
- **Patient**: User who needs blood and creates blood requests.
- **OTP**: One-Time Password sent via email for verification.
- **RBAC**: Role-Based Access Control — permissions assigned by user type.

## 2. Overall Description

### 2.1 Product Perspective
Web-based system accessible via browser, built with PHP 8.x following Clean Architecture / Domain-Driven Design principles with MySQL 8.x database.

### 2.2 User Classes
- **Admin**: Full system access, user management, request oversight, role/permission management.
- **Donor**: Can view matching blood requests, accept/decline them, manage availability, and view donation history.
- **Patient**: Can create blood requests, view/cancel own requests, and manage profile.

### 2.3 Assumptions
- Users have basic browser knowledge.
- SMTP server is configured for email delivery.
- MySQL database is pre-configured with required tables.
- Web server is configured to serve from `public/` directory and rewrite all requests to `index.php`.

## 3. System Modules and Features

### Module: User Management

#### 1. User Registration/Login
This sub-module allows users to create accounts and securely access the system.

**User Registration:**
- Users can sign up by providing username, email, password, blood group, address, and phone number.
- Users select their role (Patient or Donor) during registration.
- Passwords are securely stored using bcrypt hashing.
- Email OTP verification is required before account activation.
- User data is NOT saved to the database until OTP is verified — registration data is stored in session during verification.
- Duplicate email detection throws a DomainException.

**User Login:**
- Users can log in using their email or username and password.
- Implements session-based authentication.
- Rejects login for unverified accounts.
- Rejects login for inactive (disabled) accounts.
- Session ID is regenerated on successful login.
- "Forgot password" functionality with email OTP verification.

#### 2. Role Assignment (Admin, Donor, Patient)
This part of the module controls what users can see and do based on their assigned role.

**Role Definitions:**
- **Admin**: Full access including user management, blood request management, donor management, and role/permission management.
- **Donor**: Can view matching blood requests, accept/decline, manage availability, view donation history.
- **Patient**: Can create blood requests, view/cancel own requests, search donors.

**Role Assignment:**
- Roles are assigned during registration based on user selection.
- Role-Based Access Control (RBAC) using `user_type_permissions` table ensures users only access permitted features.
- 19 permission strings control feature access (e.g., `blood_request.create`, `blood_request.accept`, `user.view`).
- Admins can change user roles after account creation.

#### 3. Profile Management
Users have the ability to view and update their personal information.

**Profile Viewing:**
- Users can view details such as username, email, phone number, blood group, address, and role.
- Option to see personal activity based on role (requests, donation history, notifications).

**Profile Editing:**
- Users can update contact information (email, phone, address) and change password.
- Changes are validated and saved securely.
- Admins can update user roles, active status, or deactivate accounts.

**Security Features:**
- Profile updates are logged for audit purposes.

### Module: Blood Request Management

#### 1. Create Blood Request
This functionality allows patients to submit blood requests.

**Process:**
- Patient specifies blood group needed, hospital name, urgency level, contact phone, and number of units.
- System assigns a unique request code (REQ + YYYYMMDDHHmmss).
- System checks if patient already has a PENDING request — if so, creation is blocked.
- Request is created in PENDING status.
- Notifications are sent to all matching donors and all admins. 

#### 2. View/Cancel Blood Requests
Patients can view and manage their submitted requests.

**View Requests:**
- Patients can view a list of all their requests with current status.
- Detailed view shows request code, blood group needed, hospital, urgency, status, and assigned donor.

**Cancel Request:**
- Patients can cancel their own PENDING requests only.
- ACCEPTED requests cannot be cancelled by the patient.
- Ownership is enforced — patient can only cancel their own requests.
- Notifications are sent to relevant parties on cancellation.

#### 3. Search Donors
Patients can search for available donors matching their required blood group.
- Filter by blood group and location.
- View donor availability status.

### Module: Donor Matching & Acceptance

#### 1. View Matching Requests
Donors can see blood requests that match their blood group.

**Process:**
- Donor dashboard displays all PENDING blood requests matching the donor's blood group.
- Shows request details: hospital, urgency, patient name, contact phone, units needed.
- Displays donor's eligibility info including next available date.

#### 2. Accept/Decline Request
Donors can respond to matching blood requests.

**Accept Process:**
- System checks donor eligibility before accepting:
  - 3-month cooldown period must have elapsed since last donation.
  - Donor must not have another active accepted request.
- If eligible, request status changes to ACCEPTED.
- Donor's next_available_date is set to current date + 3 months.
- A donation history record is created.
- Notifications sent to patient, donor, and all admins.

**Decline Process:**
- Donor can decline a PENDING request.
- Donor cannot accept a request they have already declined.

#### 3. Donation History
Donors can view their past donations.

**View:**
- List of all donations with request code, donation date, status, and remarks.
- Shows overall donation count and next eligible date.

#### 4. Availability Management
Donors can manage their donation availability.
- System automatically syncs availability based on `next_available_date`.
- Availability status (available/unavailable) is displayed on dashboard.
- Eligibility is evaluated based on last donation date and cooldown period.

### Module: Admin Management

#### 1. Dashboard & Analytics
Admins have an overview of the entire system.

**Dashboard Includes:**
- Total users, donors, patients, blood requests.
- Pending, accepted, completed request counts.
- Live activity feed showing recent system events (last 10 log entries).

#### 2. User Management
Admins can manage all users in the system.

**List Users:**
- View all users excluding soft-deleted accounts.
- Search/filter by name, email, role, status.

**Edit User:**
- Update username, email, role, and active status.
- Perform soft-delete (sets `deleted_at` timestamp, does not remove row).
- Restore soft-deleted users.
- Soft-deleted users are excluded from all queries and cannot log in.

#### 3. Blood Request Management
Admins have full oversight of all blood requests.

**List Requests:**
- View all requests with status, patient, blood group, hospital, urgency, assigned donor.

**View Request Detail:**
- Complete request information including matching donors.

**Assign Donor:**
- Admin can assign a specific donor to a PENDING request.
- Notifications sent to assigned donor, patient, and admins.

**Complete Request:**
- Admin can mark an ACCEPTED request as COMPLETED.
- Donation history status is synced accordingly.

#### 4. Role & Permission Management
Admins can manage the RBAC system.

**Manage Roles:**
- View and edit user type definitions.
- Assign permissions to roles.
- Manage 19 permission strings across user types.

#### 5. Donor Management
Admins can view and manage all donors.
- List all donors with donation history.
- Disable donor accounts if needed.

### Module: Notification System

#### 1. Email Notifications
Email serves as the primary external communication method.

**Types of Email Alerts:**
- **OTP Verification**: Sent during registration and password reset.
- **Password Reset**: OTP sent for forgot password flow.

#### 2. System Notifications
In-app notifications that inform users while logged into the system.

**Types of System Notifications:**
- **Blood Request Created**: Notifies matching donors and all admins when a patient creates a request.
- **Pending Request Exists**: Notifies patient when they attempt to create a request while one is pending.
- **Request Accepted**: Notifies patient, donor, and admins when a donor accepts.
- **Request Cancelled**: Notifies assigned donor, matching donors, and admins.
- **Request Completed**: Notifies patient, donor, and admins.
- **Request Assigned**: Notifies donor when admin assigns them to a request.

**Notification Management:**
- Users can view their notifications.
- Mark individual notifications as read.
- Mark all notifications as read.
- Unread notification count is displayed.
- Notification types: REQUEST, REMINDER, PROFILE_UPDATE, GENERAL.

### Module: Activity Logging

#### 1. Activity Log
All significant system events are logged for audit purposes.

**Logged Events:**
- User login events.
- Blood request lifecycle events (create, accept, decline, cancel, complete).
- Profile update events.
- Admin user management actions (update, delete, restore).
- Donor disable/restore actions.

**Dashboard Display:**
- Last 10 activity log entries shown on admin dashboard.

### Module: Password Reset

#### 1. Forgot Password
Users can reset their password if forgotten.

**Process:**
- User enters their registered email address.
- System sends a 6-digit OTP to the email.
- OTP expires after 10 minutes.
- User verifies OTP and sets a new password.
- New password is hashed with bcrypt before storing.

### Module: Google OAuth

#### 1. Social Login
Users can register or log in using their Google account.

**Features:**
- Login via Google OAuth.
- Registration via Google OAuth with role selection.
- Link Google account to existing user accounts if email matches.

## 4. Functional Requirements

- FR1: The system shall allow users to register as Patient or Donor with username, email, phone, password, blood group, and address.
- FR2: The system shall hash passwords using bcrypt before storing.
- FR3: The system shall send a 6-digit OTP via email upon registration and prevent database save until verified.
- FR4: The system shall allow users to log in with email or username and password.
- FR5: The system shall reject login for unverified or inactive accounts.
- FR6: The system shall support logout via session destruction.
- FR7: The system shall support Google OAuth login and registration.
- FR8: The system shall allow password reset via email OTP.
- FR9: The system shall allow patients to create blood requests with blood group, hospital, urgency, contact phone, and units.
- FR10: The system shall prevent patients from creating a new blood request while they have a PENDING request.
- FR11: The system shall assign a unique request code (REQ + YYYYMMDDHHmmss) to each request.
- FR12: The system shall allow donors to view blood requests matching their blood group.
- FR13: The system shall allow donors to accept a PENDING blood request.
- FR14: The system shall enforce donor eligibility — 3-month cooldown and no overlapping active accepted requests.
- FR15: The system shall set the donor's next available date to +3 months upon accepting a request.
- FR16: The system shall create a donation history record when a donor accepts a request.
- FR17: The system shall allow donors to decline a PENDING blood request.
- FR18: The system shall allow patients to cancel their own PENDING requests only.
- FR19: The system shall allow admins to assign a donor to a PENDING request.
- FR20: The system shall allow admins to mark an ACCEPTED request as COMPLETED.
- FR21: The system shall support request statuses: PENDING, ACCEPTED, COMPLETED, CANCELLED, DECLINED.
- FR22: The system shall allow admins to list, view, edit, and soft-delete users.
- FR23: The system shall exclude soft-deleted users from all queries.
- FR24: The system shall allow admins to manage roles and permissions (RBAC).
- FR25: The system shall create notifications for users on request events.
- FR26: The system shall allow users to view, mark read, and manage notifications.
- FR27: The system shall log user login, request lifecycle, profile update, and admin actions.
- FR28: The system shall display the last 10 activity log entries on the admin dashboard.
- FR29: The system shall allow users to view and update their profile.
- FR30: The system shall track donor availability and sync based on next_available_date.
- FR31: The system shall allow donors to view their donation history.
- FR32: The system shall notify all matching donors and admins when a blood request is created.

## 5. Non-Functional Requirements

- **NFR1 (Performance)**: Page load time must be under 3 seconds for dashboard pages.
- **NFR2 (Security)**: Passwords must be hashed using bcrypt. All queries must use prepared statements. RBAC must be enforced at the middleware level.
- **NFR3 (Usability)**: UI must be responsive (mobile and desktop). Flash messages must provide clear feedback.
- **NFR4 (Maintainability)**: Code must follow Clean Architecture — separation of Presentation, Application, Domain, Infrastructure. Business logic must reside in Use Case classes. Controllers must use dependency injection.
- **NFR5 (Availability)**: Email delivery failures must not prevent registration (OTP fallback).
- **NFR6 (Scalability)**: Database queries should use appropriate indexes. Singleton pattern for repository instances.

## 6. External Interfaces

- **Hardware**: Standard PC or mobile device with web browser.
- **Software**: PHP 8.x, MySQL 8.x.
- **Web Server**: Apache/Nginx configured to serve from `public/` directory.
- **Email**: SMTP-compatible server for OTP and password reset emails.
- **Third-Party**: Google OAuth API for social login.
