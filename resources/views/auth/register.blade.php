<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <title>Sign Up - berUANG</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            overflow: hidden;
        }
        
        /* Matikan zoom sepenuhnya */
        html {
            touch-action: manipulation;
            -webkit-text-size-adjust: none;
            text-size-adjust: none;
        }
        
        body {
            font-family: 'Rubik', 'Plus Jakarta Sans', sans-serif;
            background: #FFFFFF;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 10px;
        }
        
        /* Background Image */
        .bg-image {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background: url('{{ asset("images/BG.png") }}') no-repeat center center;
            background-size: cover;
            z-index: 0;
        }
        
        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        /* Container */
        .signup-container {
            position: relative;
            width: 100%;
            max-width: 420px;
            z-index: 2;
            margin: 0 auto;
        }
        
        /* Card */
        .signup-card {
            background: #F8F8F8;
            border-radius: 24px;
            box-shadow: 0px 6px 6px rgba(0, 0, 0, 0.3);
            padding: 55px 30px 30px;
            position: relative;
        }
        
        /* Logo */
        .logo-container {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 80px;
            background-color: #FFFFFF;
            border-radius: 50%;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            border: 3px solid #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .logo-image {
            width: 68px;
            height: 68px;
            background: url('{{ asset("images/berUANG-removebg-preview.png") }}') center/contain no-repeat;
            border-radius: 50%;
        }
        
        /* Title */
        .create-account-title {
            font-family: 'Rubik';
            font-weight: 500;
            font-size: 20px;
            line-height: 28px;
            text-align: center;
            color: #000000;
            margin-top: 10px;
            margin-bottom: 25px;
        }
        
        /* Input Group */
        .input-group {
            margin-bottom: 16px;
            position: relative;
        }
        
        .input-label {
            position: absolute;
            left: 12px;
            top: -9px;
            background: #263142;
            padding: 0 6px;
            border-radius: 4px;
            font-family: 'Rubik';
            font-weight: 400;
            font-size: 10px;
            line-height: 16px;
            color: #F8F8F8;
            z-index: 1;
        }
        
        .input-field {
            width: 100%;
            height: 42px;
            padding: 10px 12px;
            border: 1px solid #000000;
            border-radius: 8px;
            font-family: 'Rubik';
            font-weight: 500;
            font-size: 13px;
            color: #626778;
            background: white;
        }
        
        .input-field:focus {
            outline: none;
            border-color: #4F772D;
            box-shadow: 0 0 0 2px rgba(79, 119, 45, 0.1);
        }
        
        /* Button Create */
        .btn-create {
            width: 100%;
            height: 42px;
            padding: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #4F772D;
            border-radius: 8px;
            border: none;
            font-family: 'Rubik';
            font-weight: 600;
            font-size: 13px;
            color: #FFFFFF;
            cursor: pointer;
            margin-bottom: 15px;
        }
        
        .btn-create:hover {
            background: #3d5e22;
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 15px 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .divider span {
            padding: 0 10px;
            font-family: 'Plus Jakarta Sans';
            font-weight: 600;
            font-size: 11px;
            color: #999;
        }
        
        /* Button Google */
        .btn-google {
            width: 100%;
            height: 40px;
            padding: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Rubik';
            font-weight: 500;
            font-size: 12px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }
        
        .btn-google:hover {
            background: #f5f5f5;
            border-color: #4F772D;
        }
        
        /* Agree Check */
        .agree-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 15px 0;
        }
        
        .agree-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border: 1.5px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
            accent-color: #4F772D;
        }
        
        .agree-check label {
            font-family: 'Plus Jakarta Sans';
            font-weight: 500;
            font-size: 11px;
            line-height: 150%;
            color: #666;
            cursor: pointer;
        }
        
        .agree-check a {
            color: #4F772D;
            text-decoration: none;
            font-weight: 600;
        }
        
        .agree-check a:hover {
            text-decoration: underline;
        }
        
        /* Login Link */
        .login-link {
            text-align: center;
            margin-top: 15px;
            padding-top: 12px;
            border-top: 1px solid #e0e0e0;
        }
        
        .login-link p {
            font-family: 'Plus Jakarta Sans';
            font-size: 11px;
            color: #666;
        }
        
        .login-link a {
            color: #4F772D;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        /* Error Message */
        .error-message {
            background: #fee2e2;
            border: 1px solid #ef4444;
            color: #dc2626;
            padding: 8px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 11px;
            text-align: center;
        }
        
        /* Responsive untuk layar lebih kecil */
        @media (max-width: 480px) {
            .signup-container {
                max-width: 95%;
            }
            
            .signup-card {
                padding: 50px 20px 25px;
            }
            
            .logo-container {
                width: 70px;
                height: 70px;
                top: -35px;
            }
            
            .logo-image {
                width: 60px;
                height: 60px;
            }
            
            .create-account-title {
                font-size: 18px;
                margin-top: 8px;
                margin-bottom: 20px;
            }
            
            .input-group {
                margin-bottom: 14px;
            }
            
            .input-field, .btn-create {
                height: 40px;
                font-size: 12px;
            }
            
            .btn-google {
                height: 38px;
                font-size: 11px;
            }
        }
        
        /* Untuk layar dengan tinggi kecil */
        @media (max-height: 700px) {
            .signup-card {
                padding: 45px 30px 20px;
            }
            
            .logo-container {
                width: 65px;
                height: 65px;
                top: -32px;
            }
            
            .logo-image {
                width: 55px;
                height: 55px;
            }
            
            .create-account-title {
                font-size: 18px;
                margin-bottom: 15px;
            }
            
            .input-group {
                margin-bottom: 12px;
            }
            
            .input-field, .btn-create {
                height: 38px;
            }
            
            .btn-google {
                height: 36px;
                margin-bottom: 12px;
            }
            
            .agree-check {
                margin: 10px 0;
            }
            
            .login-link {
                margin-top: 12px;
                padding-top: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Image -->
    <div class="bg-image"></div>
    <div class="overlay"></div>
    
    <div class="signup-container">
        <div class="signup-card">
            <!-- Logo -->
            <div class="logo-container">
                <div class="logo-image"></div>
            </div>
            
            <!-- Title -->
            <h2 class="create-account-title">Create an Account</h2>
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="error-message">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Full Name -->
                <div class="input-group">
                    <div class="input-label">Full Name</div>
                    <input type="text" name="name" class="input-field" value="{{ old('name') }}" required autofocus>
                </div>
                
                <!-- Email -->
                <div class="input-group">
                    <div class="input-label">Email</div>
                    <input type="email" name="email" class="input-field" value="{{ old('email') }}" required>
                </div>
                
                <!-- Password -->
                <div class="input-group">
                    <div class="input-label">Password</div>
                    <input type="password" name="password" class="input-field" required>
                </div>
                
                <!-- Confirm Password -->
                <div class="input-group">
                    <div class="input-label">Confirm Password</div>
                    <input type="password" name="password_confirmation" class="input-field" required>
                </div>
                
                <!-- Create Account Button -->
                <button type="submit" class="btn-create">
                    Create account
                </button>
            </form>
            
            <!-- Divider -->
            <div class="divider">
                <span>OR</span>
            </div>
            
            <!-- Google Button -->
            <button class="btn-google" onclick="alert('Google Sign Up coming soon!')">
                <svg width="18" height="18" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.0001 11.2091C20.0001 10.4818 19.931 9.75455 19.8001 9.04547H11.2002V13.2182H16.2383C16.0001 14.4727 15.231 15.5636 14.1077 16.2545L17.523 18.9272C19.2153 17.3454 20.0001 14.9636 20.0001 11.2091Z" fill="#4285F4"/>
                    <path d="M11.2 20.0003C13.6882 20.0003 15.7855 19.2457 17.523 18.9275L14.1077 16.2548C13.1698 16.8821 12.0077 17.1548 11.2 17.1548C8.7 17.1548 6.59266 15.4912 5.88862 13.1457L2.38428 15.8366C4.11528 19.3275 7.47619 20.0003 11.2 20.0003Z" fill="#34A853"/>
                    <path d="M5.88862 13.1457C5.70771 12.5184 5.58862 11.8729 5.58862 11.2002C5.58862 10.5275 5.70771 9.88199 5.88862 9.25469L2.38428 6.56378C1.82329 7.69999 1.5 8.98199 1.5 10.4002C1.5 11.8184 1.82329 13.1004 2.38428 14.2366L5.88862 11.5457V13.1457Z" fill="#FBBC05"/>
                    <path d="M11.2 5.24544C12.0691 5.23544 12.9077 5.56362 13.5382 6.14544L16.5846 3.05454C14.8309 1.39089 12.5927 0.44544 10.1845 0.44544C6.46182 0.44544 3.10092 1.11817 1.36908 4.60907L4.87344 7.3C5.57748 4.95454 7.68455 3.29089 10.1845 3.29089C10.3691 3.29089 11.2 3.24544 11.2 5.24544Z" fill="#EA4335"/>
                </svg>
                Sign Up with Google
            </button>
            
            <!-- Terms & Conditions -->
            <div class="agree-check">
                <input type="checkbox" id="agree" required>
                <label for="agree">I agree to the <a href="#">Terms & Conditions</a></label>
            </div>
            
            <!-- Login Link -->
            <div class="login-link">
                <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
            </div>
        </div>
    </div>
    
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const agreeCheck = document.getElementById('agree');
            if (!agreeCheck.checked) {
                e.preventDefault();
                alert('Please agree to the Terms & Conditions to continue');
            }
        });
    </script>
</body>
</html>