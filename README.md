# Job Tracker - Shop Management System

A simple yet powerful PHP + SQLite spreadsheet application for recording and tracking jobs at your shop.

## Features

✅ **Job Management**
- Add, edit, and delete jobs
- Track customer information
- Record job dates and values

✅ **Financial Tracking**
- Record costs for each job
- Track customer payments
- Calculate profit/loss per job
- View outstanding balances

✅ **Dashboard**
- Real-time statistics
- Total jobs, value, costs, and payments
- Profit and outstanding balance overview
- Color-coded payment status

✅ **Responsive Design**
- Works on desktop, tablet, and mobile
- Clean, modern interface
- Easy-to-use form controls

## Installation

### Requirements
- PHP 7.0 or higher with SQLite extension
- A web server (Apache, Nginx, etc.)

### Setup

1. **Clone or download this repository**
   ```bash
   git clone https://github.com/oderalon/job-tracker.git
   cd job-tracker
   ```

2. **Copy files to your web server**
   - `config.php`
   - `api.php`
   - `index.php`
   - `README.md`

3. **Set file permissions** (Linux/Mac)
   ```bash
   chmod 755 .
   chmod 644 *.php
   ```

4. **Open in browser**
   Navigate to `http://localhost/job-tracker/index.php` or your server URL

The SQLite database (`jobs.db`) will be created automatically on first run.

## Database Structure

### jobs table
| Field | Type | Description |
|-------|------|-------------|
| id | INTEGER (PK) | Unique job identifier |
| customer_name | TEXT | Customer's name |
| customer_info | TEXT | Phone, email, address, notes |
| job_date | DATE | Date the job was performed |
| job_value | DECIMAL | Amount charged to customer |
| costs | DECIMAL | Costs incurred for the job |
| amount_paid | DECIMAL | Amount paid by customer |
| created_at | TIMESTAMP | Record creation timestamp |
| updated_at | TIMESTAMP | Record last update timestamp |

## API Endpoints

### GET /api.php?action=list
Returns all jobs ordered by date (newest first)

### POST /api.php?action=create
Creates a new job
```json
{
  "customer_name": "John Doe",
  "customer_info": "555-1234, john@email.com",
  "job_date": "2024-01-15",
  "job_value": 100.00,
  "costs": 25.00,
  "amount_paid": 50.00
}
```

### POST /api.php?action=update
Updates an existing job
```json
{
  "id": 1,
  "customer_name": "John Doe",
  "customer_info": "555-1234, john@email.com",
  "job_date": "2024-01-15",
  "job_value": 100.00,
  "costs": 25.00,
  "amount_paid": 50.00
}
```

### POST /api.php?action=delete
Deletes a job
```json
{
  "id": 1
}
```

### GET /api.php?action=stats
Returns business statistics
```json
{
  "total_jobs": 10,
  "total_value": 1000.00,
  "total_costs": 250.00,
  "total_paid": 800.00,
  "total_profit": 750.00,
  "total_outstanding": 200.00
}
```

## Usage

### Adding a Job
1. Click the **"➕ New Job"** button
2. Fill in the job details:
   - Customer name (required)
   - Customer info (optional)
   - Job date (required)
   - Job value (required)
   - Costs (optional)
   - Amount paid (optional)
3. Click **"💾 Save"**

### Editing a Job
1. Find the job in the table
2. Click **"✏️ Edit"** button
3. Modify the details
4. Click **"💾 Save"**

### Deleting a Job
1. Click **"🗑️ Delete"** button
2. Confirm the deletion

### Understanding the Dashboard
- **Total Jobs**: Number of records
- **Total Value**: Sum of all job values
- **Total Costs**: Sum of all costs
- **Total Paid**: Sum of all payments received
- **Total Profit**: Job value minus costs
- **Outstanding**: Total balance still owed

### Payment Status
- 🟢 **✓ Paid** - Customer has paid in full
- 🟡 **⏳ Pending** - Customer still owes money

## File Structure

```
job-tracker/
├── config.php      # Database configuration and initialization
├── api.php         # Backend API endpoints
├── index.php       # Frontend web interface
└── README.md       # This file
```

## Security Notes

- This application is designed for small shop operations
- Use HTTPS in production
- Restrict access to trusted users only
- Regular backups of `jobs.db` recommended
- Do not expose the API publicly without authentication

## Backup

To backup your data, simply copy the `jobs.db` file to a safe location.

## Troubleshooting

### "Database error" on startup
- Ensure PHP has write permissions to the application directory
- Check that SQLite extension is enabled in PHP

### No jobs appear
- Refresh the page (🔄 Refresh button)
- Check browser console for errors (F12 → Console)

### Changes not saving
- Verify PHP error log for issues
- Ensure write permissions on directory

## License

Open source - use freely

## Support

For issues or suggestions, please create an issue in the repository.

---

Made with ❤️ for shop owners everywhere
