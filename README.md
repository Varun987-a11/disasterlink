# 🌐 DisasterLink – Emergency Help & Resource Locator

A comprehensive web-based platform designed to assist communities during natural disasters such as floods, earthquakes, and storms. DisasterLink enables users to submit emergency reports, locate safe zones and shelters, find food distribution centers, and connect with emergency services in real time.

---

## 🌟 Project Overview

DisasterLink aims to strengthen community coordination and accelerate disaster response. Built with **PHP** for backend logic, **MySQL** for database management, and **HTML**, **CSS**, and **JavaScript** for a responsive frontend, this project demonstrates practical application of full-stack web development in a critical context.

---

## 🛠️ Features

* 📋 **Submit Emergency Reports**: User-friendly form for reporting disaster-related incidents.
* 🔎 **View & Search Reports**: Admin dashboard to display and filter reports by location, category, or status.
* 📈 **Update Report Status**: Admins can mark reports as *Pending*, *In-Progress*, *Resolved*, etc.
* 🗂️ **Download Reports**: Export all reports to CSV for offline analysis and record-keeping.
* 🏠 **Resource Locator**: Interactive map to find nearby shelters, aid stations, and emergency services.
* 🌍 **Real-time Updates**: Live feed of new reports and status changes.

---

## ⚙️ Technology Stack

| Layer      | Technology            |
| ---------- | --------------------- |
| Frontend   | HTML, CSS, JavaScript |
| Backend    | PHP                   |
| Database   | MySQL (via XAMPP)     |
| Versioning | Git, GitHub           |

---

## 🚀 Setup & Installation

1. **Install XAMPP**

   * Download: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
   * Start **Apache** and **MySQL** from the XAMPP Control Panel.

2. **Clone the Repository**

   ```bash
   git clone https://github.com/yourusername/disasterlink.git
   ```

3. **Deploy to Localhost**

   * Move the `disasterlink` folder into `C:\xampp\htdocs\`
   * Navigate to **[http://localhost](http://localhost)** to confirm.

4. **Configure the Database**

   * Open **phpMyAdmin**: [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)
   * Create a new database: `disasterlink_db`
   * Import `database.sql` (if provided) or manually create tables:

     * `reports`, `admins`, `doctor_schedule`, etc.

5. **Update Connection Settings**

   * Edit `db_connect.php` with your MySQL credentials.

6. **Access the Application**

   * Open your browser at:

     ```
     http://localhost/disasterlink/
     ```

---

## 🎮 Usage

* **Submit Report**: Navigate to *Submit Emergency Report* page, fill in details, and submit.
* **Admin Dashboard**: Log in as admin to view, filter, update, and export reports.
* **Resource Locator**: Use the map interface to locate nearby safe zones and services.

---

## Live Demo
[Go to Home Page]([index.html](https://Varun987-a11.github.io/disasterlink/index.html
)



## 🤝 Contribution & Credits

This project is developed and maintained by **Varun Kumar S**. Your contributions are welcome under the following guidelines:

1. **Fork** the repository.
2. Create a new branch: `git checkout -b feature/YourFeature`
3. **Commit** your changes: \`git commit -m "Add new feature"
4. **Push** to your branch: `git push origin feature/YourFeature`
5. Open a **Pull Request** for review.

> ⚠️ **Credit & Usage:** Please give proper credit to **Varun Kumar S** when using or referencing this project. Re-uploading, plagiarizing, or commercial use without permission is prohibited.

---

## 📝 License

Distributed under the **MIT License**. See [LICENSE](LICENSE) for details.

---

## 🙏 Acknowledgements

* Inspired by the need for rapid disaster response and community support.
* Traditional blessing: *"Lokah Samastah Sukhino Bhavantu"* — May all beings be happy and free.

---

## 👨‍💻 Team Members

- [@Sujan-4](https://github.com/Sujan-4)  
- [@Varsush](https://github.com/Varsush)  
- [@Varun987-a11](https://github.com/Varun987-a11)  
- [@Shlaghana16](https://github.com/Shlaghana16)
