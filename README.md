# 📜 DisasterLink – Emergency Help & Resource Locator

## 🌟 Project Overview

**DisasterLink** is a web-based platform designed to help people during natural disasters such as floods, earthquakes, and storms. The system allows users to submit emergency reports, locate safe zones, access shelter homes, find food distribution centers, and connect with emergency services efficiently.

This project aims to enhance community coordination and improve the speed of disaster response. It is developed using PHP for the backend, MySQL for database management, and HTML, CSS, and JavaScript for the frontend.

---

## 🛠️ Features

- 📋 **Submit Emergency Reports**: Users can report disaster-related incidents through an easy-to-use form.
- 🔎 **View and Search Reports**: Admins can view all submitted reports and filter them by location, issue type, or status.
- 📈 **Update Report Status**: Admins can update the status of the reports (Pending, Resolved, etc.).
- 🗂️ **Download Reports**: Export all reports into a CSV file for offline use.
- 🏠 **Resource Locator**: Users can find nearby shelters, resources, and emergency services.
- 🌍 **Real-time Updates**: Stay updated with the latest information from disaster zones.

---

## ⚙️ Technology Stack

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (XAMPP Server)
- **Version Control**: Git, GitHub

---

## 🛤️ How to Set Up Locally

1. **Install XAMPP**:
   - Download and install XAMPP (https://www.apachefriends.org/index.html).
   - Start **Apache** and **MySQL** using the XAMPP Control Panel.

2. **Clone the Repository**:
   Open a terminal/command prompt and run:
   ```bash
   git clone https://github.com/Varun987-a11/disasterlink.git
This will download the project files to your local machine.

Move the Project Folder: Move the cloned project folder to the htdocs directory of your XAMPP installation:

On Windows: C:\xampp\htdocs\disasterlink

Import the Database:

Open phpMyAdmin (http://localhost/phpmyadmin/).

Create a new database called disasterlink_db.

Import the provided .sql file (if available) or manually create the necessary tables:

reports table for storing disaster reports.

Other tables: admins, patients, etc.

Access the Project:

Open a browser and go to:
http://localhost/disasterlink/

You should see the DisasterLink home page.

🎮 Usage
Once the setup is complete, users can:

Submit new reports through the "Submit Report" page.

Admins can view, filter, and update report statuses from the "View Reports" section.

Download reports in CSV format.

Use the resource locator to find shelters and emergency services.



💡 How to Contribute
Fork the repository.

Create a new branch for your feature or fix:
git checkout -b feature-branch

Commit your changes with clear messages:
git commit -m "Your message"

Push to your forked repository:
git push origin feature-branch

Create a Pull Request (PR) to merge your changes into the main repository.

🙏 Acknowledgements
This project was developed with the goal of enhancing disaster management. It is inspired by the need for a quicker, more efficient way to respond to natural disasters.

Thanks to all who contributed, tested, and provided feedback to make this project successful!

📄 License
This project is open-source and available under the MIT License. See the LICENSE file for more details.

🌿 Traditional Blessing for the Project
"Lokah Samastah Sukhino Bhavantu"
(May all beings everywhere be happy and free.)

May this project help people during critical times and serve as a tool for safety, comfort, and support in emergencies. 🌿🙏🏼

🛡️ Notes
Please make sure to update the database connection details in the db_connect.php file.

If you face any issues, feel free to open an issue on the GitHub repository, and I’ll get back to you as soon as possible!

📥 Contact
For any questions or inquiries, feel free to reach out to me  or open an issue on the GitHub repository.

🚂 Final Thoughts
DisasterLink aims to bridge the gap between affected communities and emergency services, providing them with the necessary tools to stay safe and informed. Together, we can make a difference!

---


