# Home Resident Management System

## Overview
The Home Resident Management System is a comprehensive web-based application designed for managing residential communities. It provides tools for administrators to manage residents, visitors, events, and keys for a residential property. The system streamlines communication between administrators and residents while providing secure access management and community event coordination.

## Key Features

### User Management
- Admin account management
- Resident registration and profiles
- Secure authentication

### Visitor Management
- Visitor registration
- Approval workflow (Pending, Approved, Declined)
- Visit scheduling and purpose tracking

### Event Management
- Event creation, editing, and deletion
- Event calendar and notifications

### Key Management
- Registration and tracking of different key types
- Key assignment and activation status
- Unit-specific key inventory

### Communication
- Feedback system
- Announcements for community events

## Technologies Used

### Frontend
- HTML5
- CSS3
- JavaScript
- Bootstrap (for responsive design)

### Backend
- PHP (core programming language)
- MySQL (database management)

### Development Tools
- XAMPP/WAMP (local development environment)
- Git (version control)
- Visual Studio Code (code editor)

## Database Structure
The system uses a relational database with the following main tables:
- `admin`: Stores administrator account information
- `resident`: Contains resident profile data
- `visitor`: Manages visitor information and approval status
- `event`: Tracks community events
- `key`: Stores key information
- `keyregistration`: Manages key assignments to units
- `feedback`: Stores user feedback

## Installation
1. Install XAMPP/WAMP on your local machine
2. Clone the repository to your htdocs/www folder
3. Import the `home_resident_mgmt.sql` file into your MySQL database
4. Configure the database connection in `admin/data_connection.php`
5. Access the application through your localhost

## Security Features
- Password encryption using SHA-1
- Session-based authentication
- Input validation and sanitization
- Role-based access control

## Future Enhancements
- Mobile application integration
- Real-time notifications
- Enhanced reporting capabilities
- Payment integration for community dues
- Maintenance request tracking
