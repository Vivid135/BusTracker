# ADBU Student Bus Tracking System

A comprehensive bus tracking system designed for university students to track real-time bus locations, routes, and schedules.

## 🎯 Features

### Student Features
- **User Registration & Authentication** - Secure student account creation and login
- **Real-time Bus Tracking** - Live bus location tracking on interactive maps
- **Route Information** - Detailed bus routes and stop information
- **Schedule Viewing** - Daily bus schedules and timing information
- **User Profile Management** - Personal account settings and preferences
- **Reporting System** - Report issues or inappropriate behavior

### Admin Features
- **Dashboard** - Comprehensive admin control panel
- **User Management** - Manage student accounts and permissions
- **Bus Management** - Add, edit, and manage bus fleet
- **Route Management** - Create and modify bus routes
- **Schedule Management** - Set up and maintain bus schedules
- **Report Handling** - Review and address student reports

### Technical Features
- **Dark/Light Theme** - Toggle between light and dark modes
- **Responsive Design** - Mobile-friendly interface
- **Real-time Updates** - Automatic data refresh
- **Secure Authentication** - Role-based access control
- **Database Integration** - MySQL database backend

## 🛠️ Technology Stack

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with CSS variables
- **JavaScript** - Interactive functionality
- **Leaflet.js** - Interactive mapping
- **DataTables** - Dynamic data tables
- **jQuery** - JavaScript library

### Backend
- **PHP** - Server-side scripting
- **MySQL** - Database management
- **Session Management** - User authentication

## 🚀 Installation

### Prerequisites
- **XAMPP/WAMP** - Local server environment
- **MySQL** - Database server
- **PHP 7.4+** - Server-side scripting

### Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Vivid135/BusTracker.git
   cd BusTracker
   ```

2. **Database Setup**
   - Start XAMPP/WAMP
   - Access phpMyAdmin (http://localhost/phpmyadmin)
   - Create database `bus_tracker`
   - Import SQL files from `DB/` folder

3. **Access the Application**
   - Start Apache and MySQL in XAMPP
   - Navigate to: `http://localhost/BusTracker`

## 📁 Project Structure

```
BusTracker/
├── admin/                  # Admin dashboard
├── student/                # Student pages
├── includes/               # Reusable components
├── config/                 # Configuration
├── css/                    # Stylesheets
├── js/                     # JavaScript files
├── DB/                     # Database files
├── index.php               # Home page
├── login.php               # Login page
├── register.php            # Registration page
├── about.php               # About page
├── contact.php             # Contact page
└── README.md               # Documentation
```

## 🎨 Theme System

- **Automatic Theme Detection** - Respects OS preferences
- **Manual Toggle** - User-controlled theme switching
- **Persistent Settings** - Theme preference saved locally
- **Smooth Transitions** - Animated theme changes

## 📊 Database Schema

### Main Tables
- **users** - Student and admin accounts
- **buses** - Bus fleet information
- **routes** - Bus route details
- **schedules** - Bus timing schedules
- **bus_locations** - Real-time bus positions
- **reports** - User-reported issues

## 🔐 Security Features

- **Password Protection** - Secure user authentication
- **Session Management** - Secure session handling
- **Input Validation** - Form data sanitization
- **SQL Injection Prevention** - Prepared statements
- **Role-based Access** - Admin/student permissions

## 📱 Responsive Design

- **Mobile-First** - Optimized for mobile devices
- **Tablet Support** - Tablet-friendly interface
- **Desktop Layout** - Full-featured desktop experience
- **Touch-Friendly** - Touch-optimized interactions

## 🎯 Usage

### For Students
1. Register a student account
2. Login to the system
3. Track buses in real-time
4. Check bus schedules
5. Report issues if needed

### For Administrators
1. Access admin dashboard
2. Manage student accounts
3. Update bus information
4. Set bus schedules
5. Handle user reports

## 🔄 Version History

### v1.0.0 - Initial Release
- Complete bus tracking system
- User authentication and management
- Real-time bus tracking
- Admin dashboard
- Dark/light theme support
- Responsive design

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📞 Support

For support or questions:
- **University**: Assam Don Bosco University
- **Department**: Transport Management

---

**Developed for ADBU Students** 🚌🎓
