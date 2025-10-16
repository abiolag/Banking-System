<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Oarkard - Modern Banking')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-green: #00D54B;
            --dark-green: #00B140;
            --light-green: #E8F5E8;
            --dark-text: #1A1A1A;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--dark-green) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #EAEAEA;
            border-radius: 20px 20px 0 0 !important;
            text-align: center;
            padding: 2.5rem 1rem;
        }
        
        .card-header h4 {
            margin: 0;
            font-weight: 700;
            color: var(--dark-text);
            font-size: 1.5rem;
        }
        
        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #EAEAEA;
            font-size: 1rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(0, 213, 75, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-green);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .btn-primary:hover {
            background-color: var(--dark-green);
        }
        
        .btn-google {
            border: 2px solid #EAEAEA;
            color: var(--dark-text);
            font-weight: 600;
            border-radius: 12px;
            padding: 12px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .btn-google:hover {
            border-color: var(--primary-green);
            color: var(--primary-green);
            transform: translateY(-1px);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #6C757D;
            margin: 1.5rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #EAEAEA;
        }
        
        .divider span {
            padding: 0 1rem;
            background: white;
        }
    </style>
</head>
<body>
    @yield('content')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>