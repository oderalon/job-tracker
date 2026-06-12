<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Tracker - Shop Management</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 6px;
            backdrop-filter: blur(10px);
        }

        .stat-card label {
            display: block;
            font-size: 12px;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .stat-card .value {
            font-size: 20px;
            font-weight: bold;
        }

        .controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        button {
            background-color: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #764ba2;
        }

        button.danger {
            background-color: #e74c3c;
        }

        button.danger:hover {
            background-color: #c0392b;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .form-container.show {
            display: block;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 13px;
            color: #555;
        }

        input, textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
        }

        .form-actions button {
            flex: 1;
        }

        .table-container {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            font-size: 13px;
            color: #555;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-buttons button {
            padding: 6px 12px;
            font-size: 12px;
        }

        .status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
        }

        .status.outstanding {
            background-color: #fff3cd;
            color: #856404;
        }

        .status.paid {
            background-color: #d4edda;
            color: #155724;
        }

        .currency {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .profit {
            font-weight: 600;
        }

        .profit.positive {
            color: #28a745;
        }

        .profit.negative {
            color: #e74c3c;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #999;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 10px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 Job Tracker</h1>
            <p>Shop Job Management System</p>
            <div class="stats">
                <div class="stat-card">
                    <label>Total Jobs</label>
                    <div class="value" id="stat-jobs">0</div>
                </div>
                <div class="stat-card">
                    <label>Total Value</label>
                    <div class="value" id="stat-value">$0.00</div>
                </div>
                <div class="stat-card">
                    <label>Total Costs</label>
                    <div class="value" id="stat-costs">$0.00</div>
                </div>
                <div class="stat-card">
                    <label>Total Paid</label>
                    <div class="value" id="stat-paid">$0.00</div>
                </div>
                <div class="stat-card">
                    <label>Total Profit</label>
                    <div class="value" id="stat-profit">$0.00</div>
                </div>
                <div class="stat-card">
                    <label>Outstanding</label>
                    <div class="value" id="stat-outstanding">$0.00</div>
                </div>
            </div>
        </header>

        <div class="controls">
            <button onclick="showAddForm()">➕ New Job</button>
            <button onclick="location.reload()">🔄 Refresh</button>
        </div>

        <div class="form-container" id="addForm">
            <h2 id="formTitle">Add New Job</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="customerName">Customer Name *</label>
                    <input type="text" id="customerName" required>
                </div>
                <div class="form-group">
                    <label for="customerInfo">Customer Info</label>
                    <textarea id="customerInfo" placeholder="Phone, email, address, etc."></textarea>
                </div>
                <div class="form-group">
                    <label for="jobDate">Job Date *</label>
                    <input type="date" id="jobDate" required>
                </div>
                <div class="form-group">
                    <label for="jobValue">Job Value *</label>
                    <input type="number" id="jobValue" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="costs">Costs</label>
                    <input type="number" id="costs" step="0.01" value="0">
                </div>
                <div class="form-group">
                    <label for="amountPaid">Amount Paid</label>
                    <input type="number" id="amountPaid" step="0.01" value="0">
                </div>
            </div>
            <div class="form-actions">
                <button onclick="saveJob()">💾 Save</button>
                <button onclick="hideAddForm()" style="background-color: #6c757d;">❌ Cancel</button>
            </div>
        </div>

        <div class="table-container">
            <table id="jobsTable">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Info</th>
                        <th>Job Date</th>
                        <th>Job Value</th>
                        <th>Costs</th>
                        <th>Amount Paid</th>
                        <th>Balance</th>
                        <th>Profit</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="jobsList">
                    <tr><td colspan="10" class="empty-state"><p>No jobs yet. Click "New Job" to get started.</p></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        let currentEditId = null;
        const API_URL = 'api.php';

        // Set today's date as default
        document.getElementById('jobDate').valueAsDate = new Date();

        // Load jobs on page load
        loadJobs();
        loadStats();

        // Reload data every 30 seconds
        setInterval(loadJobs, 30000);
        setInterval(loadStats, 30000);

        function loadJobs() {
            fetch(`${API_URL}?action=list`)
                .then(r => r.json())
                .then(jobs => {
                    const tbody = document.getElementById('jobsList');
                    if (jobs.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="10" class="empty-state"><p>No jobs yet. Click "New Job" to get started.</p></td></tr>';
                        return;
                    }

                    tbody.innerHTML = jobs.map(job => {
                        const outstanding = job.job_value - job.amount_paid;
                        const profit = job.job_value - job.costs;
                        const isPaid = outstanding <= 0;

                        return `
                            <tr>
                                <td><strong>${escapeHtml(job.customer_name)}</strong></td>
                                <td>${escapeHtml(job.customer_info || '-')}</td>
                                <td>${formatDate(job.job_date)}</td>
                                <td class="currency">$${parseFloat(job.job_value).toFixed(2)}</td>
                                <td class="currency">$${parseFloat(job.costs).toFixed(2)}</td>
                                <td class="currency">$${parseFloat(job.amount_paid).toFixed(2)}</td>
                                <td class="currency">$${Math.max(0, outstanding).toFixed(2)}</td>
                                <td class="currency profit ${profit >= 0 ? 'positive' : 'negative'}">$${profit.toFixed(2)}</td>
                                <td><span class="status ${isPaid ? 'paid' : 'outstanding'}">${isPaid ? '✓ Paid' : '⏳ Pending'}</span></td>
                                <td class="action-buttons">
                                    <button onclick="editJob(${job.id})">✏️ Edit</button>
                                    <button class="danger" onclick="deleteJob(${job.id})">🗑️ Delete</button>
                                </td>
                            </tr>
                        `;
                    }).join('');
                })
                .catch(err => console.error('Error loading jobs:', err));
        }

        function loadStats() {
            fetch(`${API_URL}?action=stats`)
                .then(r => r.json())
                .then(stats => {
                    document.getElementById('stat-jobs').textContent = stats.total_jobs || 0;
                    document.getElementById('stat-value').textContent = '$' + (stats.total_value || 0).toFixed(2);
                    document.getElementById('stat-costs').textContent = '$' + (stats.total_costs || 0).toFixed(2);
                    document.getElementById('stat-paid').textContent = '$' + (stats.total_paid || 0).toFixed(2);
                    document.getElementById('stat-profit').textContent = '$' + (stats.total_profit || 0).toFixed(2);
                    document.getElementById('stat-outstanding').textContent = '$' + (stats.total_outstanding || 0).toFixed(2);
                })
                .catch(err => console.error('Error loading stats:', err));
        }

        function showAddForm() {
            currentEditId = null;
            document.getElementById('formTitle').textContent = 'Add New Job';
            document.getElementById('customerName').value = '';
            document.getElementById('customerInfo').value = '';
            document.getElementById('jobDate').valueAsDate = new Date();
            document.getElementById('jobValue').value = '';
            document.getElementById('costs').value = '0';
            document.getElementById('amountPaid').value = '0';
            document.getElementById('addForm').classList.add('show');
            document.getElementById('customerName').focus();
        }

        function hideAddForm() {
            document.getElementById('addForm').classList.remove('show');
        }

        function saveJob() {
            const customerName = document.getElementById('customerName').value.trim();
            const jobValue = parseFloat(document.getElementById('jobValue').value);

            if (!customerName || isNaN(jobValue) || jobValue <= 0) {
                alert('Please fill in required fields correctly');
                return;
            }

            const data = {
                customer_name: customerName,
                customer_info: document.getElementById('customerInfo').value.trim(),
                job_date: document.getElementById('jobDate').value,
                job_value: jobValue,
                costs: parseFloat(document.getElementById('costs').value) || 0,
                amount_paid: parseFloat(document.getElementById('amountPaid').value) || 0
            };

            const action = currentEditId ? `${API_URL}?action=update` : `${API_URL}?action=create`;
            
            if (currentEditId) {
                data.id = currentEditId;
            }

            fetch(action, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            })
                .then(r => r.json())
                .then(result => {
                    if (result.error) {
                        alert('Error: ' + result.error);
                    } else {
                        hideAddForm();
                        loadJobs();
                        loadStats();
                    }
                })
                .catch(err => {
                    console.error('Error saving job:', err);
                    alert('Error saving job');
                });
        }

        function editJob(id) {
            fetch(`${API_URL}?action=list`)
                .then(r => r.json())
                .then(jobs => {
                    const job = jobs.find(j => j.id === id);
                    if (job) {
                        currentEditId = id;
                        document.getElementById('formTitle').textContent = 'Edit Job';
                        document.getElementById('customerName').value = job.customer_name;
                        document.getElementById('customerInfo').value = job.customer_info || '';
                        document.getElementById('jobDate').value = job.job_date;
                        document.getElementById('jobValue').value = job.job_value;
                        document.getElementById('costs').value = job.costs;
                        document.getElementById('amountPaid').value = job.amount_paid;
                        document.getElementById('addForm').classList.add('show');
                        document.getElementById('customerName').focus();
                    }
                })
                .catch(err => console.error('Error loading job:', err));
        }

        function deleteJob(id) {
            if (confirm('Are you sure you want to delete this job?')) {
                fetch(`${API_URL}?action=delete`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                })
                    .then(r => r.json())
                    .then(() => {
                        loadJobs();
                        loadStats();
                    })
                    .catch(err => {
                        console.error('Error deleting job:', err);
                        alert('Error deleting job');
                    });
            }
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr + 'T00:00:00');
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
