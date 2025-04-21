<!DOCTYPE html>
<html>
<head>
    <title>Business Proposal</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 2px solid #007BFF;
        }
        .header .logo img {
            max-height: 60px;
        }
        .header .client-info {
            text-align: right;
        }
        .header .client-info h2 {
            margin: 0;
            font-size: 18px;
            color: #007BFF;
        }
        .header .client-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #333;
        }
        .section {
            margin: 20px 0;
        }
        .section h2 {
            font-size: 20px;
            color: #007BFF;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .section p {
            margin: 5px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .info-table th {
            background-color: #f4f4f4;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <!-- Logo Section -->
            <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Company Logo" style="max-height: 60px;">
    </div>

            <!-- Client Information Section -->
            <div class="client-info">
                <h2>Client Information</h2>
                <p><strong>Name:</strong> {{ $client->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $client->email ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $client->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $client->add1 ?? 'N/A' }}, {{ $client->city ?? 'N/A' }}, {{ $client->state ?? 'N/A' }} {{ $client->zip ?? 'N/A' }}</p>
            </div>
            </div>
        </div>

        <!-- Client Information Section -->
        <div class="section">
            <h2>Client Information</h2>
            <table class="info-table">
                <tr>
                    <th>Name</th>
                    <td>{{ $client->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $client->email ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $client->phone ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $client->add1 ?? 'N/A' }}, {{ $client->city ?? 'N/A' }}, {{ $client->state ?? 'N/A' }} {{ $client->zip ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <!-- Project Information Section -->
        <div class="section">
            <h2>Project Information</h2>
            <table class="info-table">
            <tr>
            <th>Title</th>
            <td>{{ $project->title ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $project->description ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>{{ $project->start_date ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>End Date</th>
            <td>{{ $project->end_date ?? 'N/A' }}</td>
        </tr>
            </table>
        </div>

        <!-- Proposal Details Section -->
        <div class="section">
            <h2>Proposal Details</h2>
            <p>
                We are pleased to present this proposal for your project. Our team is committed to delivering high-quality results that meet your expectations. Please feel free to reach out if you have any questions or require further details.
            </p>
        </div>

         <!-- Notes Section -->
         <div class="section">
            <h2>Notes</h2>
            <p>
                {{ $notes ?? 'No additional notes provided.' }}
            </p>
        </div>

        <!-- Footer Section -->
        <div class="footer">
            <p>Thank you for considering our proposal. We look forward to working with you!</p>
        </div>
    </div>
</body>
</html>