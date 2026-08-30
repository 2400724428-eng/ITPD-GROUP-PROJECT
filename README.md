

### **How to Run the Gym Supplements Web App Locally Using XAMPP**

Follow these instructions to get the project up and running on your local machine:

#### **Step 1: Move Project Files into XAMPP**

1. Download or clone this project folder (`gym-supplements-store/`).
2. Move the entire folder into your XAMPP root directory:
* **Windows**: `C:\xampp\htdocs\`
* **Mac/Linux**: `/Applications/XAMPP/xamppfiles/htdocs/`


3. Ensure the folder name inside `htdocs` is exactly `gym-supplements-store`.

#### **Step 2: Start XAMPP Services**

1. Open the **XAMPP Control Panel**.
2. Click **Start** next to **Apache** (handles PHP pages and routing).
3. Click **Start** next to **MySQL / MariaDB** (handles the database).

#### **Step 3: Import the 18-Table Database**

1. Open your web browser and go to: `http://localhost/phpmyadmin/`
2. Click on the **SQL** tab at the top.
3. Paste the complete 18-table database schema script (provided in your project files) into the SQL query box.
4. Click **Go** at the bottom right to execute the script. This will automatically create the `gym_supplements_store` database along with all 18 tables, relations, and default configuration settings.

#### **Step 4: Configure Database Connection**

1. Open the project folder in your code editor (such as Visual Studio Code).
2. Locate the database connection file inside the `includes/` folder (`includes/db_connect.php`).
3. Ensure your PDO connection string points to your local database correctly:
* **Host**: `localhost`
* **Database Name**: `gym_supplements_store`
* **Username**: `root`
* **Password**: (leave blank by default on standard XAMPP installations)



#### **Step 5: View the Project in Your Browser**

1. Open your web browser.
2. Navigate to: `http://localhost/gym-supplements-store/`
3. You should see the homepage load successfully, with full access to the product catalog, cart functionality, user accounts, and admin panels!